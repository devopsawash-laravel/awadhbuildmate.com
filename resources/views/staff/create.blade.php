@extends('layouts.app')

@section('title', 'Add Staff')
@section('page-title', 'Add Staff')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="page-header">
    <div>
        <div class="page-title">Add New Staff</div>
        <div class="page-subtitle">Register office and site staff</div>
    </div>

    <a href="{{ route('staff.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card" style="max-width:900px;">

    <div class="card-header">
        Staff Details
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('staff.store') }}">

            @csrf

            {{-- Name & Employee ID --}}
            <div class="form-grid-2">

                <div class="form-group">
                    <label>Full Name *</label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="e.g. Shivani Sharma">
                </div>

                <div class="form-group">
                    <label>Employee ID *</label>

                    <input
                        type="text"
                        name="employee_id"
                        value="{{ $employeeId ?? '' }}"
                        readonly
                        required>
                </div>

                <div class="form-group">
                    <label>Education</label>

                    <input
                        type="text"
                        name="education"
                        value="{{ old('Education') }}"
                        required
                        placeholder="e.g. B.Tech">
                </div>

                <div class="form-group">
                    <label>Experience</label>

                    <input
                        type="text"
                        name="experience"
                        value="{{old('Experience')}}"
                        required
                        placeholder="e.g. 5 Years">
                </div>

            </div>

            {{-- Department & Phone --}}
            <div class="form-grid-2">

                <div class="form-group">
                    <label>Category *</label>

                    <select name="category" id="category" required>

                        <option value="">Select Category</option>

                        @foreach([
                            'Site Incharge',
                            'QC-Quality',
                            'Safety Supervisor',
                            'Planning',
                            'Execution',
                            'Admin',
                            'Supervisor',
                        ] as $dept)

                            <option value="{{ $dept }}">
                                {{ $dept }}
                            </option>

                        @endforeach

                    </select>
                </div>

                
                <div class="form-group">
                    <label>Phone</label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="9876543210">
                </div>

            </div>

            {{-- Address --}}
           <div class="form-grid-2">

    {{-- Address --}}
                <div class="form-group">
                    <label>Address</label>

                    <textarea
                        name="address"
                        rows="2"
                        placeholder="Full address">{{ old('address') }}</textarea>
                </div>

                {{-- Joining Date --}}
                <div class="form-group">
                    <label>Joining Date</label>

                    <input
                        type="date"
                        name="joining_date"
                        value="{{ old('joining_date', date('Y-m-d')) }}">
                </div>

            </div>
            <hr class="divider">

            {{-- Salary Section --}}
            <div style="font-weight:600;font-size:13px;margin-bottom:14px;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;">
                <i class="fas fa-rupee-sign"></i> Salary Structure
            </div>

            <div class="form-grid-4">

                 <div class="form-group">
                    <label>Salary (₹) *</label>

                    <input
                        type="number"
                        id="total_salary"
                        name="total_salary"
                        placeholder="Enter total monthly salary"
                        value="{{ old('total_salary') }}"
                        required
                        step="0.01"
                        min="0">
                </div>

                <!-- Working Days -->
                {{-- <div class="form-group">
                    <label>Working Days/Month *</label>

                    <select id="working_days" name="working_days" required>
                        <option value="">Select Days</option>

                        @for($i = 26; $i <= 31; $i++)
                            <option value="{{ $i }}">{{ $i }} Days</option>
                        @endfor
                    </select>
                </div> --}}

            {{-- <div class="form-group">

                <label>Salary Month *</label>

                <select id="salary_month" name="salary_month" required>

                    <option value="">Select Month</option>

                    <option value="0">January</option>
                    <option value="1">February</option>
                    <option value="2">March</option>
                    <option value="3">April</option>
                    <option value="4">May</option>
                    <option value="5">June</option>
                    <option value="6">July</option>
                    <option value="7">August</option>
                    <option value="8">September</option>
                    <option value="9">October</option>
                    <option value="10">November</option>
                    <option value="11">December</option>

                </select>
            </div> --}}

            {{-- <div class="form-group">

            <label>Year *</label>

            <select id="salary_year" name="salary_year">

                @for($year = date('Y'); $year <= date('Y') + 5; $year++)

                    <option value="{{ $year }}">
                        {{ $year }}
                    </option>

                @endfor

            </select>

        </div> --}}

                 <!-- Daily Wage -->
                {{-- <div class="form-group">
                    <label>Daily Wage (₹) *</label>

                    <input
                        type="number"
                        id="daily_wage"
                        name="daily_wage"
                        placeholder="Auto calculated daily wage"
                        readonly
                        step="0.01">
                </div> --}}

                <div class="form-group">
                    <label>Basic Salary</label>

                    <input
                        type="number"
                        name="basic_salary"
                        value="{{ old('basic_salary') }}"
                        step="0.01">
                </div>

                <div class="form-group">
                    <label>HRA</label>

                    <input
                        type="number"
                        name="hra"
                        value="{{ old('hra') }}"
                        step="0.01">
                </div>

                <div class="form-group">
                    <label>Other Allowance</label>

                    <input
                        type="number"
                        name="other_allowance"
                        value="{{ old('other_allowance') }}"
                        step="0.01">
                </div>

                {{-- <div class="form-group">
                    <label>PF Percentage</label>

                    <input
                        type="number"
                        name="pf_percentage"
                        value="{{ old('pf_percentage', 12) }}"
                        step="0.01"> --}}
                {{-- </div> --}}

                <div class="form-group">
                    <label>Status *</label>

                    {{-- <select name="status" required> --}}
                    <select name="status" id="status" required>
                        <option value="active">Active</option>

                        <option value="inactive">Inactive</option>

                    </select>
                </div>

               <div class="form-group">

    <label>Site *</label>

    <select name="site_id" id="site_id" required>

        <option value="">Select Site</option>

        @foreach($sites as $site)

            <option value="{{ $site->id }}">

                {{ $site->name }}

            </option>

        @endforeach

    </select>

</div>


            </div>

            <hr class="divider">

            {{-- Bank Section --}}
            <div style="font-weight:600;font-size:13px;margin-bottom:14px;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;">
                <i class="fas fa-university"></i> Bank Details
            </div>

            <div class="form-grid-2">

                <div class="form-group">
                    <label>Bank Name</label>

                    <select name="bank_id" id="bank">

                        <option value="">Select Bank</option>

                        @foreach($banks as $bank)

                            <option
                                value="{{ $bank->id }}"
                                {{ old('bank_id') == $bank->id ? 'selected' : '' }}>

                                {{ $bank->name }}

                            </option>

                        @endforeach

                    </select>
                </div>

                <div class="form-group">
                    <label>Account Number</label>

                    <input
                        type="text"
                        name="Account_Number"
                        value="{{ old('Account_Number') }}">
                </div>

                <div class="form-group">
                    <label>IFSC Code</label>

                    <input
                        type="text"
                        name="IFSC"
                        value="{{ old('IFSC') }}">
                </div>

                 <div class="form-grid-2">

                    {{-- Nominee Name --}}
                    <div class="form-group">
                        <label>Nominee Name</label>

                        <input
                            type="text"
                            name="Nominee_details"
                            value="{{ old('Nominee_details') }}"
                            placeholder="Enter nominee name">
                    </div>

                    {{-- Nominee Relation --}}
                    <div class="form-group">
                        <label>Relation</label>

                        <select name="relation" id="nominee_relation">

                            <option value="">Select Relation</option>

                            <option value="Father">Father</option>
                            <option value="Mother">Mother</option>
                            {{-- <option value="Spouse">Spouse</option> --}}
                            <option value="Wife">Wife</option>
                            <option value="Husband">Husband</option>  
                            <option value="Son">Son</option>
                            <option value="Daughter">Daughter</option>
                            <option value="Brother">Brother</option>
                            <option value="Sister">Sister</option>
                            <option value="Guardian">Guardian</option>

                        </select>
                    </div>

                </div>
                               
                <div class="form-group">
                    <label>PAN Card</label>

                    <input
                        type="text"
                        name="Pan_Card"
                        value="{{ old('Pan_Card') }}">
                </div>

                <div class="form-group">
                    <label>Aadhar Number</label>

                    <input
                        type="text"
                        name="Aadhar_Number"
                        value="{{ old('Aadhar_Number') }}">
                </div>

                <div class="form-group">
                    <label>ESIC Number</label>

                    <input
                        type="text"
                        name="ESIC_Number"
                        value="{{ old('ESIC_Number') }}">
                </div>

                <div class="form-group">
                    <label>UAN Number</label>

                    <input
                        type="text"
                        name="UAN"
                        value="{{ old('UAN') }}">
                </div>

            </div>

            {{-- Joining --}}
            {{-- <div class="form-grid-2">

                <div class="form-group">
                    <label>Joining Date *</label>

                    <input
                        type="date"
                        name="joining_date"
                        value="{{ old('joining_date', date('Y-m-d')) }}"
                        required>
                </div>
            </div> --}}

            <div style="display:flex;gap:10px;margin-top:20px;">

                <button type="submit" class="btn btn-staff">
                        <i class="fas fa-save"></i>
                            Save Staff
                </button>

                <a href="{{ route('staff.create') }}" class="btn btn-secondary">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

<script>

$(document).ready(function () {

    // Category
$('#category').select2({
    placeholder: "Select Category",
    width: '100%',
    // dropdownParent: $('.staff-form')
    dropdownParent: $('#category').parent()
});

    // Bank
  $('#bank').select2({
    placeholder: "Select Bank",
    width: '100%',
    dropdownParent: $('#bank').parent()
});

    // Status
   $('#status').select2({
    width: '100%',
    minimumResultsForSearch: Infinity,
    dropdownParent: $('#status').parent()
});

// Working Days
$('#working_days').select2({
    minimumResultsForSearch: Infinity,
    width: '100%',
    dropdownParent: $('#working_days').parent()
});

// Nominee Relation
$('#nominee_relation').select2({
    placeholder: "Select Relation",
    width: '100%',
    dropdownParent: $('#nominee_relation').parent()
});

    // Auto Calculate Daily Wage
    function calculateRates() {

        let salary =
            parseFloat($('#total_salary').val()) || 0;

        let workingDays =
            parseFloat($('#working_days').val()) || 0;

        // Prevent divide by zero
        if (workingDays > 0) {

            let dailyWage = salary / workingDays;

            $('#daily_wage').val(
                dailyWage.toFixed(2)
            );

        } else {

            $('#daily_wage').val('');

        }
    }

    // Events
    $('#total_salary').on('input', calculateRates);

    $('#working_days').on('change', calculateRates);

    // Initial Load
    calculateRates();

});

// Site
$('#site_id').select2({
    placeholder: "Select Site",
    minimumResultsForSearch: Infinity,
    width: '100%',
    dropdownParent: $('#site_id').parent()
});

// Salary Month
$('#salary_month').select2({
    placeholder: "Select Month",
    minimumResultsForSearch: Infinity,
    width: '100%',
    dropdownParent: $('#salary_month').parent()
});

// Salary Year
$('#salary_year').select2({
    placeholder: "Select Year",
    minimumResultsForSearch: Infinity,
    width: '100%',
    dropdownParent: $('#salary_year').parent()
});

 
function calculateDailyWage() {

    let salary =
        parseFloat($('#total_salary').val()) || 0;

    let month =
        parseInt($('#salary_month').val());

    let year =
        parseInt($('#salary_year').val());

    // Check month/year selected
    if (isNaN(month) || isNaN(year)) {

        $('#daily_wage').val('');

        return;
    }

    // Get total days in month
    let totalDays =
        new Date(year, month + 1, 0).getDate();

    // Calculate
    let dailyWage = salary / totalDays;

    $('#daily_wage').val(
        dailyWage.toFixed(2)
    );
}

// Events
$('#total_salary').on('input', calculateDailyWage);

$('#salary_month').on('change', calculateDailyWage);

$('#salary_year').on('change', calculateDailyWage);

</script>
<style>
    .form-grid-4{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));
    gap:16px;
}

/* =========================================
   STAFF BLUE BUTTON
========================================= */

.btn-staff{

    background:#2563eb;

    color:#fff;

    border:none;

    transition:0.2s ease;
}

.btn-staff:hover{

    background:#1d4ed8;

    color:#fff;

    transform:translateY(-1px);
}

.btn-staff:focus{

    box-shadow:
        0 0 0 3px rgba(37,99,235,.25);
}
</style>

@endsection
