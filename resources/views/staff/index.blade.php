@extends('layouts.app')

@section('title', 'Labour Registry')
@section('page-title', 'Staff Registry')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;500;600;700;800&family=Barlow:wght@300;400;500;600&display=swap');

    /* ── Layout & presentation only — no filter CSS touched ── */
    .sr2-root {
        --blue:         #0D2461;
        --blue-mid:     #1E40AF;
        --blue-light:   #2563EB;
        --blue-soft:    #EBF0FD;
        --blue-border:  #C4D4F8;
        --blue-text:    #0F2D8C;
        --danger:       #DC2626;
        --danger-soft:  #FEF2F2;
        --success:      #059669;
        --success-soft: #ECFDF5;
        --ink:          #0F172A;
        --muted:        #64748B;
        --border:       #E2E8F0;
        --border-light: #F1F5F9;
        --surface:      #F8FAFC;
        --white:        #ffffff;
        font-family: 'Barlow', sans-serif;
        color: var(--ink);
    }

    /* ── Page header ── */
    .sr2-header {
        padding: 32px 0 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 28px;
    }

    .sr2-eyebrow {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 5px;
    }

    .sr2-heading {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: clamp(22px, 3vw, 30px);
        font-weight: 700;
        letter-spacing: 0.01em;
        text-transform: uppercase;
        color: var(--ink);
        line-height: 1;
        margin: 0;
    }

    .sr2-heading span { color: var(--blue-mid); }

    .sr2-header-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sr2-date-badge {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 0.06em;
        color: var(--muted);
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 7px 14px;
        display: flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }

    .sr2-date-badge i { color: var(--blue-mid); font-size: 11px; }

    /* ── Table card ── */
    .sr2-table-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-top: 3px solid var(--blue-mid);
        border-radius: 10px;
        overflow: hidden;
        margin-top: 20px;
    }

    .sr2-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 20px;
        background: var(--surface);
        border-bottom: 1px solid var(--border);
    }

    .sr2-table-header-left {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .sr2-table-icon {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: var(--blue-soft);
        color: var(--blue-mid);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
    }

    .sr2-table-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--ink);
    }

    .sr2-count {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.06em;
        color: var(--muted);
        background: var(--border-light);
        border: 1px solid var(--border);
        border-radius: 5px;
        padding: 3px 10px;
    }

    /* ── Table ── */
    .sr2-table-wrap { overflow-x: auto; }

    .sr2-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Barlow', sans-serif;
        font-size: 13px;
    }

    .sr2-table thead tr {
        background: var(--surface);
        border-bottom: 2px solid var(--border);
    }

    .sr2-table th {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--muted);
        padding: 11px 16px;
        text-align: left;
        white-space: nowrap;
    }

    .sr2-table td {
        padding: 13px 16px;
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
        color: var(--ink);
    }

    .sr2-table tbody tr:last-child td { border-bottom: none; }
    .sr2-table tbody tr { transition: background 0.14s ease; }
    .sr2-table tbody tr:hover { background: #F5F8FF; }

    /* ── Cell styles ── */
    .sr2-emp-id {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
        background: var(--border-light);
        border: 1px solid var(--border);
        border-radius: 4px;
        padding: 2px 8px;
        display: inline-block;
    }

    .sr2-name {
        font-weight: 600;
        font-size: 13.5px;
        color: var(--ink);
    }

    .sr2-cat-badge {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        background: var(--blue-soft);
        color: var(--blue-text);
        border: 1px solid var(--blue-border);
        border-radius: 5px;
        padding: 3px 9px;
        white-space: nowrap;
    }

    .sr2-mono {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12.5px;
        letter-spacing: 0.04em;
        color: var(--muted);
    }

    .sr2-salary {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: var(--ink);
    }

    .sr2-status {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        border-radius: 5px;
        padding: 4px 10px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: 1px solid transparent;
    }

    .sr2-status--active   { background: var(--success-soft); color: var(--success); border-color: #A7F3D0; }
    .sr2-status--inactive { background: var(--danger-soft);  color: var(--danger);  border-color: #FECACA; }

    .sr2-dot {
        width: 5px; height: 5px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .sr2-status--active   .sr2-dot { background: var(--success); animation: sr2-pulse 2s infinite; }
    .sr2-status--inactive .sr2-dot { background: var(--danger); }

    @keyframes sr2-pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }

    /* ── Action buttons — scoped so global CSS unaffected ── */
    .sr2-root .btn.btn-sm.btn-outline {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px; font-weight: 600;
        background: var(--white); color: var(--muted);
        border: 1px solid var(--border); border-radius: 6px;
        padding: 0 11px; height: 30px;
        display: inline-flex; align-items: center; gap: 5px;
        text-decoration: none; transition: border-color 0.15s, color 0.15s;
    }
    .sr2-root .btn.btn-sm.btn-outline:hover { border-color: var(--blue-mid); color: var(--blue-mid); }

    .sr2-root .btn.btn-sm.btn-secondary {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px; font-weight: 600;
        background: var(--blue-soft); color: var(--blue-mid);
        border: 1px solid var(--blue-border); border-radius: 6px;
        padding: 0 11px; height: 30px;
        display: inline-flex; align-items: center; gap: 5px;
        text-decoration: none; transition: background 0.15s;
    }
    .sr2-root .btn.btn-sm.btn-secondary:hover { background: #D8E4FC; }

    .sr2-root .btn.btn-sm.btn-danger {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px; font-weight: 600;
        background: var(--danger); color: var(--white);
        border: none; border-radius: 6px;
        padding: 0 11px; height: 30px;
        display: inline-flex; align-items: center; gap: 5px;
        cursor: pointer; transition: opacity 0.15s;
    }
    .sr2-root .btn.btn-sm.btn-danger:hover { opacity: 0.85; }

    .sr2-action-row { display: flex; gap: 5px; align-items: center; }

    /* ── Pagination ── */
    .sr2-pagination {
        padding: 14px 20px;
        border-top: 1px solid var(--border);
        background: var(--surface);
    }

    /* ── Empty state ── */
    .sr2-empty { text-align: center; padding: 56px 20px; color: var(--muted); }
    .sr2-empty i { font-size: 36px; opacity: 0.25; display: block; margin-bottom: 14px; color: var(--blue-mid); }
    .sr2-empty-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 15px; font-weight: 700;
        letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--ink); margin-bottom: 6px;
    }
    .sr2-empty a { color: var(--blue-mid); text-decoration: underline; }

    /* ── Staff blue button — same as original ── */
    .btn-staff {
        background: #2563eb;
        color: #fff;
        border: none;
        transition: 0.2s ease;
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12.5px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        border-radius: 7px;
        padding: 0 18px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
    }
    .btn-staff:hover { background: #1d4ed8; color: #fff; transform: translateY(-1px); }
    .btn-staff:focus { box-shadow: 0 0 0 3px rgba(37,99,235,.25); }

    @media (max-width: 640px) {
        .sr2-header { flex-direction: column; align-items: flex-start; gap: 12px; }
    }
</style>

<div class="sr2-root">

    {{-- ── Header ── --}}
    <div class="sr2-header">
        <div>
            <div class="sr2-eyebrow">Staff Payroll</div>
            <h1 class="sr2-heading">Staff <span>Registry</span></h1>
        </div>
        <div class="sr2-header-right">
            <div class="sr2-date-badge">
                <i class="fas fa-calendar-alt"></i>
                {{ \Carbon\Carbon::now()->format('d M Y') }}
            </div>
            <a href="{{ route('staff.create') }}" class="btn btn-staff">
                <i class="fas fa-user-plus"></i> Add Staff
            </a>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         FILTERS — exactly as original, untouched
         ══════════════════════════════════════════ --}}
    <div class="form-group">
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
                    <select name="site_id" id="site_id" class="site-dropdown">
                        <option value="">All Sites</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ ($siteId ?? '') == $site->id ? 'selected' : '' }}>
                                {{ $site->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="min-width:120px;">
                    <label>Status</label>
                    <select name="status" id="status">
                        <option value="">All</option>
                        <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Filter</button>
                <a href="{{ route('staff.index') }}" class="btn btn-outline">Clear</a>

            </form>
        </div>
    </div>

    {{-- ── Staff Table ── --}}
    <div class="sr2-table-card">

        <div class="sr2-table-header">
            <div class="sr2-table-header-left">
                <div class="sr2-table-icon"><i class="fas fa-user-tie"></i></div>
                <span class="sr2-table-title">Staff Records</span>
            </div>
            <span class="sr2-count">{{ $staff->count() }} {{ Str::plural('Record', $staff->count()) }}</span>
        </div>

        <div class="sr2-table-wrap">
            <table class="sr2-table">
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
                <tbody>
                    @forelse($staff as $member)
                    <tr>
                        <td><span class="sr2-emp-id">{{ $member->employee_id }}</span></td>

                        <td><span class="sr2-name">{{ $member->name }}</span></td>

                        <td><span class="sr2-cat-badge">{{ $member->category }}</span></td>

                        <td class="sr2-mono">{{ $member->site->name ?? '—' }}</td>

                        <td class="sr2-mono">{{ $member->education ?? '—' }}</td>

                        <td class="sr2-mono">{{ $member->experience ?? '—' }}</td>

                        <td><span class="sr2-salary">₹{{ number_format($member->total_salary ?? 0, 0) }}</span></td>

                        <td>
                            @if($member->status === 'active')
                                <span class="sr2-status sr2-status--active">
                                    <span class="sr2-dot"></span> Active
                                </span>
                            @else
                                <span class="sr2-status sr2-status--inactive">
                                    <span class="sr2-dot"></span> Inactive
                                </span>
                            @endif
                        </td>

                        <td class="sr2-mono">{{ \Carbon\Carbon::parse($member->joining_date)->format('d M Y') }}</td>

                        <td>
                            <div class="sr2-action-row">
                                <a href="{{ route('staff.show', $member) }}" class="btn btn-sm btn-outline" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('staff.edit', $member) }}" class="btn btn-sm btn-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('staff.destroy', $member) }}"
                                      onsubmit="return confirm('Delete this staff member?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="sr2-empty">
                                <i class="fas fa-users"></i>
                                <div class="sr2-empty-title">No Staff Found</div>
                                <p style="font-size:13px;margin-top:4px;">
                                    <a href="{{ route('staff.create') }}">Add your first staff member</a>
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($staff->hasPages())
        <div class="sr2-pagination">{{ $staff->links() }}</div>
        @endif

    </div>

</div>

<script>
$(document).ready(function () {
    $('#site_staff').select2({ placeholder: "Select Site",     allowClear: true, width: '220px' });

    $('#category_staff').select2({
        placeholder: "Select Category",
        allowClear: true,
        width: '220px',
        dropdownParent: $('#category_staff').parent()
    });

    $('#status').select2({
        placeholder: "Status",
        allowClear: true,
        width: '220px',
        dropdownParent: $('#status').parent()
    });

    $('#site_id').on('change', function () { this.form.submit(); });

    $('#site_id').select2({
    placeholder: "Select Site",
    allowClear: true,
    width: '220px',
    dropdownParent: $('#site_id').parent()

});
});
</script>

@endsection