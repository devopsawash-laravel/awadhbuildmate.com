@extends('layouts.public')
@section('title', 'Our Services — Awadh Buildmate')

@push('styles')
<style>
.page-hero {
    padding: 160px 0 80px;
    background: var(--dark);
    position: relative;
    overflow: hidden;
}
.page-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
    background-size: 60px 60px;
}
.services-detail { padding: 80px 0 120px; background: var(--black); }
.service-block {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
    padding: 72px 0;
    border-bottom: 1px solid var(--border);
}
.service-block:last-child { border-bottom: none; }
.service-block.reverse { direction: rtl; }
.service-block.reverse > * { direction: ltr; }
.sb-visual {
    background: var(--dark2);
    border: 1px solid var(--border);
    aspect-ratio: 4/3;
    display: flex; align-items: center; justify-content: center;
    position: relative;
    overflow: hidden;
}
.sb-visual::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(232,80,10,0.1) 0%, transparent 60%);
}
.sb-visual-icon { font-size: 80px; color: rgba(232,80,10,0.12); position: relative; z-index: 1; }
.sb-num {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 80px;
    color: rgba(255,255,255,0.04);
    line-height: 1;
    margin-bottom: -20px;
}
.sb-title { font-family: 'Bebas Neue', sans-serif; font-size: 46px; letter-spacing: 1px; color: #fff; margin-bottom: 16px; }
.sb-desc { font-size: 15px; line-height: 1.8; color: var(--muted); margin-bottom: 28px; }
.sb-features { list-style: none; }
.sb-features li {
    font-size: 14px;
    color: var(--text);
    padding: 8px 0;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    display: flex;
    align-items: center;
    gap: 10px;
}
.sb-features li::before { content: '▶'; color: var(--orange); font-size: 8px; }
@media (max-width: 900px) {
    .service-block { grid-template-columns: 1fr; }
    .service-block.reverse { direction: ltr; }
}
</style>
@endpush

@section('content')
<div class="page-hero">
    <div class="container">
        <div class="section-tag">What We Offer</div>
        <h1 class="section-title">Our<br>Services</h1>
        <p class="section-subtitle" style="margin-top:16px">Comprehensive construction and fabrication services delivered by experienced professionals.</p>
    </div>
</div>

<section class="services-detail">
    <div class="container">

        <div class="service-block">
            <div class="sb-visual"><i class="fas fa-drafting-compass sb-visual-icon"></i></div>
            <div>
                <div class="sb-num">01</div>
                <h2 class="sb-title">Structural Fabrication</h2>
                <p class="sb-desc">We fabricate a wide range of structural steel components with precision cutting, welding, and finishing. Our workshop is equipped with modern machinery ensuring quality at every step.</p>
                <ul class="sb-features">
                    <li>Structural steel beams, columns, and trusses</li>
                    <li>Industrial frameworks and mezzanine floors</li>
                    <li>Pressure vessels and storage tanks</li>
                    <li>Pipe fabrication and skid packages</li>
                    <li>Staircases, walkways, and platforms</li>
                </ul>
            </div>
        </div>

        <div class="service-block reverse">
            <div class="sb-visual"><i class="fas fa-industry sb-visual-icon"></i></div>
            <div>
                <div class="sb-num">02</div>
                <h2 class="sb-title">Steel Erection</h2>
                <p class="sb-desc">Our trained riggers and erectors safely and efficiently assemble steel structures on-site. We handle all types of erection work including heavy lifts using advanced machinery.</p>
                <ul class="sb-features">
                    <li>Industrial plant and factory erection</li>
                    <li>Warehouse and shed construction</li>
                    <li>Heavy equipment installation</li>
                    <li>Pipe rack and cable tray erection</li>
                    <li>Crane-assisted heavy lifts</li>
                </ul>
            </div>
        </div>

        <div class="service-block">
            <div class="sb-visual"><i class="fas fa-building sb-visual-icon"></i></div>
            <div>
                <div class="sb-num">03</div>
                <h2 class="sb-title">Industrial Construction</h2>
                <p class="sb-desc">Complete turnkey construction solutions for industrial clients. We manage everything from site preparation and civil works to final commissioning and handover.</p>
                <ul class="sb-features">
                    <li>Factory and plant construction</li>
                    <li>Civil foundation and RCC works</li>
                    <li>Electrical and instrumentation support</li>
                    <li>Project planning and management</li>
                    <li>Safety-compliant execution</li>
                </ul>
            </div>
        </div>

        <div class="service-block reverse">
            <div class="sb-visual"><i class="fas fa-tools sb-visual-icon"></i></div>
            <div>
                <div class="sb-num">04</div>
                <h2 class="sb-title">Plant Maintenance</h2>
                <p class="sb-desc">We provide annual maintenance contracts (AMC) and shutdown maintenance services to keep industrial plants running at peak performance with minimal downtime.</p>
                <ul class="sb-features">
                    <li>Annual maintenance contracts (AMC)</li>
                    <li>Shutdown and turnaround maintenance</li>
                    <li>Equipment repair and retrofitting</li>
                    <li>Structural repair and painting</li>
                    <li>Emergency breakdown services</li>
                </ul>
            </div>
        </div>

    </div>
</section>
@endsection