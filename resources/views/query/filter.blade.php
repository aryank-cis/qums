@php
    $departments = App\Models\Departments::orderBy('name', 'ASC')
        ->whereNotIn('name', ['Super Admin', 'developer'])
        ->get();
@endphp
{{-- <div class="container card mt-2 p-2 sticky-top" style="top: 60px; z-index: 1030;"> --}}
<div class=" card mt-2 p-3 pb-3 ml-5">
    <h3>Query Filter</h3>
    <div class="row">
        <div class="col-md-4">
            <label class="control-label">Departments</label>
            <select class="form-select" id="departments" data-url="{{ route('QueryMember') }} ">
                <option value="{{ null }}">Select an option</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="control-label">Employee</label>
            <select class="form-select" id="QueryMember">
                <option value="{{ null }}">Select an option</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="control-label">Query Status</label>
            <select class="form-select" id="queryStatus" name="queryStatus">
                <option value="{{ null }}" selected>Select an option</option>
                <option value="1">In-Progress</option>
                <option value="2">Completed</option>
                <option value="3">Cancelled</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="control-label">Search by ID</label>
            <input type="text" class="form-control" name="searchbyID" id="searchbyID"
                placeholder="search by Query ID">
        </div>
        <div class="col-md-4">
            <label class="control-label">Initiated/Assigned Query</label>
            <select class="form-select" id="queryFilter" name="queryFilter">
                <option value="{{ null }}" selected>Select a status</option>
                <option value="query_for">Query Assigned </option>
                <option value="query_to">Query Initiated </option>
            </select>

        </div>
    </div>
</div>
<script>
    let currentUrl = window.location.href
</script>
