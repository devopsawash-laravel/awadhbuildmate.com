@extends('layouts.public')
@section('title', 'Contact Us — Awadh Buildmate')

@push('styles')
<style>
.page-hero { padding: 160px 0 80px; background: var(--dark); position: relative; overflow: hidden; }
.page-hero::before { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 60px 60px; }
.contact-section { padding: 80px 0 120px; background: var(--black); }
.contact-grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 80px; margin-top: 60px; }
.contact-info-item {
    border-left: 2px solid var(--orange);
    padding-left: 20px;
    margin-bottom: 36px;
}
.ci-label { font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--orange); margin-bottom: 8px; }
.ci-val { font-size: 16px; color: #fff; font-weight: 500; margin-bottom: 4px; }
.ci-sub { font-size: 13px; color: var(--muted); }
.contact-form {
    background: var(--dark2);
    border: 1px solid var(--border);
    padding: 40px;
}
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-group { margin-bottom: 20px; }
.form-label {
    display: block;
    font-family: 'Rajdhani', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 8px;
}
.form-control {
    width: 100%;
    background: var(--steel);
    border: 1px solid var(--border);
    color: #fff;
    padding: 12px 16px;
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    transition: border-color 0.2s;
}
.form-control:focus { border-color: var(--orange); }
.form-control::placeholder { color: #555; }
select.form-control option { background: var(--dark2); }
textarea.form-control { resize: vertical; min-height: 120px; }
.alert-success {
    background: rgba(16,185,129,0.1);
    border: 1px solid rgba(16,185,129,0.3);
    color: #34d399;
    padding: 14px 18px;
    margin-bottom: 24px;
    font-size: 14px;
}
@media (max-width: 900px) {
    .contact-grid { grid-template-columns: 1fr; }
    .form-row { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="page-hero">
    <div class="container">
        <div class="section-tag">Get In Touch</div>
        <h1 class="section-title">Contact<br>Us</h1>
        <p class="section-subtitle" style="margin-top:16px">Have a project in mind? We'd love to hear about it. Fill out the form and our team will get back to you within 24 hours.</p>
    </div>
</div>

<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <div>
                <div class="section-tag">Reach Us</div>
                <h2 class="section-title" style="font-size:42px;margin-bottom:40px">Let's Build<br>Something</h2>

                <div class="contact-info-item">
                    <div class="ci-label"><i class="fas fa-phone"></i> Phone</div>
                    <div class="ci-val">+91 7275502405</div>
                    <div class="ci-sub">Mon–Sat, 9AM–6PM</div>
                </div>
                <div class="contact-info-item">
                    <div class="ci-label"><i class="fas fa-envelope"></i> Email</div>
                    <div class="ci-val">awadhbuildmate@gmail.com</div>
                    <div class="ci-sub">We reply within 24 hours</div>
                </div>
                <div class="contact-info-item">
                    <div class="ci-label"><i class="fas fa-map-marker-alt"></i> Office</div>
                    <div class="ci-val">Awadh Buildmate</div>
                    <div class="ci-sub">Vadodara — 390023, Gujarat, India</div>
                </div>
                <div class="contact-info-item">
                    <div class="ci-label"><i class="fab fa-whatsapp"></i> WhatsApp</div>
                    <div class="ci-val">+91 7275502405</div>
                    <div class="ci-sub">Quick enquiries welcome</div>
                </div>
            </div>

            <div class="contact-form">
                @if(session('success'))
                    <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171;padding:14px 18px;margin-bottom:24px;font-size:14px;">
                        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('website.contact') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Your Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Ramesh Shah" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company" class="form-control" value="{{ old('company') }}" placeholder="Shah Industries Ltd.">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Phone *</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+91 98765 43210" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="ramesh@company.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Service Required *</label>
                        <select name="service_type" class="form-control" required>
                            <option value="">Select a service...</option>
                            <option value="Structural Fabrication" {{ old('service_type') == 'Structural Fabrication' ? 'selected' : '' }}>Structural Fabrication</option>
                            <option value="Steel Erection" {{ old('service_type') == 'Steel Erection' ? 'selected' : '' }}>Steel Erection</option>
                            <option value="Industrial Construction" {{ old('service_type') == 'Industrial Construction' ? 'selected' : '' }}>Industrial Construction</option>
                            <option value="Plant Maintenance" {{ old('service_type') == 'Plant Maintenance' ? 'selected' : '' }}>Plant Maintenance (AMC)</option>
                            <option value="Pipe Fabrication" {{ old('service_type') == 'Pipe Fabrication' ? 'selected' : '' }}>Pipe Fabrication</option>
                            <option value="Other" {{ old('service_type') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Project Details *</label>
                        <textarea name="message" class="form-control" placeholder="Describe your project, location, timeline, and any specific requirements..." required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">
                        <i class="fas fa-paper-plane"></i> Send Enquiry
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection