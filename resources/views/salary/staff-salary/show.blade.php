@extends('layouts.app')

@section('title', 'Salary Slip')
@section('page-title', 'Salary Slip')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<div class="page-header">
    <div>
        <div class="page-title">Salary Slip</div>
        <div class="page-subtitle">
            {{ $salary->getMonthName() }} {{ $salary->year }}
        </div>
    </div>

    <div style="display:flex;gap:10px;">
        <button onclick="window.print()" class="btn btn-secondary">
            <i class="fas fa-print"></i> Print
        </button>

        <a href="{{ route('salary.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="card" id="salary-slip" style="max-width:1100px;margin:auto;border:1px solid #dcdcdc;">

    {{-- Company Header --}}
    <div style="padding:25px 30px;border-bottom:2px solid #e5e7eb;text-align:center;background:#f9fafb;">

        <div style="font-size:28px;font-weight:700;color:#f97316;font-family:'Barlow Condensed',sans-serif;">
            AWADH BUILDMATE
        </div>

        <div style="font-size:14px;color:#6b7280;margin-top:6px;">
            Made for Quality and Trust
        </div>

        <div style="font-size:13px;color:#6b7280;">
           
        </div>

        <div style="margin-top:12px;font-size:18px;font-weight:700;letter-spacing:1px;">
            SALARY SLIP
        </div>

        <div style="font-size:13px;color:#6b7280;">
            For the Month of {{ $salary->getMonthName() }} {{ $salary->year }}
        </div>
    </div>

    {{-- Employee Details --}}
    <div style="padding:22px 30px;border-bottom:1px solid #e5e7eb;">

        <div style="font-size:14px;font-weight:700;color:#111827;margin-bottom:14px;text-transform:uppercase;">
            Employee Details
        </div>

        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:18px;">

            <div>
                <div class="slip-label">Employee Name</div>
                <div class="slip-value">{{ $salary->staff->site->name ?? 'N/A' }}</div>
            </div>

            <div>
                <div class="slip-label">Employee ID</div>
                <div class="slip-value">{{ $salary->staff->employee_id ?? 'N/A'}}</div>
            </div>

            <div>
                <div class="slip-label">Category</div>
                <div class="slip-value">{{ $salary->staff->category ?? 'N/A'}}</div>
            </div>

            <div>
                <div class="slip-label">Date Of Joining</div>
                <div class="slip-value">
                    {{ $salary->staff?->joining_date ? \Carbon\Carbon::parse($salary->staff->joining_date)->format('d M Y') : 'N/A'
}}
                </div>
            </div>

            <div>
                <div class="slip-label">UAN Number</div>
                <div class="slip-value">{{ $salary->staff->UAN ?? '-' }}</div>
            </div>

            <div>
                <div class="slip-label">ESIC Number</div>
                <div class="slip-value">{{ $salary->staff->ESIC_Number ?? '-' }}</div>
            </div>

            <div>
                <div class="slip-label">Bank Name</div>
                <div class="slip-value">
                    {{ $salary->staff->bank->name ?? '-' }}
                </div>
            </div>

            <div>
                <div class="slip-label">Bank A/C No.</div>
                <div class="slip-value">
                    {{ $salary->staff->Account_Number ?? '-' }}
                </div>
            </div>

            <div>
                <div class="slip-label">IFSC Code</div>
                <div class="slip-value">
                    {{ $salary->staff->IFSC ?? '-' }}
                </div>
            </div>

        </div>
    </div>

    {{-- Working Details --}}
    <div style="padding:22px 30px;border-bottom:1px solid #e5e7eb;">

        <div style="font-size:14px;font-weight:700;color:#111827;margin-bottom:14px;text-transform:uppercase;">
            Working Details
        </div>

        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#f3f4f6;">
                    <th class="table-head">Present Days</th>
                    <th class="table-head">W/OFF</th>
                    <th class="table-head">Paid Days</th>
                    <th class="table-head">OT Hours</th>
                    <th class="table-head">Total Days</th>
                </tr>
            </thead>

            <tbody>
             @php

                $totalDaysInMonth =
                    \Carbon\Carbon::create(
                        $salary->year,
                        $salary->month,
                        1
                    )->daysInMonth;

                $monthlySalary = $salary->staff->total_salary ?? 0;

                $dailyWage = $monthlySalary / $totalDaysInMonth;

                $presentDays = $salary->paid_days ?? 0;

                $earnedSalary = round( $dailyWage * $presentDays,2);

            @endphp
                <tr>
                    <td class="table-data">{{ $salary->present_days }}</td>
                    <td class="table-data">{{ $salary->week_off_days }}</td>
                    <td class="table-data">
                        {{ $paidDays }}
                    </td>
                    {{-- <td class="table-data">{{ $salary->finalothours }}</td> --}}
                    <td class="table-data">
                        {{ number_format($lastOT, 1) }}
                    </td>
                    {{-- <td class="table-data">{{ $salary->total_days }}</td> --}}
                    <td class="table-data">{{ $finalPayableDays }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Earnings + Deductions --}}
    <div style="padding:22px 30px;">

        <div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;">

            {{-- Earnings --}}
            <div>

                <div style="font-size:14px;font-weight:700;color:#16a34a;margin-bottom:12px;text-transform:uppercase;">
                    Earnings Details
                </div>

                <table style="width:100%;border-collapse:collapse;">

                    <thead>
                        <tr style="background:#f3f4f6;">
                            <th class="table-head" style="text-align:left;">Earnings</th>
                            <th class="table-head">Actual</th>
                            <th class="table-head">Earned</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
    <td class="table-data-left">Basic Salary</td>

    <td class="table-data">
        ₹{{ number_format($salary->staff->basic_salary ?? 0, 2) }}
    </td>

    <td class="table-data">
        ₹{{ number_format($salary->earned_basic ?? 0, 2) }}
    </td>
</tr>

<tr>
    <td class="table-data-left">HRA</td>

    <td class="table-data">
        ₹{{ number_format($salary->staff->hra ?? 0, 2) }}
    </td>

    <td class="table-data">
        ₹{{ number_format($salary->earned_hra ?? 0, 2) }}
    </td>
</tr>

<tr>
    <td class="table-data-left">Other Allowance</td>

    <td class="table-data">
        ₹{{ number_format($salary->staff->other_allowance ?? 0, 2) }}
    </td>

    <td class="table-data">
        ₹{{ number_format($salary->earned_other_allowance ?? 0, 2) }}
    </td>
</tr>

<tr>
    <td class="table-data-left">Present Days</td>

    <td class="table-data">
        {{ $salary->paid_days ?? 0 }}
    </td>

    <td class="table-data">
        {{ $salary->paid_days ?? 0 }}
    </td>
</tr>

<tr>
    <td class="table-data-left">Daily Wage</td>

    <td class="table-data">
        ₹{{ number_format($salary->daily_wage ?? 0, 2) }}
    </td>

    <td class="table-data">
        ₹{{ number_format($salary->daily_wage ?? 0, 2) }}
    </td>
</tr>

<tr style="background:#ecfdf5;font-weight:700;">
    <td class="table-data-left">Gross Income</td>

    <td class="table-data">
        ₹{{ number_format($salary->staff->total_salary ?? 0, 2) }}
    </td>

    <td class="table-data">
        ₹{{ number_format($salary->gross_salary ?? 0, 2) }}
    </td>
</tr>
                        <td class="table-data-left">Gross Income</td>

                        <td class="table-data">
                        ₹{{ number_format(
                        ($salary->staff->basic_salary ?? 0) +
                        ($salary->staff->hra ?? 0) +
                        ($salary->staff->other_allowance ?? 0),2) }}
                        </td>

                        <td class="table-data">
                                ₹{{ number_format(
                                    ($salary->earned_basic ?? 0) +
                                    ($salary->earned_hra ?? 0) +
                                    ($salary->earned_other_allowance ?? 0) +
                                    ($salary->overtime_amount ?? 0),
                                2) }}
</td>
                    </tr>

                    </tbody>
                </table>
            </div>

            {{-- Deductions --}}

            <form action="{{ route('salary.updateDeductions', $salary->id) }}"
            method="POST">

            @csrf
            @method('PUT')
            <div>

                <div style="font-size:14px;font-weight:700;color:#dc2626;margin-bottom:12px;text-transform:uppercase;">
                    Deduction Details
                </div>

                <table style="width:100%;border-collapse:collapse;">

                    <thead>
                        <tr style="background:#fef2f2;">
                            <th class="table-head" style="text-align:left;">Deduction</th>
                            <th class="table-head">Amount</th>
                        </tr>
                    </thead>

                    <tbody>

                       <tr>
                        <td class="table-data-left">PF</td>

                        <td class="table-data">

                            <input type="number"
                                step="0.01"
                                name="pf_deduction"
                                {{-- value="{{ $salary->pf_deduction ?? 0 }}" --}}
                                {{-- value="{{ old('pf_deduction', 0) }}" --}}
                                value="{{ number_format($salary->pf_deduction ?? 0, 2) }}"
                                style="width:100px;padding:5px;">

                        </td>
                        </tr>

                        <tr>
                            <td class="table-data-left">ESIC</td>

                            <td class="table-data">

                                <input type="number"
                                    step="0.01"
                                    name="esic_deduction"
                                    value="{{ $salary->esic_deduction ?? 0 }}"
                                    style="width:100px;padding:5px;">

                            </td>
                        </tr>

                      <tr>
                        <td class="table-data-left">Advance</td>

                        <td class="table-data">

                            <input type="number"
                                step="0.01"
                                name="advance_deduction"
                                value="{{ $salary->advance_deduction ?? 0 }}"
                                style="width:100px;padding:5px;">

                        </td>
                    </tr>
                        <tr>
                            <td class="table-data-left">PT</td>

                            <td class="table-data">

                                <input type="number"
                                    step="0.01"
                                    name="pt_deduction"
                                    value="{{ $salary->pt_deduction ?? 0 }}"
                                    style="width:100px;padding:5px;">

                            </td>
                        </tr>

                        <tr>
                            <td class="table-data-left">LWF</td>

                            <td class="table-data">

                                <input type="number"
                                    step="0.01"
                                    name="lwf_deduction"
                                    value="{{ $salary->lwf_deduction ?? 0 }}"
                                    style="width:100px;padding:5px;">

                            </td>
                        </tr>
                        <tr>
                            <td class="table-data-left">Other Deduction</td>

                            <td class="table-data">

                                <input type="number"
                                    step="0.01"
                                    name="other_deduction"
                                    value="{{ $salary->other_deduction ?? 0 }}"
                                    style="width:100px;padding:5px;">

                            </td>
                        </tr>
                        <tr style="background:#FEF2F2;">
                                    <td style="padding:10px 8px;font-weight:700;color:var(--danger);">
                                        Total Deductions
                                    </td>

                                    <td style="padding:10px 8px;text-align:right;font-weight:700;color:var(--danger);">
                                       {{-- ₹{{ number_format($salary->total_deduction ?? 0, 2) }} --}}
                                       ₹{{ number_format($salary->total_deduction ?? 0, 2) }}
                                    </td>
                                </tr>

                               <!-- Net Salary -->
                                <tr style="background:#f9fafb;border-top:1px solid #e5e7eb;">
                                    <td style="padding:12px 8px;font-weight:700;font-size:14px;color:#111827;">
                                        Net Payable Salary
                                    </td>

                                    <td style="padding:12px 8px;text-align:right;font-weight:700;font-size:14px;color:#111827;">
                                        {{-- ₹{{ number_format($salary->net_salary, 2) }} --}}
                                        ₹{{ number_format($salary->net_salary) }}
                                    </td>
                                </tr>
                    </tbody>
                </table>
                <div style="margin-top:15px;text-align:right;">

                {{-- Button for updating all the deductions entered manually from earned salary --}}
                {{-- <button type="button" class="btn btn-warning">
                         <i class="fas fa-edit"></i> Update Deduction
                </button> --}}
                    {{-- Button for Generating PaySlip --}}
                {{-- <button type="button" class="btn btn-success">
                        <i class="fas fa-download"></i> Download PaySlip
                </button> --}}

                {{-- Updataed Blade --}}
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Update Deduction
                </button>

                {{-- Button for Generating PaySlip --}}
                <a href="{{ route('salary.payslip', $salary->id) }}"
                        class="btn btn-success"
                        target="_blank">
                        <i class="fas fa-download"></i> Download PaySlip
                    </a>
                </div>
            </form>
            </div>

        </div>
    </div>
</div>

<style>

.slip-label{
    font-size:11px;
    text-transform:uppercase;
    color:#6b7280;
    margin-bottom:4px;
    letter-spacing:1px;
    font-weight:600;
}

.slip-value{
    font-size:14px;
    font-weight:600;
    color:#111827;
}

.table-head{
    border:1px solid #d1d5db;
    padding:10px;
    font-size:12px;
    text-transform:uppercase;
    color:#374151;
    font-weight:700;
}

.table-data{
    border:1px solid #e5e7eb;
    padding:10px;
    text-align:center;
    font-size:14px;
    color:#111827;
}

.table-data-left{
    border:1px solid #e5e7eb;
    padding:10px;
    font-size:14px;
    color:#111827;
    font-weight:600;
}

@media print {

    .sidebar,
    .topbar,
    .page-header,
    .btn {
        display:none !important;
    }

    .main{
        margin-left:0 !important;
    }

    .content{
        padding:0 !important;
    }

    #salary-slip{
        border:none !important;
        box-shadow:none !important;
    }
    
}

</style>

@endsection