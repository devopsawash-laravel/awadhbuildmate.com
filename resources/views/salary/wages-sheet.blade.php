    @extends('layouts.app')

    @section('title', 'Wages Sheet')
    @section('page-title', 'Wages Sheet')

    @section('content')

    <div class="page-header no-print"
        style="
            display:flex;
            justify-content:flex-end;
            align-items:flex-start;
            flex-wrap:wrap;
            gap:20px;
        ">

        <form method="GET"
            style="
                display:flex;
                gap:14px;
                align-items:end;
                flex-wrap:wrap;
                justify-content:flex-end;
            ">

            {{-- Site --}}
            <div style="min-width:240px;">

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

            {{-- View --}}
            <div>

                <button type="submit"
                        class="btn btn-secondary">

                    <i class="fas fa-search"></i>

                    View

                </button>

            </div>

            {{-- Print --}}
            <div>

                <button type="button"
                        onclick="window.print()"
                        class="btn btn-primary">

                    <i class="fas fa-print"></i>

                    Print

                </button>

            </div>

        </form>

    </div>

    <div class="wages-container">

        {{-- Company Header --}}
        <div class="company-header">

            <div style="
                display:flex;
                align-items:center;
                gap:16px;
            ">

                {{-- Company Logo --}}
                <div>

                    <img src="{{ asset('images/projects/logo.png') }}"
                        alt="Logo"
                        style="
                            width:80px;
                            height:80px;
                            object-fit:contain;
                        ">

                </div>

                {{-- Company Details --}}
                <div>

                    <div class="company-name">
                        AWADH BUILDMATE
                    </div>

                    <div class="company-tagline">
                        Made For Quality and Trust
                    </div>

                    <div class="company-subtitle">
                        Fabrication | Erection | Structural Work
                    </div>

                </div>

            </div>

            {{-- Sheet Details --}}
            <div style="text-align:right;">

                <div class="sheet-title">
                    FORM XVII - REGISTER OF WAGES
                </div>

                <div class="sheet-month">
                    {{ date('F', mktime(0,0,0,$month,1)) }}
                    {{ $year }}
                </div>

            </div>

        </div>

        <div class="table-wrapper">

            <table class="wages-table">

                <thead>

                    <tr>

                        <th rowspan="2">Sr.</th>
                        <th rowspan="2">Type</th>
                        <th rowspan="2">Name of Workman</th>
                        
                        <th rowspan="2">Designation</th>

                        <th rowspan="2">Total Present</th>
                        <th rowspan="2">OT Hours</th>

                        <th colspan="4">Actual</th>

                        <th colspan="5">Earned</th>

                        <th colspan="6">Deduction</th>

                        {{-- <th rowspan="2">Net Amount Paid</th> --}}
                        <th rowspan="2">Total Payable</th>

                    </tr>

                    <tr>

                        {{-- Actual --}}
                        <th>Basic</th>
                        <th>HRA</th>
                        <th>Allowance</th>
                        <th>Gross</th>

                        {{-- Earned --}}
                        <th>Basic</th>
                        <th>HRA</th>
                        <th>Allowance</th>
                        <th>OT Amount</th>
                        <th>Gross</th>

                        {{-- Deduction --}}
                        <th>PF</th>
                        <th>ESIC</th>
                        <th>PT</th>
                        <th>ADV</th>
                        <th>Others</th>
                        <th>Total Ded</th>

                    </tr>

                </thead>

                <tbody>

                    @php

                        $totalPaidDays = 0;
                        $totalOtHours = 0;

                        $totalActualBasic = 0;
                        $totalActualHra = 0;
                        $totalActualAllowance = 0;
                        $totalActualGross = 0;

                        $totalEarnedBasic = 0;
                        $totalEarnedHra = 0;
                        $totalEarnedAllowance = 0;
                        $totalOtAmount = 0;
                        $totalEarnedGross = 0;

                        $totalPf = 0;
                        $totalEsic = 0;
                        $totalPt = 0;
                        $totalAdv = 0;
                        $totalOther = 0;

                        $grandTotalDeduction = 0;

                        $grandNetSalary = 0;
                        $grandTotalPayable = 0;

                    @endphp

                    @foreach($combinedSlips as $i => $salary)

                    @php

                        $paidDays =
                            $salary->present_days +
                            ($salary->half_days * 0.5);

                        $finalOtHours =
                            ($salary->overtime_hours ?? 0) *
                            ($salary->ot_rate_multiplier ?? 1);

                        // $actualGross =
                        //     ($salary->labour->basic_salary ?? 0) +
                        //     ($salary->labour->hra ?? 0) +
                        //     ($salary->labour->other_allowance ?? 0);

                        $actualGross =
                            ($salary->employee->basic_salary ?? 0) +
                            ($salary->employee->hra ?? 0) +
                            ($salary->employee->other_allowance ?? 0);

                        $earnedGross =
                            ($salary->earned_basic ?? 0) +
                            ($salary->earned_hra ?? 0) +
                            ($salary->earned_other_allowance ?? 0) +
                            ($salary->overtime_amount ?? 0);

                        $totalPayable =
                            ($salary->net_salary ?? 0);

                        // Totals
                        $totalPaidDays += $paidDays;
                        $totalOtHours += $finalOtHours;

                        $totalActualBasic += $salary->employee->basic_salary ?? 0;
                        $totalActualHra += $salary->employee->hra ?? 0;
                        $totalActualAllowance += $salary->employee->other_allowance ?? 0;
                        $totalActualGross += $actualGross;

                        $totalEarnedBasic += $salary->earned_basic ?? 0;
                        $totalEarnedHra += $salary->earned_hra ?? 0;
                        $totalEarnedAllowance += $salary->earned_other_allowance ?? 0;
                        $totalOtAmount += $salary->overtime_amount ?? 0;
                        $totalEarnedGross += $earnedGross;

                        $totalPf += $salary->pf_deduction ?? 0;
                        $totalEsic += $salary->esic_deduction ?? 0;
                        $totalPt += $salary->pt_deduction ?? 0;
                        $totalAdv += $salary->advance_deduction ?? 0;
                        $totalOther += $salary->other_deduction ?? 0;

                        $grandTotalDeduction += $salary->total_deduction ?? 0;

                        $grandNetSalary += $salary->net_salary ?? 0;

                        $grandTotalPayable += $totalPayable;

                    @endphp

                    <tr>

                        <td>{{ $i + 1 }}</td>

                        <td>
                            {{ $salary->employee_type }}
                        </td>

                        <td>
                            {{ $salary->employee->name }}
                        </td>

                        <td>
                            {{ $salary->employee->category ?? $salary->employee->designation }}
                        </td>

                        <td>
                            {{ number_format($paidDays,1) }}
                        </td>

                        <td>
                            {{ number_format($finalOtHours,1) }}
                        </td>

                        {{-- Actual --}}
                        <td>{{ number_format($salary->employee->basic_salary ?? 0,0) }}</td>

                        <td>{{ number_format($salary->employee->hra ?? 0,0) }}</td>

                        <td>{{ number_format($salary->employee->other_allowance ?? 0,0) }}</td>

                        <td>{{ number_format($actualGross,0) }}</td>

                        {{-- Earned --}}
                        <td>{{ number_format($salary->earned_basic ?? 0,0) }}</td>

                        <td>{{ number_format($salary->earned_hra ?? 0,0) }}</td>

                        <td>{{ number_format($salary->earned_other_allowance ?? 0,0) }}</td>

                        <td>{{ number_format($salary->overtime_amount ?? 0,0) }}</td>

                        <td>{{ number_format($earnedGross,0) }}</td>

                        {{-- Deduction --}}
                        <td>{{ number_format($salary->pf_deduction ?? 0,0) }}</td>

                        <td>{{ number_format($salary->esic_deduction ?? 0,0) }}</td>

                        <td>{{ number_format($salary->pt_deduction ?? 0,0) }}</td>

                        <td>{{ number_format($salary->advance_deduction ?? 0,0) }}</td>

                        <td>{{ number_format($salary->other_deduction ?? 0,0) }}</td>

                        <td>
                            <strong>
                                {{ number_format($salary->total_deduction ?? 0,0) }}
                            </strong>
                        </td>

                        {{-- Final --}}
                        {{-- <td>
                            <strong>
                                {{ number_format($salary->net_salary ?? 0,0) }}
                            </strong>
                        </td> --}}

                        <td>
                            <strong>
                                {{ number_format($totalPayable,0) }}
                            </strong>
                        </td>

                    </tr>

                    @endforeach

                    {{-- TOTAL ROW --}}
                    <tr class="total-row">

                        <td colspan="4">
                            <strong>TOTAL</strong>
                        </td>

                        <td>{{ number_format($totalPaidDays,1) }}</td>

                        <td>{{ number_format($totalOtHours,1) }}</td>

                        <td>{{ number_format($totalActualBasic,0) }}</td>

                        <td>{{ number_format($totalActualHra,0) }}</td>

                        <td>{{ number_format($totalActualAllowance,0) }}</td>

                        <td>{{ number_format($totalActualGross,0) }}</td>

                        <td>{{ number_format($totalEarnedBasic,0) }}</td>

                        <td>{{ number_format($totalEarnedHra,0) }}</td>

                        <td>{{ number_format($totalEarnedAllowance,0) }}</td>

                        <td>{{ number_format($totalOtAmount,0) }}</td>

                        <td>{{ number_format($totalEarnedGross,0) }}</td>

                        <td>{{ number_format($totalPf,0) }}</td>

                        <td>{{ number_format($totalEsic,0) }}</td>

                        <td>{{ number_format($totalPt,0) }}</td>

                        <td>{{ number_format($totalAdv,0) }}</td>

                        <td>{{ number_format($totalOther,0) }}</td>

                        <td>{{ number_format($grandTotalDeduction,0) }}</td>

                        {{-- <td>{{ number_format($grandNetSalary,0) }}</td> --}}

                        <td>{{ number_format($grandTotalPayable,0) }}</td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <style>


    :root{
        --primary:#ea580c;
        --primary-dark:#c2410c;
        --primary-light:#fff7ed;

        --text:#1f2937;
        --muted:#6b7280;

        --border:#d1d5db;
        --header-bg:#fffaf5;
        --table-head:#fff3e8;

        --total-bg:#fff7ed;
    }

    /* PAGE */

    .wages-container{
        background:#ffffff;
        border:1px solid var(--border);
        border-radius:14px;
        padding:22px;
        box-shadow:0 4px 18px rgba(0,0,0,0.06);
    }

    /* HEADER */

    .company-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:20px;

        margin-bottom:22px;
        padding-bottom:16px;

        border-bottom:2px solid var(--primary-light);
    }

    .company-name{
        font-size:30px;
        font-weight:800;
        letter-spacing:0.5px;
        color:var(--primary);
        line-height:1.1;
    }

    .company-tagline{
        font-size:13px;
        color:var(--text);
        margin-top:4px;
        font-weight:600;
    }

    .company-subtitle{
        font-size:12px;
        color:var(--muted);
        margin-top:5px;
        letter-spacing:0.3px;
    }

    .sheet-title{
        font-size:20px;
        font-weight:800;
        color:var(--text);
    }

    .sheet-month{
        font-size:13px;
        color:var(--primary-dark);
        margin-top:6px;
        font-weight:600;
    }

    /* TABLE */

    .table-wrapper{
        overflow:auto;
        border-radius:10px;
    }

    .wages-table{
        width:100%;
        border-collapse:collapse;
        font-size:11px;
        min-width:1500px;
    }

    /* TABLE HEADER */

    .wages-table thead th{
        background:var(--table-head);
        color:var(--text);
        font-weight:700;
        border:1px solid #d6d3d1;
        padding:8px 6px;
        text-transform:uppercase;
        letter-spacing:0.3px;
    }

    /* TABLE BODY */

    .wages-table td{
        border:1px solid #e5e7eb;
        padding:7px 6px;
        text-align:center;
        vertical-align:middle;
        color:#111827;
        background:#ffffff;
    }

    /* ROW HOVER */

    .wages-table tbody tr:hover{
        background:#fffaf5;
    }

    /* ALTERNATE ROWS */

    .wages-table tbody tr:nth-child(even){
        background:#fcfcfc;
    }

    /* TOTAL ROW */

    .total-row td{
        font-weight:800;
        background:var(--total-bg) !important;
        color:var(--primary-dark);
        border-top:2px solid var(--primary);
        font-size:11.5px;
    }

    /* BUTTONS */

    .btn{
        border:none;
        border-radius:8px;
        padding:10px 16px;
        font-weight:600;
        transition:0.25s ease;
        cursor:pointer;
    }

    .btn-primary{
        background:var(--primary);
        color:white;
    }

    .btn-primary:hover{
        background:var(--primary-dark);
        transform:translateY(-1px);
    }

    .btn-secondary{
        background:#374151;
        color:white;
    }

    .btn-secondary:hover{
        background:#111827;
        transform:translateY(-1px);
    }

    /* FORM ELEMENTS */

    select{
        height:42px;
        border:1px solid #d1d5db;
        border-radius:8px;
        padding:0 12px;
        background:#fff;
        color:#111827;
        font-weight:500;
        min-width:140px;
    }

    label{
        display:block;
        margin-bottom:6px;
        font-size:13px;
        font-weight:600;
        color:#374151;
    }

    /* LOGO */

    /* .company-header img{
        background:#fff;
        border-radius:12px;
        padding:6px;
        border:1px solid #fed7aa;
        box-shadow:0 2px 8px rgba(234,88,12,0.08);
    } */

    /* SCROLLBAR */

    .table-wrapper::-webkit-scrollbar{
        height:8px;
    }

    .table-wrapper::-webkit-scrollbar-thumb{
        background:#fdba74;
        border-radius:20px;
    }

    /* MOBILE */

    @media(max-width:768px){

        .company-header{
            flex-direction:column;
            align-items:flex-start;
        }

        .sheet-title{
            font-size:16px;
        }

        .company-name{
            font-size:24px;
        }

        .wages-container{
            padding:14px;
        }

        .page-header form{
            width:100%;
        }

        select{
            min-width:100%;
        }
    }

    /* PRINT */

    @media print{

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

        .wages-container{
            border:none;
            box-shadow:none;
            border-radius:0;
            padding:0;
        }

        .wages-table{
            font-size:10px;
        }

        .wages-table th{
            background:#f3f4f6 !important;
            color:#000 !important;
        }

        .total-row td{
            background:#f5f5f5 !important;
            color:#000 !important;
        }

        @page{
            size:landscape;
            margin:5mm;
        }
    }

    </style>


    @endsection