@extends('layouts.app')

@section('title', 'Daily Attendance')
@section('page-title', 'Daily Attendance')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Daily Attendance</div>
        <div class="page-subtitle">Mark attendance for all active labours</div>
    </div>
    <a href="{{ route('attendance.monthly') }}" class="btn btn-outline">
        <i class="fas fa-calendar-alt"></i> Monthly Report
    </a>
</div>

<!-- Date Selector -->
<div class="card mb-4">

    <div class="card-body" style="padding:0;">

        {{-- Top Controls --}}
        <div style="
            padding:18px 20px;
            display:flex;
            justify-content:space-between;
            align-items:end;
            gap:18px;
            flex-wrap:wrap;
        ">

            {{-- Date Form --}}
            <form method="GET"
            style="
                display:flex;
                gap:12px;
                align-items:flex-end;
                flex-wrap:wrap;
            ">

<form method="GET"
      style="
        display:flex;
        gap:12px;
        align-items:flex-end;
        flex-wrap:wrap;
      ">

    {{-- Site --}}
    <div>

        <label>Site</label>

        <select name="site_id">

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

    {{-- Month --}}
    <div>

        <label>Month</label>

        <select name="month" id="month_select">

            @for($m = 1; $m <= 12; $m++)

            <option value="{{ $m }}"
                {{ $m == $month ? 'selected' : '' }}>

                {{ date('F', mktime(0,0,0,$m,1)) }}

            </option>

            @endfor

        </select>

    </div>

    {{-- Year --}}
    <div>

        <label>Year</label>

        <select name="year" id="year_select">

            @for($y = date('Y'); $y >= date('Y') - 3; $y--)

            <option value="{{ $y }}"
                {{ $y == $year ? 'selected' : '' }}>

                {{ $y }}

            </option>

            @endfor

        </select>

    </div>

    {{-- Date --}}
    <div>

        <label>Date</label>

        <input type="date"
               name="date"
               id="attendance_date"
               value="{{ $date }}"
               max="{{ date('Y-m-d') }}">

    </div>

    <button type="submit"
            class="btn btn-secondary">

        <i class="fas fa-search"></i>

        Load

    </button>


</form>
            {{-- Search Labour --}}
            <div style="
                position:relative;
                min-width:320px;
                flex:1;
                max-width:420px;
            ">

                <i class="fas fa-search"
                   style="
                        position:absolute;
                        left:14px;
                        top:50%;
                        transform:translateY(-50%);
                        color:#9ca3af;
                        font-size:14px;
                   ">
                </i>

                <input type="text"
                       id="labourSearch"
                       placeholder="Search labour by name, ID or category..."
                       style="
                            width:100%;
                            padding:11px 42px 11px 40px;
                            border:1px solid #d1d5db;
                            border-radius:10px;
                            font-size:14px;
                            background:#fff;
                            transition:.2s;
                            outline:none;
                       "

                       onfocus="this.style.borderColor='#f97316';
                                this.style.boxShadow='0 0 0 3px rgba(249,115,22,.12)'"

                       onblur="this.style.borderColor='#d1d5db';
                               this.style.boxShadow='none'">

                <button type="button"
                        id="clearSearch"
                        style="
                            position:absolute;
                            right:12px;
                            top:50%;
                            transform:translateY(-50%);
                            border:none;
                            background:#f3f4f6;
                            width:22px;
                            height:22px;
                            border-radius:50%;
                            font-size:14px;
                            cursor:pointer;
                            color:#6b7280;
                            display:none;
                        ">

                    ×

                </button>

            </div>

        </div>

    </div>

</div>

@if($labours->isEmpty())
    <div class="card">
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <p>No active labours found. <a href="{{ route('labours.create') }}">Add labours</a> first.</p>
        </div>
    </div>
@else
<form method="POST" action="{{ route('attendance.store') }}">
    @csrf
    <input type="date" id="attendance_date" name="date" value="{{ $date }}">

    <div class="card">
        <div class="card-header">
            <span>
                <i class="fas fa-calendar-check" style="color:var(--primary)"></i>&nbsp;
                Attendance for {{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}
            </span>
            <div style="display:flex;gap:8px;">

                <button type="button" onclick="markAll('present')" class="btn btn-sm btn-success">
                    <i class="fas fa-check-double"></i> Mark All Present
                </button>
                  <button type="button" onclick="markAll('week_off')" class="btn btn-sm btn-info">
                    <i class="fas fa-check-double"></i> Mark All Week OFF
                </button>
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-save"></i> Save Attendance
                </button>
              
            </div>
        </div>
       
</div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Daily Wage</th>
                        <th style="width:220px;">Attendance</th>
                        <th style="width:150px;">OT Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($labours as $i => $labour)
                    <tr class="labour-row">
                        <td style="color:var(--text-muted)">{{ $i + 1 }}</td>
                        <td><strong>{{ $labour->name }}</strong><br><small class="text-muted">{{ $labour->employee_id }}</small></td>
                        <td><span class="badge badge-{{ strtolower($labour->category) }}">{{ $labour->category }}</span></td>
                        <td>₹{{ number_format($labour->daily_wage, 0) }}</td>
                        <td>
             <div style="display:flex;gap:0;border:1px solid var(--border);border-radius:7px;overflow:hidden;">

                @foreach([
                    'present' => ['P','var(--success)'],
                    'absent' => ['A','var(--danger)'],
                    'half_day' => ['½','var(--warning)'],
                    'week_off' => ['WO','var(--info)']
                ] as $val => [$label, $color])

                @php $checked = false; @endphp

                <label style="
                    flex:1;
                    text-align:center;
                    padding:7px 4px;
                    cursor:pointer;
                    transition:all 0.15s;
                    background:transparent;
                    color:inherit;
                    font-size:12px;
                    font-weight:700;
                "
                class="att-label"
                data-color="{{ $color }}">

                    <input type="radio"
                                name="attendance[{{ $labour->id }}]"
                                value="{{ $val }}"
                                style="display:none;">
                    {{ $label }}
                </label>
                @endforeach
         </div>
    </td>
                        <td>
                            <input type="number"
                                name="overtime[{{ $labour->id }}]"
                                value=" "
                                min="0" max="12" step="0.5"
                                style="width:100%;"
                                placeholder="0">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:14px 20px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Attendance</button>
        </div>
    </div>
</form>
@endif

@push('scripts')

<script>
  const searchInput =
    document.getElementById('labourSearch');

const clearBtn =
    document.getElementById('clearSearch');

searchInput.addEventListener('input', function () {

    clearBtn.style.display =
        this.value.length ? 'block' : 'none';
});

clearBtn.addEventListener('click', function () {

    searchInput.value = '';

    document.querySelectorAll('.labour-row')
        .forEach(row => {

        row.style.display = '';
    });

    clearBtn.style.display = 'none';

    searchInput.focus();
});
// Colorize attendance labels on click
document.querySelectorAll('.att-label').forEach(label => {
    label.addEventListener('click', function () {
        const row = this.closest('tr');
        row.querySelectorAll('.att-label').forEach(l => {
            l.style.background = 'transparent';
            l.style.color = 'inherit';
        });
        this.style.background = this.dataset.color;
        this.style.color = '#fff';
    });
});

function markAll(status) {
    document.querySelectorAll(`input[type=radio][value="${status}"]`).forEach(radio => {
        radio.checked = true;
        radio.closest('.att-label').click();
    });
    
}

// Attendance label color handling
document.addEventListener('click', function(e) {

    const label = e.target.closest('.att-label');

    if (!label) return;

    const row = label.closest('tr');

    row.querySelectorAll('.att-label').forEach(l => {

        l.style.background = 'transparent';

        l.style.color = 'inherit';
    });

    label.style.background = label.dataset.color;

    label.style.color = '#fff';
});


// Mark all attendance
function markAll(status) {

    document.querySelectorAll(
        `input[type=radio][value="${status}"]`
    ).forEach(radio => {

        radio.checked = true;

        const label = radio.closest('.att-label');

        label.style.background = label.dataset.color;

        label.style.color = '#fff';
    });
}


// Search labour
document.getElementById('labourSearch')
    .addEventListener('keyup', function () {

    let value = this.value.toLowerCase();

    document.querySelectorAll('.labour-row')
        .forEach(row => {

        let labourName =
            row.children[1].innerText.toLowerCase();

        let category =
            row.children[2].innerText.toLowerCase();

        let employeeId =
            row.children[1].innerText.toLowerCase();

        let fullText =
            labourName + ' ' +
            category + ' ' +
            employeeId;

        row.style.display =
            fullText.includes(value)
                ? ''
                : 'none';
    });
    });
    document.addEventListener('DOMContentLoaded', function () {

    const monthSelect =
        document.getElementById('month_select');

    const yearSelect =
        document.getElementById('year_select');

    const dateInput =
        document.getElementById('attendance_date');

    function updateDateRange() {

        let month = monthSelect.value;

        let year = yearSelect.value;

        // First day
        let firstDay =
            `${year}-${String(month).padStart(2,'0')}-01`;

        // Last day
        let lastDate =
            new Date(year, month, 0).getDate();

        let lastDay =
            `${year}-${String(month).padStart(2,'0')}-${lastDate}`;

        // Apply min/max
        dateInput.min = firstDay;

        dateInput.max = lastDay;

        // Auto update selected date
        if (
            !dateInput.value ||
            dateInput.value < firstDay ||
            dateInput.value > lastDay
        ) {
            dateInput.value = firstDay;
        }
    }

    monthSelect.addEventListener(
        'change',
        updateDateRange
    );

    yearSelect.addEventListener(
        'change',
        updateDateRange
    );

    updateDateRange();

});

</script>
@endpush

@endsection