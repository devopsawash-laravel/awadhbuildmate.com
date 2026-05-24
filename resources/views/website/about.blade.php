@extends ('layouts.public')
@section('title', 'About Us — Awadh Buildmate')

@push('styles')
<style>
.page-hero { padding: 160px 0 80px; background: var(--dark); position: relative; overflow: hidden; }
.page-hero::before { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 60px 60px; }
.about-section { padding: 80px 0 120px; background: var(--black); }
.about-intro { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; margin-bottom: 100px; }
.big-stat { font-family: 'Bebas Neue', sans-serif; font-size: 120px; letter-spacing: 2px; color: var(--orange); line-height: 1; }
.about-text p { font-size: 16px; line-height: 1.9; color: var(--muted); margin-bottom: 20px; }
.values-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px; background: var(--border); margin-top: 60px; }
.value-card { background: var(--dark2); padding: 36px 24px; text-align: center; }
.vc-icon { width: 60px; height: 60px; background: var(--orange-glow); border: 1px solid rgba(232,80,10,0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
.vc-icon i { color: var(--orange); font-size: 22px; }
.vc-title { font-family: 'Bebas Neue', sans-serif; font-size: 22px; letter-spacing: 1px; color: #fff; margin-bottom: 10px; }
.vc-desc { font-size: 13px; color: var(--muted); line-height: 1.6; }
.team-section { padding: 80px 0; background: var(--dark); }
.team-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 48px; }
.team-card { background: var(--dark2); border: 1px solid var(--border); padding: 32px; }
.tc-avatar {
    width: 72px; height: 72px;
    background: var(--orange);
    clip-path: polygon(0 0, 88% 0, 100% 12%, 100% 100%, 12% 100%, 0 88%);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 26px;
    color: #fff;
    margin-bottom: 16px;
}
.tc-name { font-family: 'Rajdhani', sans-serif; font-size: 18px; font-weight: 700; color: #fff; }
.tc-role { font-size: 12px; color: var(--orange); letter-spacing: 2px; font-family: 'Rajdhani', sans-serif; text-transform: uppercase; margin-bottom: 12px; }
.tc-desc { font-size: 13px; color: var(--muted); line-height: 1.7; }
@media (max-width: 900px) {
    .about-intro { grid-template-columns: 1fr; }
    .values-grid { grid-template-columns: 1fr 1fr; }
    .team-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="page-hero">
    <div class="container">
        <div class="section-tag">Our Story</div>
        <h1 class="section-title">About<br>Awadh Buildmate</h1>
    </div>
</div>

<section class="about-section">
    <div class="container">
        <div class="about-intro">
            <div>
                <div class="big-stat">12</div>
                <div style="font-family:'Rajdhani',sans-serif;font-size:14px;font-weight:700;letter-spacing:3px;text-transform:uppercase;color:var(--muted);margin-top:-8px">Years of Excellence</div>
            </div>
            <div class="about-text">
                <div class="section-tag">Who We Are</div>
                <h2 class="section-title" style="font-size:42px;margin-bottom:24px">Building India's<br>Industrial Backbone</h2>
                <p>Awadh Buildmate Pvt. Ltd. was founded with a single mission: to deliver world-class fabrication, erection, and construction services to India's industrial sector. Based in Ankleshwar, Gujarat — the heart of India's chemical and industrial belt — we have grown from a small workshop to a trusted name across the country.</p>
                <p>With over 200 completed projects and 500+ skilled workers on our rolls, we handle everything from small maintenance jobs to multi-crore greenfield plant constructions. Our team of certified welders, riggers, fitters, and engineers bring unmatched expertise to every job site.</p>
                <a href="{{ route('website.contact') }}" class="btn-primary" style="margin-top:8px"><i class="fas fa-arrow-right"></i> Work With Us</a>
            </div>
        </div>

        <div class="section-tag">Our Values</div>
        <h2 class="section-title">What Drives Us</h2>
        <div class="values-grid">
            <div class="value-card">
                <div class="vc-icon"><i class="fas fa-shield-alt"></i></div>
                <div class="vc-title">Safety</div>
                <div class="vc-desc">Every worker goes home safe. Zero compromise on safety protocols, PPE, and site standards.</div>
            </div>
            <div class="value-card">
                <div class="vc-icon"><i class="fas fa-medal"></i></div>
                <div class="vc-title">Quality</div>
                <div class="vc-desc">ISO-aligned quality management. Every weld, bolt, and beam meets the highest standards.</div>
            </div>
            <div class="value-card">
                <div class="vc-icon"><i class="fas fa-clock"></i></div>
                <div class="vc-title">Timeliness</div>
                <div class="vc-desc">We plan meticulously and execute efficiently. Deadlines are commitments we keep.</div>
            </div>
            <div class="value-card">
                <div class="vc-icon"><i class="fas fa-handshake"></i></div>
                <div class="vc-title">Integrity</div>
                <div class="vc-desc">Transparent pricing, honest communication, and long-term relationships with every client.</div>
            </div>
        </div>
    </div>
</section>

<section class="team-section">
    <div class="container">
        <div class="section-tag">Leadership</div>
        <h2 class="section-title">Our Team</h2>
        <div class="team-grid">
            <div class="team-card">
                <div class="tc-avatar">RK</div>
                <div class="tc-name">Rajesh Kumar Sharma</div>
                <div class="tc-role">Founder & Managing Director</div>
                <p class="tc-desc">20+ years in industrial construction. Visionary leader who built Awadh Buildmate from the ground up with a focus on quality and safety.</p>
            </div>
            <div class="team-card">
                <div class="tc-avatar">AS</div>
                <div class="tc-name">Anil Singh</div>
                <div class="tc-role">General Manager — Projects</div>
                <p class="tc-desc">15 years of project management experience. Oversees all site operations, planning, and delivery across active projects.</p>
            </div>
            <div class="team-card">
                <div class="tc-avatar">PP</div>
                <div class="tc-name">Priya Patel</div>
                <div class="tc-role">Head — Quality & Safety</div>
                <p class="tc-desc">Certified safety officer ensuring ISO compliance, quality audits, and zero-accident culture across all job sites.</p>
            </div>
        </div>
    </div>
</section>
@endsection