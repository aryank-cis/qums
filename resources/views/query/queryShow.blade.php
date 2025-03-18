@extends('layouts.app')
@extends('layouts.appInclude')
@section('content')
    @if (!empty($query))
        <div class="col-md-12  p-3">
            <div class="card shadow-sm border-dark">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5>Query Information</h5>
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="card-body">
                    <div class="card p-2">
                        <h3>Query Creator Information</h3>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row">Query Date</th>
                                    <td>{{ \Carbon\Carbon::parse($query['created_at'])->format('d-m-Y H:i A') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Query By</th>
                                    <td>{{ $query['name'] }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td>{{ $query['email'] }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Query ID</th>
                                    <td>{{ $query['query_id'] }}</td>
                                </tr>

                                <tr>
                                    <th scope="row">Status</th>
                                    <td>
                                        <span
                                            class="badge 
											@if ($query->status == 1) bg-success
											@else bg-warning @endif">
                                            @if ($query->status == 1)
                                                Closed
                                            @else
                                                Pending
                                            @endif
                                        </span>
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row">Query Creator Comment</th>
                                    <td>{{ $query['query_raiser_comment'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card p-2 mt-2">
                        <h3>Query Resolver's Information</h3>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row">Query For</th>
                                    <td>{{ $query->queryUser->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td>{{ $query->queryUser->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Query Status</th>
                                    <td>
                                        <span
                                            class="badge 
											@if ($query->query_status == 1) bg-warning
											@elseif($query->query_status == 2) bg-success
											@elseif($query->query_status == 3) bg-danger
											@else bg-secondary @endif">
                                            @if ($query->query_status == 1)
                                                In Progress
                                            @elseif($query->query_status == 2)
                                                Closed
                                            @elseif($query->query_status == 3)
                                                Canceled
                                            @else
                                                Pending
                                            @endif
                                        </span>
                                    </td>

                                </tr>
                                <tr>
                                    <th scope="row"> Query Resolver's Comment</th>
                                    <td>{{ $query['query_closer_comment'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card p-2 mt-2">
                        <h3>Query Message</h3>
                        <p class="text-left text-dark">{{ $query->query_content ?? 'No Message Here' }}</p>
                    </div>

                    <div class="d-flex justify-content-end p-2">
                        @if (auth()->user()->id == $query->query_for)
                            <a class="btn btn-sm btn-dark me-2" type="button" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#InProgressModal"
                                {{ in_array($query->query_status, [2, 3]) ? 'hidden' : '' }}>Query Action</a>
                        @endif

                        @if (auth()->user()->id == $query->query_to)
                            <a class="btn btn-sm btn-dark me-2" type="button" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#QueryRaiserModal"
                                {{ in_array($query->status, [1]) ? 'hidden' : '' }}>User Action</a>
                        @endif
                    </div>

                </div>
    @endif
    <!-- Modal -->
    <div class="modal fade" id="InProgressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Query In-Progress</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('queryAction') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="text" hidden name="queryID" value="{{ $query->id }}">
                        <div class="row">
                            <div class="col-12">
                                <label for="query_status">Query Status</label>
                                <select class="form-select" id="query_status" name="query_status" required>
                                    <option value="{{ null }}">Select Status</option>
                                    <option value="1">In Progress</option>
                                    <option value="2">Closed</option>
                                    <option value="3">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="query_resolution">Query Resolution</label>
                                <textarea class="form-control" id="query_resolution" rows="3" name="query_resolution" required></textarea>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary"> Save </button>

                </div>
                </form>
            </div>
        </div>
    </div>


    {{--  Query Raiser Action  --}}


    <div class="modal fade" id="QueryRaiserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Query User Action</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('QueryUserAction') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="text" hidden name="queryID" value="{{ $query->id }}">
                        <div class="row">
                            <div class="col-12">
                                <label for="query_status">Query Status</label>
                                <select class="form-select" id="query_status" name="query_status">
                                    <option value="{{ null }}">Select an option</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Closed</option>

                                </select>
                            </div>
                            <div class="col-12">
                                <label for="query_resolution">Query Comment</label>
                                <textarea class="form-control" id="query_resolution" rows="3" name="query_resolution" required></textarea>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"> Save </button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
