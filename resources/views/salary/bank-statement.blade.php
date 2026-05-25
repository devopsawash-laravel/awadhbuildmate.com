@extends('layouts.app')

@section('title', 'Bank Statement')

@section('content')
<div class="page-header no-print"
     style="
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        flex-wrap:wrap;
        gap:20px;
     ">

    {{-- LEFT --}}
    <div></div>

    {{-- RIGHT --}}
    <div style="
        margin-left:auto;
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
<a href="{{ route('salary.bankstatement.export', [
        'site_id' => request('site_id'),
        'month' => $month,
        'year' => $year
    ]) }}"
   class="btn btn-success">

    <i class="fas fa-file-excel"></i>

    Export {{ date('F', mktime(0,0,0,$month,1)) }} Report

</a>
            </div>

        </form>

    </div>

</div>

<div class="company-header">

    <div class="company-left">

        {{-- Logo --}}
        <img src="{{ asset('images/projects/logo.png') }}"
             alt="Logo"
             class="company-logo">

        {{-- Company Details --}}
        <div>

            <div class="company-name">
                AWADH BUILDMATE
            </div>

            <div class="company-tagline">
                Build with Quality and Trust
            </div>

            <div class="company-subtitle">
                Fabrication | Erection | Structural Work
            </div>

        </div>

    </div>

    <div class="company-right">

        <div class="sheet-title">
            BANK STATEMENT
        </div>

        <div class="sheet-month">

            {{ \Carbon\Carbon::create()
                ->month($month)
                ->format('F') }}

            {{ $year }}

        </div>

    </div>

</div>


<div class="card">

    <div class="card-header">

        <h2>
            Salary Bank Statement
        </h2>

        <div>
            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
            {{ $year }}
        </div>

    </div>

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>
                    <th>Sr No</th>
                    <th>Type</th>
                    <th>Account Number</th>
                    <th>Employee Name</th>
                    <th>IFSC</th>
                    <th>Amount</th>
                </tr>

            </thead>

            <tbody>

                {{-- @foreach($salaries as $i => $salary) --}}
                @foreach($statement as $i => $item)
                <tr>

                    <td>{{ $i + 1 }}</td>

                    <td>NEFT</td>

                    <td>{{ $item['account_number'] ?? '-' }}</td>

                    <td>{{ $item['name'] ?? '-' }}</td>

                    <td>{{ $item['ifsc'] ?? '-' }}</td>

                    <td>
                        ₹{{ number_format($item['amount']) }}
                    </td>
                </tr>

                @endforeach

                {{-- Total --}}
                <tr style="
                    background:#f0fdf4;
                    font-weight:700;
                ">

                    <td colspan="5"
                        style="text-align:right;">

                        TOTAL PAYABLE

                    </td>

                    <td style="color:#16a34a;">

                        ₹{{ number_format($totalAmount, 2) }}

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection

<style>
    table{
    width:100%;
    border-collapse:collapse;
    border:1px solid #d1d5db;
}

table th{
    border:1px solid #d1d5db;
    padding:10px 12px;
    background:#f3f4f6;
    color:#374151;
    font-size:12px;
    text-transform:uppercase;
    font-weight:700;
}

table td{
    border:1px solid #d1d5db;
    padding:10px 12px;
    font-size:13px;
    color:#111827;
}

table tr:last-child td{
    font-weight:700;
    background:#f0fdf4;
}
.company-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 0 18px 0;
    margin-bottom:16px;
}

.company-left{
    display:flex;
    align-items:center;
    gap:16px;
}

.company-logo{
    width:80px;
    height:80px;
    object-fit:contain;
}

.company-right{
    text-align:right;
}

.company-name{
    font-size:28px;
    font-weight:800;
    color:#ea580c;
    line-height:1;
}

.company-tagline{
    font-size:13px;
    color:#374151;
    margin-top:6px;
    font-weight:600;
}

.company-subtitle{
    font-size:11px;
    color:#6b7280;
    margin-top:4px;
}

.sheet-title{
    font-size:22px;
    font-weight:700;
    color:#111827;
}

.sheet-month{
    font-size:13px;
    color:#6b7280;
    margin-top:4px;
}   

</style>