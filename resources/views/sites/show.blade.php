@extends('layouts.app')

@section('title', $site->name)

@section('page-title', 'Site Details')

@section('content')


<div class="page-header"
     style="
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        flex-wrap:wrap;
        gap:20px;
     ">

    {{-- LEFT SECTION --}}
    <div style="
        display:flex;
        align-items:flex-start;
        gap:24px;
        flex-wrap:wrap;
    ">

        {{-- Site Title --}}
        <div>

            <div class="page-title"
                 style="
                    display:flex;
                    align-items:center;
                    gap:10px;
                 ">

                <i class="fas fa-building"
                   style="
                        color:var(--primary);
                   "></i>

                {{ $site->name }}

            </div>

            <div class="page-subtitle">

                {{ $site->location }}
                •
                {{ $site->state }}

            </div>

        </div>


        {{-- Attendance Filter --}}
        <div class="no-print"
             style="
                margin-top:2px;
             ">

            <form method="GET"
                  style="
                    display:flex;
                    gap:12px;
                    align-items:end;
                    flex-wrap:wrap;
                  ">

                {{-- Month --}}
                <div>

                    <label>Month</label>

                    <select name="month">

                        @for($m = 1; $m <= 12; $m++)

                        <option value="{{ $m }}"
                            {{ $m == $selectedMonth ? 'selected' : '' }}>

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
                            {{ $y == $selectedYear ? 'selected' : '' }}>

                            {{ $y }}

                        </option>

                        @endfor

                    </select>

                </div>

                {{-- Button --}}
                <div>

                    <button type="submit"
                            class="btn btn-secondary">

                        <i class="fas fa-search"></i>

                        View

                    </button>
                    

                </div>
                <a href="{{ route('sites.index') }}"
   class="btn btn-primary"
   style="
        display:flex;
        align-items:center;
        gap:8px;
        width:max-content;
   ">

    <i class="fas fa-arrow-left"></i>

    Back

</a>

            </form>

        </div>

    </div>


    {{-- STATUS --}}
    <div>

        <span class="badge badge-success"
              style="
                padding:8px 14px;
                font-size:13px;
              ">

            {{ ucfirst($site->status) }}

        </span>

    </div>

</div>



{{-- SITE INFO --}}
<div class="card mb-4">

    <div class="card-header">

        <i class="fas fa-info-circle"></i>

        Site Information

    </div>

    <div class="card-body">

        <div class="form-grid"
             style="
                display:grid;
                grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
                gap:20px;
             ">

            <div>

                <div class="text-muted">
                    Client
                </div>

                <strong>
                    {{ $site->client ?? '-' }}
                </strong>

            </div>

            <div>

                <div class="text-muted">
                    Site Incharge
                </div>

                <strong>
                    {{ $site->site_incharge ?? '-' }}
                </strong>

            </div>

            <div>

                <div class="text-muted">
                    Incharge Phone
                </div>

                <strong>
                    {{ $site->incharge_phone ?? '-' }}
                </strong>

            </div>

            <div>

                <div class="text-muted">
                    Description
                </div>

                <strong>
                    {{ $site->description ?? '-' }}
                </strong>

            </div>

        </div>

    </div>

</div>



{{-- STATS --}}
<div style="
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:18px;
    margin-bottom:24px;
">

    {{-- Total Labours --}}
    <div class="card">

        <div class="card-body">

            <div class="text-muted">
                Total Labours
            </div>

            <div style="
                font-size:28px;
                font-weight:700;
                margin-top:8px;
            ">

                {{ $labours->count() }}

            </div>

        </div>

    </div>


    {{-- Total Staff --}}
    <div class="card">

        <div class="card-body">

            <div class="text-muted">
                Total Staff
            </div>

            <div style="
                font-size:28px;
                font-weight:700;
                margin-top:8px;
            ">

                {{ $staffs->count() }}

            </div>

        </div>

    </div>


    {{-- Attendance --}}
    <div class="card">

        <div class="card-body">

            <div class="text-muted">
                Attendance Records
            </div>

            <div style="
                font-size:28px;
                font-weight:700;
                margin-top:8px;
            ">

                {{ $attendanceCount }}

            </div>

        </div>

    </div>


    {{-- Salary Paid --}}
    <div class="card">

        <div class="card-body">

            <div class="text-muted">
                Total Salary Paid
            </div>

            <div style="
                font-size:28px;
                font-weight:700;
                margin-top:8px;
                color:var(--success);
            ">

                ₹{{ number_format($salarySlips->sum('net_salary'),0) }}

            </div>

        </div>

    </div>

</div>



{{-- LABOUR LIST --}}
<div class="card">

    <div class="card-header"
         style="
            display:flex;
            justify-content:space-between;
            align-items:center;
         ">

        <span>

            <i class="fas fa-users"></i>

            Site Labour List

        </span>

        <span class="text-muted">

            {{ $labours->count() }} Employees

        </span>

    </div>

    <div style="overflow-x:auto;">

        <table>

            <thead>

                <tr>

                    <th>Employee ID</th>

                    <th>Name</th>

                    <th>Category</th>

                    <th>Phone</th>

                    <th>Daily Wage</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse($labours as $labour)

                <tr>

                    <td>

                        {{ $labour->employee_id }}

                    </td>

                    <td>

                        <strong>
                            {{ $labour->name }}
                        </strong>

                    </td>

                    <td>

                        {{ $labour->category }}

                    </td>

                    <td>

                        {{ $labour->phone }}

                    </td>

                    <td>

                        ₹{{ number_format($labour->daily_wage,0) }}

                    </td>

                    <td>

                        <span class="badge badge-success">

                            {{ ucfirst($labour->status) }}

                        </span>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6">

                        <div class="empty-state">

                            <i class="fas fa-users"></i>

                            <p>
                                No labours assigned to this site
                            </p>

                        </div>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection