@extends('layouts.app')
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
    <input type="text" data-url="{{ route('ShowQueryList') }}" id="data-url" hidden>
    <div class="shadow-sm mt-3 rounded mb-3" style="background-color: white">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between align-items-center mb-2">
                <h1 class="fw-bolder mb-0">Queries</h1>
                <a href="{{ route('querySubmission') }}" class="btn btn-success m-2">Raise Query</a>
            </div>
        </div>
        <div class="p-2  ">
            <table id="queryTable" class="table table-striped table-bordered table-hover bg-dark" cellspacing="0"
                width="100%">
                <thead class=" ">
                    <tr>
                        <th class="bg-dark" style="color: white">Sr No.</th>
                        <th class="bg-dark" style="color: white">Query ID</th>
                        <th class="bg-dark" style="color: white">Name</th>
                        <th class="bg-dark" style="color: white">Email</th>
                        @if (auth()->user()->department == 1)
                            {{-- <th>Query For</th>
                            <th>Query Type</th> --}}
                            <th class="bg-dark" style="color: white">Query Status</th>
                            <th class="bg-dark" style="color: white"> Status</th>
                        @endif
                        <th class="bg-dark" style="color: white">Query Comment</th>
                        <th class="bg-dark" style="color: white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @if (!empty($queryList))
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
                    @endif --}}
                </tbody>


            </table>

        </div>
    </div>
@endsection
@extends('layouts.appInclude')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        let url = $('#data-url').attr('data-url');
        var table = $('#queryTable').DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            serverSide: true,
            processing: true,
            "ajax": {
                "url": url,
                "type": "GET",
                "data": function(d) {
                    d.department = $('#departments').val();
                    d.QueryMember = $('#QueryMember').val();
                    d.queryStatus = $('#queryStatus').val();
                    d.searchbyID = $('#searchbyID').val();
                    d.queryFilter = $('#queryFilter').val();
                }
            },
            "columns": [{
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    },
                },
                {
                    "data": "query_id"
                },
                {
                    "data": "name"
                },
                {
                    "data": "email"
                },
                @if (auth()->user()->department == 1)
                    {
                        "data": "query_status", // Query Status
                        "render": function(data, type, row) {
                            if (data == 1)
                                return '<span class="badge bg-warning">In Progress</span>';
                            if (data == 2)
                                return '<span class="badge bg-success">Closed</span>';
                            if (data == 3)
                                return '<span class="badge bg-danger">Canceled</span>';
                            return '<span class="badge bg-secondary">Pending</span>';
                        }
                    }, {
                        "data": "status", // Status
                        "render": function(data, type, row) {
                            return data == 1 ?
                                '<span class="badge bg-success">Resolved</span>' :
                                '<span class="badge bg-warning">Pending</span>';
                        }
                    },
                @endif {
                    "data": "query_content"
                },
                {
                    "data": null, // Action buttons
                    "render": function(data, type, row) {
                        let actions = '<a href="/queryShow/' + row.id +
                            '" class="btn btn-sm btn-info"><i class="fa-regular fa-eye"></i></a>';
                        return actions;
                    }
                }
            ],
            language: {
                lengthMenu: "Show _MENU_ records per page",
                zeroRecords: "No records found",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "No records found",
                infoFiltered: "(filtered from _MAX_ total records)",
                search: "Search:",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });


        $('#departments').on('change', function() {
            table.ajax.reload();
        });

        $('#QueryMember').on('change', function() {
            table.ajax.reload();
        });

        $('#queryStatus').on('change', function() {
            table.ajax.reload();
        });

        $('#searchbyID').on('change', function() {
            table.ajax.reload();
        });

        $('#queryFilter').on('change', function() {
            table.ajax.reload();
        });
    });
</script>
