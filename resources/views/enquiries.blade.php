@extends('layouts.admin')
@section('title', 'Enquiries')
@section('page-title', 'Website Enquiries')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Enquiries</div>
        <div class="page-subtitle">Contact form submissions from the website</div>
    </div>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enquiries as $enq)
                <tr>
                    <td style="color:var(--text-muted)">{{ $enq->id }}</td>
                    <td><strong>{{ $enq->name }}</strong><br><small style="color:var(--text-muted)">{{ $enq->email }}</small></td>
                    <td>{{ $enq->company ?? '—' }}</td>
                    <td><a href="tel:{{ $enq->phone }}" style="color:var(--primary);text-decoration:none">{{ $enq->phone }}</a></td>
                    <td><span class="badge badge-info">{{ $enq->service_type }}</span></td>
                    <td style="max-width:220px;font-size:12px;color:var(--text-muted)">{{ Str::limit($enq->message, 70) }}</td>
                    <td style="font-size:11px;color:var(--text-muted)">{{ $enq->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        @if($enq->is_read)
                            <span class="badge badge-success">Read</span>
                        @else
                            <span class="badge badge-warning">New</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.enquiries.read', $enq) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline" title="{{ $enq->is_read ? 'Mark Unread' : 'Mark Read' }}">
                                <i class="fas fa-{{ $enq->is_read ? 'envelope' : 'envelope-open' }}"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
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
    <div style="padding:12px 18px;border-top:1px solid var(--border);">{{ $enquiries->links() }}</div>
    @endif
</div>

@endsection