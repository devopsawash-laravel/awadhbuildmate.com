@extends('layouts.app')

@section('title', 'Monthly Attendance Report')
@section('page-title', 'Monthly Report')

@section('content')

<style>
.att-page-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
.att-page-header .att-title{font-size:20px;font-weight:700;color:#7C2D00}
.att-page-header .att-subtitle{font-size:13px;color:#A84500;margin-top:3px}
.att-btn-outline{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;border:1.5px solid #F97316;color:#F97316;font-size:13px;font-weight:600;background:#fff;text-decoration:none;transition:all .15s}
.att-btn-outline:hover{background:#FFF0E0;color:#EA6000;text-decoration:none}
.att-filter-card{background:#FFF7F0;border:1px solid #FFE4C8;border-radius:12px;padding:14px 18px;margin-bottom:18px}
.att-filter-row{display:flex;gap:14px;align-items:flex-end;flex-wrap:wrap}
.att-filter-group{display:flex;flex-direction:column;gap:4px}
.att-filter-group label{font-size:11px;font-weight:700;color:#A84500;text-transform:uppercase;letter-spacing:.5px;margin-bottom:0}
.att-filter-group select{border:1px solid #FFE4C8;border-radius:8px;padding:7px 12px;font-size:13px;background:#fff;color:#333;min-width:140px;cursor:pointer;outline:none}
.att-filter-group select:focus{border-color:#F97316;box-shadow:0 0 0 3px rgba(249,115,22,.12)}
.att-btn-load{display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:8px;background:#F97316;color:#fff;font-size:13px;font-weight:600;border:none;cursor:pointer;transition:background .15s}
.att-btn-load:hover{background:#EA6000}
.att-summary-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:18px}
.att-scard{background:#FFF7F0;border:1px solid #FFE4C8;border-radius:10px;padding:12px 16px}
.att-scard .sl{font-size:11px;font-weight:700;color:#A84500;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px}
.att-scard .sv{font-size:28px;font-weight:700;line-height:1.1}
.att-card{background:#fff;border:1px solid #FDDBB4;border-radius:12px;overflow:hidden;margin-bottom:18px}
.att-card-header{background:linear-gradient(90deg,#FFF0E0,#FFF7F0);padding:12px 18px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #FFE4C8}
.att-card-header .cht{font-size:14px;font-weight:700;color:#7C2D00}
.att-card-header .chm{font-size:12px;color:#A84500}
.att-tbl-wrap{overflow-x:auto}
.att-tbl{width:100%;border-collapse:collapse;font-size:12px}
.att-tbl thead tr{background:#FFF0E0}
.att-tbl thead th{padding:8px 4px;text-align:center;border-bottom:1px solid #FFE4C8;color:#7C2D00;font-weight:700;white-space:nowrap;font-size:11px}
.att-tbl thead th.cn{text-align:left;padding-left:14px;min-width:130px}
.att-tbl thead th.cc{text-align:left;min-width:80px;padding-left:6px}
.att-tbl thead th.cd{min-width:28px}
.att-tbl thead th.wknd{background:#FFE4C8}
.att-tbl tbody tr{border-bottom:1px solid #FFF5EC;transition:background .12s}
.att-tbl tbody tr:hover{background:#FFF7F0}
.att-tbl tbody td{padding:6px 4px;text-align:center;color:#555}
.att-tbl tbody td.cn{text-align:left;padding-left:14px;font-weight:700;color:#1a1a1a;white-space:nowrap}
.att-tbl tbody td.cc{text-align:left;padding-left:6px}
.att-tbl tbody td.wknd{background:#FFF5EC}
.att-tbl tfoot tr{background:#FFF0E0}
.att-tbl tfoot td{padding:7px 4px;font-weight:700;color:#7C2D00;border-top:1px solid #FFE4C8;text-align:center;font-size:11px}
.att-tbl tfoot td.cn{text-align:left;padding-left:14px}
.att-legend{display:flex;gap:16px;flex-wrap:wrap;padding:10px 16px;border-top:1px solid #FFE4C8;background:#FFF7F0;font-size:11px;color:#555}
.att-legend span{display:inline-flex;align-items:center;gap:5px}
.att-legend b{display:inline-block;width:8px;height:8px;border-radius:50%}
.badge-skilled{background:#FEF3C7;color:#92400E;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700}
.badge-unskilled{background:#F0FDF4;color:#166534;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700}
.badge-supervisor{background:#EEF2FF;color:#3730A3;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700}
.badge-helper{background:#FDF4FF;color:#6B21A8;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700}
</style>

{{-- Page Header --}}
<div class="att-page-header">
    <div>
        <div class="att-title"><i class="fas fa-calendar-alt" style="color:#F97316;margin-right:8px"></i>Monthly Attendance Report</div>
        <div class="att-subtitle">{{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}</div>
    </div>
    <a href="{{ route('attendance.index') }}" class="att-btn-outline">
        <i class="fas fa-calendar-check"></i> Daily Attendance
    </a>
</div>

{{-- Filter Card --}}
<div class="att-filter-card">
    <form method="GET">
        <div class="att-filter-row">
            <div class="att-filter-group">
                <label>Site</label>
                <select name="site_id">
                    <option value="">All Sites</option>
                    @foreach($sites as $site)
                        <option value="{{ $site->id }}" {{ request('site_id') == $site->id ? 'selected' : '' }}>
                            {{ $site->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="att-filter-group">
                <label>Month</label>
                <select name="month">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0,0,0,$m,1)) }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="att-filter-group">
                <label>Year</label>
                <select name="year">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="att-btn-load">
                <i class="fas fa-search"></i> Load
            </button>
        </div>
    </form>
</div>

{{-- Summary Cards --}}
@php
    $totalPresent = $labours->sum(fn($l) => $l->attendances->where('status','present')->count());
    $totalAbsent  = $labours->sum(fn($l) => $l->attendances->where('status','absent')->count());
    $totalHalf    = $labours->sum(fn($l) => $l->attendances->where('status','half_day')->count());
    $totalWeekOff = $labours->sum(fn($l) => $l->attendances->where('status','week_off')->count());
    $totalOT      = $labours->sum(fn($l) => $l->attendances->sum('overtime_hours'));
@endphp
<div class="att-summary-grid">
    <div class="att-scard"><div class="sl">Present</div><div class="sv" style="color:#16A34A">{{ $totalPresent }}</div></div>
    <div class="att-scard"><div class="sl">Absent</div><div class="sv" style="color:#DC2626">{{ $totalAbsent }}</div></div>
    <div class="att-scard"><div class="sl">Half Day</div><div class="sv" style="color:#D97706">{{ $totalHalf }}</div></div>
    <div class="att-scard"><div class="sl">Week Off</div><div class="sv" style="color:#0284C7">{{ $totalWeekOff }}</div></div>
    <div class="att-scard"><div class="sl">OT Hours</div><div class="sv" style="color:#7C3AED">{{ $totalOT > 0 ? $totalOT : '—' }}</div></div>
</div>

{{-- Attendance Table --}}
<div class="att-card">
    <div class="att-card-header">
        <div class="cht">
            Attendance Summary — {{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}
        </div>
        <div class="chm">{{ $daysInMonth }} days &nbsp;·&nbsp; {{ $labours->count() }} labours</div>
    </div>

    <div class="att-tbl-wrap">
        <table class="att-tbl">
            <thead>
                <tr>
                    <th class="cn">Labour</th>
                    <th class="cc">Category</th>
                    @for($d = 1; $d <= $daysInMonth; $d++)
                        @php $dn = \Carbon\Carbon::createFromDate($year, $month, $d)->format('D'); @endphp
                        <th class="cd {{ in_array($dn,['Sun']) ? 'wknd' : '' }}">
                            <div>{{ $d }}</div>
                            <div style="font-weight:400;font-size:9px;color:#A84500">{{ $dn }}</div>
                        </th>
                    @endfor
                    <th style="min-width:28px;color:#16A34A">P</th>
                    <th style="min-width:28px;color:#DC2626">A</th>
                    <th style="min-width:28px;color:#D97706">½</th>
                    <th style="min-width:34px;color:#0284C7">W/O</th>
                    <th style="min-width:38px;color:#7C3AED">OT Hrs</th>
                </tr>
            </thead>
            <tbody>
                @forelse($labours as $labour)
                    @php
                        $attMap  = $labour->attendances->keyBy(fn($a) => $a->date->day);
                        $present = $labour->attendances->where('status','present')->count();
                        $absent  = $labour->attendances->where('status','absent')->count();
                        $halfDay = $labour->attendances->where('status','half_day')->count();
                        $weekOff = $labour->attendances->where('status','week_off')->count();
                        $otHours = $labour->attendances->sum('overtime_hours');
                    @endphp
                    <tr>
                        <td class="cn">{{ $labour->name }}</td>
                        <td class="cc">
                            <span class="badge-{{ strtolower($labour->category) }}">{{ $labour->category }}</span>
                        </td>
                        @for($d = 1; $d <= $daysInMonth; $d++)
                            @php
                                $att = $attMap[$d] ?? null;
                                $dn  = \Carbon\Carbon::createFromDate($year, $month, $d)->format('D');
                            @endphp
                            <td class="{{ in_array($dn,['Sun']) ? 'wknd' : '' }}" style="text-align:center;padding:5px 3px;">
                                @if($att)
                                    @if($att->status === 'present')
                                        <span style="color:#16A34A;font-weight:700;">P</span>
                                    @elseif($att->status === 'absent')
                                        <span style="color:#DC2626;font-weight:700;">A</span>
                                    @elseif($att->status === 'week_off')
                                        <span style="color:#0284C7;font-weight:700;">W</span>
                                    @else
                                        <span style="color:#D97706;font-weight:700;">½</span>
                                    @endif
                                @else
                                    <span style="color:#CBD5E1;">—</span>
                                @endif
                            </td>
                        @endfor
                        <td style="font-weight:700;color:#16A34A;text-align:center">{{ $present }}</td>
                        <td style="font-weight:700;color:#DC2626;text-align:center">{{ $absent }}</td>
                        <td style="font-weight:700;color:#D97706;text-align:center">{{ $halfDay }}</td>
                        <td style="font-weight:700;color:#0284C7;text-align:center">{{ $weekOff }}</td>
                        <td style="font-weight:700;color:#7C3AED;text-align:center">{{ $otHours > 0 ? $otHours.'h' : '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $daysInMonth + 7 }}" style="text-align:center;padding:28px;color:#999;">
                            No active labours found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td class="cn" colspan="2">Daily Present</td>
                    @for($d = 1; $d <= $daysInMonth; $d++)
                        @php
                            $cnt = $labours->filter(fn($l) =>
                                ($l->attendances->keyBy(fn($a) => $a->date->day)[$d] ?? null)?->status === 'present'
                            )->count();
                            $dn = \Carbon\Carbon::createFromDate($year, $month, $d)->format('D');
                        @endphp
                        <td class="{{ in_array($dn,['Sat','Sun']) ? 'wknd' : '' }}">{{ $cnt ?: '—' }}</td>
                    @endfor
                    <td colspan="5"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Legend --}}
    <div class="att-legend">
        <span><b style="background:#16A34A"></b> P — Present</span>
        <span><b style="background:#DC2626"></b> A — Absent</span>
        <span><b style="background:#D97706"></b> ½ — Half Day</span>
        <span><b style="background:#0284C7"></b> W — Week Off</span>
        <span><b style="background:#7C3AED"></b> OT — Overtime</span>
    </div>
</div>

@endsection