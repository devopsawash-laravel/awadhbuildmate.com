<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Salary Slip</title>
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: #fff;
        font-family: "DejaVu Sans", Arial, sans-serif;
        font-size: 12px;
        color: #111;
        padding: 20px;
    }

    .payslip {
        width: 100%;
        background: #fff;
        border: 1px solid #ccc;
    }

    /* ── HEADER ── */
    .header-table {
        width: 100%;
        border-collapse: collapse;
        border-bottom: 2px solid #111;
    }
    .header-table td { padding: 12px 16px; vertical-align: middle; }

    .company-name {
        font-size: 20px;
        font-weight: 900;
        color: #e85d04;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }
    .company-tagline { font-size: 10px; color: #666; margin-top: 2px; }
    .slip-title {
        font-size: 17px;
        font-weight: 900;
        color: #111;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-align: right;
    }
    .slip-month { font-size: 11px; color: #555; margin-top: 2px; text-align: right; }

    /* ── SECTION HEADING ── */
    .section-heading {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        background: #f5f5f5;
        border: 1px solid #ccc;
        padding: 7px 10px;
        margin: 14px 16px 0 16px;
    }

    .earn-heading {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #166534;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-bottom: none;
        padding: 7px 10px;
    }

    .dedu-heading {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #991b1b;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-bottom: none;
        padding: 7px 10px;
    }

    /* ── INFO / WORKING TABLE ── */
    .info-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ccc;
        margin: 0 0 0 0;
    }
    .info-table td {
        border: 1px solid #ccc;
        padding: 7px 10px;
        font-size: 12px;
    }
    .lbl {
        font-weight: 700;
        background: #fafafa;
        color: #222;
        width: 18%;
    }
    .val { width: 32%; color: #333; }

    /* ── SALARY TABLE ── */
    .salary-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ccc;
    }
    .salary-table th {
        background: #f5f5f5;
        border: 1px solid #ccc;
        padding: 7px 10px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #444;
    }
    .salary-table th.right,
    .salary-table td.right { text-align: right; }
    .salary-table th.left,
    .salary-table td.left  { text-align: left; }

    .salary-table td {
        border: 1px solid #ccc;
        padding: 7px 10px;
        font-size: 12px;
        color: #222;
    }

    .gross-row td {
        font-weight: 700;
        background: #f9fafb;
        border-top: 1px solid #aaa;
    }
    .total-dedu td {
        font-weight: 700;
        background: #fef2f2;
        color: #991b1b;
        border-top: 2px solid #fca5a5;
    }
    .net-pay-row td {
        font-weight: 700;
        background: #fff;
        border-top: 2px solid #111;
    }
    .net-amount {
        color: #16a34a;
        font-size: 15px;
        font-weight: 900;
        text-align: right;
    }

    /* ── FOOTER ── */
    .footer {
        border-top: 1px solid #ccc;
        padding: 9px 16px;
        background: #fafafa;
    }
    .footer-table { width: 100%; border-collapse: collapse; }
    .footer-note { font-size: 9px; color: #888; }

    /* ── PRINT ── */
    @media print {
        body { background: #fff; padding: 0; }
        .sidebar, .topbar, .page-header, .btn, .no-print { display: none !important; }
        .main { margin-left: 0 !important; }
        .content { padding: 0 !important; }
        @page { margin: 10mm 8mm; }
    }
    .page-break { page-break-after: always; }
</style>
</head>
<body>

@foreach($salarySlips as $salary)

@php
    $paidDays           = $salary->present_days + ($salary->half_days * 0.5) + $salary->week_off_days;
    $workingHoursPerDay = $salary->labour->working_hours_per_day ?? 8;
    $otMultiplier       = $salary->labour->ot_rate_multiplier ?? 1;
    $effectiveOtHours   = ($salary->overtime_hours ?? 0) * $otMultiplier;
    $otDays             = $workingHoursPerDay > 0 ? $effectiveOtHours / $workingHoursPerDay : 0;
    $finalOtHours       = ($salary->overtime_hours ?? 0) * ($salary->ot_rate_multiplier ?? 1);
    $lastOT             = $finalOtHours * $salary->labour->ot_rate_multiplier;
    $totalDays          = $paidDays + $otDays;

    $totalOTHours       = ($effectiveOtHours) * 2;
    // Clean OT Days display — remove trailing zeros
    $otDaysDisplay = rtrim(rtrim(number_format($otDays, 4, '.', ''), '0'), '.');
@endphp

<div class="payslip">

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td style="width:50%;">
                <div class="company-name">Awadh Buildmate</div>
                <div class="company-tagline">Made for Quality and Trust</div>
            </td>
            <td style="width:50%; text-align:right;">
                <div class="slip-title">Pay Slip</div>
                <div class="slip-month">{{ $salary->getMonthName() }} {{ $salary->year }}</div>
            </td>
        </tr>
    </table>

    {{-- EMPLOYEE DETAILS --}}
    <div class="section-heading">Employee Details</div>
    <div style="padding: 0 16px 0 16px; margin-top: 6px;">
        <table class="info-table">
            <tr>
                <td class="lbl">Employee Name</td>
                <td class="val">{{ $salary->labour->name }}</td>
                <td class="lbl">Employee ID</td>
                <td class="val">{{ $salary->labour->employee_id }}</td>
            </tr>
            <tr>
                <td class="lbl">Category</td>
                <td class="val">{{ $salary->labour->category }}</td>
                <td class="lbl">Joining Date</td>
                <td class="val">{{ \Carbon\Carbon::parse($salary->labour->joining_date)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td class="lbl">UAN Number</td>
                <td class="val">{{ $salary->labour->UAN ?? '—' }}</td>
                <td class="lbl">ESIC Number</td>
                <td class="val">{{ $salary->labour->ESIC_Number ?? '—' }}</td>
            </tr>
            <tr>
                <td class="lbl">Bank Name</td>
                <td class="val">{{ $salary->labour->bank->name ?? '—' }}</td>
                <td class="lbl">Account No.</td>
                <td class="val">{{ $salary->labour->Account_Number ?? '—' }}</td>
            </tr>
            <tr>
                <td class="lbl">IFSC Code</td>
                <td class="val">{{ $salary->labour->IFSC ?? '—' }}</td>
                <td class="lbl">Month</td>
                <td class="val">{{ $salary->getMonthName() }} {{ $salary->year }}</td>
            </tr>
        </table>
    </div>

    {{-- WORKING DETAILS --}}
    <div class="section-heading">Working Details</div>
    <div style="padding: 0 16px 0 16px; margin-top: 6px;">
        <table class="info-table">
            <tr>
                <td class="lbl">Present Days</td>
                <td class="val">{{ $salary->present_days }}</td>
                <td class="lbl">Week Off</td>
                <td class="val">{{ $salary->week_off_days }}</td>
            </tr>
            <tr>
                <td class="lbl">Paid Days</td>
                <td class="val">{{ number_format($paidDays, 1) }}</td>
                <td class="lbl">OT Hours</td>
                <td class="val">{{ number_format($lastOT, 1) }}</td>
            </tr>
            <tr>
                <td class="lbl">OT Days</td>
                <td class="val">{{ $otDaysDisplay }}</td>
                <td class="lbl">Total Days</td>
                <td class="val">{{ number_format($totalDays, 1) }}</td>
            </tr>
        </table>
    </div>

    {{-- EARNINGS & DEDUCTIONS — table-based two column layout for PDF compat --}}
    <div style="padding: 14px 16px 16px 16px;">
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                {{-- LEFT: Earnings --}}
                <td style="width:50%; vertical-align:top; padding-right:8px;">
                    <div class="earn-heading">Earnings Details</div>
                    <table class="salary-table">
                        <thead>
                            <tr>
                                <th class="left" style="width:44%;">Earnings</th>
                                <th class="right" style="width:28%;">Actual</th>
                                <th class="right" style="width:28%;">Earned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="left">Basic Salary</td>
                                <td class="right">&#8377;{{ number_format($salary->labour->basic_salary ?? 0, 2) }}</td>
                                <td class="right">&#8377;{{ number_format($salary->earned_basic ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="left">HRA</td>
                                <td class="right">&#8377;{{ number_format($salary->labour->hra ?? 0, 2) }}</td>
                                <td class="right">&#8377;{{ number_format($salary->earned_hra ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="left">Other Allowance</td>
                                <td class="right">&#8377;{{ number_format($salary->labour->other_allowance ?? 0, 2) }}</td>
                                <td class="right">&#8377;{{ number_format($salary->earned_other_allowance ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="left">OT Amount</td>
                                <td class="right">—</td>
                                <td class="right">&#8377;{{ number_format($salary->overtime_amount ?? 0, 2) }}</td>
                            </tr>
                            <tr class="gross-row">
                                <td class="left">Gross Income</td>
                                <td class="right">&#8377;{{ number_format(($salary->labour->basic_salary ?? 0) + ($salary->labour->hra ?? 0) + ($salary->labour->other_allowance ?? 0), 2) }}</td>
                                <td class="right">&#8377;{{ number_format(($salary->earned_basic ?? 0) + ($salary->earned_hra ?? 0) + ($salary->earned_other_allowance ?? 0) + ($salary->overtime_amount ?? 0), 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>

                {{-- RIGHT: Deductions --}}
                <td style="width:50%; vertical-align:top; padding-left:8px;">
                    <div class="dedu-heading">Deduction Details</div>
                    <table class="salary-table">
                        <thead>
                            <tr>
                                <th class="left" style="width:60%;">Deduction</th>
                                <th class="right" style="width:40%;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="left">PF</td>
                                <td class="right">&#8377;{{ number_format($salary->pf_deduction ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="left">ESIC</td>
                                <td class="right">&#8377;{{ number_format($salary->esic_deduction ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="left">Advance</td>
                                <td class="right">&#8377;{{ number_format($salary->advance_deduction ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="left">PT</td>
                                <td class="right">&#8377;{{ number_format($salary->pt_deduction ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="left">LWF</td>
                                <td class="right">&#8377;{{ number_format($salary->lwf_deduction ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="left">Other Deduction</td>
                                <td class="right">&#8377;{{ number_format($salary->other_deduction ?? 0, 2) }}</td>
                            </tr>
                            <tr class="total-dedu">
                                <td class="left">Total Deduction</td>
                                <td class="right">&#8377;{{ number_format($salary->total_deduction ?? 0, 2) }}</td>
                            </tr>
                            <tr class="net-pay-row">
                                <td class="left">NET PAYABLE SALARY</td>
                                <td class="net-amount">&#8377;{{ number_format($salary->net_salary) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td><span class="footer-note">This is a system-generated payslip and does not require a signature.</span></td>
                <td style="text-align:right;"><span class="footer-note">Awadh Buildmate &nbsp;&middot;&nbsp; Made For Quality and Trust</span></td>
            </tr>
        </table>
    </div>

</div>
<div class="page-break"></div>
@endforeach

</body>
</html>