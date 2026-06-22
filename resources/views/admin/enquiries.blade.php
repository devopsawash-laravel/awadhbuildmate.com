@extends('layouts.app')

@section('title', 'Enquiries')
@section('page-title', 'Website Enquiries')

@section('content')

<style>
    .enq-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    .enq-page-header h1 {
        font-size: 20px;
        font-weight: 500;
        color: var(--text-primary);
        margin: 0;
    }
    .enq-page-header p {
        font-size: 13px;
        color: var(--text-muted);
        margin: 3px 0 0;
    }

    /* ── Stat cards ── */
    .enq-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 1.25rem;
    }
    .enq-stat {
        background: var(--bg-secondary, #f7f7f5);
        border-radius: 8px;
        padding: 12px 16px;
    }
    .enq-stat-val {
        font-size: 24px;
        font-weight: 500;
        color: var(--text-primary);
        line-height: 1;
    }
    .enq-stat-lbl {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 4px;
    }

    /* ── Card / table ── */
    .enq-card {
        background: var(--card-bg, #fff);
        border: 0.5px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
    }
    .enq-table-wrap {
        overflow-x: auto;
    }
    .enq-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        table-layout: fixed;
    }
    .enq-table colgroup col:nth-child(1) { width: 46px; }
    .enq-table colgroup col:nth-child(2) { width: 175px; }
    .enq-table colgroup col:nth-child(3) { width: 120px; }
    .enq-table colgroup col:nth-child(4) { width: 120px; }
    .enq-table colgroup col:nth-child(5) { width: 125px; }
    .enq-table colgroup col:nth-child(6) { width: 200px; }
    .enq-table colgroup col:nth-child(7) { width: 130px; }
    .enq-table colgroup col:nth-child(8) { width: 76px; }
    .enq-table colgroup col:nth-child(9) { width: 52px; }

    .enq-table thead th {
        padding: 10px 14px;
        text-align: left;
        font-size: 11px;
        font-weight: 500;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 0.5px solid var(--border);
        background: var(--bg-secondary, #f7f7f5);
        white-space: nowrap;
    }
    .enq-table tbody td {
        padding: 11px 14px;
        border-bottom: 0.5px solid var(--border);
        color: var(--text-primary);
        vertical-align: middle;
    }
    .enq-table tbody tr:last-child td {
        border-bottom: none;
    }
    .enq-table tbody tr:hover td {
        background: var(--bg-secondary, #f7f7f5);
    }

    /* ── Avatar + name cell ── */
    .enq-name-cell {
        display: flex;
        align-items: center;
        gap: 9px;
    }
    .enq-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 500;
        flex-shrink: 0;
        background: #EEEDFE;
        color: #3C3489;
    }
    .enq-name {
        font-weight: 500;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .enq-email {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ── Badges ── */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 9px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
    }
    .badge-new     { background: #FAEEDA; color: #633806; }
    .badge-read    { background: #EAF3DE; color: #27500A; }
    .badge-service { background: #EEEDFE; color: #3C3489; }

    /* ── Message preview ── */
    .enq-msg {
        font-size: 12px;
        color: var(--text-muted);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* ── Action button ── */
    .enq-btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 6px;
        border: 0.5px solid var(--border);
        background: transparent;
        cursor: pointer;
        color: var(--text-muted);
        padding: 0;
        transition: background 0.15s;
    }
    .enq-btn-icon:hover {
        background: var(--bg-secondary, #f7f7f5);
    }

    /* ── Empty state ── */
    .enq-empty {
        padding: 48px 24px;
        text-align: center;
        color: var(--text-muted);
    }
    .enq-empty i {
        font-size: 32px;
        display: block;
        margin-bottom: 10px;
        opacity: 0.4;
    }
    .enq-empty p {
        font-size: 14px;
    }

    /* ── Pagination bar ── */
    .enq-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 16px;
        border-top: 0.5px solid var(--border);
    }
    .enq-pagination-info {
        font-size: 12px;
        color: var(--text-muted);
    }

    /* ── Export button ── */
    .enq-export-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0 14px;
        height: 34px;
        border-radius: 8px;
        border: 0.5px solid var(--border);
        background: transparent;
        cursor: pointer;
        font-size: 13px;
        color: var(--text-primary);
        text-decoration: none;
        transition: background 0.15s;
    }
    .enq-export-btn:hover {
        background: var(--bg-secondary, #f7f7f5);
    }

    @media (max-width: 640px) {
        .enq-stats { grid-template-columns: 1fr 1fr; }
        .enq-stats .enq-stat:last-child { grid-column: span 2; }
    }

    .badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 9px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 500;
    white-space: nowrap;
    max-width: 100%;
}

.badge-service {
    background: #EEEDFE;
    color: #3C3489;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block;   /* override inline-flex so ellipsis works */
}

.enq-table tbody td {
    padding: 11px 14px;
    border-bottom: 0.5px solid var(--border);
    color: var(--text-primary);
    vertical-align: middle;
    overflow: hidden;
}
</style>

{{-- Page header --}}
<div class="enq-page-header">
    <div>
        <h1>Enquiries</h1>
        <p>Contact form submissions from the website</p>
    </div>
    <a href="{{ '#' }}" class="enq-export-btn">
        <i class="fas fa-download" style="font-size:12px"></i> Export
    </a>
</div>

{{-- Summary stat cards --}}
<div class="enq-stats">
    <div class="enq-stat">
        <div class="enq-stat-val">{{ $enquiries->total() }}</div>
        <div class="enq-stat-lbl">Total enquiries</div>
    </div>
    <div class="enq-stat">
        <div class="enq-stat-val">{{ $unreadCount ?? $enquiries->where('is_read', false)->count() }}</div>
        <div class="enq-stat-lbl"><span class="badge badge-new" style="font-size:10px;padding:2px 7px">New</span> unread</div>
    </div>
    <div class="enq-stat">
        <div class="enq-stat-val">{{ $readCount ?? $enquiries->where('is_read', true)->count() }}</div>
        <div class="enq-stat-lbl">Responded</div>
    </div>
</div>

{{-- Main table card --}}
<div class="enq-card">
    <div class="enq-table-wrap">
        <table class="enq-table">
            <colgroup>
                <col><col><col><col><col><col><col><col><col>
            </colgroup>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Phone</th>
                    <th>Service</th>
                    <th>Message</th>
                    <th>Received</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($enquiries as $enq)
                @php
                    $initials = collect(explode(' ', $enq->name))
                        ->take(2)
                        ->map(fn($w) => strtoupper($w[0] ?? ''))
                        ->implode('');

                    $avatarPalette = [
                        ['bg' => '#EEEDFE', 'color' => '#3C3489'],
                        ['bg' => '#E1F5EE', 'color' => '#085041'],
                        ['bg' => '#FBEAF0', 'color' => '#72243E'],
                        ['bg' => '#FAEEDA', 'color' => '#633806'],
                        ['bg' => '#E6F1FB', 'color' => '#0C447C'],
                    ];
                    $avatarStyle = $avatarPalette[$enq->id % count($avatarPalette)];
                @endphp
                <tr>
                    <td style="color:var(--text-muted);font-size:11px">{{ $enq->id }}</td>

                    <td>
                        <div class="enq-name-cell">
                            <div class="enq-avatar"
                                 style="background:{{ $avatarStyle['bg'] }};color:{{ $avatarStyle['color'] }}">
                                {{ $initials }}
                            </div>
                            <div style="min-width:0">
                                <div class="enq-name">{{ $enq->name }}</div>
                                <div class="enq-email">{{ $enq->email }}</div>
                            </div>
                        </div>
                    </td>

                    <td style="font-size:13px">{{ $enq->company ?? '—' }}</td>

                    <td>
                        <a href="tel:{{ $enq->phone }}"
                           style="color:var(--primary);text-decoration:none;font-size:12px">
                            {{ $enq->phone }}
                        </a>
                    </td>

                    <td><span class="badge badge-service">{{ $enq->service_type }}</span></td>

                    <td>
                        <div class="enq-msg" title="{{ $enq->message }}">
                            {{ Str::limit($enq->message, 65) }}
                        </div>
                    </td>

                    <td style="font-size:11px;color:var(--text-muted);white-space:nowrap">
                        {{ $enq->created_at->format('d M Y, h:i A') }}
                    </td>

                    <td>
                        @if($enq->is_read)
                            <span class="badge badge-read">Read</span>
                        @else
                            <span class="badge badge-new">New</span>
                        @endif
                    </td>

                    <td>
                        <form method="POST" action="{{ route('admin.enquiries', $enq) }}">
                            @csrf
                            <button type="submit"
                                    class="enq-btn-icon"
                                    title="{{ $enq->is_read ? 'Mark as unread' : 'Mark as read' }}">
                                <i class="fas fa-{{ $enq->is_read ? 'envelope' : 'envelope-open' }}"
                                   style="font-size:13px"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="enq-empty">
                            <i class="fas fa-inbox"></i>
                            <p>No enquiries received yet.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($enquiries->hasPages())
    <div class="enq-pagination">
        <span class="enq-pagination-info">
            Showing {{ $enquiries->firstItem() }}–{{ $enquiries->lastItem() }}
            of {{ $enquiries->total() }} enquiries
        </span>
        {{ $enquiries->links() }}
    </div>
    @endif
</div>

@endsection