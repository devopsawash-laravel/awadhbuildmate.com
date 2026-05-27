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

    .lr-add-btn {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 12.5px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        background: var(--orange);
        color: var(--white);
        border: none;
        border-radius: 7px;
        padding: 0 18px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        transition: opacity 0.18s ease, transform 0.15s ease;
        white-space: nowrap;
    }

    .lr-add-btn:hover { opacity: 0.88; transform: translateY(-1px); color: var(--white); }

    /* ── Cards ── */
    .lr-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .lr-card--orange { border-top: 3px solid var(--orange); }
    .lr-card--blue   { border-top: 3px solid var(--blue-mid); }

    .lr-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 20px;
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
        width: 28px;
        height: 28px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
    }

    .lr-card-icon--orange { background: var(--orange-soft); color: var(--orange); }
    .lr-card-icon--blue   { background: var(--blue-soft);   color: var(--blue-mid); }

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
        font-family: 'Barlow', sans-serif;
        font-size: 13px;
    }

    .lr-table thead tr {
        background: var(--surface);
        border-bottom: 2px solid var(--border);
    }

    .lr-table th {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--muted);
        padding: 11px 14px;
        text-align: left;
        white-space: nowrap;
    }

    .lr-table td {
        padding: 12px 14px;
        border-bottom: 1px solid var(--border-light);
        color: var(--ink);
        vertical-align: middle;
    }

    .lr-table tbody tr:last-child td { border-bottom: none; }
    .lr-table tbody tr { transition: background 0.15s ease; }
    .lr-table tbody tr:hover { background: #FAFBFC; }

    /* ── Cell styles ── */
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
        font-size: 13.5px;
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
        font-weight: 600;
        color: var(--ink);
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
    .lr-action-row { display: flex; gap: 5px; align-items: center; }

    .lr-root .btn.btn-sm.btn-outline {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.06em;
        background: var(--white);
        color: var(--muted);
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 0 11px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: border-color 0.15s, color 0.15s;
    }

    .lr-root .btn.btn-sm.btn-outline:hover {
        border-color: var(--orange);
        color: var(--orange);
    }

    .lr-root .btn.btn-sm.btn-secondary {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.06em;
        background: var(--blue-soft);
        color: var(--blue-mid);
        border: 1px solid #C4D4F8;
        border-radius: 6px;
        padding: 0 11px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: background 0.15s;
    }

    .lr-root .btn.btn-sm.btn-secondary:hover {
        background: #D8E4FC;
    }

    .lr-root .btn.btn-sm.btn-danger {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        font-weight: 600;
        background: var(--danger);
        color: var(--white);
        border: none;
        border-radius: 6px;
        padding: 0 11px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        transition: opacity 0.15s;
    }

    .lr-root .btn.btn-sm.btn-danger:hover { opacity: 0.85; }

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

    .lr-empty a {
        color: var(--orange);
        text-decoration: underline;
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
        .lr-header { flex-direction: column; align-items: flex-start; gap: 12px; }
    }
</style>

<div class="lr-root">

    {{-- Header --}}
    <div class="lr-header">
        <div>
            <div class="lr-eyebrow">Site Operations</div>
            <h1 class="lr-heading">Labour <span>Registry</span></h1>
        </div>
        <a href="{{ route('labours.create') }}" class="lr-add-btn">
            <i class="fas fa-user-plus"></i> Add Labour
        </a>
    </div>


    {{-- ══════════════════════════════════════
         FILTERS — layout & colours untouched
         ══════════════════════════════════════ --}}
    <div class="card mb-4">

        <div class="card-body"
             style="
                padding:16px 20px;
                display:flex;
                justify-content:space-between;
                align-items:end;
                gap:14px;
                flex-wrap:wrap;
             ">

            <form method="GET"
                  style="
                    display:flex;
                    gap:14px;
                    align-items:end;
                    flex-wrap:wrap;
                    width:100%;
                  ">

                {{-- Search --}}
                <div style="flex:1;min-width:220px;">
                    <label>Search</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Name or Employee ID...">
                </div>

                {{-- Category --}}
                <div style="min-width:220px;">
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

                {{-- Status --}}
                <div style="min-width:220px;">
                    <label>Status</label>
                    <select name="status" id="status">
                        <option value="">All Status</option>
                        <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Site --}}
                <div style="min-width:240px;">
                    <label>Site</label>
                    <select name="site_id" id="site" onchange="this.form.submit()">
                        <option value="">All Sites</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}">{{ $site->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Buttons --}}
                <div style="display:flex;gap:10px;">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('labours.index') }}" class="btn btn-outline">Clear</a>
                </div>

            </form>

        </div>

    </div>


    {{-- ════════════════════════
         LABOUR TABLE — styled
         ════════════════════════ --}}
    <div class="lr-card lr-card--orange">

        <div class="lr-card-header">
            <div class="lr-card-header-left">
                <div class="lr-card-icon lr-card-icon--orange">
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
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Phone</th>
                        <th>Daily Wage</th>
                        <th>Site</th>
                        <th>OT Hours</th>
                        <th>Status</th>
                        <th>Account No.</th>
                        <th>PAN Card</th>
                        <th>UAN</th>
                        <th>Pending Adv.</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($labours as $labour)
                    <tr>
                        <td><span class="lr-emp-id">{{ $labour->employee_id }}</span></td>

                        <td><span class="lr-name">{{ $labour->name }}</span></td>

                        <td><span class="lr-cat-badge">{{ $labour->category }}</span></td>

                        <td class="lr-mono">{{ $labour->phone ?? '—' }}</td>

                        <td class="lr-wage">₹{{ number_format($labour->daily_wage, 0) }}</td>

                        <td>{{ $labour->site->name ?? '—' }}</td>

                        <td class="lr-mono">{{ $labour->overtime_hours }} hrs</td>

                        <td>
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

                        <td>
                            @php $pending = $labour->getPendingAdvances(); @endphp
                            @if($pending > 0)
                                <span class="lr-pending-amt">₹{{ number_format($pending, 0) }}</span>
                            @else
                                <span style="color:var(--muted);">—</span>
                            @endif
                        </td>

                        <td>
                            <div class="lr-action-row">
                                <a href="{{ route('labours.show', $labour) }}"
                                   class="btn btn-sm btn-outline" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('labours.edit', $labour) }}"
                                   class="btn btn-sm btn-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST"
                                      action="{{ route('labours.destroy', $labour) }}"
                                      onsubmit="return confirm('Delete this labour?')">
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
                        <td colspan="13">
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
            {{ $labours->links() }}
        </div>
        @endif

    </div>

</div>

<script>
$(document).ready(function () {
    $('#category').select2({
        placeholder: "Select Category",
        allowClear: true,
        width: '220px',
    });

    $('#status').select2({
        placeholder: "All Status",
        allowClear: true,
        width: '220px'
    });

    $('#site').select2({
        placeholder: "All Sites",
        allowClear: true,
        width: '220px'
    });
});
</script>

@endsection