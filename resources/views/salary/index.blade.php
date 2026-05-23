@extends('layouts.app')

@section('title', 'Salary Management')
@section('page-title', 'Salary Management')

@section('content')

<div class="page-header">

    <div>

        <div class="page-title">
            Salary Management
        </div>

        <div class="page-subtitle">
            Generate and manage monthly salary slips
        </div>

    </div>

</div>


{{-- FILTER SECTION --}}
<div class="card mb-4">

    <div class="card-body"
         style="
            padding:18px 20px;
         ">

        <form method="GET"
              style="
                display:flex;
                gap:16px;
                align-items:end;
                flex-wrap:wrap;
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

            {{-- Button --}}
            <div>

                <button type="submit"
                        class="btn btn-secondary">

                    <i class="fas fa-search"></i>

                    View

                </button>

            </div>

        </form>

    </div>

</div>


{{-- GENERATE SALARY --}}
@if($labours->isNotEmpty())

<div class="card mb-4">

    <div class="card-header">

        <span>

            <i class="fas fa-file-invoice-dollar"
               style="color:var(--primary)"></i>

            Generate Salary Slip

        </span>

    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('salary.generate') }}"
              style="
                display:flex;
                gap:14px;
                align-items:end;
                flex-wrap:wrap;
              ">

            @csrf

            <input type="hidden"
                   name="month"
                   value="{{ $month }}">

            <input type="hidden"
                   name="year"
                   value="{{ $year }}">

            <input type="hidden"
                   name="site_id"
                   value="{{ request('site_id') }}">

            {{-- Labour --}}
            <div style="
                flex:1;
                min-width:320px;
            ">

                <label>Select Labour</label>

                <select name="labour_id"
                        required>

                    <option value="">
                        -- Choose Labour --
                    </option>

                    @foreach($labours as $labour)

                    <option value="{{ $labour->id }}">

                        {{ $labour->name }}
                        —
                        {{ $labour->employee_id }}
                        —
                        {{ $labour->site->name ?? 'No Site' }}

                    </option>

                    @endforeach

                </select>

            </div>

            {{-- Generate --}}
            <div>

                <button type="submit"
                        class="btn btn-primary">

                    <i class="fas fa-file-invoice"></i>

                    Generate

                </button>

            </div>

        </form>

        <div style="
            margin-top:12px;
            font-size:12px;
            color:var(--text-muted);
        ">

            <i class="fas fa-info-circle"></i>

            Salary = (Present Days × Daily Wage)
            + (OT Hours × OT Rate × Multiplier)
            − PF − Pending Advances

        </div>

    </div>

</div>

@endif


{{-- SALARY SLIPS --}}
<div class="card">

    <div class="card-header"
         style="
            display:flex;
            justify-content:space-between;
            align-items:center;
         ">

        <div>

            Salary Slips —
            {{ date('F', mktime(0,0,0,$month,1)) }}
            {{ $year }}

        </div>

        @if($salarySlips->isNotEmpty())

        <div style="
            font-size:13px;
            color:var(--text-muted);
        ">

            Total Net Salary:
            ₹{{ number_format($salarySlips->sum('net_salary'), 0) }}

        </div>

        @endif

    </div>

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>Labour</th>

                    <th>Site</th>

                    <th>Category</th>

                    <th>Days Worked</th>

                    <th>Gross</th>

                    <th>PF</th>

                    <th>Advance</th>

                    <th>Net Salary</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                @forelse($salarySlips as $slip)

                <tr>

                    <td>

                        <strong>
                            {{ $slip->labour->name }}
                        </strong>

                        <br>

                        <small class="text-muted">

                            {{ $slip->labour->employee_id }}

                        </small>

                    </td>

                    <td>

                        {{ $slip->labour->site->name ?? '-' }}

                    </td>

                    <td>

                        {{ $slip->labour->category }}

                    </td>

                    <td>

                        {{ $slip->present_days + ($slip->half_days * 0.5) + ($slip->week_off_days)}}

                    </td>

                    <td>

                        ₹{{ number_format($slip->gross_salary, 0) }}

                    </td>

                    <td style="color:var(--danger);">

                        -₹{{ number_format($slip->pf_deduction, 0) }}

                    </td>

                    <td style="color:var(--danger);">

                        -₹{{ number_format($slip->advance_deduction, 0) }}

                    </td>

                    <td>

                        <strong style="
                            color:var(--success);
                        ">

                            ₹{{ number_format($slip->net_salary, 0) }}

                        </strong>

                    </td>

                    <td>

                        <div style="
                            display:flex;
                            gap:6px;
                        ">

                            <a href="{{ route('salary.show', $slip) }}"
                               class="btn btn-sm btn-outline">

                                <i class="fas fa-eye"></i>

                            </a>

                            <a href="{{ route('salary.pdf', $slip) }}"
                               class="btn btn-sm btn-outline">

                                <i class="fas fa-file-pdf"></i>

                            </a>

                            <form method="POST"
                                  action="{{ route('salary.destroy', $slip) }}"
                                  onsubmit="return confirm('Delete this salary slip?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-sm btn-danger">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="9">

                        <div class="empty-state">

                            <i class="fas fa-file-invoice"></i>

                            <p>
                                No salary slips generated for this period
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