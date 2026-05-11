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
    <div class="card-body" style="padding:14px 20px;">
        <form method="GET" style="display:flex;gap:12px;align-items:flex-end;">
            <div>
                <label>Select Date</label>
                <input type="date" name="date" value="{{ $date }}" max="{{ date('Y-m-d') }}">
            </div>
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Load</button>
        </form>
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
    <input type="hidden" name="date" value="{{ $date }}">

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
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-save"></i> Save Attendance
                </button>
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
                    <tr>
                        <td style="color:var(--text-muted)">{{ $i + 1 }}</td>
                        <td><strong>{{ $labour->name }}</strong><br><small class="text-muted">{{ $labour->employee_id }}</small></td>
                        <td><span class="badge badge-{{ strtolower($labour->category) }}">{{ $labour->category }}</span></td>
                        <td>₹{{ number_format($labour->daily_wage, 0) }}</td>
                        <td>
                            <div style="display:flex;gap:0;border:1px solid var(--border);border-radius:7px;overflow:hidden;">
                                @foreach(['present' => ['P','var(--success)'], 'absent' => ['A','var(--danger)'], 'half_day' => ['½','var(--warning)']] as $val => [$label, $color])
                                @php $checked = ($attendances[$labour->id] ?? '') === $val; @endphp
                                <label style="flex:1;text-align:center;padding:7px 4px;cursor:pointer;transition:all 0.15s;background:{{ $checked ? $color : 'transparent' }};color:{{ $checked ? '#fff' : 'inherit' }};font-size:12px;font-weight:700;" class="att-label" data-color="{{ $color }}">
                                    <input type="radio" name="attendance[{{ $labour->id }}]" value="{{ $val }}" {{ $checked ? 'checked' : '' }} style="display:none;" required>
                                    {{ $label }}
                                </label>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <input type="number"
                                name="overtime[{{ $labour->id }}]"
                                value="{{ $overtimes[$labour->id] ?? 0 }}"
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
</script>
@endpush

@endsection