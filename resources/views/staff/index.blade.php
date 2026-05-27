@extends('layouts.app')

@section('title', 'Labour Registry')
@section('page-title', 'Staff Registry')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="page-header">
    <div>
        {{-- <div class="page-title">Staff Registry</div> --}}
        <div class="page-subtitle">Manage all site staff records</div>
    </div>
    <a href="{{ route('staff.create')}}" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Add Staff
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body" style="padding:14px 20px;">
        <form method="GET" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
            <div style="flex:1;min-width:200px;">
                <label>Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or Employee ID..." id="search">
            </div>
            <div style="min-width:150px;">
                <label>Category</label>
                <select name="category" id="category_staff">
                    <option value="">All Categories</option>
                    @foreach(['Site Incharge','QC-Quality','Safety Supervisor','Planning','Execution','Admin','Supervisor'] as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div style="min-width:220px;">
                <label>Site</label>
                <select name="site_id" id="site_staff" class="site-dropdown">
                    <option value="">
                        All Sites
                    </option>
                    @foreach($sites as $site)
                        <option value="{{ $site->id }}"
                            {{ request('site_id') == $site->id ? 'selected' : '' }}>
                            {{ $site->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="min-width:120px;">
                <label>Status</label>
                <select name="status" id="status">
                    <option value="">All</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Filter</button>
            <a href="{{ route('staff.index') }}" class="btn btn-outline">Clear</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Site</th>
                        <th>Education</th>
                        <th>Experience/Y</th>
                        <th>Salary</th>
                        <th>Status</th>
                        <th>Joining Date</th>
                        <th>Actions</th>
                    </tr>
            </thead>
            </thead>
            <tbody>

@forelse($staff as $member)

<tr>

    {{-- Employee ID --}}
    <td>
        <span style="
            font-family:monospace;
            font-size:13px;
            color:var(--text-muted);
        ">
            {{ $member->employee_id }}
        </span>
    </td>

    {{-- Name --}}
    <td>
        <strong>{{ $member->name }}</strong>
    </td>

    {{-- Designation --}}
    <td>
        <span class="badge badge-primary">
            {{ $member->category }}
        </span>
    </td>

    {{-- Site --}}
    <td>
        {{ $member->site->name ?? '-' }}
    </td>

    {{-- Education --}}
    <td>
        {{ $member->education ?? '-' }}
    </td>

    {{-- Experience --}}
    <td>
        {{ $member->experience ?? '-' }}
    </td>

    {{-- Salary --}}
    <td>
        ₹{{ number_format($member->total_salary ?? 0, 0) }}
    </td>

    {{-- Status --}}
    <td>
        <span class="badge {{ $member->status === 'active'
            ? 'badge-success'
            : 'badge-danger' }}">
            {{ ucfirst($member->status) }}
        </span>
    </td>

    {{-- Joining Date --}}
    <td>
        {{ \Carbon\Carbon::parse($member->joining_date)->format('d M Y') }}
    </td>
    {{-- Actions --}}
    <td>
        <div style="display:flex;gap:5px;">
            {{-- View --}}
            <a href="{{ route('staff.show', $member) }}"
               class="btn btn-sm btn-outline">
                <i class="fas fa-eye"></i>
            </a>
            {{-- Edit --}}
            <a href="{{ route('staff.edit', $member) }}"
               class="btn btn-sm btn-secondary">
                <i class="fas fa-edit"></i>
            </a>
            {{-- Delete --}}
            <form method="POST"
                  action="{{ route('staff.destroy', $member) }}"
                  onsubmit="return confirm('Delete this staff member?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </td>
</tr>

@empty

        <tr>
            <td colspan="10">
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <p>
                        No Staff Found
                        <a href="{{ route('staff.create') }}">
                            Add one
                        </a>
                    </p>
                </div>
            </td>
        </tr>

@endforelse
</tbody>
        </table>
    </div>
    {{-- @if($lastLabour->hasPages())
    <div style="padding:14px 20px;border-top:1px solid var(--border);">
        {{ $lastLabour->links() }}
    </div>
    @endif
</div> --}}
<script>

$(document).ready(function(){
    $('#site_staff').select2({
       placeholder: "Select Site",
        allowClear: true,
        width: '220px'
    });
});

$(document).ready(function(){
    $('#category_staff').select2({
       placeholder: "Select Category",
        allowClear: true,
        width: '220px'
    });
});

$(document).ready(function(){
    $('#status').select2({
       placeholder: "Status",
        allowClear: true,
        width: '220px'
    });
});

// $(document).ready(function(){
//     $('#search').select2({
//        placeholder: "Name or Employee ID...",
//         allowClear: true,
//         width: '220px'
//     });
// });



</script>   
@endsection
