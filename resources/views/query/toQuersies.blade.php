@extends('layouts.app')
@extends('layouts.appInclude')
<style>
    .paginate_button {
        border-radius: 0 !important;
    }
</style>
@php
    $departments = App\Models\Departments::orderBy('name', 'ASC')->get();
@endphp
@section('content')
    @if (auth()->user()->department == 1)
        @include('query.filter')
    @endif

    <div class="  col-md-12 shadow-sm mt-3 rounded mb-3" style="background-color: white">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between align-items-center mb-2">
                <h1 class="fw-bolder mb-0">Queries</h1>
                <a href="{{ route('querySubmission') }}" class="btn btn-success m-2">Raise Query</a>
            </div>
        </div>
        <div class="p-2  ">
            <table id="dataTable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                <thead class=" ">
                    <tr>
                        <th class="bg-dark" style="color: white">Sr No.</th>
                        <th class="bg-dark" style="color: white">Query ID</th>
                        <th class="bg-dark" style="color: white">Name</th>
                        <th class="bg-dark" style="color: white">Email</th>
                        @if (auth()->user()->department == 1)
                            <th class="bg-dark" style="color: white">Query For</th>
                            <th class="bg-dark" style="color: white">Query Type</th>
                            <th class="bg-dark" style="color: white">Query Status</th>
                            <th class="bg-dark" style="color: white">Status</th>
                        @endif
                        <th class="bg-dark" style="color: white">Query Comment</th>
                        <th class="bg-dark" style="color: white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($queryList))
                        @foreach ($queryList as $queries)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $queries->query_id ?? 'N/A' }}</td>
                                <td>{{ $queries->name ?? 'N/A' }}</td>
                                <td>{{ $queries->email ?? 'N/A' }}</td>
                                @if (auth()->user()->department == 1)
                                    <td>{{ $queries->queryUser->name ?? 'N/A' }}</td>
                                    <td>{{ $queries->QueryDepartment->name ?? 'N/A' }}</td>
                                    <td>
                                        <span
                                            class="badge 
											@if ($queries->query_status == 1) bg-warning
											@elseif($queries->query_status == 2) bg-success
											@elseif($queries->query_status == 3) bg-danger
											@else bg-secondary @endif">
                                            @if ($queries->query_status == 1)
                                                In Progress
                                            @elseif($queries->query_status == 2)
                                                Closed
                                            @elseif($queries->query_status == 3)
                                                Canceled
                                            @else
                                                Pending
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge 
											@if ($queries->status == 1) bg-success @else bg-warning @endif">
                                            {{ $queries->status == 1 ? 'Resolved' : 'Pending' }}
                                        </span>
                                    </td>
                                @endif
                                <td>{{ $queries->query_content ?? 'N/A' }}</td>
                                <td>
                                    @if (auth()->check() && $departments->contains('id', auth()->user()->department_id))
                                        <a href="{{ route('QueryRemove', ['id' => $queries->id]) }}"
                                            class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-user-xmark"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('queryShow', ['id' => $queries->id]) }}"
                                        class="btn btn-sm btn-info"><i class="fa-regular fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>

                {{-- <tfoot>
                    <tr>
                        <th>Sr No.</th>
                        <th>Query ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        @if (auth()->user()->department == 1)
                            <th>Query For</th>
                            <th>Query Type</th>
                            <th>Query Status</th>
                            <th>Status</th>
                        @endif
                        <th>Query Comment</th>
                        <th>Action</th>
                    </tr>
                </tfoot> --}}
            </table>

        </div>
    </div>
@endsection
