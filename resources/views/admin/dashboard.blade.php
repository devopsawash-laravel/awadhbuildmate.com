@extends('layouts.app')
{{-- @extends('layouts.admin') --}}
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@if(session('success'))
    <div id="success-alert" class="alert alert-success">
        {{ session('success') }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const alertBox = document.getElementById('success-alert');

            setTimeout(() => {
                alertBox.style.transition = 'all 0.5s ease';
                alertBox.style.opacity = '0';
                alertBox.style.transform = 'translateY(-10px)';

                setTimeout(() => {
                    alertBox.remove();
                }, 500);

            }, 3000);

        });
    </script>
@endif
<div class="card">
    <div class="card-header">
        <span><i class="fas fa-bolt" style="color:var(--primary)"></i>&nbsp; Quick Actions</span>
    </div>
    <div class="card-body" style="display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('labours.create') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Add Labour</a>
        <a href="{{ route('attendance.index') }}" class="btn btn-success"><i class="fas fa-calendar-check"></i> Mark Attendance</a>
        <a href="{{ route('salary.index') }}" class="btn btn-secondary"><i class="fas fa-file-invoice-dollar"></i> Salary Slips</a>
        <a href="{{ route('attendance.monthly') }}" class="btn btn-outline"><i class="fas fa-calendar-alt"></i> Monthly Report</a>
        <a href="{{ route('admin.enquiries') }}" class="btn btn-outline"><i class="fas fa-envelope"></i> View Enquiries</a>
        {{-- <a href="{{ route('admin.logout') }}" class="btn btn-outline"><i class="fas fa-sign-out-alt"></i> Logout</a> --}}
        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-outline">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</div>
{{-- <a href="{{ route('salary.index', ['month' => $salary->month, 'year' => $salary->year]) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a> --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-hard-hat"></i></div>
        <div><div class="stat-value">{{ $totalLabours }}</div><div class="stat-label">Active Labours</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
        <div><div class="stat-value">{{ $presentToday }}</div><div class="stat-label">Present Today</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-user-times"></i></div>
        <div><div class="stat-value">{{ $absentToday }}</div><div class="stat-label">Absent Today</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow"><i class="fas fa-hand-holding-usd"></i></div>
        <div><div class="stat-value">₹{{ number_format($pendingAdvances, 0) }}</div><div class="stat-label">Pending Advances</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-envelope"></i></div>
        {{-- <div><div class="stat-value">{{ $newEnquiries }}</div><div class="stat-label">New Enquiries</div></div> --}}
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px;">
    <div class="card">
        <div class="card-header">
            <span><i class="fas fa-chart-bar" style="color:var(--primary)"></i>&nbsp; Labour by Category</span>
        </div>
        <div class="card-body">
            @foreach(['Welder','Fitter','Helper','Rigger'] as $cat)
            @php $count = $categoryStats[$cat] ?? 0; @endphp
            <div style="margin-bottom:12px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:4px;font-size:12px;font-weight:600;">
                    <span>{{ $cat }}</span><span>{{ $count }}</span>
                </div>
                <div style="background:#f6f4f364;border-radius:99px;height:6px;overflow:hidden;">
                    <div style="height:100%;border-radius:99px;background:var(--primary);width:{{ $totalLabours > 0 ? ($count/$totalLabours)*100 : 0 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span><i class="fas fa-envelope-open-text" style="color:var(--primary)"></i>&nbsp; Recent Enquiries</span>
            {{-- <a href="{{ route('admin.enquiries') }}" class="btn btn-sm btn-outline">View All</a> --}}
        </div>
        {{-- @if($recentEnquiries->isEmpty())
            <div class="empty-state"><i class="fas fa-inbox"></i><p>No enquiries yet</p></div>
        @else --}}
        <div class="table-wrapper">
            <table>
                <thead><tr><th>Name</th><th>Service</th><th>Date</th></tr></thead>
                <tbody>
                {{-- @foreach($recentEnquiries as $enq)
                <tr>
                    <td><strong>{{ $enq->name }}</strong><br><small class="text-muted">{{ $enq->company }}</small></td>
                    <td><span class="badge badge-info" style="font-size:10px">{{ Str::limit($enq->service_type, 18) }}</span></td>
                    <td style="font-size:11px;color:var(--text-muted)">{{ $enq->created_at->format('d M') }}</td>
                </tr>
                @endforeach --}}
                </tbody>
            </table>
        </div>
        {{-- @endif --}}
    </div>
</div>


@endsection
