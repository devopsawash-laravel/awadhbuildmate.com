@extends('layouts.app')

@section('title', 'Labour Registry')
@section('page-title', 'Labour Registry')

@section('content')

<div class="page-header">
    <div>
        <div class="page-title">Labour Registry</div>
        <div class="page-subtitle">Manage all site labour records</div>
    </div>
    <a href="{{ route('labours.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Add Labour
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body" style="padding:14px 20px;">
        <form method="GET" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
            <div style="flex:1;min-width:200px;">
                <label>Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or Employee ID...">
            </div>
            <div style="min-width:150px;">
                <label>Category</label>
                <select name="category">
                    <option value="">All Categories</option>
                    @foreach(['Welder','Fitter','Helper','Rigger'] as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div style="min-width:120px;">
                <label>Status</label>
                <select name="status">
                    <option value="">All</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Filter</button>
            <a href="{{ route('labours.index') }}" class="btn btn-outline">Clear</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Phone</th>
                    <th>Daily Wage</th>
                    <th>OT Rate/Hr</th>
                    <th>PF %</th>
                    <th>Joining Date</th>
                    <th>Status</th>
                    <th>Pending Adv.</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($labours as $labour)
                <tr>
                    <td><span style="font-family:monospace;font-size:13px;color:var(--text-muted)">{{ $labour->employee_id }}</span></td>
                    <td><strong>{{ $labour->name }}</strong></td>
                    <td><span class="badge badge-{{ strtolower($labour->category) }}">{{ $labour->category }}</span></td>
                    <td>{{ $labour->phone ?? '—' }}</td>
                    <td>₹{{ number_format($labour->daily_wage, 0) }}</td>
                    <td>₹{{ number_format($labour->overtime_rate, 0) }}</td>
                    <td>{{ $labour->pf_percentage }}%</td>
                    <td>{{ $labour->joining_date->format('d M Y') }}</td>
                    <td>
                        <span class="badge {{ $labour->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ ucfirst($labour->status) }}
                        </span>
                    </td>
                    <td>
                        @php $pending = $labour->getPendingAdvances(); @endphp
                        @if($pending > 0)
                            <span style="color:var(--danger);font-weight:600;">₹{{ number_format($pending, 0) }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            <a href="{{ route('labours.show', $labour) }}" class="btn btn-sm btn-outline" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('labours.edit', $labour) }}" class="btn btn-sm btn-secondary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('labours.destroy', $labour) }}" onsubmit="return confirm('Delete this labour?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11">
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <p>No labours found. <a href="{{ route('labours.create') }}">Add one</a>.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($labours->hasPages())
    <div style="padding:14px 20px;border-top:1px solid var(--border);">
        {{ $labours->links() }}
    </div>
    @endif
</div>

@endsection