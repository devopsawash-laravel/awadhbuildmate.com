@extends('layouts.app')

@section('title', 'Daily Attendance')
@section('page-title', 'Daily Attendance')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Sora:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
:root {
    --org-50:  #FFF7ED;
    --org-100: #FFEDD5;
    --org-200: #FED7AA;
    --org-400: #FB923C;
    --org-500: #F97316;
    --org-600: #EA580C;
    --org-700: #C2410C;
    --org-800: #9A3412;
    --org-900: #7C2D12;
    --gray-50:  #F8FAFC;
    --gray-100: #F1F5F9;
    --gray-200: #E2E8F0;
    --gray-300: #CBD5E1;
    --gray-400: #94A3B8;
    --gray-500: #64748B;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1E293B;
    --green-50:  #EAF3DE;
    --green-100: #C0DD97;
    --green-500: #22C55E;
    --green-600: #3B6D11;
    --red-50:   #FCEBEB;
    --red-500:  #EF4444;
    --red-600:  #A32D2D;
    --amber-50: #FAEEDA;
    --amber-100: #FAC775;
    --amber-500: #F59E0B;
    --amber-600: #854F0B;
    --blue-50:  #EFF6FF;
    --blue-400: #60A5FA;
    --blue-600: #185FA5;
    --radius-sm: 6px;
    --radius-md: 10px;
    --radius-lg: 14px;
    --font-ui: 'DM Sans', sans-serif;
    --font-display: 'Sora', sans-serif;
}

* { box-sizing: border-box; }
body { font-family: var(--font-ui); }

/* ── Page Header ──────────────────────────── */
.att-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 22px;
}
.att-page-header .ph-title {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 700;
    color: var(--gray-800);
    margin: 0;
}
.att-page-header .ph-sub {
    font-size: 13px;
    color: var(--gray-400);
    margin-top: 3px;
}

/* ── Buttons ──────────────────────────────── */
.att-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    font-family: var(--font-ui);
    font-size: 13px;
    font-weight: 500;
    border-radius: var(--radius-sm);
    cursor: pointer;
    border: 1px solid transparent;
    transition: background .15s, color .15s, border-color .15s;
    text-decoration: none;
    white-space: nowrap;
}
.att-btn-outline {
    background: #fff;
    color: var(--gray-600);
    border-color: var(--gray-200);
}
.att-btn-outline:hover { background: var(--gray-100); color: var(--gray-800); }
.att-btn-orange {
    background: var(--org-600);
    color: #fff;
    border-color: var(--org-600);
}
.att-btn-orange:hover { background: var(--org-800); border-color: var(--org-800); }
.att-btn-primary {
    background: var(--org-900);
    color: #fff;
    border-color: var(--org-900);
}
.att-btn-primary:hover { background: var(--org-800); }
.att-btn-success {
    background: var(--green-600);
    color: #fff;
}
.att-btn-success:hover { filter: brightness(0.9); }
.att-btn-info {
    background: var(--blue-600);
    color: #fff;
}
.att-btn-info:hover { filter: brightness(0.9); }
.att-btn-sm { padding: 7px 13px; font-size: 12px; }

/* ── Filter Card ──────────────────────────── */
.filter-card {
    background: #fff;
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-lg);
    margin-bottom: 20px;
    overflow: hidden;
}
.filter-card-header {
    background: var(--org-900);
    padding: 13px 22px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.filter-card-header .fch-title {
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 600;
    color: #fff;
    letter-spacing: .5px;
}
.filter-card-header i { color: var(--org-200); }
.filter-body {
    padding: 18px 22px;
    display: flex;
    gap: 14px;
    align-items: flex-end;
    flex-wrap: wrap;
}

/* ── Form Controls ────────────────────────── */
.fc-group { display: flex; flex-direction: column; gap: 5px; flex: 1; min-width: 160px; }
.fc-group label {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: var(--gray-400);
}
.fc-group select,
.fc-group input[type="date"] {
    width: 100%;
    padding: 9px 12px;
    font-family: var(--font-ui);
    font-size: 13px;
    color: var(--gray-800);
    background: var(--gray-50);
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-sm);
    outline: none;
    transition: border-color .15s, box-shadow .15s;
}
.fc-group select:focus,
.fc-group input[type="date"]:focus {
    border-color: var(--org-400);
    box-shadow: 0 0 0 3px var(--org-50);
    background: #fff;
}

.search-wrap {
    position: relative;
    flex: 1;
    min-width: 260px;
    max-width: 380px;
}
.search-wrap i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    font-size: 14px;
    pointer-events: none;
}
.search-wrap input {
    width: 100%;
    padding: 9px 36px 9px 36px;
    font-family: var(--font-ui);
    font-size: 13px;
    background: var(--gray-50);
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-sm);
    outline: none;
    transition: border-color .15s, box-shadow .15s;
    color: var(--gray-800);
}
.search-wrap input:focus {
    border-color: var(--org-400);
    box-shadow: 0 0 0 3px var(--org-50);
    background: #fff;
}
.search-wrap input::placeholder { color: var(--gray-400); }
.clear-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: var(--gray-200);
    border: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    font-size: 13px;
    cursor: pointer;
    color: var(--gray-600);
    display: none;
    align-items: center;
    justify-content: center;
    line-height: 1;
}
.clear-btn:hover { background: var(--gray-300); }

/* ── Attendance Card ──────────────────────── */
.att-card {
    background: #fff;
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-lg);
    overflow: hidden;
}
.att-card-header {
    padding: 14px 22px;
    background: var(--org-900);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    flex-wrap: wrap;
}
.att-card-header .ach-date {
    font-family: var(--font-display);
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 8px;
}
.att-card-header .ach-date i { color: var(--org-200); }
.ach-actions { display: flex; gap: 8px; flex-wrap: wrap; }

/* ── Table ────────────────────────────────── */
.table-wrap { overflow-x: auto; }
table.att-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    font-family: var(--font-ui);
}
.att-table thead tr {
    background: var(--org-50);
    border-bottom: 2px solid var(--org-100);
}
.att-table thead th {
    padding: 11px 14px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: var(--org-800);
    text-align: left;
    white-space: nowrap;
}
.att-table tbody td {
    padding: 11px 14px;
    border-bottom: 1px solid var(--gray-100);
    color: var(--gray-800);
    vertical-align: middle;
}
.att-table tbody tr:last-child td { border-bottom: none; }
.att-table tbody tr:hover td { background: var(--org-50); }

.emp-name { font-weight: 600; font-size: 13px; color: var(--gray-800); }
.emp-id   { font-size: 11px; color: var(--gray-400); margin-top: 2px; }

/* Category badge */
.cat-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    background: var(--org-50);
    color: var(--org-800);
    border: 1px solid var(--org-100);
}

/* Wage */
.wage { font-weight: 600; color: var(--gray-700); }

/* Attendance toggle */
.att-toggle {
    display: flex;
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-sm);
    overflow: hidden;
    width: fit-content;
}
.att-toggle .att-opt {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 44px;
    padding: 7px 10px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: background .15s, color .15s;
    user-select: none;
    color: var(--gray-500);
    background: transparent;
    border-right: 1px solid var(--gray-200);
}
.att-toggle .att-opt:last-child { border-right: none; }
.att-toggle .att-opt input[type="radio"] { display: none; }
.att-toggle .att-opt:hover { background: var(--gray-100); color: var(--gray-700); }
.att-toggle .att-opt.sel-present  { background: #22C55E; color: #fff; }
.att-toggle .att-opt.sel-absent   { background: #EF4444; color: #fff; }
.att-toggle .att-opt.sel-half_day { background: #F59E0B; color: #fff; }
.att-toggle .att-opt.sel-week_off { background: #3B82F6; color: #fff; }

/* OT input */
.ot-input {
    width: 90px;
    padding: 7px 10px;
    font-family: var(--font-ui);
    font-size: 13px;
    color: var(--gray-800);
    background: var(--gray-50);
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-sm);
    outline: none;
    transition: border-color .15s, box-shadow .15s;
}
.ot-input:focus {
    border-color: var(--org-400);
    box-shadow: 0 0 0 3px var(--org-50);
    background: #fff;
}

/* ── Footer ───────────────────────────────── */
.att-footer {
    padding: 14px 22px;
    border-top: 1px solid var(--gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--gray-50);
}
.att-footer .footer-count {
    font-size: 12px;
    color: var(--gray-400);
}
.att-footer .footer-count span {
    font-weight: 600;
    color: var(--gray-700);
}

/* ── Empty State ──────────────────────────── */
.empty-block {
    padding: 60px 20px;
    text-align: center;
    color: var(--gray-400);
}
.empty-block i { font-size: 40px; margin-bottom: 14px; color: var(--org-200); }
.empty-block p { font-size: 14px; }
.empty-block a { color: var(--org-600); font-weight: 500; text-decoration: none; }
.empty-block a:hover { color: var(--org-800); }

/* ── Select2 overrides ────────────────────── */
.select2-container--default .select2-selection--single {
    background: var(--gray-50);
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-sm);
    height: 38px;
    display: flex;
    align-items: center;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    font-family: var(--font-ui);
    font-size: 13px;
    color: var(--gray-800);
    line-height: 38px;
    padding-left: 12px;
}
.select2-container--default .select2-selection--single:focus,
.select2-container--default.select2-container--open .select2-selection--single {
    border-color: var(--org-400);
    box-shadow: 0 0 0 3px var(--org-50);
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background: var(--org-600);
}

@media print {
    .att-page-header, .filter-card, .att-btn, .att-footer { display: none !important; }
    .att-card { border: none !important; border-radius: 0 !important; }
    .att-table tbody tr:hover td { background: transparent !important; }
}
</style>

{{-- Page Header --}}
<div class="att-page-header">
    <div>
        <p class="ph-title">Daily Attendance</p>
        <p class="ph-sub">Mark attendance for all active labours</p>
    </div>
    <a href="{{ route('attendance.monthly') }}" class="att-btn att-btn-outline">
        <i class="fas fa-calendar-alt"></i> Monthly Report
    </a>
</div>

{{-- Filter Card --}}
<div class="filter-card">

    <div class="filter-card-header">
        <i class="fas fa-filter"></i>
        <span class="fch-title">Filter Attendance</span>
    </div>

    <div class="filter-body">

        <form method="GET" style="display:contents;">

            {{-- Site --}}
            <div class="fc-group">
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

            {{-- Month --}}
            <div class="fc-group">
                <label>Month</label>
                <select name="month" id="month_select">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0,0,0,$m,1)) }}
                        </option>
                    @endfor
                </select>
            </div>

            {{-- Year --}}
            <div class="fc-group" style="max-width:130px;">
                <label>Year</label>
                <select name="year" id="year_select">
                    <option value=""></option>
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            {{-- Date --}}
            <div class="fc-group" style="max-width:180px;">
                <label>Date</label>
                <input type="date"
                       name="date"
                       id="attendance_date_filter"
                       value="{{ $date }}"
                       max="{{ date('Y-m-d') }}">
            </div>

            <button type="submit" class="att-btn att-btn-orange" style="margin-bottom:1px;">
                <i class="fas fa-search"></i> Load
            </button>

        </form>

        {{-- Live Search --}}
        <div class="search-wrap" style="margin-bottom:1px;">
            <i class="fas fa-search"></i>
            <input type="text"
                   id="labourSearch"
                   placeholder="Search by name, ID or category…">
            <button type="button" id="clearSearch" class="clear-btn">×</button>
        </div>

    </div>
</div>

{{-- Main Content --}}
@if($labours->isEmpty())
    <div class="att-card">
        <div class="empty-block">
            <i class="fas fa-users"></i>
            <p>No active labours found. <a href="{{ route('labours.create') }}">Add labours</a> to get started.</p>
        </div>
    </div>
@else

<form method="POST" action="{{ route('attendance.store') }}">
    @csrf
    <input type="hidden" name="date" value="{{ $date }}">

    <div class="att-card">

        {{-- Card Header --}}
        <div class="att-card-header">
            <div class="ach-date">
                <i class="fas fa-calendar-check"></i>
                Attendance — {{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}
            </div>
            <div class="ach-actions">
                <button type="button" onclick="markAll('present')" class="att-btn att-btn-sm att-btn-success">
                    <i class="fas fa-check-double"></i> All Present
                </button>
                <button type="button" onclick="markAll('week_off')" class="att-btn att-btn-sm att-btn-info">
                    <i class="fas fa-umbrella-beach"></i> All Week Off
                </button>
                <button type="submit" class="att-btn att-btn-sm att-btn-primary">
                    <i class="fas fa-save"></i> Save Attendance
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-wrap">
            <table class="att-table">
                <thead>
                    <tr>
                        <th style="width:44px;">#</th>
                        <th>Labour</th>
                        <th>Category</th>
                        <th>Daily Wage</th>
                        <th style="width:230px;">Attendance</th>
                        <th style="width:120px;">OT Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($labours as $i => $labour)
                    <tr class="labour-row">

                        <td style="color:var(--gray-400);font-size:12px;">{{ $i + 1 }}</td>

                        <td>
                            <div class="emp-name">{{ $labour->name }}</div>
                            <div class="emp-id">{{ $labour->employee_id }}</div>
                        </td>

                        <td>
                            <span class="cat-badge">{{ $labour->category }}</span>
                        </td>

                        <td class="wage">₹{{ number_format($labour->daily_wage, 0) }}</td>

                        <td>
                            <div class="att-toggle">
                                @foreach([
                                    'present'  => ['P',  'present'],
                                    'absent'   => ['A',  'absent'],
                                    'half_day' => ['½',  'half_day'],
                                    'week_off' => ['WO', 'week_off'],
                                ] as $val => [$label, $cls])
                                <label class="att-opt" data-status="{{ $val }}">
                                    <input type="radio"
                                           name="attendance[{{ $labour->id }}]"
                                           value="{{ $val }}">
                                    {{ $label }}
                                </label>
                                @endforeach
                            </div>
                        </td>

                        <td>
                            <input type="number"
                                   name="overtime[{{ $labour->id }}]"
                                   min="0" max="12" step="0.5"
                                   placeholder="0"
                                   class="ot-input">
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="att-footer">
            <div class="footer-count">
                Showing <span id="visibleCount">{{ $labours->count() }}</span> of
                <span>{{ $labours->count() }}</span> labours
            </div>
            <button type="submit" class="att-btn att-btn-primary">
                <i class="fas fa-save"></i> Save Attendance
            </button>
        </div>

    </div>
</form>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Select2 ─────────────────────────────── */
    $('#site').select2({
        placeholder: 'Select Site',
        minimumResultsForSearch: Infinity,
        allowClear: true,
        width: '100%'
    });

    /* ── Date range from month/year ──────────── */
    const monthSel  = document.getElementById('month_select');
    const yearSel   = document.getElementById('year_select');
    const dateInput = document.getElementById('attendance_date_filter');

    function updateDateRange() {
        const m = monthSel.value;
        const y = yearSel.value;
        if (!m || !y) return;
        const first = `${y}-${String(m).padStart(2,'0')}-01`;
        const last  = new Date(y, m, 0).getDate();
        const lastD = `${y}-${String(m).padStart(2,'0')}-${last}`;
        dateInput.min = first;
        dateInput.max = lastD;
        if (!dateInput.value || dateInput.value < first || dateInput.value > lastD) {
            dateInput.value = first;
        }
    }

    monthSel.addEventListener('change', updateDateRange);
    yearSel.addEventListener('change', updateDateRange);
    updateDateRange();

    /* ── Attendance toggle ───────────────────── */
    document.querySelectorAll('.att-opt').forEach(label => {
        label.addEventListener('click', function () {
            const row    = this.closest('tr');
            const status = this.dataset.status;
            row.querySelectorAll('.att-opt').forEach(l => {
                l.className = 'att-opt';
            });
            this.classList.add('sel-' + status);
            this.querySelector('input').checked = true;
        });
    });

    /* ── Mark all ────────────────────────────── */
    window.markAll = function (status) {
        document.querySelectorAll('.labour-row').forEach(row => {
            row.querySelectorAll('.att-opt').forEach(l => {
                l.className = 'att-opt';
            });
            const target = row.querySelector(`.att-opt[data-status="${status}"]`);
            if (target) {
                target.classList.add('sel-' + status);
                target.querySelector('input').checked = true;
            }
        });
    };

    /* ── Live search ─────────────────────────── */
    const searchInput   = document.getElementById('labourSearch');
    const clearBtn      = document.getElementById('clearSearch');
    const visibleCount  = document.getElementById('visibleCount');
    const allRows       = document.querySelectorAll('.labour-row');

    function filterRows() {
        const q = searchInput.value.toLowerCase();
        let visible = 0;
        allRows.forEach(row => {
            const text = row.innerText.toLowerCase();
            const show = text.includes(q);
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        if (visibleCount) visibleCount.textContent = visible;
        clearBtn.style.display = q.length ? 'flex' : 'none';
    }

    searchInput.addEventListener('input', filterRows);

    clearBtn.addEventListener('click', function () {
        searchInput.value = '';
        filterRows();
        searchInput.focus();
    });
});
</script>
@endpush

@endsection