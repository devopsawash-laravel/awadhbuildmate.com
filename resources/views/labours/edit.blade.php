@extends('layouts.app')

@section('title', 'Edit Labour')
@section('page-title', 'Edit Labour')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Edit Labour — {{ $labour->name }}</div>
    </div>
    <a href="{{ route('labours.show', $labour) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card" style="max-width:800px;">
    <div class="card-header">Update Labour Details</div>
    <div class="card-body">
        <form method="POST" action="{{ route('labours.update', $labour) }}">
            @csrf @method('PUT')

            <div class="form-grid-2">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', $labour->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Employee ID *</label>
                    <input type="text" name="employee_id" value="{{ old('employee_id', $labour->employee_id) }}" required>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" required>
                        @foreach(['Welder','Fitter','Helper','Rigger'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', $labour->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $labour->phone) }}">
                </div>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="2">{{ old('address', $labour->address) }}</textarea>
            </div>

            <hr class="divider">

            <div class="form-grid-3">
                <div class="form-group">
                    <label>Daily Wage (₹) *</label>
                    <input type="number" name="daily_wage" value="{{ old('daily_wage', $labour->daily_wage) }}" required step="0.01">
                </div>
                <div class="form-group">
                    <label>OT Rate/Hour (₹) *</label>
                    <input type="number" name="overtime_rate" value="{{ old('overtime_rate', $labour->overtime_rate) }}" required step="0.01">
                    <small style="color:var(--text-muted);font-size:11px;">OT is paid at 2× this rate</small>
                </div>
                <div class="form-group">
                    <label>PF Deduction (%) *</label>
                    <input type="number" name="pf_percentage" value="{{ old('pf_percentage', $labour->pf_percentage) }}" required step="0.01">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label>Joining Date *</label>
                    <input type="date" name="joining_date" value="{{ old('joining_date', $labour->joining_date->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" required>
                        <option value="active" {{ old('status', $labour->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $labour->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Labour</button>
                <a href="{{ route('labours.show', $labour) }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection