@extends('layouts.admin')
@section('title', $site->name . ' Site')
@section('page-title', $site->name . ' — Site Dashboard')

@push('styles')
<style>
/* ── HEADER BANNER ─────────────────────────────────────────────── */
.site-header {
    background: linear-gradient(135deg, #111827 0%, #1F2937 100%);
    border: 1px solid #374151;
    border-radius: 10px;
    padding: 28px;
    margin-bottom: 22px;
    position: relative;
    overflow: hidden;
}

.site-header::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 240px; height: 240px;
    background: radial-gradient(circle, rgba(232,80,10,0.15) 0%, transparent 70%);
}

.sh-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 22px;
}

.sh-left {}

.sh-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(232,80,10,0.15);
    border: 1px solid rgba(232,80,10,0.3);
    color: #F97316;
    padding: 4px 12px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.sh-name {
    font-size: 34px;
    font-weight: 800;
    color: #fff;
    letter-spacing: 0.5px;
    line-height: 1;
    margin-bottom: 6px;
}

.sh-meta {
    font-size: 13px;
    color: #9CA3AF;
    display: flex;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
}

.sh-meta-item { display: flex; align-items: center; gap: 6px; }
.sh-meta-item i { color: #E8500A; font-size: 12px; }

.sh-actions { display: flex; gap: 8px; flex-shrink: 0; }

/* Status badge */
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
}

.status-pill.active    { background: rgba(16,185,129,0.15); color: #34D399; border: 1px solid rgba(16,185,129,0.3); }
.status-pill.inactive  { background: rgba(245,158,11,0.15); color: #FCD34D; border: 1px solid rgba(245,158,11,0.3); }
.status-pill.completed { background: rgba(107,114,128,0.15); color: #9CA3AF; border: 1px solid rgba(107,114,128,0.3); }

.pulse { animation: p 1.5s infinite; }
@keyframes p { 0%,100%{opacity:1} 50%{opacity:0.3} }

/* Timeline bar */
.sh-timeline {
    background: rgba(255,255,255,0.05);
    border-radius: 6px;
    padding: 14px 18px;
}

.sh-tl-top {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: #6B7280;
    margin-bottom: 8px;
}

.sh-tl-track {
    height: 6px;
    background: rgba(255,255,255,0.08);
    border-radius: 99px;
    overflow: hidden;
}

.sh-tl-fill {
    height: 100%;
    border-radius: 99px;
    background: linear-gradient(90deg, #E8500A, #F97316);
}

.sh-tl-bottom {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: #4B5563;
    margin-top: 6px;
}

/* ── STATS ROW ─────────────────────────────────────────────────── */
.site-stats-row {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
    margin-bottom: 22px;
}

.site-stat-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 18px 16px;
    position: relative;
    overflow: hidden;
}

.site-stat-card::before {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 3px; height: 40%;
    background: var(--sc-color, var(--primary));
    border-radius: 0 2px 2px 0;
}

.ssc-icon {
    width: 36px; height: 36px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 12px;
    font-size: 16px;
}

.ssc-val { font-size: 26px; font-weight: 700; line-height: 1; color: var(--text); }
.ssc-lbl { font-size: 11px; color: var(--text-muted); margin-top: 4px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; }

/* ── TWO COL ───────────────────────────────────────────────────── */
.two-col { display: grid; grid-template-columns: 1.5fr 1fr; gap: 18px; margin-bottom: 18px; }
.one-col { margin-bottom: 18px; }

/* ── PROJECTS ──────────────────────────────────────────────────── */
.project-row {
    padding: 16px 18px;
    border-bottom: 1px solid var(--border);
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 16px;
    align-items: center;
    transition: background 0.15s;
}

.project-row:hover { background: #FAFBFC; }
.project-row:last-child { border-bottom: none; }

.pr-left {}
.pr-type {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--primary);
    margin-bottom: 3px;
}
.pr-name { font-size: 14px; font-weight: 600; color: var(--text); margin-bottom: 6px; }
.pr-code { font-size: 11px; color: var(--text-muted); font-family: monospace; }

.pr-progress-wrap { margin-top: 8px; }
.pr-progress-track { height: 4px; background: #F3F4F6; border-radius: 99px; overflow: hidden; margin-bottom: 3px; }
.pr-progress-fill  { height: 100%; border-radius: 99px; }
.pr-progress-label { font-size: 11px; color: var(--text-muted); }

.pr-right { text-align: right; }
.pr-status {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    margin-bottom: 8px;
}
.pr-value { font-size: 13px; font-weight: 600; color: var(--text); }
.pr-value span { font-size: 11px; color: var(--text-muted); font-weight: 400; }

/* ── LABOUR TABLE ──────────────────────────────────────────────── */
.labour-mini-table { font-size: 13px; }

/* ── ATTENDANCE CHART ──────────────────────────────────────────── */
.att-chart {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    height: 80px;
    padding: 0 4px;
}

.att-bar-group {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
}

.att-bar-wrap {
    flex: 1;
    width: 100%;
    display: flex;
    align-items: flex-end;
    gap: 2px;
    justify-content: center;
}

.att-bar {
    width: 10px;
    border-radius: 2px 2px 0 0;
    transition: height 0.6s ease;
    min-height: 2px;
}

.att-bar.present { background: #10B981; }
.att-bar.absent  { background: #FEE2E2; }

.att-bar-label { font-size: 10px; color: var(--text-muted); }

/* ── CATEGORY PILLS ────────────────────────────────────────────── */
.cat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

.cat-item {
    background: var(--bg);
    border-radius: 8px;
    padding: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.ci-label { font-size: 12px; font-weight: 600; color: var(--text); }
.ci-count { font-size: 20px; font-weight: 700; }

/* ── ADD PROJECT FORM ──────────────────────────────────────────── */
.add-project-form {
    background: #FFFBEB;
    border: 1px dashed #F59E0B;
    border-radius: 8px;
    padding: 18px;
    margin-top: 12px;
    display: none;
}

.add-project-form.open { display: block; }

@media (max-width: 1100px) {
    .site-stats-row { grid-template-columns: repeat(3, 1fr); }
    .two-col { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

{{-- ── SITE HEADER BANNER ────────────────────────────────────── --}}
<div class="site-header">
    <div class="sh-top">
        <div class="sh-left">
            <div class="sh-badge"><i class="fas fa-map-marker-alt"></i> Construction Site</div>
            <div class="sh-name">{{ $site->name }}</div>
            <div class="sh-meta">
                <span class="sh-meta-item"><i class="fas fa-building"></i> {{ $site->client ?? 'Client TBD' }}</span>
                <span class="sh-meta-item"><i class="fas fa-map-pin"></i> {{ $site->location }}</span>
                @if($site->site_incharge)
                <span class="sh-meta-item"><i class="fas fa-user-tie"></i> {{ $site->site_incharge }}
                    @if($site->incharge_phone)
                        &nbsp;·&nbsp; <i class="fas fa-phone"></i> {{ $site->incharge_phone }}
                    @endif
                </span>
                @endif
            </div>
        </div>
        <div class="sh-actions">
            <span class="status-pill {{ $site->status }}">
                <span style="width:7px;height:7px;border-radius:50%;background:currentColor" {{ $site->status === 'active' ? 'class=pulse' : '' }}></span>
                {{ $site->getStatusLabel() }}
            </span>
            <a href="{{ route('admin.sites.edit', $site) }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-edit"></i> Edit Site
            </a>
            <a href="{{ route('admin.sites.index') }}" class="btn btn-sm btn-outline">
                <i class="fas fa-arrow-left"></i> All Sites
            </a>
        </div>
    </div>

    @if($site->start_date && $site->expected_end_date)
    <div class="sh-timeline">
        <div class="sh-tl-top">
            <span><i class="fas fa-play-circle"></i> Started: {{ $site->start_date->format('d M Y') }}</span>
            <span style="color:#fff;font-weight:600">{{ $site->getProgressPercent() }}% timeline elapsed</span>
            <span><i class="fas fa-flag-checkered"></i> Deadline: {{ $site->expected_end_date->format('d M Y') }}</span>
        </div>
        <div class="sh-tl-track">
            <div class="sh-tl-fill" style="width:{{ $site->getProgressPercent() }}%"></div>
        </div>
        <div class="sh-tl-bottom">
            <span>{{ $site->getDaysRunning() }} days running</span>
            <span>{{ $site->getDaysRemaining() ?? '—' }} days remaining</span>
        </div>
    </div>
    @endif
</div>

{{-- ── STATS ROW ─────────────────────────────────────────────── --}}
<div class="site-stats-row">
    <div class="site-stat-card" style="--sc-color:#3B82F6">
        <div class="ssc-icon" style="background:#EFF6FF;color:#3B82F6"><i class="fas fa-project-diagram"></i></div>
        <div class="ssc-val">{{ $projects->count() }}</div>
        <div class="ssc-lbl">Total Projects</div>
    </div>
    <div class="site-stat-card" style="--sc-color:#10B981">
        <div class="ssc-icon" style="background:#ECFDF5;color:#10B981"><i class="fas fa-spinner"></i></div>
        <div class="ssc-val">{{ $ongoingCount }}</div>
        <div class="ssc-lbl">Ongoing</div>
    </div>
    <div class="site-stat-card" style="--sc-color:#E8500A">
        <div class="ssc-icon" style="background:#FFF0EA;color:#E8500A"><i class="fas fa-users"></i></div>
        <div class="ssc-val">{{ $totalLabours }}</div>
        <div class="ssc-lbl">Active Labours</div>
    </div>
    <div class="site-stat-card" style="--sc-color:#10B981">
        <div class="ssc-icon" style="background:#ECFDF5;color:#10B981"><i class="fas fa-user-check"></i></div>
        <div class="ssc-val">{{ $todayPresent }}</div>
        <div class="ssc-lbl">Present Today</div>
    </div>
    <div class="site-stat-card" style="--sc-color:#8B5CF6">
        <div class="ssc-icon" style="background:#F5F3FF;color:#8B5CF6"><i class="fas fa-rupee-sign"></i></div>
        <div class="ssc-val" style="font-size:20px">₹{{ number_format($monthlySalaryCost, 0) }}</div>
        <div class="ssc-lbl">This Month Cost</div>
    </div>
</div>

{{-- ── MAIN TWO-COL GRID ─────────────────────────────────────── --}}
<div class="two-col">

    {{-- LEFT: Projects list --}}
    <div>
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-project-diagram" style="color:var(--primary)"></i>&nbsp; Projects on this Site</span>
                <button onclick="document.getElementById('add-project-form').classList.toggle('open')" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Add Project
                </button>
            </div>

            {{-- Add project inline form --}}
            <div id="add-project-form" class="add-project-form">
                <form method="POST" action="{{ route('admin.sites.projects.store', $site) }}">
                    @csrf
                    <div class="form-grid-3" style="margin-bottom:12px">
                        <div class="form-group" style="margin:0">
                            <label>Project Name *</label>
                            <input type="text" name="name" required placeholder="e.g. Pipe Rack Fab">
                        </div>
                        <div class="form-group" style="margin:0">
                            <label>Project Code</label>
                            <input type="text" name="project_code" placeholder="e.g. DHJ-004">
                        </div>
                        <div class="form-group" style="margin:0">
                            <label>Type *</label>
                            <select name="type" required>
                                @foreach(['Fabrication','Erection','Civil','Structural','Maintenance','Other'] as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-grid-3" style="margin-bottom:12px">
                        <div class="form-group" style="margin:0">
                            <label>Status *</label>
                            <select name="status" required>
                                <option value="planning">Planning</option>
                                <option value="ongoing" selected>Ongoing</option>
                                <option value="on_hold">On Hold</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin:0">
                            <label>Contract Value (₹)</label>
                            <input type="number" name="contract_value" placeholder="e.g. 5000000" min="0" step="1000">
                        </div>
                        <div class="form-group" style="margin:0">
                            <label>Progress %</label>
                            <input type="number" name="progress_percent" value="0" min="0" max="100">
                        </div>
                    </div>
                    <div class="form-grid-2" style="margin-bottom:12px">
                        <div class="form-group" style="margin:0">
                            <label>Start Date</label>
                            <input type="date" name="start_date">
                        </div>
                        <div class="form-group" style="margin:0">
                            <label>Expected End</label>
                            <input type="date" name="expected_end_date">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:12px">
                        <label>Description</label>
                        <textarea name="description" rows="2" placeholder="Brief project description..."></textarea>
                    </div>
                    <div style="display:flex;gap:8px">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Project</button>
                        <button type="button" onclick="document.getElementById('add-project-form').classList.remove('open')" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>

            @if($projects->isEmpty())
                <div class="empty-state"><i class="fas fa-project-diagram"></i><p>No projects added yet</p></div>
            @else
                @foreach($projects as $project)
                @php
                    $statusColors = ['ongoing'=>'#ECFDF5,#065F46', 'planning'=>'#EFF6FF,#1E40AF', 'on_hold'=>'#FFFBEB,#92400E', 'completed'=>'#F3F4F6,#374151'];
                    [$bg, $fg] = explode(',', $statusColors[$project->status] ?? '#F3F4F6,#374151');
                    $barColors  = ['ongoing'=>'#10B981', 'planning'=>'#3B82F6', 'on_hold'=>'#F59E0B', 'completed'=>'#9CA3AF'];
                    $barColor   = $barColors[$project->status] ?? '#9CA3AF';
                @endphp
                <div class="project-row">
                    <div class="pr-left">
                        <div class="pr-type"><i class="fas {{ $project->getTypeIcon() }}" style="margin-right:4px"></i>{{ $project->type }}</div>
                        <div class="pr-name">{{ $project->name }}</div>
                        @if($project->project_code)
                        <div class="pr-code">{{ $project->project_code }}</div>
                        @endif
                        <div class="pr-progress-wrap">
                            <div class="pr-progress-track">
                                <div class="pr-progress-fill" style="width:{{ $project->progress_percent }}%;background:{{ $barColor }}"></div>
                            </div>
                            <div class="pr-progress-label">{{ $project->progress_percent }}% complete</div>
                        </div>
                    </div>
                    <div class="pr-right">
                        <div>
                            <span class="pr-status" style="background:{{ $bg }};color:{{ $fg }}">{{ $project->getStatusLabel() }}</span>
                        </div>
                        @if($project->contract_value)
                        <div class="pr-value">₹{{ number_format($project->contract_value, 0) }}<br><span>Contract Value</span></div>
                        @endif
                        @if($project->expected_end_date)
                        <div style="font-size:11px;color:var(--text-muted);margin-top:6px">
                            <i class="fas fa-clock"></i> {{ $project->expected_end_date->format('d M Y') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')" style="margin-top:6px">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- RIGHT: Labour + Attendance --}}
    <div>

        {{-- Labour Category Breakdown --}}
        <div class="card mb-4">
            <div class="card-header">
                <span><i class="fas fa-users" style="color:var(--primary)"></i>&nbsp; Labour by Category</span>
                <span style="font-size:13px;color:var(--text-muted)">{{ $totalLabours }} total</span>
            </div>
            <div class="card-body">
                <div class="cat-grid">
                    @foreach(['Welder' => ['#FFF0EA','#C2400A'], 'Fitter' => ['#EFF6FF','#1D4ED8'], 'Helper' => ['#ECFDF5','#065F46'], 'Rigger' => ['#FDF4FF','#7E22CE']] as $cat => [$bg, $fg])
                    @php $count = $categoryBreak[$cat] ?? 0; @endphp
                    <div class="cat-item" style="border-left:3px solid {{ $fg }}">
                        <div>
                            <div class="ci-label">{{ $cat }}</div>
                            <div style="font-size:11px;color:var(--text-muted)">{{ $totalLabours > 0 ? round(($count/$totalLabours)*100) : 0 }}% of site</div>
                        </div>
                        <div class="ci-count" style="color:{{ $fg }}">{{ $count }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Today's Attendance --}}
        <div class="card mb-4">
            <div class="card-header">
                <span><i class="fas fa-calendar-check" style="color:var(--primary)"></i>&nbsp; Today's Attendance</span>
                <span style="font-size:11px;color:var(--text-muted)">{{ now()->format('d M Y') }}</span>
            </div>
            <div class="card-body">
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:16px">
                    <div style="text-align:center;background:#ECFDF5;border-radius:8px;padding:12px">
                        <div style="font-size:26px;font-weight:700;color:#10B981">{{ $todayPresent }}</div>
                        <div style="font-size:11px;color:#065F46;font-weight:600">Present</div>
                    </div>
                    <div style="text-align:center;background:#FEF2F2;border-radius:8px;padding:12px">
                        <div style="font-size:26px;font-weight:700;color:#EF4444">{{ $todayAbsent }}</div>
                        <div style="font-size:11px;color:#991B1B;font-weight:600">Absent</div>
                    </div>
                    <div style="text-align:center;background:#FFFBEB;border-radius:8px;padding:12px">
                        <div style="font-size:26px;font-weight:700;color:#F59E0B">{{ $todayHalf }}</div>
                        <div style="font-size:11px;color:#92400E;font-weight:600">Half Day</div>
                    </div>
                </div>

                {{-- 7-day trend --}}
                <div style="font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:10px">Last 7 Days Trend</div>
                @php $maxPresent = max(1, $last7Days->max('present')); @endphp
                <div class="att-chart">
                    @foreach($last7Days as $day)
                    <div class="att-bar-group">
                        <div class="att-bar-wrap">
                            <div class="att-bar present" style="height:{{ round(($day['present']/$maxPresent)*60) + 4 }}px" title="{{ $day['present'] }} present"></div>
                            <div class="att-bar absent"  style="height:{{ $day['absent'] > 0 ? round(($day['absent']/$maxPresent)*60) + 2 : 2 }}px" title="{{ $day['absent'] }} absent"></div>
                        </div>
                        <div class="att-bar-label">{{ $day['date'] }}</div>
                    </div>
                    @endforeach
                </div>
                <div style="display:flex;gap:14px;margin-top:10px;font-size:11px;">
                    <span style="display:flex;align-items:center;gap:5px;color:var(--text-muted)">
                        <span style="width:10px;height:10px;background:#10B981;border-radius:2px;display:inline-block"></span> Present
                    </span>
                    <span style="display:flex;align-items:center;gap:5px;color:var(--text-muted)">
                        <span style="width:10px;height:10px;background:#FEE2E2;border-radius:2px;display:inline-block"></span> Absent
                    </span>
                </div>
            </div>
        </div>

        {{-- Monthly Summary --}}
        <div class="card">
            <div class="card-header">
                <span><i class="fas fa-chart-bar" style="color:var(--primary)"></i>&nbsp; {{ now()->format('F Y') }} Summary</span>
            </div>
            <div class="card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div style="background:var(--bg);border-radius:8px;padding:14px">
                        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:1px">Man-Days</div>
                        <div style="font-size:22px;font-weight:700">{{ $monthlyPresent }}</div>
                    </div>
                    <div style="background:var(--bg);border-radius:8px;padding:14px">
                        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:1px">OT Hours</div>
                        <div style="font-size:22px;font-weight:700;color:var(--info)">{{ $monthlyOTHours }}</div>
                    </div>
                    <div style="background:var(--bg);border-radius:8px;padding:14px;grid-column:1/-1">
                        <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:1px">Salary Cost</div>
                        <div style="font-size:22px;font-weight:700;color:var(--success)">₹{{ number_format($monthlySalaryCost, 0) }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ── LABOUR TABLE ──────────────────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <span><i class="fas fa-id-badge" style="color:var(--primary)"></i>&nbsp; Labours on this Site</span>
        <a href="{{ route('admin.labours.index', ['site_id' => $site->id]) }}" class="btn btn-sm btn-outline">
            <i class="fas fa-external-link-alt"></i> Full Labour Registry
        </a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Daily Wage</th>
                    <th>OT Rate</th>
                    <th>Joining Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($labours as $labour)
                <tr>
                    <td>
                        <a href="{{ route('admin.labours.show', $labour) }}" style="font-weight:600;color:var(--primary);text-decoration:none">
                            {{ $labour->name }}
                        </a>
                    </td>
                    <td><span style="font-family:monospace;font-size:12px;color:var(--text-muted)">{{ $labour->employee_id }}</span></td>
                    <td><span class="badge badge-{{ strtolower($labour->category) }}">{{ $labour->category }}</span></td>
                    <td>₹{{ number_format($labour->daily_wage, 0) }}</td>
                    <td>₹{{ number_format($labour->overtime_rate, 0) }}/hr</td>
                    <td>{{ $labour->joining_date->format('d M Y') }}</td>
                    <td><span class="badge {{ $labour->status === 'active' ? 'badge-success' : 'badge-danger' }}">{{ ucfirst($labour->status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state"><i class="fas fa-users"></i><p>No labours assigned to this site yet</p></div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection