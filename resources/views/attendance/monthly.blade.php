@extends('layouts.app')

@section('title', 'Monthly Attendance Report')
@section('page-title', 'Monthly Report')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Monthly Attendance Report</div>
        <div class="page-subtitle">{{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}</div>
    </div>
    <a href="{{ route('attendance.index') }}" class="btn btn-outline"><i class="fas fa-calendar-check"></i> Daily Attendance</a>
</div>

<div class="card mb-4">
    <div class="card-body" style="padding:14px 20px;">
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

        <select name="site_id" id="sitem">

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

        <select name="month">

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

        <select name="year">

            @for($y = date('Y'); $y >= date('Y') - 3; $y--)

            <option value="{{ $y }}"
                {{ $y == $year ? 'selected' : '' }}>

                {{ $y }}

            </option>

            @endfor

        </select>

    </div>

    <button type="submit"
            class="btn btn-secondary">

        <i class="fas fa-search"></i>

        Load

    </button>
            

<div class="card">
    <div class="card-header">
        Attendance Summary — {{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}
        ({{ $daysInMonth }} days)
    </div>
    <div class="table-wrapper" style="overflow-x:auto;">
        <table style="font-size:12px;min-width:900px;">
            <thead>
                <tr>
                    <th style="min-width:140px;">Labour</th>
                    <th>Category</th>
                    @for($d = 1; $d <= $daysInMonth; $d++)
                    @php $dayName = \Carbon\Carbon::createFromDate($year, $month, $d)->format('D'); @endphp
                    <th style="min-width:32px;text-align:center;{{ in_array($dayName, ['Sun','Sat']) ? 'background:#FFF5F5;' : '' }}">
                        <div>{{ $d }}</div>
                        <div style="font-weight:400;font-size:9px;color:var(--text-muted)">{{ $dayName }}</div>
                    </th>
                    @endfor
                    <th>P</th><th>A</th><th>½</th><th>OT Hrs</th>
                </tr>
            </thead>
            <tbody>
                @forelse($labours as $labour)
                @php
                    $attMap = $labour->attendances->keyBy(fn($a) => $a->date->day);
                    $present  = $labour->attendances->where('status', 'present')->count();
                    $absent   = $labour->attendances->where('status', 'absent')->count();
                    $halfDay  = $labour->attendances->where('status', 'half_day')->count();
                    $weekOff = $labour->attendances->where('status', 'week_off')->count();
                    $otHours  = $labour->attendances->sum('overtime_hours');
                @endphp
                <tr>
                    <td><strong>{{ $labour->name }}</strong></td>
                    <td><span class="badge badge-{{ strtolower($labour->category) }}">{{ $labour->category }}</span></td>
                    @for($d = 1; $d <= $daysInMonth; $d++)
                    @php $att = $attMap[$d] ?? null; @endphp
                    <td style="text-align:center;padding:4px;">
                        @if($att)
                            @if($att->status === 'present')
                                <span style="color:var(--success);font-weight:700;">P</span>
                            @elseif($att->status === 'absent')
                                <span style="color:var(--danger);font-weight:700;">A</span>
                            @elseif($att->status === 'week_off')
                                <span style="color:var(--info);font-weight:700;">W/O</span>
                            @else
                                <span style="color:var(--warning);font-weight:700;">½</span>
                            @endif
                        @else
                            <span style="color:#CBD5E1;">—</span>
                        @endif
                    </td>
                    @endfor
                    <td style="font-weight:700;color:var(--success)">{{ $present }}</td>
                    <td style="font-weight:700;color:var(--danger)">{{ $absent }}</td>
                    <td style="font-weight:700;color:var(--warning)">{{ $halfDay }}</td>
                    <td style="font-weight:700;color:var(--info)">{{ $weekOff }}</td>
                    <td style="font-weight:700;color:var(--info)">{{ $otHours > 0 ? $otHours : '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="{{ $daysInMonth + 6 }}" class="text-center text-muted" style="padding:20px;">No active labours</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
