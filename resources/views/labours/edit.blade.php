@extends('layouts.app')

@section('title', 'Edit Labour')
@section('page-title', 'Edit Labour')

@section('content')

<div class="page-header">
    <div class="page-title">
        Edit Labour — {{ $labour->name }}
    </div>

    <a href="{{ route('labours.show', $labour) }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card" style="max-width:900px;">
    <div class="card-header">Update Labour Details</div>

    <div class="card-body">
        <form method="POST" action="{{ route('labours.update', $labour) }}">
            @csrf
            @method('PUT')

            {{-- BASIC INFO --}}
            <div class="form-grid-2">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name"
                        value="{{ old('name', $labour->name) }}" required>
                </div>

                <div class="form-group">
                    <label>Employee ID *</label>
                    <input type="text" name="employee_id"
                        value="{{ old('employee_id', $labour->employee_id) }}" required>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category" required>
                        @php
                            $categories = [
                                'Welder','Fitter','Helper','Rigger','Assistant Fitter',
                                'Grinder','Gas Cutter','Khallasi Helper',
                                'Visual Grinder','Structure Fitter'
                            ];
                        @endphp

                        @foreach($categories as $cat)
                            <option value="{{ $cat }}"
                                {{ old('category', $labour->category) == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone"
                        value="{{ old('phone', $labour->phone) }}">
                </div>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="2">{{ old('address', $labour->address) }}</textarea>
            </div>

            <hr class="divider">

            {{-- SALARY DETAILS --}}
            <div class="form-grid-3">

                <div class="form-group">
                    <label>Daily Wage (₹) *</label>
                    <input type="number" name="daily_wage"
                        value="{{ old('daily_wage', $labour->daily_wage) }}"
                        step="0.01" required>
                </div>

                <div class="form-group">
                    <label>OT Rate / Hour (₹) *</label>
                    <input type="number" name="overtime_rate"
                        value="{{ old('overtime_rate', $labour->overtime_rate) }}"
                        step="0.01" required>
                    <small style="color:var(--text-muted);font-size:11px;">
                        OT is usually paid at 2× rate
                    </small>
                </div>

                <div class="form-group">
                    <label>Working Days</label>
                    <input type="number" name="working_days"
                        value="{{ old('working_days', $labour->working_days) }}">
                </div>

                <div class="form-group">
                    <label>Total Salary (₹)</label>
                    <input type="number" name="total_salary"
                        value="{{ old('total_salary', $labour->total_salary) }}"
                        step="0.01">
                </div>

                <div class="form-group">
                    <label>Basic Salary</label>
                    <input type="number" name="basic_salary"
                        value="{{ old('basic_salary', $labour->basic_salary) }}"
                        step="0.01">
                </div>

                <div class="form-group">
                    <label>HRA</label>
                    <input type="number" name="hra"
                        value="{{ old('hra', $labour->hra) }}"
                        step="0.01">
                </div>

                <div class="form-group">
                    <label>Other Allowance</label>
                    <input type="number" name="other_allowance"
                        value="{{ old('other_allowance', $labour->other_allowance) }}"
                        step="0.01">
                </div>

            </div>

            <hr class="divider">

            {{-- JOINING & STATUS --}}
            <div class="form-grid-2">

                <div class="form-group">
                    <label>Joining Date *</label>
                    <input type="date" name="joining_date"
                        value="{{ old('joining_date', optional($labour->joining_date)->format('Y-m-d')) }}"
                        required>
                </div>

                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" required>
                        <option value="active" {{ old('status', $labour->status) == 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="inactive" {{ old('status', $labour->status) == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

            </div>

            {{-- SITE & BANK --}}
            <div class="form-grid-3">

                <div class="form-group">
                    <label>Site</label>
                    <select name="site_id">
                        <option value="">Select Site</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}"
                                {{ old('site_id', $labour->site_id) == $site->id ? 'selected' : '' }}>
                                {{ $site->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Bank</label>
                    <select name="bank_id">
                        <option value="">Select Bank</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}"
                                {{ old('bank_id', $labour->bank_id) == $bank->id ? 'selected' : '' }}>
                                {{ $bank->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Aadhar Number</label>
                    <input type="text" name="Aadhar_Number"
                        value="{{ old('Aadhar_Number', $labour->Aadhar_Number) }}">
                </div>

                <div class="form-group">
                    <label>Account Number</label>
                    <input type="text" name="Account_Number"
                        value="{{ old('Account_Number', $labour->Account_Number) }}">
                </div>

                <div class="form-group">
                    <label>IFSC</label>
                    <input type="text" name="IFSC"
                        value="{{ old('IFSC', $labour->IFSC) }}">
                </div>

                <div class="form-group">
                    <label>PAN Card</label>
                    <input type="text" name="Pan_Card"
                        value="{{ old('Pan_Card', $labour->Pan_Card) }}">
                </div>

                <div class="form-group">
                    <label>Nominee</label>
                    <input type="text" name="Nominee_details"
                        value="{{ old('Nominee_details', $labour->Nominee_details) }}">
                </div>

                <div class="form-group">
                    <label>ESIC Number</label>
                    <input type="text" name="ESIC_Number"
                        value="{{ old('ESIC_Number', $labour->ESIC_Number) }}">
                </div>

                <div class="form-group">
                    <label>UAN Number</label>
                    <input type="text" name="UAN"
                        value="{{ old('UAN', $labour->UAN) }}">
                </div>

            </div>

            {{-- ACTIONS --}}
            <div style="display:flex;gap:10px;margin-top:15px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Labour
                </button>

                <a href="{{ route('labours.show', $labour) }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@endsection