@extends('layouts.app')

@section('title', 'Add Labour')
@section('page-title', 'Add Labour')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Add New Labour</div>
        <div class="page-subtitle">Register a new worker on site</div>
    </div>
    <a href="{{ route('labours.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card" style="max-width:800px;">
    <div class="card-header">Labour Details</div>
    <div class="card-body">
        <form method="POST" action="{{ route('labours.store') }}">
            @csrf

            <div class="form-grid-2">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Ramesh Kumar">
                </div>
                <div class="form-group">
                    <label>Employee ID *</label>
                    <input type="text" name="employee_id" value="{{ old('employee_id') }}" required placeholder="e.g. EMP-001">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        @foreach(['Welder','Fitter','Helper','Rigger'] as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. 9876543210">
                </div>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="2" placeholder="Full address">{{ old('address') }}</textarea>
            </div>

            <hr class="divider">
            <div style="font-weight:600;font-size:13px;margin-bottom:14px;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;">
                <i class="fas fa-rupee-sign"></i>&nbsp; Wage & Deduction Settings
            </div>

            <div class="form-grid-3">
                <div class="form-group">
                    <label>Daily Wage (₹) *</label>
                    <input type="number" name="daily_wage" value="{{ old('daily_wage', 500) }}" required step="0.01" min="0">
                </div>
                <div class="form-group">
                    <label>Overtime Rate/Hour (₹) *</label>
                    <input type="number" name="overtime_rate" value="{{ old('overtime_rate', 100) }}" required step="0.01" min="0">
                    <small style="color:var(--text-muted);font-size:11px;">OT is paid at 2× this rate</small>
                </div>
                <div class="form-group">
                    <label>PF Deduction (%) *</label>
                    <input type="number" name="pf_percentage" value="{{ old('pf_percentage', 12) }}" required step="0.01" min="0" max="100">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label>Joining Date *</label>
                    <input type="date" name="joining_date" value="{{ old('joining_date', date('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            
            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Labour</button>
                <a href="{{ route('labours.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection