@extends('layouts.app')

@section('title', $staff->name)
@section('page-title', 'Staff Profile')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">{{ $staff->name }}</div>
        <div class="page-subtitle">
            {{ $staff->employee_id }}
            @if($staff->category)
                &nbsp;·&nbsp; {{ $staff->category }}
            @endif
        </div>
    </div>

    <div style="display:flex;gap:8px;">
        <a href="{{ route('staff.edit', $staff) }}" class="btn btn-secondary">
            <i class="fas fa-edit"></i> Edit
        </a>

        <a href="{{ route('staff.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

    <!-- Staff Information -->
    <div class="card">
        <div class="card-header">Staff Information</div>

        <div class="card-body">
            <table style="width:100%;">
                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);width:140px;">
                        Employee ID
                    </td>
                    <td>
                        <strong>{{ $staff->employee_id }}</strong>
                    </td>
                </tr>

                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Category
                    </td>
                    <td>{{ $staff->category ?? '—' }}</td>
                </tr>

                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Phone
                    </td>
                    <td>{{ $staff->phone ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Address
                    </td>
                    <td>{{ $staff->address ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Joining Date
                    </td>
                    <td>{{ $staff->joining_date->format('d M Y') }}</td>
                </tr>

                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Status
                    </td>
                    <td>
                        <span class="badge {{ $staff->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ ucfirst($staff->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Account Number
                    </td>
                    <td>{{ $staff->Account_Number ?? '—' }}</td>
                </tr>
                 <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        IFSC
                    </td>
                    <td>{{ $staff->IFSC ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Pan Card Number
                    </td>
                    <td>{{ $staff->Pan_Card ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Aadhar Number
                    </td>
                    <td>{{ $staff->Aadhar_Number ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Nominee Details
                    </td>
                    <td>{{ $staff->Nominee_details ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Relation
                    </td>
                    <td>{{ $staff->relation ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        ESIC Number
                    </td>
                    <td>{{ $staff->ESIC_Number ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        UAN
                    </td>
                    <td>{{ $staff->UAN ?? '—' }}</td>
                </tr>
                 <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Bank Name
                    </td>
                    <td>{{ $staff->bank->name?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Education
                    </td>
                    <td>{{ $staff->education ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Experience
                    </td>
                    <td>{{ $staff->experience ?? '—' }} Yrs.</td>
                </tr>
                <tr>
                    <td style="padding:7px 0;color:var(--text-muted);">
                        Site
                    </td>
                    <td>{{ $staff->site->name ?? '—' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Salary Details -->
    <div class="card">
        <div class="card-header">Salary Details</div>

        <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

                <div style="background:var(--bg);border-radius:8px;padding:14px;">
                    <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">
                        Monthly Salary
                    </div>

                    <div style="font-size:24px;font-weight:700;color:var(--primary)">
                        ₹{{ number_format($staff->total_salary,0) }}
                    </div>
                </div>

                <div style="background:var(--bg);border-radius:8px;padding:14px;">
                    <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">
                        Daily Wage
                    </div>

                    <div style="font-size:24px;font-weight:700;color:var(--success)">
                        ₹{{ number_format($staff->daily_wage,0) }}
                    </div>
                </div>

                <div style="background:var(--bg);border-radius:8px;padding:14px;">
                    <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">
                        Basic Salary
                    </div>

                    <div style="font-size:24px;font-weight:700;color:var(--success)">
                        ₹{{ number_format($staff->basic_salary,0) }}
                    </div>
                </div>
                <div style="background:var(--bg);border-radius:8px;padding:14px;">
                    <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">
                        HRA
                    </div>

                    <div style="font-size:24px;font-weight:700;color:var(--success)">
                        ₹{{ number_format($staff->hra,0) }}
                    </div>
                </div>
                 <div style="background:var(--bg);border-radius:8px;padding:14px;">
                    <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">
                        Advance Taken
                    </div>

                    <div style="font-size:24px;font-weight:700;color:var(--success)">
                        ₹{{ number_format($salary->advance_deduction ?? 0,  0) }}
                        {{-- ₹{{ number_format($slip->total_deduction ?? 0,0) }} --}}
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- Salary History -->
<div class="card">
    <div class="card-header">
        <span>
            <i class="fas fa-file-invoice" style="color:var(--primary)"></i>
            &nbsp; Salary History
        </span>

        <a href="{{ route('salary.index') }}" class="btn btn-sm btn-primary">
            Generate Salary
        </a>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Period</th>
                    <th>Paid Days</th>
                    <th>Basic Salary</th>
                    <th>Deductions</th>
                    <th>Net Salary</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>

            @forelse($salarySlips as $slip)

                <tr>
                    <td>
                        <strong>
                            {{ $slip->getMonthName() }} {{ $slip->year }}
                        </strong>
                    </td>

                    <td>{{ $slip->paid_days }}</td>

                    <td>
                        ₹{{ number_format($slip->gross_salary,0) }}
                    </td>

                    <td style="color:var(--danger)">
                        ₹{{ number_format($slip->total_deduction ?? 0,0) }}
                    </td>

                    <td>
                        <strong style="color:var(--success)">
                            ₹{{ number_format($slip->net_salary,0) }}
                        </strong>
                    </td>

                    <td>
                        <a href="{{ route('salary.show',$slip) }}"
                           class="btn btn-sm btn-outline">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="6"
                        class="text-center text-muted"
                        style="padding:20px;">
                        No salary slips generated
                    </td>
                </tr>

            @endforelse

            </tbody>
        </table>
    </div>
</div>

@endsection