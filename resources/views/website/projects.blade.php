@extends('layouts.public')
@section('title', 'Projects — Awadh Buildmate')

@push('styles')
<style>
.page-hero { padding: 160px 0 80px; background: var(--dark); position: relative; overflow: hidden; }
.page-hero::before { content: ''; position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 60px 60px; }
.projects-section { padding: 80px 0 120px; background: var(--black); }
.projects-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1px; background: var(--border); margin-top: 60px; }
.project-card {
    background: var(--dark);
    padding: 36px 28px;
    position: relative;
    overflow: hidden;
    transition: background 0.3s;
}
.project-card:hover { background: var(--dark2); }
.project-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 3px; height: 0;
    background: var(--orange);
    transition: height 0.3s;
}
.project-card:hover::before { height: 100%; }
.pc-category {
    font-family: 'Rajdhani', sans-serif;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--orange);
    margin-bottom: 12px;
}
.pc-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 24px;
    letter-spacing: 1px;
    color: #fff;
    margin-bottom: 10px;
}
.pc-client { font-size: 13px; color: var(--muted); margin-bottom: 20px; }
.pc-meta { display: flex; gap: 20px; }
.pc-meta-item { font-size: 12px; }
.pc-meta-label { color: var(--muted); font-family: 'Rajdhani', sans-serif; letter-spacing: 1px; text-transform: uppercase; font-size: 10px; }
.pc-meta-val { color: var(--text); font-weight: 500; margin-top: 2px; }
.pc-tag {
    display: inline-block;
    padding: 3px 10px;
    border: 1px solid rgba(232,80,10,0.3);
    color: var(--orange);
    font-size: 11px;
    font-family: 'Rajdhani', sans-serif;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-top: 20px;
}
@media (max-width: 900px) { .projects-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="page-hero">
    <div class="container">
        <div class="section-tag">Our Work</div>
        <h1 class="section-title">Featured<br>Projects</h1>
        <p class="section-subtitle" style="margin-top:16px">A selection of completed and Ongoing projects across cities demonstrating our capabilities and commitment to quality.</p>
    </div>
</div>

<section class="projects-section">
    <div class="container">
        <div class="projects-grid">
            @php
            $projects = [
                ['cat' => 'IBR Fabrication & Erection', 'title' => 'Asian Paints(L&T) – Lakhani Engineering and Organisation', 'client' => 'L&T, Dahej', 'year' => '2025-26', 'value' => '₹6.3 Cr', 'tag' => 'Ongoing'],
                ['cat' => 'Structure', 'title' => 'Adani Power Limited(FabTech)', 'client' => 'Mundra', 'year' => '2026', 'value' => '₹1.2 Cr', 'tag' => 'Ongoing'],
                ['cat' => 'Piping Erection', 'title' => 'GNFC Chemical Plant AMC', 'client' => 'Mundra', 'year' => '2026', 'value' => '-', 'tag' => 'Ongoing'],
                // ['cat' => 'Steel Erection', 'title' => 'Reliance Industries Warehouse', 'client' => 'Reliance, Dahej', 'year' => '2022', 'value' => '₹2.1 Cr', 'tag' => 'Completed'],
                // ['cat' => 'Fabrication', 'title' => 'IOCL Storage Tank Farm', 'client' => 'IOCL, Vadodara', 'year' => '2023', 'value' => '₹3.5 Cr', 'tag' => 'Completed'],
                // ['cat' => 'Industrial Construction', 'title' => 'Adani Adani Power Limited(FabTech)peline Project', 'client' => 'BPCL, Rajkot', 'year' => '2023', 'value' => '₹1.8 Cr', 'tag' => 'Completed'],
                // ['cat' => 'Structural Fabrication', 'title' => 'Torrent Power Substation', 'client' => 'Torrent, Ahmedabad', 'year' => '2022', 'value' => '₹2.6 Cr', 'tag' => 'Completed'],
                // ['cat' => 'Erection', 'title' => 'GSFC Fertilizer Plant', 'client' => 'GSFC, Vadodara', 'year' => '2024', 'value' => '₹5.1 Cr', 'tag' => 'Ongoing'],
            ];
            @endphp

            @foreach($projects as $p)
            <div class="project-card">
                <div class="pc-category">{{ $p['cat'] }}</div>
                <div class="pc-title">{{ $p['title'] }}</div>
                <div class="pc-client"><i class="fas fa-building" style="color:var(--orange);margin-right:6px;font-size:11px"></i>{{ $p['client'] }}</div>
                <div class="pc-meta">
                    <div class="pc-meta-item">
                        <div class="pc-meta-label">Year</div>
                        <div class="pc-meta-val">{{ $p['year'] }}</div>
                    </div>
                    <div class="pc-meta-item">
                        <div class="pc-meta-label">Value</div>
                        <div class="pc-meta-val">{{ $p['value'] }}</div>
                    </div>
                </div>
                <div class="pc-tag">{{ $p['tag'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection