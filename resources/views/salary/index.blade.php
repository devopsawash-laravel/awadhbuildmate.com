@extends('layouts.app')

@section('title', 'Salary Management')
@section('page-title', 'Salary Management')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Salary Management</div>
        <div class="page-subtitle">Generate and manage monthly salary slips</div>
    </div>
</div>
<div>

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
<div class="card">

    <div class="card-header">

        <span>

            <i class="fas fa-file-invoice-dollar"
               style="color:var(--primary)"></i>

            Salary Slips —
            {{ date('F', mktime(0,0,0,$month,1)) }}
            {{ $year }}

        </span>

    </div>

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>#</th>

                    <th>Employee</th>

                    <th>Site</th>

                    <th>Category</th>

                    <th>Status</th>

                    <th style="width:120px;">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($labours as $i => $labour)

                @php

                    $generated =
                        $salarySlips
                            ->where('labour_id', $labour->id)
                            ->first();

                @endphp

                <tr>

                    <td>
                        {{ $i + 1 }}
                    </td>

                    <td>

                        <strong>
                            {{ $labour->name }}
                        </strong>

                        <br>

                        <small class="text-muted">
                            {{ $labour->employee_id }}
                        </small>

                    </td>

                    <td>
                        {{ $labour->site->name ?? '-' }}
                    </td>

                    <td>
                        {{ $labour->category }}
                    </td>

                    <td>

                        @if($generated)

                            <span class="badge badge-success">

                                Generated

                            </span>

                        @else

                            <span class="badge badge-warning">

                                Pending

                            </span>

                        @endif

                    </td>

                    <td>

                        @if($generated)

                            <a href="{{ route('salary.show', $generated->id) }}"
                               class="btn btn-sm btn-primary">

                                <i class="fas fa-eye"></i>

                            </a>

                        @else

                            <form method="POST"
                                  action="{{ route('salary.generate') }}">

                                @csrf

                                <input type="hidden"
                                       name="labour_id"
                                       value="{{ $labour->id }}">

                                <input type="hidden"
                                       name="month"
                                       value="{{ $month }}">

                                <input type="hidden"
                                       name="year"
                                       value="{{ $year }}">

                                <button type="submit"
                                        class="btn btn-sm btn-success">

                                    <i class="fas fa-file-invoice"></i>

                                </button>

                            </form>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6"
                        style="text-align:center;padding:40px;">

                        No labours found for selected site.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
<!-- Month Selector -->
<div class="card mb-4">
    <div class="card-body" style="padding:14px 20px;">
        <form method="GET" style="display:flex;gap:12px;align-items:flex-end;">
            <div>
                <label>Month</label>
                <select name="month">
                    @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label>Year</label>
                <select name="year">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> View</button>
        </form>
    </div>
</div>

<!-- Generate Salary -->
@if($labours->isNotEmpty())
<div class="card mb-4">
    <div class="card-header">
        <span><i class="fas fa-magic" style="color:var(--primary)"></i>&nbsp; Generate Salary Slip</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('salary.generate') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
            @csrf
            <input type="hidden" name="month" value="{{ $month }}">
            <input type="hidden" name="year" value="{{ $year }}">
            <div style="flex:2;min-width:200px;">
                <label>Select Labour</label>
                <select name="labour_id" required>
                    <option value="">— Choose Labour —</option>
                    @foreach($labours as $l)
                    <option value="{{ $l->id }}">{{ $l->name }} ({{ $l->employee_id }}) — {{ $l->category }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-file-invoice"></i> Generate</button>
        </form>
        <p style="margin-top:10px;font-size:12px;color:var(--text-muted);">
            <i class="fas fa-info-circle"></i>
            Salary = (Present Days × Daily Wage) + (OT Hours × OT Rate × 2) — PF — Pending Advances
        </p>
    </div>
</div>
@endif

<!-- Salary Slips List -->
<div class="card">
    <div class="card-header">
        Salary Slips — {{ date('F', mktime(0,0,0,$month,1)) }} {{ $year }}
        @if($salarySlips->isNotEmpty())
        <span style="font-size:13px;color:var(--text-muted)">Total Net: ₹{{ number_format($salarySlips->sum('net_salary'), 0) }}</span>
        @endif
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Labour</th>
                    <th>Category</th>
                    <th>Days Worked</th>
                    <th>Basic Salary</th>
                    <th>OT Amount</th>
                    <th>Gross</th>
                    <th>PF Deduction</th>
                    <th>Advance Cut</th>
                    <th>Net Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salarySlips as $slip)
                <tr>
                    <td><strong>{{ $slip->labour->name }}</strong><br><small class="text-muted">{{ $slip->labour->employee_id }}</small></td>
                    <td><span class="badge badge-{{ strtolower($slip->labour->category) }}">{{ $slip->labour->category }}</span></td>
                    <td>{{ $slip->present_days + ($slip->half_days * 0.5) }} / {{ $slip->total_days }}</td>
                    <td>₹{{ number_format($slip->basic_salary, 0) }}</td>
                    <td>₹{{ number_format($slip->overtime_amount, 0) }}{{ $slip->overtime_hours > 0 ? ' (' . $slip->overtime_hours . 'h)' : '' }}</td>
                    <td>₹{{ number_format($slip->gross_salary, 0) }}</td>
                    <td style="color:var(--danger)">-₹{{ number_format($slip->pf_deduction, 0) }}</td>
                    <td style="color:var(--danger)">-₹{{ number_format($slip->advance_deduction, 0) }}</td>
                    <td><strong style="color:var(--success);font-size:16px;">₹{{ number_format($slip->net_salary, 0) }}</strong></td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            <a href="{{ route('salary.show', $slip) }}" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('salary.pdf', $slip) }}" class="btn btn-sm btn-outline"><i class="fas fa-file-pdf"></i> PDF</a>
                            <form method="POST" action="{{ route('salary.destroy', $slip) }}" onsubmit="return confirm('Delete this salary slip?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10">
                        <div class="empty-state">
                            <i class="fas fa-file-invoice"></i>
                            <p>No salary slips generated for this period</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection