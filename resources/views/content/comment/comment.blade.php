@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="height: calc(100vh - 43px);">
                <div class="card-body">
                    <h4>{{ $activity->projects->projectName }} - {{ $activity->activityName }}</h4>

                    <!-- Form untuk komentar baru -->
                    <form id="commentForm" method="POST" action="{{ route('Add Comments', ['id' => $activity]) }}">
                        @csrf
                        <div class="form-group">
                            <label for="comment">Write your comments:</label>
                            <textarea class="form-control" id="comment" name="description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>

                    <!-- Daftar komentar -->
                    <div id="commentsSection" style="margin-top: 20px;">
                        <h5>Comments:</h5>
                        <ul class="list-group"
                            @if ($comments->isNotEmpty() && $comments->count() > 4) style="height: 300px; overflow-y: scroll" @endif>
                            <!-- Contoh komentar -->
                            @if ($comments->isNotEmpty())
                                @foreach ($comments as $data)
                                    @if ($data->employeeId == Session::get('employee')->employeeId)
                                        <li class="list-group-item text-end float-end">
                                            <span class="fs-6">{{ $data->description }}</span>
                                            <div>
                                                <a href="javascript:void(0);"
                                                    class="text-decoration-none text-warning fw-bold me-1"
                                                    onclick="showEditForm({{ $data->commentId }})">Edit</a>
                                                <a href="{{ route('Delete Comments', ['id' => $data->commentId]) }}"
                                                    class="text-decoration-none text-danger fw-bold"
                                                    data-confirm-delete="true">Delete</a>
                                            </div>
                                        </li>
                                        <!-- Form edit komentar -->
                                        <form id="editCommentForm-{{ $data->commentId }}" method="POST"
                                            action="{{ route('Edit Comments', ['id' => $data->commentId]) }}"
                                            style="display: none;">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group" style="margin-bottom: 10px">
                                                <textarea class="form-control" name="description" rows="2">{{ $data->description }}</textarea>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-warning">Update</button>
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="hideEditForm({{ $data->commentId }})">Cancel</button>
                                            </div>
                                        </form>
                                    @else
                                        <!-- Komentar pengguna lain -->
                                        <li class="list-group-item text-start float-start">
                                            <strong class="fs-6">{{ $data->employees->employeeName }}:</strong>
                                            <span class="fs-6">{{ $data->description }}
                                            </span>
                                        </li>
                                    @endif
                                @endforeach
                            @else
                                <li class="list-group-item text-center">No Comment</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function showEditForm(commentId) {
        document.getElementById('editCommentForm-' + commentId).style.display = 'block';
    }

    function hideEditForm(commentId) {
        document.getElementById('editCommentForm-' + commentId).style.display = 'none';
    }
</script>
