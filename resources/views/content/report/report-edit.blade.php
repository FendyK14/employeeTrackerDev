@extends('layout.app')

@section('title', 'Edit Report')

@section('content')
    @if (Session::get('employee')->positionId === 1)
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Edit Report</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-3" method="POST" enctype="multipart/form-data"
                            action="{{ route('Edited Report', ['id' => $performance->performanceId]) }}">
                            @csrf
                            @method('PATCH')
                            {{-- employee --}}
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputName1" class="col-form-label col-sm-2">Employee Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="employeeName"
                                        value="{{ $performance->employees->employeeName }}" class="form-control"
                                        id="exampleInputName1" placeholder="Employee Name" readonly>
                                </div>
                            </div>
                            {{-- Date --}}
                            <div class="row mb-3 align-items-center">
                                <label for="evaluationDate" class="col-form-label col-sm-2">Evaluation Date</label>
                                <div class="col-sm-10">
                                    <input type="date" name="evaluationDate" class="form-control" id="evaluationDate"
                                        value="{{ $performance->evaluationDate }}" readonly>
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
                                                        class="form-control score-input"
                                                        value="{{ $scores[$data['id']] ?? 0 }}" required>
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
                                    <textarea type="text" name="description" class="form-control" id="exampleInputDescription1">{{ $performance->description }}</textarea>
                                </div>
                            </div>
                            {{-- notes --}}
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputNotes1" class="col-form-label col-sm-2">Notes</label>
                                <div class="col-sm-10">
                                    <input type="text" name="notes" class="form-control" id="exampleInputNotes1"
                                        value="{{ $performance->notes }}" placeholder="Notes">
                                </div>
                            </div>
                            {{-- status --}}
                            <div class="row mb-3 align-items-center">
                                <label for="exampleInputStatus1" class="col-form-label col-sm-2">Status</label>
                                <div class="col-sm-10">
                                    <select name="status" class="form-control" id="exampleInputStatus1" required>
                                        <option value="">Select Status</option>
                                        <option value="Pending" {{ $performance->status == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Cancelled"
                                            {{ $performance->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="Completed"
                                            {{ $performance->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                            </div>
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
