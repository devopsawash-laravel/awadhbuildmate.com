@extends('layouts.app')

@section('title', 'Labour Registry')
@section('page-title', 'Labour Registry')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@300;400;500;600;700;800&family=Barlow:wght@300;400;500;600&display=swap');

    .lr-root {
        --orange:       #D95C2B;
        --orange-soft:  #FEF0E8;
        --orange-text:  #A3400F;
        --blue:         #0D2461;
        --blue-mid:     #1E40AF;
        --blue-soft:    #EBF0FD;
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
    .lr-header {
        padding: 32px 0 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 28px;
    }

    .lr-eyebrow {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 5px;
    }

    .lr-heading {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: clamp(22px, 3vw, 30px);
        font-weight: 700;
        letter-spacing: 0.01em;
        text-transform: uppercase;
        color: var(--ink);
        line-height: 1;
    }

    .lr-heading span { color: var(--orange); }

    /* ─── ADD LABOUR BUTTON (Glossy Orange) ─── */
    .lr-add-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 10px 20px;
        min-height: 38px;
        width: max-content;
        flex-shrink: 0;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #fff !important;
        cursor: pointer;
        border: none;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        letter-spacing: 0.01em;
        white-space: nowrap;
        line-height: 1.3;
        background: linear-gradient(180deg, #fdba74 0%, #f97316 30%, #ea580c 60%, #c2410c 100%);
        box-shadow:
            0 1px 0 rgba(255,255,255,0.45) inset,
            0 -1px 0 rgba(0,0,0,0.3) inset,
            0 0 0 1px #9a3412,
            0 4px 14px rgba(234,88,12,0.55),
            0 1px 3px rgba(0,0,0,0.3);
        transition: box-shadow 0.15s, transform 0.15s, filter 0.15s;
    }

    .lr-add-btn::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 52%;
        background: linear-gradient(180deg, rgba(255,255,255,0.40) 0%, rgba(255,255,255,0.05) 100%);
        border-radius: 10px 10px 60% 60%;
        pointer-events: none;
    }

    .lr-add-btn::after {
        content: '';
        position: absolute;
        top: -60%; left: -60%;
        width: 40%; height: 200%;
        background: linear-gradient(105deg, transparent 35%, rgba(255,255,255,0.26) 50%, transparent 65%);
        transform: skewX(-15deg);
        animation: gloss-sweep 2.8s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes gloss-sweep {
        0%   { left: -60%; }
        55%  { left: 130%; }
        100% { left: 130%; }
    }

    .lr-add-btn i    { font-size: 15px; filter: drop-shadow(0 1px 1px rgba(0,0,0,0.3)); position: relative; z-index: 1; }
    .lr-add-btn span { position: relative; z-index: 1; }

    .lr-add-btn:hover {
        filter: brightness(1.1);
        transform: translateY(-2px);
        color: #fff !important;
        text-decoration: none;
        box-shadow:
            0 1px 0 rgba(255,255,255,0.45) inset,
            0 -1px 0 rgba(0,0,0,0.3) inset,
            0 0 0 1px #9a3412,
            0 8px 24px rgba(234,88,12,0.65),
            0 2px 6px rgba(0,0,0,0.25);
    }

    .lr-add-btn:active {
        filter: brightness(0.95);
        transform: translateY(1px);
    }

    /* ── Filter Card ── */
    .lr-filter-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-end;
        gap: 14px;
        flex-wrap: wrap;
    }

    .lr-filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
        flex: 1;
        min-width: 180px;
    }

    .lr-filter-group label {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
    }

    .lr-filter-group input,
    .lr-filter-group select {
        height: 36px;
        padding: 0 10px;
        font-size: 13px;
        border: 1px solid var(--border);
        border-radius: 7px;
        background: var(--surface);
        color: var(--ink);
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        width: 100%;
    }

    .lr-filter-group input:focus,
    .lr-filter-group select:focus {
        border-color: var(--orange);
        box-shadow: 0 0 0 3px rgba(217,92,43,0.1);
        background: var(--white);
    }

    .lr-filter-btns {
        display: flex;
        gap: 8px;
        align-items: flex-end;
        padding-bottom: 0;
    }

    .lr-btn-filter {
        height: 36px;
        padding: 0 16px;
        background: var(--orange);
        color: #fff;
        border: none;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }
    .lr-btn-filter:hover { background: #c2410c; }

    .lr-btn-clear {
        height: 36px;
        padding: 0 16px;
        background: var(--white);
        color: var(--muted);
        border: 1px solid var(--border);
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: border-color 0.15s, color 0.15s;
    }
    .lr-btn-clear:hover { border-color: var(--orange); color: var(--orange); }

    /* ── Main Table Card ── */
    .lr-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-top: 3px solid var(--orange);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
    }

    .lr-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        gap: 12px;
    }

    .lr-card-header-left {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .lr-card-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: var(--orange-soft);
        color: var(--orange);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .lr-card-title {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--ink);
    }

    .lr-count-badge {
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
    .lr-table-wrap { overflow-x: auto; }

    .lr-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 1100px;
    }

    /* Header row */
    .lr-table thead tr {
        background: #F1F5F9;
    }

    .lr-table thead th {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--muted);
        padding: 11px 14px;
        text-align: left;
        white-space: nowrap;
        border: 1px solid var(--border);
        background: #F1F5F9;
    }

    .lr-table thead th:first-child { border-left: none; }
    .lr-table thead th:last-child  { border-right: none; }

    /* Body rows */
    .lr-table tbody tr:nth-child(even) td { background: #FAFBFC; }
    .lr-table tbody tr:hover td { background: #FEF6F1 !important; }

    .lr-table tbody td {
        padding: 11px 14px;
        border: 1px solid var(--border);
        color: var(--ink);
        vertical-align: middle;
        font-size: 13px;
        white-space: nowrap;
    }

    .lr-table tbody td:first-child { border-left: none; }
    .lr-table tbody td:last-child  { border-right: none; }

    /* ── Cell styles ── */
    .lr-srno {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: var(--muted);
        text-align: center;
        width: 48px;
    }

    .lr-emp-id {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
        background: var(--border-light);
        border: 1px solid var(--border);
        border-radius: 4px;
        padding: 2px 7px;
        display: inline-block;
    }

    .lr-name {
        font-weight: 600;
        font-size: 13px;
        color: var(--ink);
    }

    .lr-cat-badge {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        background: var(--orange-soft);
        color: var(--orange-text);
        border: 1px solid #FDDCC9;
        border-radius: 5px;
        padding: 3px 9px;
        white-space: nowrap;
    }

    .lr-wage {
        font-weight: 700;
        color: var(--ink);
        font-variant-numeric: tabular-nums;
    }

    .lr-pending-amt {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12.5px;
        font-weight: 700;
        color: var(--danger);
        background: var(--danger-soft);
        border: 1px solid #FECACA;
        border-radius: 5px;
        padding: 3px 9px;
        display: inline-block;
    }

    .lr-mono {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12px;
        letter-spacing: 0.04em;
        color: var(--muted);
    }

    .lr-site-name {
        font-size: 12px;
        color: var(--ink);
    }

    /* ── Toggle switch ── */
    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }

    .switch input { opacity: 0; width: 0; height: 0; }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background: #D1D5DB;
        transition: .25s;
        border-radius: 999px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background: white;
        transition: .25s;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.18);
    }

    .switch input:checked + .slider { background: var(--orange); }
    .switch input:checked + .slider:before { transform: translateX(20px); }

    /* ── Action buttons ── */
    .lr-action-row { display: flex; gap: 5px; align-items: center; justify-content: center; }

    .lr-action-btn {
        width: 30px;
        height: 30px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        background: none;
        transition: opacity 0.15s, transform 0.1s;
    }
    .lr-action-btn:hover  { opacity: 0.75; }
    .lr-action-btn:active { transform: scale(0.94); }

    .lr-btn-view   { background: #EFF6FF; color: #2563EB; border-color: #BFDBFE; }
    .lr-btn-edit   { background: var(--blue-soft); color: var(--blue-mid); border-color: #C4D4F8; }
    .lr-btn-delete { background: var(--danger-soft); color: var(--danger); border-color: #FECACA; }

    /* ── Column alignment ── */
    .col-center { text-align: center; }
    .col-right  { text-align: right; font-variant-numeric: tabular-nums; }

    /* ── Pagination ── */
    .lr-pagination {
        padding: 14px 20px;
        border-top: 1px solid var(--border);
        background: var(--surface);
    }

    /* ── Empty state ── */
    .lr-empty {
        text-align: center;
        padding: 52px 20px;
        color: var(--muted);
    }

    .lr-empty i {
        font-size: 34px;
        margin-bottom: 12px;
        opacity: 0.28;
        display: block;
        color: var(--orange);
    }

    .lr-empty p {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin: 0;
    }

    .lr-empty a { color: var(--orange); text-decoration: underline; }

    @media (max-width: 640px) {
        .lr-header { flex-direction: column; align-items: flex-start; gap: 12px; }
    }
</style>

<div class="lr-root">

    {{-- ── Header ── --}}
    <div class="lr-header">
        <div>
            <div class="lr-eyebrow">Site Operations</div>
            <h1 class="lr-heading">Labour <span>Registry</span></h1>
        </div>
        <a href="{{ route('labours.create') }}" class="lr-add-btn">
            <i class="fas fa-user-plus"></i>
            <span>Add Labour</span>
        </a>
    </div>

    {{-- ── Filters ── --}}
    <div class="lr-filter-card">
        <form method="GET" style="display:contents;">

            <div class="lr-filter-group">
                <label>Search</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Name or Employee ID...">
            </div>

            <div class="lr-filter-group" style="min-width:180px;max-width:220px;">
                <label>Category</label>
                <select name="category" id="category">
                    <option value="">All Categories</option>
                    @foreach([
                        'Welder','Fitter','Helper','Rigger','Assistant Fitter',
                        'Grinder','Taker Welder','Gas Cutter','Khallasi Helper',
                        'Visual Grinder','Structure Fitter'
                    ] as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="lr-filter-group" style="min-width:150px;max-width:180px;">
                <label>Status</label>
                <select name="status" id="status">
                    <option value="">All Status</option>
                    <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="lr-filter-group" style="min-width:180px;max-width:220px;">
                <label>Site</label>
                <select name="site_id" id="site">
                    <option value="">All Sites</option>
                    @foreach($sites as $site)
                        <option value="{{ $site->id }}" {{ request('site_id') == $site->id ? 'selected' : '' }}>
                            {{ $site->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="lr-filter-btns">
                <button type="submit" class="lr-btn-filter">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('labours.index') }}" class="lr-btn-clear">
                    <i class="fas fa-times"></i> Clear
                </a>
            </div>

        </form>
    </div>

    {{-- ── Table Card ── --}}
    <div class="lr-card">

        <div class="lr-card-header">
            <div class="lr-card-header-left">
                <div class="lr-card-icon">
                    <i class="fas fa-hard-hat"></i>
                </div>
                <span class="lr-card-title">Labour Records</span>
            </div>
            <span class="lr-count-badge">
                {{ $labours->total() }} {{ Str::plural('Record', $labours->total()) }}
            </span>
        </div>

        <div class="lr-table-wrap">
            <table class="lr-table">
                <thead>
                    <tr>
                        <th class="col-center" style="width:48px;">SR.NO</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Phone</th>
                        <th class="col-right">Daily Wage</th>
                        <th>Site</th>
                        <th class="col-center">OT Hours</th>
                        <th class="col-center">Status</th>
                        <th>Account No.</th>
                        <th>PAN Card</th>
                        <th>UAN</th>
                        <th class="col-right">Pending Adv.</th>
                        <th class="col-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($labours as $labour)
                    <tr>

                        <td class="lr-srno col-center">
                            {{ ($labours->currentPage() - 1) * $labours->perPage() + $loop->iteration }}
                        </td>

                        <td><span class="lr-emp-id">{{ $labour->employee_id }}</span></td>

                        <td><span class="lr-name">{{ $labour->name }}</span></td>

                        <td><span class="lr-cat-badge">{{ $labour->category }}</span></td>

                        <td class="lr-mono">{{ $labour->phone ?? '—' }}</td>

                        <td class="col-right lr-wage">₹{{ number_format($labour->daily_wage, 0) }}</td>

                        <td class="lr-site-name">{{ $labour->site->name ?? '—' }}</td>

                        <td class="col-center lr-mono">{{ $labour->overtime_hours }} hrs</td>

                        <td class="col-center">
                            <form method="POST" action="{{ route('labours.toggleStatus', $labour->id) }}">
                                @csrf
                                @method('PUT')
                                <label class="switch">
                                    <input type="checkbox"
                                           onchange="this.form.submit()"
                                           {{ $labour->status === 'active' ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </form>
                        </td>

                        <td class="lr-mono">{{ $labour->Account_Number ?? '—' }}</td>
                        <td class="lr-mono">{{ $labour->Pan_Card ?? '—' }}</td>
                        <td class="lr-mono">{{ $labour->UAN ?? '—' }}</td>

                        <td class="col-right">
                            @php $pending = $labour->getPendingAdvances(); @endphp
                            @if($pending > 0)
                                <span class="lr-pending-amt">₹{{ number_format($pending, 0) }}</span>
                            @else
                                <span class="lr-mono">—</span>
                            @endif
                        </td>

                        <td class="col-center">
                            <div class="lr-action-row">
                                <a href="{{ route('labours.show', $labour) }}"
                                   class="lr-action-btn lr-btn-view" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('labours.edit', $labour) }}"
                                   class="lr-action-btn lr-btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST"
                                      action="{{ route('labours.destroy', $labour) }}"
                                      onsubmit="return confirm('Delete this labour?')"
                                      style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="lr-action-btn lr-btn-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="14">
                            <div class="lr-empty">
                                <i class="fas fa-users"></i>
                                <p>No labours found. <a href="{{ route('labours.create') }}">Add one</a>.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($labours->hasPages())
        <div class="lr-pagination">
            {{ $labours->withQueryString()->links() }}
        </div>
        @endif

    </div>

</div>

<script>
$(document).ready(function () {
    $('#category').select2({ placeholder: "Select Category", allowClear: true, width: '100%' });
    $('#status').select2({ placeholder: "All Status", allowClear: true, width: '100%' });
    $('#site').select2({ placeholder: "All Sites", allowClear: true, width: '100%' });
});
</script>

@endsection