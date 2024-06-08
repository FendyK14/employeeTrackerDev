@extends('layout.app')

@section('title', 'Add Report')

@section('content')
    @if (Session::get('employee')->positionId === 1)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Add Report</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-3" method="POST" enctype="multipart/form-data"
                            action="{{ route('Added Report') }}">
                            @csrf
                            {{-- employee --}}
                            <div class="row mb-3 align-items-center">
                                <label for="employeeId" class="col-form-label col-sm-2">Employee</label>
                                <div class="col-sm-10">
                                    <select name="employeeId" class="form-control" id="employeeId" required>
                                        <option value="">Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->employeeId }}">{{ $employee->employeeName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Date --}}
                            <div class="row mb-3 align-items-center">
                                <label for="evaluationDate" class="col-form-label col-sm-2">Evaluation Date</label>
                                <div class="col-sm-10">
                                    <input type="date" name="evaluationDate" class="form-control" id="evaluationDate"
                                        value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            {{-- table utk KPIs indicator --}}
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        @foreach ($header as $head)
                                            <th class=" @if ($head === 'Action') text-center @endif">
                                                {{ $head }}
                                            </th>
                                        @endforeach
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        ?>
                                        @foreach ($kpis as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $data['indicator'] }}</td>
                                                <td>
                                                    <input type="number" name="scores[{{ $data['id'] }}]"
                                                        class="form-control score-input" required>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2" class="text-end fw-bold">Total Score</td>
                                            <td id="totalScore" class="fw-bold"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- end of table --}}
                            {{-- Description --}}
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputDescription1" class="col-form-label col-sm-2">Description</label>
                                <div class="col-sm-10">
                                    <textarea type="text" name="description" class="form-control" id="exampleInputDescription1"></textarea>
                                </div>
                            </div>
                            {{-- notes --}}
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputNotes1" class="col-form-label col-sm-2">Notes</label>
                                <div class="col-sm-10">
                                    <input type="text" name="notes" class="form-control" id="exampleInputNotes1"
                                        placeholder="Notes">
                                </div>
                            </div>
                            {{-- status --}}
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputStatus1" class="col-form-label col-sm-2">Status</label>
                                <div class="col-sm-10">
                                    <select name="status" class="form-control" id="exampleInputStatus1" required>
                                        <option value="">Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Cancelled">Cancelled</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                            {{-- indicator grade --}}

                            {{-- button save n back --}}
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="mt-3 d-flex justify-content-center me-3">
                                    <button type="submit" class="btn btn-block btn-primary fw-bold auth-form-btn">Save
                                    </button>
                                </div>
                                <div class="mt-3 d-flex justify-content-center">
                                    <button type="button"
                                        class="btn btn-block btn-outline-secondary fw-bold auth-form-btn"> <a
                                            class="text-decoration-none" href={{ route('List Report') }}>Back</a>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('error.page404')
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scoreInputs = document.querySelectorAll('.score-input');
            const totalScoreElement = document.getElementById('totalScore');

            function updateTotalScore() {
                let total = 0;
                scoreInputs.forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                totalScoreElement.textContent = total;
            }

            scoreInputs.forEach(input => {
                input.addEventListener('input', updateTotalScore);
            });

            updateTotalScore();
        });
    </script>
@endsection
