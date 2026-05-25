@extends('layouts.admin')
@section('title', 'Site Management')
@section('page-title', 'Site Management')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Site Management</div>
        <div class="page-subtitle">{{ $sites->count() }} sites — click any to view full details</div>
    </div>
    <a href="{{ route('sites.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Site
    </a>
</div>

@push('styles')
<style>
.sites-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 20px;
}

.site-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    display: block;
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    position: relative;
}

.site-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.1);
    border-color: var(--primary);
}

.site-card-top {
    padding: 22px 22px 0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.site-icon {
    width: 52px; height: 52px;
    background: #FFF0EA;
    border: 1px solid rgba(232,80,10,0.2);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.site-icon i { color: var(--primary); font-size: 22px; }

.site-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.site-status.active    { background: #ECFDF5; color: #065F46; }
.site-status.inactive  { background: #FFFBEB; color: #92400E; }
.site-status.completed { background: #F3F4F6; color: #374151; }

.site-status-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    animation: pulse-dot 2s infinite;
}

.active .site-status-dot    { background: #10B981; }
.inactive .site-status-dot  { background: #F59E0B; animation: none; }
.completed .site-status-dot { background: #9CA3AF; animation: none; }

@keyframes pulse-dot {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.4; }
}

.site-card-body { padding: 16px 22px; }

.site-name {
    font-size: 22px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 4px;
    letter-spacing: 0.3px;
}

.site-client {
    font-size: 12px;
    color: var(--primary);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 4px;
}

.site-location {
    font-size: 12px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 16px;
}

/* Progress bar */
.site-progress-wrap { margin-bottom: 18px; }

.site-progress-top {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: var(--text-muted);
    margin-bottom: 5px;
    font-weight: 500;
}

.site-progress-track {
    height: 5px;
    background: #F3F4F6;
    border-radius: 99px;
    overflow: hidden;
}

.site-progress-fill {
    height: 100%;
    border-radius: 99px;
    background: var(--primary);
    transition: width 1s ease;
}

/* Stats row */
.site-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0;
    border-top: 1px solid var(--border);
}

.site-stat {
    padding: 14px 0;
    text-align: center;
    border-right: 1px solid var(--border);
}

.site-stat:last-child { border-right: none; }

.ss-num {
    font-size: 22px;
    font-weight: 700;
    color: var(--text);
    line-height: 1;
}

.ss-label {
    font-size: 10px;
    color: var(--text-muted);
    margin-top: 3px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    font-weight: 600;
}

/* Hover arrow */
.site-arrow {
    position: absolute;
    bottom: 0; right: 0;
    padding: 10px 14px;
    background: var(--primary);
    color: #fff;
    font-size: 13px;
    opacity: 0;
    transform: translate(4px, 4px);
    transition: all 0.2s;
    border-radius: 10px 0 10px 0;
}

.site-card:hover .site-arrow {
    opacity: 1;
    transform: translate(0, 0);
}

/* Empty state */
.empty-sites {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
    color: var(--text-muted);
}

.empty-sites i { font-size: 48px; opacity: 0.2; margin-bottom: 16px; display: block; }
</style>
@endpush

<div class="sites-grid">

@forelse($sites as $site)

<a href="{{ route('sites.show', $site) }}" class="site-card">

    {{-- Card Top --}}
    <div class="site-card-top">

        {{-- Icon --}}
        <div class="site-icon">
            <i class="fas fa-map-marker-alt"></i>
        </div>

        {{-- Status --}}
        <div class="site-status {{ strtolower($site->status) }}">

            <span class="site-status-dot"></span>

            {{ ucfirst($site->status) }}

        </div>

    </div>

    {{-- Card Body --}}
    <div class="site-card-body">

        {{-- Client --}}
        <div class="site-client">

            {{ $site->client_name ?? 'Client' }}

        </div>

        {{-- Site Name --}}
        <div class="site-name">

            {{ $site->name }}

        </div>

        {{-- Location --}}
        <div class="site-location">

            <i class="fas fa-map-marker-alt"></i>

            {{ $site->location }}

        </div>

        {{-- Progress --}}
        <div class="site-progress-wrap">

            <div class="site-progress-top">

                <span>

                    <i class="fas fa-calendar-alt"></i>

                    {{ \Carbon\Carbon::parse($site->start_date)->format('M Y') }}

                </span>

                <span>

                    {{ $site->progress ?? 0 }}% time elapsed

                </span>

                <span>

                    {{ \Carbon\Carbon::parse($site->end_date)->format('M Y') }}

                </span>

            </div>

            <div class="site-progress-track">

                <div class="site-progress-fill"
                     style="width:{{ $site->progress ?? 0 }}%">
                </div>

            </div>

        </div>

    </div>

    {{-- Stats --}}
    <div class="site-stats">

        {{-- Projects --}}
        <div class="site-stat">

            <div class="ss-num">

                {{ $site->projects_count ?? 0 }}

            </div>

            <div class="ss-label">

                Projects

            </div>

        </div>

        {{-- Ongoing --}}
        <div class="site-stat">

            <div class="ss-num">

                {{ $site->ongoing_projects ?? 0 }}

            </div>

            <div class="ss-label">

                Ongoing

            </div>

        </div>

        {{-- Labours --}}
        <div class="site-stat">

            <div class="ss-num">

                {{ $site->labours_count ?? 0 }}

            </div>

            <div class="ss-label">

                Labours

            </div>

        </div>

    </div>

    {{-- Arrow --}}
    <div class="site-arrow">

        <i class="fas fa-arrow-right"></i>

    </div>

</a>

@empty

<div class="empty-sites">

    <i class="fas fa-map-marked-alt"></i>

    <h3>No Sites Found</h3>

    <p>
        Create your first site to start managing projects.
    </p>

</div>

@endforelse

</div>

    <div class="empty-sites">
        <i class="fas fa-map-marked-alt"></i>
        <p style="font-size:16px;font-weight:600;margin-bottom:8px">No sites added yet</p>
        <p style="font-size:13px;margin-bottom:20px">Add your first construction site to get started.</p>
        <a href="{{ route('sites.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add First Site</a>
    </div>
</div>

@endsection