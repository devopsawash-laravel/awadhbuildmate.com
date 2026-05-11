@extends('layouts.app')

@section('title', 'Salary Slip')
@section('page-title', 'Salary Slip')

@section('content')

{{-- Salary slip section --}}
<div class="page-header">
    <div>
        <div class="page-title">{{ $salary->labour->name }}</div>
        <div class="page-subtitle">{{ $salary->labour->category }} — {{ $salary->getMonthName() }} {{ $salary->year }}</div>
    </div>

    <div style="display:flex;gap:8px;">
        <button onclick="window.print()" class="btn btn-secondary"><i class="fas fa-print"></i> Print</button>
        <a href="{{ route('salary.index', ['month' => $salary->month, 'year' => $salary->year]) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card" style="max-width:720px;" id="slip-content">
    <!-- Header -->
    <div style="background:var(--secondary);color:#fff;padding:24px 28px;display:flex;justify-content:space-between;align-items:center;">
        <div>
            <div style="font-family:'Barlow Condensed',sans-serif;font-size:24px;font-weight:700;color:var(--primary);">
                <i class="fas fa-hard-hat"></i> AwadhBuildmate
            </div>
            <div style="font-size:12px;color:rgba(255,255,255,0.5);margin-top:3px;letter-spacing:2px;">SALARY SLIP</div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:18px;font-weight:700;">{{ $salary->getMonthName() }} {{ $salary->year }}</div>
            <div style="font-size:12px;color:rgba(255,255,255,0.5);">Generated: {{ $salary->created_at->format('d M Y') }}</div>
        </div>
    </div>

    <!-- Labour Info -->
    <div style="padding:20px 28px;background:#F8F9FA;border-bottom:1px solid var(--border);display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">
        <div>
            <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:3px;">Employee Name</div>
            <div style="font-weight:700;font-size:16px;">{{ $salary->labour->name }}</div>
        </div>
        <div>
            <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:3px;">Employee ID</div>
            <div style="font-weight:600;">{{ $salary->labour->employee_id }}</div>
        </div>
        <div>
            <div style="font-size:11px;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:3px;">Category</div>
            <span class="badge badge-{{ strtolower($salary->labour->category) }}">{{ $salary->labour->category }}</span>
        </div>
    </div>

    <!-- Attendance Summary -->
    <div style="padding:20px 28px;border-bottom:1px solid var(--border);">
        <div style="font-weight:700;font-size:13px;text-transform:uppercase;letter-spacing:1px;margin-bottom:14px;color:var(--text-muted);">Attendance Summary</div>
        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:12px;">
            @foreach([
                ['Total Days', $salary->total_days, '#6B7280'],
                ['Present', $salary->present_days, 'var(--success)'],
                ['Half Day', $salary->half_days, 'var(--warning)'],
                ['Absent', $salary->absent_days, 'var(--danger)'],
                ['OT Hours', $salary->overtime_hours, 'var(--info)'],
            ] as [$label, $val, $color])
            <div style="text-align:center;background:var(--bg);border-radius:8px;padding:12px;">
                <div style="font-size:22px;font-weight:700;color:{{ $color }}">{{ $val }}</div>
                <div style="font-size:11px;color:var(--text-muted)">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Earnings & Deductions -->
    <div style="padding:20px 28px;display:grid;grid-template-columns:1fr 1fr;gap:28px;border-bottom:1px solid var(--border);">
        <!-- Earnings -->
        <div>
            <div style="font-weight:700;font-size:13px;text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;color:var(--success);">
                <i class="fas fa-plus-circle"></i> Earnings
            </div>
            <table style="width:100%;font-size:14px;">
                <tr>
                    <td style="padding:7px 0;border-bottom:1px dashed var(--border);">Daily Wage</td>
                    <td style="padding:7px 0;border-bottom:1px dashed var(--border);text-align:right;color:var(--text-muted);">₹{{ number_format($salary->daily_wage, 0) }} × {{ $salary->present_days + ($salary->half_days * 0.5) }} days</td>
                </tr>
                <tr>
                    <td style="padding:7px 0;border-bottom:1px dashed var(--border);">Basic Salary</td>
                    <td style="padding:7px 0;border-bottom:1px dashed var(--border);text-align:right;font-weight:600;">₹{{ number_format($salary->basic_salary, 2) }}</td>
                </tr>
                @if($salary->overtime_hours > 0)
                <tr>
                    <td style="padding:7px 0;border-bottom:1px dashed var(--border);">
                        Overtime ({{ $salary->overtime_hours }}h × 2×)
                        <div style="font-size:11px;color:var(--text-muted)">Base: ₹{{ number_format($salary->overtime_rate,0) }}/hr → Paid: ₹{{ number_format($salary->overtime_rate*2,0) }}/hr</div>
                    </td>
                    <td style="padding:7px 0;border-bottom:1px dashed var(--border);text-align:right;font-weight:600;">₹{{ number_format($salary->overtime_amount, 2) }}</td>
                </tr>
                @endif
                <tr style="background:#ECFDF5;">
                    <td style="padding:9px 6px;font-weight:700;color:var(--success);">Gross Salary</td>
                    <td style="padding:9px 6px;text-align:right;font-weight:700;font-size:16px;color:var(--success);">₹{{ number_format($salary->gross_salary, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Deductions -->
        <div>
            <div style="font-weight:700;font-size:13px;text-transform:uppercase;letter-spacing:1px;margin-bottom:12px;color:var(--danger);">
                <i class="fas fa-minus-circle"></i> Deductions
            </div>
            <table style="width:100%;font-size:14px;">
                <tr>
                    <td style="padding:7px 0;border-bottom:1px dashed var(--border);">
                        PF ({{ $salary->pf_percentage }}%)
                        <div style="font-size:11px;color:var(--text-muted)">On basic salary</div>
                    </td>
                    <td style="padding:7px 0;border-bottom:1px dashed var(--border);text-align:right;color:var(--danger);">-₹{{ number_format($salary->pf_deduction, 2) }}</td>
                </tr>
                @if($salary->advance_deduction > 0)
                <tr>
                    <td style="padding:7px 0;border-bottom:1px dashed var(--border);">Advance Deduction</td>
                    <td style="padding:7px 0;border-bottom:1px dashed var(--border);text-align:right;color:var(--danger);">-₹{{ number_format($salary->advance_deduction, 2) }}</td>
                </tr>
                @endif
                @if($salary->other_deduction > 0)
                <tr>
                    <td style="padding:7px 0;border-bottom:1px dashed var(--border);">Other Deductions</td>
                    <td style="padding:7px 0;border-bottom:1px dashed var(--border);text-align:right;color:var(--danger);">-₹{{ number_format($salary->other_deduction, 2) }}</td>
                </tr>
                @endif
                <tr style="background:#FEF2F2;">
                    <td style="padding:9px 6px;font-weight:700;color:var(--danger);">Total Deductions</td>
                    <td style="padding:9px 6px;text-align:right;font-weight:700;font-size:16px;color:var(--danger);">-₹{{ number_format($salary->total_deduction, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Net Salary -->
    <div style="padding:20px 28px;background:var(--secondary);display:flex;justify-content:space-between;align-items:center;">
        <div style="color:rgba(255,255,255,0.7);font-size:14px;font-weight:600;text-transform:uppercase;letter-spacing:1px;">Net Salary Payable</div>
        <div style="font-size:32px;font-weight:700;color:var(--accent);">₹{{ number_format($salary->net_salary, 2) }}</div>
    </div>

    @if($salary->remarks)
    <div style="padding:14px 28px;font-size:13px;color:var(--text-muted);border-top:1px solid var(--border);">
        <i class="fas fa-sticky-note"></i> {{ $salary->remarks }}
    </div>
    @endif
</div>

@push('styles')
<style>
@media print {
    .sidebar, .topbar, .page-header .btn, .page-header .d-flex { display: none !important; }
    .main { margin-left: 0 !important; }
    .content { padding: 0 !important; }
    .card { border: none !important; box-shadow: none; }
}
</style>
@endpush

@endsection