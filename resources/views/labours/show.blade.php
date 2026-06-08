@extends('layouts.app')

@section('title', $labour->name)
@section('page-title', 'Labour Profile')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">{{ $labour->name }}</div>
        <div class="page-subtitle">{{ $labour->employee_id }} &nbsp;·&nbsp; <span class="badge badge-{{ strtolower($labour->category) }}">{{ $labour->category }}</span></div>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('labours.edit', $labour) }}" class="btn btn-secondary"><i class="fas fa-edit"></i> Edit</a>
        <a href="{{ route('labours.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

    <div class="card">
        <div class="card-header">Labour Information</div>
        <div class="card-body">
            <table style="width:100%;">
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;width:140px;">Employee ID</td><td><strong>{{ $labour->employee_id }}</strong></td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Category</td><td><span class="badge badge-{{ strtolower($labour->category) }}">{{ $labour->category }}</span></td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Phone</td><td>{{ $labour->phone ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Address</td><td>{{ $labour->address ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Joining Date</td><td>{{ $labour->joining_date->format('d M Y') }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Status</td><td><span class="badge {{ $labour->status === 'active' ? 'badge-success' : 'badge-danger' }}">{{ ucfirst($labour->status) }}</span></td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Created At</td><td>{{ $labour->created_at->format('d M Y, h:i A') }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Address</td><td>{{ $labour->address ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Total Salary</td><td>{{ $labour->total_salary ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Daily Wage</td><td>{{ $labour->daily_wage ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Basic Salary</td><td>{{ $labour->basic_salary ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">HRA</td><td>{{ $labour->hra ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Other Allowances</td><td>{{ $labour->other_allowance ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Overtime Rate</td><td>{{ $labour->overtime_rate ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Account Number</td><td>{{ $labour->Account_Number ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Nominee Details</td><td>{{ $labour->Nominee_details ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Relation</td><td>{{ $labour->relation ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">IFSC Code</td><td>{{ $labour->IFSC ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">Pan_Card</td><td>{{ $labour->Pan_Card ?? '—' }}</td></tr>
                <tr><td style="padding:7px 0;color:var(--text-muted);font-size:13px;">ESIC_Number</td><td>{{ $labour->ESIC_Number ?? '—' }}</td></tr>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Wage & Deduction Details</div>
        <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div style="background:var(--bg);border-radius:8px;padding:14px;">
                    <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">Daily Wage</div>
                    <div style="font-size:22px;font-weight:700;color:var(--primary)">₹{{ number_format($labour->daily_wage, 0) }}</div>
                </div>
                <div style="background:var(--bg);border-radius:8px;padding:14px;">
                    <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">OT Rate/Hour</div>
                    <div style="font-size:22px;font-weight:700;color:var(--info)">₹{{ number_format($labour->overtime_rate, 0) }}</div>
                    <div style="font-size:11px;color:var(--text-muted)">Paid at 2× = ₹{{ number_format($labour->overtime_rate * 2, 0) }}/hr</div>
                </div>
                <div style="background:var(--bg);border-radius:8px;padding:14px;">
                    <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">PF Deduction</div>
                    <div style="font-size:22px;font-weight:700;color:var(--warning)">{{ $labour->pf_percentage }}%</div>
                </div>
                <div style="background:var(--bg);border-radius:8px;padding:14px;">
                    <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px;">Pending Advance</div>
                    <div style="font-size:22px;font-weight:700;color:var(--danger)">₹{{ number_format($labour->getPendingAdvances(), 0) }}</div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Advance Section -->
<div class="card mb-4">
    <div class="card-header">
        <span><i class="fas fa-hand-holding-usd" style="color:var(--warning)"></i>&nbsp; Advance Given</span>
        <button onclick="document.getElementById('advance-form').classList.toggle('hidden')" class="btn btn-sm btn-warning">
            <i class="fas fa-plus"></i> Give Advance
        </button>
    </div>

    <div id="advance-form" class="hidden" style="padding:16px 20px;border-bottom:1px solid var(--border);background:#FFFBEB;">
        <form method="POST" action="{{ route('advances.store') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
            @csrf
            <input type="hidden" name="labour_id" value="{{ $labour->id }}">
            <div style="flex:1;min-width:140px;">
                <label>Amount (₹)</label>
                <input type="number" name="amount" required min="1" step="0.01">
            </div>
            <div style="flex:1;min-width:140px;">
                <label>Date</label>
                <input type="date" name="given_date" value="{{ date('Y-m-d') }}" required>
            </div>
            <div style="flex:2;min-width:200px;">
                <label>Remarks</label>
                <input type="text" name="remarks" placeholder="Reason for advance...">
            </div>
            <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Save</button>
        </form>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr><th>Date</th><th>Amount</th><th>Remarks</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse($advances as $adv)
                <tr>
                    <td>{{ $adv->given_date->format('d M Y') }}</td>
                    <td><strong>₹{{ number_format($adv->amount, 0) }}</strong></td>
                    <td>{{ $adv->remarks ?? '—' }}</td>
                    <td>
                        @if($adv->is_deducted)
                            <span class="badge badge-success">Deducted</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if(!$adv->is_deducted)
                        <form method="POST" action="{{ route('advances.destroy', $adv) }}" onsubmit="return confirm('Delete this advance?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted" style="padding:20px;">No advances recorded</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Salary History -->
<div class="card">
    <div class="card-header">
        <span><i class="fas fa-file-invoice" style="color:var(--primary)"></i>&nbsp; Salary History</span>
        <a href="{{ route('salary.index') }}" class="btn btn-sm btn-primary">Generate Salary</a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr><th>Period</th><th>Days Worked</th><th>Basic</th><th>OT</th><th>Gross</th><th>PF</th><th>Advance</th><th>Net</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($salarySlips as $slip)
                <tr>
                    <td><strong>{{ $slip->getMonthName() }} {{ $slip->year }}</strong></td>
                    <td>{{ $slip->present_days + ($slip->half_days * 0.5) }}</td>
                    <td>₹{{ number_format($slip->basic_salary, 0) }}</td>
                    <td>₹{{ number_format($slip->overtime_amount, 0) }}</td>
                    <td>₹{{ number_format($slip->gross_salary, 0) }}</td>
                    <td style="color:var(--danger)">-₹{{ number_format($slip->pf_deduction, 0) }}</td>
                    <td style="color:var(--danger)">-₹{{ number_format($slip->advance_deduction, 0) }}</td>
                    <td><strong style="color:var(--success)">₹{{ number_format($slip->net_salary, 0) }}</strong></td>
                    <td><a href="{{ route('salary.show', $slip) }}" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted" style="padding:20px;">No salary slips generated</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    // Toggle advance form
    const hidden = document.getElementById('advance-form');
    hidden.classList.toggle('hidden', true);
</script>
<style>
.hidden { display: none !important; }
</style>
@endpush

@endsection