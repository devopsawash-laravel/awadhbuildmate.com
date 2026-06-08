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
                <h2 class="sb-title">Piping Fabrication and Erection</h2>
                <p class="sb-desc">We provide comprehensive industrial piping solutions, from high-precision fabrication to seamless on-site installation and erection. Equipped with advanced machinery and certified welders, we ensure absolute integrity, safety, and compliance with global engineering standards for all fluid and gas transport systems.</p>
                <ul class="sb-features">
                    <li>Process and Utility Piping Networks (Carbon Steel, Stainless Steel)s</li>
                    <li>Pre-Fabricated Pipe Spools and  Skid Packages</li>
                    <li>High-Pressure Piping and Cross-Country Pipelines</li>
                    <li>​On-Site Pipe Routing, Alignment, Support Installation, and Erection</li>
                    <li>S ​Hydrotesting, Non-Destructive  Testing (NDT), and Quality Assurance</li>
                </ul>
            </div>
        </div>

        <div class="service-block reverse">
            <div class="sb-visual"><i class="fas fa-industry sb-visual-icon"></i></div>
            <div>
                <div class="sb-num">02</div>
                <h2 class="sb-title">UG Piping works</h2>
                <p class="sb-desc">We deliver end-to-end underground (UG) piping solutions engineered to withstand subterranean pressure, soil corrosion, and environmental factors. From precise trenching and excavation to advanced anti-corrosive wrapping, laying, and backfilling, we ensure long-term durability and structural safety for critical sub-surface fluid networks.</p>
                <ul class="sb-features">
                    <li>Trenching, Excavation, and Bedding  Preparation</li>
                    <li>​Industrial Cooling Water, Firewater, and Effluent UG Networks</li>
                    <li>​Anti-Corrosion Protection (Coal Tar Tape Wrapping, 3LPE, and Cathodic Protection)</li>
                    <li>Jointing, Welding, and Holiday Testing for Coating Integrity</li>
                    <li>Hydrotesting, Backfilling, and Soil Compaction Compliance</li>
                </ul>
            </div>
        </div>

        <div class="service-block">
            <div class="sb-visual"><i class="fas fa-building sb-visual-icon"></i></div>
            <div>
                <div class="sb-num">03</div>
                <h2 class="sb-title">Structural Fabrication and Erection</h2>
                <p class="sb-desc">We specialize in heavy-duty structural steel fabrication and erection, delivering robust frameworks for complex industrial infrastructures. Combining precision workshop engineering with highly planned heavy-lifting and site assembly, we build durable, high-load structures that form the backbone of modern factories, warehouses, and process plants.</p>
                <ul class="sb-features">
                    <li>​Heavy Structural Steel Beams, Columns, Bracings, and Trusses</li>
                    <li>​Industrial Sheds, Warehouses, and Pre-Engineered Building (PEB) Frameworks</li>
                    <li>Pipe Racks, Cable Tray Supports, and Technological Structures</li>
                    <li>​Industrial Platforms, Walkways, Mezzanine Floors, and Safety Staircases</li>
                    <li>​Crane-Assisted Heavy Lifts, Rigging, and Safe On-Site Assembly</li>
                </ul>
            </div>
        </div>

        <div class="service-block reverse">
            <div class="sb-visual"><i class="fas fa-tools sb-visual-icon"></i></div>
            <div>
                <div class="sb-num">04</div>
                <h2 class="sb-title">Boiler Fabrication and Erection</h2>
                <p class="sb-desc">We offer expert engineering solutions for industrial boiler fabrication and on-site erection, ensuring high thermal efficiency and absolute operational safety. Adhering strictly to IBR (Indian Boiler Regulations) and global safety codes, our certified team handles everything from precision pressure part fabrication to complex field installation and commissioning.</p>
                <ul class="sb-features">
                    <li> ​Fabrication of Boiler Pressure Parts (Waterwalls, Superheaters, Economizers, and Coils)</li>
                    <li>Structural Framework, Boiler Casing, and Ducting Fabrication</li>
                    <li>On-Site Positioning, Alignment, Structural Support, and Boiler Erection</li>
                    <li>​High-Pressure Piping Integration and Header Interconnections</li>
                    <li>​Pre-Commissioning Hydrotests, NDT Inspections, and Regulatory (IBR) Approvals</li>
                </ul>
            </div>
        </div>

    </div>
</section>
@endsection