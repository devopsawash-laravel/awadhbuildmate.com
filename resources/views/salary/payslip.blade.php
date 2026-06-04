@extends('layouts.app')

@section('title', 'Professional Pay Slip')
@section('page-title', 'Professional Pay Slip')

@section('content')

<div class="page-header no-print">
    <div>
        <div class="page-title">Professional Pay Slip</div>
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

<div class="payslip-container">

    {{-- Header --}}
    <div class="header-section">

        <div>
            <div class="company-name">
                AWADH BUILDMATE
            </div>

            <div class="company-subtitle">
                Made for Quality and Trust
            </div>
        </div>

        <div style="text-align:right;">
            <div class="slip-title">
                PAY SLIP
            </div>

            <div class="slip-month">
                {{ $salary->getMonthName() }} {{ $salary->year }}
            </div>
        </div>

    </div>

    {{-- Employee Details --}}
    <div class="section">

        <div class="section-heading">
            Employee Details
        </div>

        <table class="info-table">
            <tr>
                <td><strong>Employee Name</strong></td>
                <td>{{ $salary->labour->name }}</td>

                <td><strong>Employee ID</strong></td>
                <td>{{ $salary->labour->employee_id }}</td>
            </tr>

            <tr>
                <td><strong>Category</strong></td>
                <td>{{ $salary->labour->category }}</td>

                <td><strong>Joining Date</strong></td>
                <td>
                    {{ \Carbon\Carbon::parse($salary->labour->joining_date)->format('d M Y') }}
                </td>
            </tr>

            <tr>
                <td><strong>UAN Number</strong></td>
                <td>{{ $salary->labour->UAN ?? '-' }}</td>

                <td><strong>ESIC Number</strong></td>
                <td>{{ $salary->labour->ESIC_Number ?? '-' }}</td>
            </tr>

            <tr>
                <td><strong>Bank Name</strong></td>
                <td>{{ $salary->labour->bank->name ?? '-' }}</td>

                <td><strong>Account No.</strong></td>
                <td>{{ $salary->labour->Account_Number ?? '-' }}</td>
            </tr>

            <tr>
                <td><strong>IFSC Code</strong></td>
                <td>{{ $salary->labour->IFSC ?? '-' }}</td>

                <td><strong>Month</strong></td>
                <td>{{ $salary->getMonthName() }} {{ $salary->year }}</td>
            </tr>
        </table>
    </div>

    {{-- Working Details --}}
    <div class="section">

        <div class="section-heading">
            Working Details
        </div>

        @php
                // Paid days
            $paidDays =
            $salary->present_days + ($salary->half_days * 0.5) + $salary->week_off_days;

            // Site working hours
                    $workingHoursPerDay =  $salary->labour->working_hours_per_day ?? 8;

                    // OT multiplier (2x, 1.5x etc.)
                    $otMultiplier =
                        $salary->labour->ot_rate_multiplier ?? 1;

                    // Effective OT hours
                    $effectiveOtHours = ($salary->overtime_hours ?? 0) * $otMultiplier;

                    // Convert OT into payable days
                    // $otDays = round( $effectiveOtHours / $workingHoursPerDay,2 );
                    
                    // For removing unnecessory 0's.
                    // $otDays = rtrim(rtrim(number_format($effectiveOtHours / $workingHoursPerDay, 2, '.', ''), ''), '.');
                    $otDays =$effectiveOtHours / $workingHoursPerDay;
                    // dd($otDays)

                    // $otDays = rtrim(rtrim(sprintf('%.2f', $otDays), '0'), '.');
                    // $otDays = 

                    $finalOtHours =
                            ($salary->overtime_hours ?? 0) *
                            ($salary->ot_rate_multiplier ?? 1);
                    // Logic for calculating OT hours amount based on OT hours and OT rate multiplier

                    $lastOT= ($finalOtHours * $salary->labour->ot_rate_multiplier);
                    // Every 6 OT hours = 1 day
                    // $otDays = ($salary->overtime_hours ?? 0) / 6;

                    // Final total days
                    $totalDays = $paidDays + $otDays;

                    $finalOtHours =
                                    ($salary->overtime_hours ?? 0) *    
                                    ($salary->ot_rate_multiplier ?? 1);
                    // Logic for calculating OT hours amount based on OT hours and OT rate multiplier
                    $lastOT= ($finalOtHours * $salary->labour->ot_rate_multiplier);

        @endphp

        <table class="info-table">
        <tr>
            <td><strong>Present Days</strong></td>
            <td>{{ $salary->present_days }}</td>

            <td><strong>Week Off</strong></td>
            <td>{{ $salary->week_off_days }}</td>
        </tr>

        <tr>
            <td><strong>Paid Days</strong></td>
            <td>{{ number_format($paidDays, 1) }}</td>

            <td><strong>OT Hours</strong></td>
            <td>{{ number_format($lastOT, 1) }}</td>
        </tr>

        <tr>
            <td><strong>OT Days</strong></td>
            <td>{{ ($otDays) }}</td>

            <td><strong>Total Days</strong></td>
            <td>{{ number_format($totalDays, 1) }}</td>
        </tr>

        </table>

    </div>

    {{-- Salary Details --}}
    <div class="salary-grid">

        {{-- Earnings --}}
        <div>

            <div class="section-heading earnings-head">
                Earnings Details
            </div>

            <table class="salary-table">

                <thead>
                    <tr>
                        <th>Earnings</th>
                        <th>Actual</th>
                        <th>Earned</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>Basic Salary</td>

                        <td>
                            ₹{{ number_format($salary->labour->basic_salary ?? 0, 2) }}
                        </td>

                        <td>
                            ₹{{ number_format($salary->earned_basic ?? 0, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td>HRA</td>

                        <td>
                            ₹{{ number_format($salary->labour->hra ?? 0, 2) }}
                        </td>

                        <td>
                            ₹{{ number_format($salary->earned_hra ?? 0, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td>Other Allowance</td>

                        <td>
                            ₹{{ number_format($salary->labour->other_allowance ?? 0, 2) }}
                        </td>

                        <td>
                            ₹{{ number_format($salary->earned_other_allowance ?? 0, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td>OT Amount</td>

                        <td>—</td>

                        <td>
                            ₹{{ number_format($salary->overtime_amount ?? 0, 2) }}
                        </td>
                    </tr>

                    <tr class="gross-row">

                        <td><strong>Gross Income</strong></td>

                        <td>
                            <strong>
                                ₹{{ number_format(
                                    ($salary->labour->basic_salary ?? 0) +
                                    ($salary->labour->hra ?? 0) +
                                    ($salary->labour->other_allowance ?? 0),
                                2) }}
                            </strong>
                        </td>

                        <td>
                            <strong>
                                ₹{{ number_format(
                                    ($salary->earned_basic ?? 0) +
                                    ($salary->earned_hra ?? 0) +
                                    ($salary->earned_other_allowance ?? 0) +
                                    ($salary->overtime_amount ?? 0),
                                2) }}
                            </strong>
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        {{-- Deductions --}}
        <div>

            <div class="section-heading deduction-head">
                Deduction Details
            </div>

            <table class="salary-table">

                <thead>
                    <tr>
                        <th>Deduction</th>
                        <th>Amount</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>PF</td>
                        <td>₹{{ number_format($salary->pf_deduction ?? 0, 2) }}</td>
                    </tr>

                    <tr>
                        <td>ESIC</td>
                        <td>₹{{ number_format($salary->esic_deduction ?? 0, 2) }}</td>
                    </tr>

                    <tr>
                        <td>Advance</td>
                        <td>₹{{ number_format($salary->advance_deduction ?? 0, 2) }}</td>
                    </tr>

                    <tr>
                        <td>PT</td>
                        <td>₹{{ number_format($salary->pt_deduction ?? 0, 2) }}</td>
                    </tr>

                    <tr>
                        <td>LWF</td>
                        <td>₹{{ number_format($salary->lwf_deduction ?? 0, 2) }}</td>
                    </tr>

                    <tr>
                        <td>Other Deduction</td>
                        <td>₹{{ number_format($salary->other_deduction ?? 0, 2) }}</td>
                    </tr>

                    <tr class="deduction-total">

                        <tr>
                                <td>
                                    <strong>Total Deduction</strong>
                                </td>

                                <td>
                                    <strong>
                                        ₹{{ number_format($salary->total_deduction ?? 0, 2) }}
                                    </strong>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong>NET PAYABLE SALARY</strong>
                                </td>

                                <td>
                                    <strong style="color:#16a34a;font-size:18px;">
                                        ₹{{ number_format($salary->net_salary) }}
                                    </strong>
                                </td>
                            </tr>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    {{-- Net Salary --}}
    {{-- <div class="net-salary-box">

        <div>
            NET PAYABLE SALARY
        </div>

        <div class="net-salary-amount">
            ₹{{ number_format($salary->net_salary ?? 0, 2) }}
        </div>

    </div> --}}

</div>

<style>

body{
    background:#f3f4f6;
}

.payslip-container{
    max-width:1100px;
    margin:auto;
    background:#fff;
    border:1px solid #d1d5db;
}

.header-section{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:16px 20px;
    border-bottom:1px solid #d1d5db;
    background:#fafafa;
}

.company-name{
    font-size:24px;
    font-weight:800;
    color:#ea580c;
}

.company-subtitle{
    font-size:11px;
    color:#6b7280;
    margin-top:4px;
}

.slip-title{
    font-size:20px;
    font-weight:700;
    color:#111827;
}

.slip-month{
    font-size:12px;
    color:#6b7280;
    margin-top:3px;
}

.section{
    padding:16px 20px;
}

.section-heading{
    font-size:13px;
    font-weight:700;
    margin-bottom:10px;
    padding:8px 10px;
    border:1px solid #d1d5db;
    background:#f9fafb;
    text-transform:uppercase;
    letter-spacing:1px;
}

.info-table{
    width:100%;
    border-collapse:collapse;
}

.info-table td{
    border:1px solid #d1d5db;
    padding:8px 10px;
    font-size:12px;
    color:#111827;
}

.salary-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
    padding:0 20px 20px;
}

.salary-table{
    width:100%;
    border-collapse:collapse;
}

.salary-table th{
    background:#f3f4f6;
    border:1px solid #d1d5db;
    padding:8px;
    font-size:11px;
    text-transform:uppercase;
    color:#374151;
}

.salary-table td{
    border:1px solid #d1d5db;
    padding:8px;
    font-size:12px;
    color:#111827;
}

.earnings-head{
    background:#f0fdf4;
    color:#166534;
}

.deduction-head{
    background:#fef2f2;
    color:#991b1b;
}

.gross-row{
    background:#f9fafb;
}

.deduction-total{
    background:#fef2f2;
}

.net-salary-box{
    margin:0 20px 20px;
    border:1px solid #111827;
    padding:12px 16px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#fafafa;
    font-size:14px;
    font-weight:700;
}

.net-salary-amount{
    font-size:24px;
    color:#16a34a;
    font-weight:800;
}

@media print{

    body{
        background:#fff;
    }

    .sidebar,
    .topbar,
    .page-header,
    .btn,
    .no-print{
        display:none !important;
    }

    .main{
        margin-left:0 !important;
    }

    .content{
        padding:0 !important;
    }

    .payslip-container{
        border:none;
        width:100%;
        max-width:100%;
    }

    @page{
        margin:8mm;
    }
    
}
.salary-table{
    width:100%;
    border-collapse:collapse;
    border:1px solid #d1d5db;
}

.salary-table th,
.salary-table td{
    border:1px solid #d1d5db;
}

.info-table{
    width:100%;
    border-collapse:collapse;
    border:1px solid #d1d5db;
}

.info-table td{
    border:1px solid #d1d5db;
}

.deduction-total td{
    border:1px solid #d1d5db;
}

.net-pay-row td{
    border:1px solid #d1d5db;
}


</style>

@endsection