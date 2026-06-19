@extends('layouts.app')

@section('title', $site->name)

@section('page-title', 'Site Details')

@section('content')

<style>
:root {
    --brand:       #EA6C00;
    --brand-lt:    #FFF4EA;
    --brand-dk:    #C45A00;
    --success:     #16A34A;
    --success-bg:  #DCFCE7;
    --warn:        #B45309;
    --warn-bg:     #FEF3C7;
    --muted:       #64748B;
    --border:      #E2E8F0;
    --surface:     #FFFFFF;
    --bg:          #F8FAFC;
    --text:        #0F172A;
    --text-lt:     #475569;
    --radius:      8px;
    --radius-lg:   12px;
}

* { box-sizing: border-box; }

.sd-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px 20px 60px;
    font-family: 'Inter', system-ui, sans-serif;
    color: var(--text);
    background: var(--bg);
}

/* ── Top Bar ── */
.sd-topbar {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}

.sd-title-block {
    display: flex;
    align-items: center;
    gap: 14px;
}

.sd-icon-wrap {
    width: 46px;
    height: 46px;
    background: var(--brand-lt);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.sd-icon-wrap i { font-size: 20px; color: var(--brand); }

.sd-site-name {
    font-size: 20px;
    font-weight: 500;
    color: var(--text);
    line-height: 1.2;
}

.sd-site-sub {
    font-size: 13px;
    color: var(--muted);
    margin-top: 3px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.sd-site-sub .dot {
    width: 3px;
    height: 3px;
    border-radius: 50%;
    background: var(--border);
    display: inline-block;
}

/* ── Status Badge ── */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 13px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 500;
}

.status-badge.active  { background: var(--success-bg); color: var(--success); }
.status-badge.inactive { background: var(--warn-bg);    color: var(--warn); }

.status-badge::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

/* ── Filter Bar ── */
.sd-filter-bar {
    background: var(--surface);
    border: 0.5px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 14px 18px;
    display: flex;
    align-items: flex-end;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 22px;
}

.sd-filter-bar label {
    display: block;
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .4px;
    color: var(--muted);
    margin-bottom: 5px;
}

.sd-filter-bar select {
    height: 34px;
    padding: 0 10px;
    border: 0.5px solid var(--border);
    border-radius: var(--radius);
    font-size: 13px;
    color: var(--text);
    background: var(--bg);
    outline: none;
    cursor: pointer;
    transition: border-color .15s;
}

.sd-filter-bar select:focus { border-color: var(--brand); }

/* ── Buttons ── */
.btn-primary {
    height: 34px;
    padding: 0 16px;
    background: var(--brand);
    color: #fff;
    border: none;
    border-radius: var(--radius);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    text-decoration: none;
    transition: background .15s;
}

.btn-primary:hover { background: var(--brand-dk); }

.btn-ghost {
    height: 34px;
    padding: 0 14px;
    background: transparent;
    color: var(--text-lt);
    border: 0.5px solid var(--border);
    border-radius: var(--radius);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    text-decoration: none;
    transition: background .15s;
}

.btn-ghost:hover { background: var(--bg); }

/* ── Cards ── */
.sd-card {
    background: var(--surface);
    border: 0.5px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    margin-bottom: 18px;
}

.sd-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 13px 18px;
    border-bottom: 0.5px solid var(--border);
    background: var(--bg);
}

.sd-card-header-left {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    font-weight: 500;
    color: var(--text);
}

.sd-card-header-left i { font-size: 15px; color: var(--brand); }

.sd-card-body { padding: 18px; }

/* ── Info Grid ── */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 18px;
}

.info-item label {
    display: block;
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: var(--muted);
    margin-bottom: 4px;
}

.info-item .info-value {
    font-size: 14px;
    font-weight: 500;
    color: var(--text);
}

/* ── Stats Row ── */
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 14px;
    margin-bottom: 18px;
}

.stat-card {
    background: var(--bg);
    border-radius: var(--radius);
    padding: 16px 18px;
    position: relative;
    overflow: hidden;
}

.stat-card::after {
    content: '';
    position: absolute;
    left: 0; top: 0;
    width: 3px;
    height: 100%;
}

.stat-card.orange::after { background: var(--brand); }
.stat-card.amber::after  { background: #F97316; }
.stat-card.yellow::after { background: #FDBA74; }
.stat-card.green::after  { background: var(--success); }

.stat-label {
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: var(--muted);
    margin-bottom: 10px;
}

.stat-value {
    font-size: 26px;
    font-weight: 500;
    color: var(--text);
    letter-spacing: -.5px;
}

.stat-value.green { color: var(--success); }

/* ── Table ── */
.sd-table-wrap { overflow-x: auto; }

.sd-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.sd-table thead tr {
    background: var(--bg);
    border-bottom: 0.5px solid var(--border);
}

.sd-table th {
    padding: 10px 14px;
    text-align: left;
    font-size: 10.5px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: var(--muted);
    white-space: nowrap;
}

.sd-table tbody tr { border-bottom: 0.5px solid var(--border); }
.sd-table tbody tr:last-child { border-bottom: none; }
.sd-table tbody tr:hover { background: var(--bg); }

.sd-table td {
    padding: 12px 14px;
    color: var(--text);
    vertical-align: middle;
}

.sd-table td.dim { color: var(--text-lt); }

/* ── Pills & Badges ── */
.emp-id {
    display: inline-block;
    padding: 2px 8px;
    background: var(--brand-lt);
    color: var(--brand);
    border-radius: 5px;
    font-size: 11.5px;
    font-weight: 500;
    font-family: 'Courier New', monospace;
}

.type-badge {
    display: inline-block;
    padding: 2px 9px;
    border-radius: 5px;
    font-size: 12px;
    font-weight: 500;
    background: var(--brand-lt);
    color: var(--brand-dk);
}

.type-badge.staff { background: var(--warn-bg); color: var(--warn); }

.pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 9px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 500;
}

.pill::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
    flex-shrink: 0;
}

.pill.active   { background: var(--success-bg); color: var(--success); }
.pill.inactive { background: var(--warn-bg);    color: var(--warn); }

/* ── Salary Toggle ── */
.salary-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
}

.salary-toggle {
    position: relative;
    display: inline-block;
    width: 36px;
    height: 20px;
    flex-shrink: 0;
}

.salary-toggle input { opacity: 0; width: 0; height: 0; }

.salary-toggle .slider {
    position: absolute;
    inset: 0;
    background: #CBD5E1;
    border-radius: 50px;
    cursor: pointer;
    transition: .2s;
}

.salary-toggle .slider::before {
    content: '';
    position: absolute;
    width: 14px;
    height: 14px;
    left: 3px;
    top: 3px;
    background: #fff;
    border-radius: 50%;
    transition: .2s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}

.salary-toggle input:checked + .slider { background: var(--primary); }
.salary-toggle input:checked + .slider::before { transform: translateX(16px); }

.salary-label {
    font-size: 12px;
    font-weight: 500;
    min-width: 46px;
}

.salary-label.paid    { color: var(--success); }
.salary-label.pending { color: var(--muted); }

/* ── Empty State ── */
.empty-state {
    text-align: center;
    padding: 48px 20px;
    color: var(--muted);
}

.empty-state i { font-size: 32px; opacity: .3; display: block; margin-bottom: 10px; }
.empty-state p { font-size: 13.5px; margin: 0; }

/* ── Utilities ── */
.wage { font-weight: 500; }

@media print {
    .no-print { display: none !important; }
    .sd-page  { padding: 0; background: #fff; }
    .sd-card, .stat-card { box-shadow: none; }
}

@media (max-width: 640px) {
    .sd-topbar { flex-direction: column; }
    .sd-table th, .sd-table td { padding: 9px 10px; }
}
</style>


<div class="sd-page">

    {{-- ── TOP BAR ── --}}
    <div class="sd-topbar">

        <div class="sd-title-block">
            <div class="sd-icon-wrap">
                <i class="fas fa-building"></i>
            </div>
            <div>
                <div class="sd-site-name">{{ $site->name }}</div>
                <div class="sd-site-sub">
                    {{ $site->location }}
                    <span class="dot"></span>
                    {{ $site->state }}
                </div>
            </div>
        </div>

        <span class="status-badge {{ strtolower($site->status) === 'active' ? 'active' : 'inactive' }}">
            {{ ucfirst($site->status) }}
        </span>

    </div>


    {{-- ── FILTER BAR ── --}}
    <div class="sd-filter-bar no-print">
        <form method="GET" style="display:contents;">

            <div>
                <label>Month</label>
                <select name="month">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $selectedMonth ? 'selected' : '' }}>
                            {{ date('F', mktime(0,0,0,$m,1)) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label>Year</label>
                <select name="year">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="btn-primary" style="margin-top:auto;">
                <i class="fas fa-search"></i> View
            </button>

        </form>

        <div style="margin-left:auto;">
            <a href="{{ route('sites.index') }}" class="btn-ghost">
                <i class="fas fa-arrow-left"></i> Back to Sites
            </a>
        </div>
    </div>


    {{-- ── SITE INFORMATION ── --}}
    <div class="sd-card">
        <div class="sd-card-header">
            <div class="sd-card-header-left">
                <i class="fas fa-info-circle"></i>
                Site Information
            </div>
        </div>
        <div class="sd-card-body">
            <div class="info-grid">

                <div class="info-item">
                    <label>Client</label>
                    <div class="info-value">{{ $site->client ?? '—' }}</div>
                </div>

                <div class="info-item">
                    <label>Site Incharge</label>
                    <div class="info-value">{{ $site->site_incharge ?? '—' }}</div>
                </div>

                <div class="info-item">
                    <label>Incharge Phone</label>
                    <div class="info-value">{{ $site->incharge_phone ?? '—' }}</div>
                </div>

                <div class="info-item">
                    <label>Description</label>
                    <div class="info-value">{{ $site->description ?? '—' }}</div>
                </div>

            </div>
        </div>
    </div>


    {{-- ── STATS ROW ── --}}
    <div class="stats-row">

        <div class="stat-card orange">
            <div class="stat-label">Total Labours</div>
            <div class="stat-value">{{ $labours->count() }}</div>
        </div>

        <div class="stat-card amber">
            <div class="stat-label">Total Staff</div>
            <div class="stat-value">{{ $staffs->count() }}</div>
        </div>

        <div class="stat-card yellow">
            <div class="stat-label">Attendance Records</div>
            <div class="stat-value">{{ $attendanceCount }}</div>
        </div>

        <div class="stat-card green">
            <div class="stat-label">Total Salary Paid</div>
            <div class="stat-value green">₹{{ number_format($totalSalary) }}</div>
        </div>

    </div>


    {{-- ── EMPLOYEE TABLE ── --}}
    <div class="sd-card">

        <div class="sd-card-header">
            <div class="sd-card-header-left">
                <i class="fas fa-users"></i>
                Site Labour List
            </div>
            <span style="font-size:12px; color:var(--muted); font-weight:500;">
                {{ $countLS }} Employees
            </span>
        </div>

        <div class="sd-table-wrap">
            <table class="sd-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Phone</th>
                        <th>Daily Wage</th>
                        <th>Status</th>
                        <th>Salary Paid</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($employees as $index => $e)
                    <tr>

                        <td class="dim" style="font-size:12px;">{{ $index + 1 }}</td>

                        <td><span class="emp-id">{{ $e->employee_id }}</span></td>

                        <td style="font-weight:500;">{{ $e->name }}</td>

                        <td>
                            <span class="type-badge {{ strtolower($e->type) === 'staff' ? 'staff' : '' }}">
                                {{ $e->type }}
                            </span>
                        </td>

                        <td class="dim">{{ $e->category ?? '—' }}</td>

                        <td class="dim">
                            <i class="fas fa-phone" style="font-size:11px; margin-right:4px; opacity:.4;"></i>
                            {{ $e->phone ?? '—' }}
                        </td>

                        <td>
                            <span class="wage">₹{{ number_format($e->daily_wage, 0) }}</span>
                            <span style="font-size:11px; color:var(--muted); margin-left:2px;">/day</span>
                        </td>

                        <td>
                            <span class="pill {{ strtolower($site->status) === 'active' ? 'active' : 'inactive' }}">
                                {{ ucfirst($site->status) }}
                            </span>
                        </td>

                      <td>
    @if($e->salarySlip)

        <div class="salary-wrap">

            <label class="salary-toggle">
                <input type="checkbox"
                       {{ $e->salarySlip->salary_paid ? 'checked' : '' }}
                       onchange="toggleSalaryStatus(
                           {{ $e->salarySlip->id }},
                           this.checked,
                           this
                       )">
                <span class="slider"></span>
            </label>

            <span class="salary-label {{ $e->salarySlip->salary_paid ? 'paid' : 'pending' }}"
                  id="salary-label-{{ $e->salarySlip->id }}">
                {{ $e->salarySlip->salary_paid ? 'Paid' : 'Pending' }}
            </span>

        </div>

    @else

        <span class="salary-label pending">No Slip</span>

    @endif
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <p>No employees assigned to this site yet.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>

</div>

<script>
function toggleSalaryStatus(salaryId, status, checkbox) {

    const label = document.getElementById('salary-label-' + salaryId);

    fetch(`/salary/${salaryId}/mark-paid`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            salary_paid: status
        })
    })
    .then(res => res.json())
    .then(data => {
            if (label) {
                label.textContent = status ? 'Paid' : 'Pending';
                label.className = 'salary-label ' + (status ? 'paid' : 'pending');
            }
    })
    .catch(() => {
        checkbox.checked = !status;
    });
}
</script>

@endsection