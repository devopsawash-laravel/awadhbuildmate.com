@extends('layouts.app')

@section('title', 'Labour Registry')
@section('page-title', 'Labour Registry')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Staff Registry</div>
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
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or Employee ID...">
            </div>
            <div style="min-width:150px;">
                <label>Category</label>
                <select name="category">
                    <option value="">All Categories</option>
                    @foreach(['Site Incharge','QC-Quality','Safety Supervisor','Planning','Execution','Admin','Supervisor'] as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div style="min-width:120px;">
                <label>Status</label>
                <select name="status">
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
                        <th>Experience</th>
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

@endsection