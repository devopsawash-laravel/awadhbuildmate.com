@extends('layouts.app')

@section('title', 'Labour Registry')
@section('page-title', 'Labour Registry')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="page-header">
    <div>
        <div class="page-title">Labour Registry</div>
        <div class="page-subtitle">Manage all site labour records</div>
    </div>
    <a href="{{ route('labours.create')}}" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Add Labour
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">

    <div class="card-body"
         style="
            padding:16px 20px;
            display:flex;
            justify-content:space-between;
            align-items:end;
            gap:14px;
            flex-wrap:wrap;
         ">

        <form method="GET"
              style="
                display:flex;
                gap:14px;
                align-items:end;
                flex-wrap:wrap;
                width:100%;
              ">

            {{-- Search --}}
            <div style="flex:1;min-width:220px;">

                <label>Search</label>

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Name or Employee ID...">

            </div>

            {{-- Category --}}
            <div style="min-width:220px;">

                <label>Category</label>

                <select name="category" id="category">

                    <option value="">
                        All Categories
                    </option>

                    @foreach([
                        'Welder',
                        'Fitter',
                        'Helper',
                        'Rigger',
                        'Assistant Fitter',
                        'Grinder',
                        'Taker Welder',
                        'Gas Cutter',
                        'Khallasi Helper',
                        'Visual Grinder',
                        'Structure Fitter'
                    ] as $cat)

                    <option value="{{ $cat }}"
                        {{ request('category') == $cat ? 'selected' : '' }}>

                        {{ $cat }}

                    </option>

                    @endforeach

                </select>

            </div>

            {{-- Status --}}
            <div style="min-width:220px;">

                <label>Status</label>

                <select name="status" id="status">

                    <option value="">
                        All Status
                    </option>

                    <option value="active"
                        {{ request('status') == 'active' ? 'selected' : '' }}>

                        Active

                    </option>

                    <option value="inactive"
                        {{ request('status') == 'inactive' ? 'selected' : '' }}>

                        Inactive

                    </option>

                </select>

            </div>

            {{-- Site --}}
            <div style="min-width:240px;">

    <label>Site</label>

    <select name="site_id" id='site'
            onchange="this.form.submit()">

        <option value="">
            All Sites
        </option>

         @foreach($sites as $site)

                        <option value="{{ $site->id }}">
                             {{ $site->name }}
                         </option>

                        @endforeach

    </select>

</div>

            {{-- Buttons --}}
            <div style="
                display:flex;
                gap:10px;
            ">

                <button type="submit"
                        class="btn btn-secondary">

                    <i class="fas fa-search"></i>

                    Filter

                </button>

                <a href="{{ route('labours.index') }}"
                   class="btn btn-outline">

                    Clear

                </a>

            </div>

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
                    <th>SITE</th>
                    {{-- <th>OT Rate/Hr</th> --}}
                    {{-- <th>PF %</th> --}}
                    <th>OT Hour</th>
                    {{-- <th>Joining Date</th> --}}
                    <th>Status</th>
                    <th>Account no</th>
                    <th>Pan Card</th>
                    <th>UAN</th>
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
                    {{-- <td>₹{{ number_format($labour->overtime_rate, 0) }}</td> --}}
                    <td> {{ $labour->site->name ?? '—' }}</td>
                    <!-- <td>{{ $labour->pf_percentage }}%</td> -->
                     <td>{{ get_overtime_hours }} hrs</td>
                    {{-- <td>{{ $labour->joining_date->format('d M Y') }}</td> --}}
                    <td>
                       <form method="POST"
                            action="{{ route('labours.toggleStatus', $labour->id) }}">

                            @csrf
                            @method('PUT')

                            <label class="switch">

                                <input type="checkbox"
                                    onchange="this.form.submit()"
                                    {{ $labour->status === 'active' ? 'checked' : '' }}>

                                <span class="slider"></span>
                            </label>
                    </form>
                    </td>
                    <td>{{ $labour->Account_Number }}</td>
                    <td>{{ $labour->Pan_Card }}</td>
                    <td>{{ $labour->UAN }}</td>
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
<style>
    .switch{
    position:relative;
    display:inline-block;
    width:52px;
    height:28px;
}

.switch input{
    opacity:0;
    width:0;
    height:0;
}

.slider{
    position:absolute;
    cursor:pointer;
    top:0;
    left:0;
    right:0;
    bottom:0;
    background:#d1d5db;
    transition:.3s;
    border-radius:999px;
}

.slider:before{
    position:absolute;
    content:"";
    height:22px;
    width:22px;
    left:3px;
    bottom:3px;
    background:white;
    transition:.3s;
    border-radius:50%;
    box-shadow:0 1px 4px rgba(0,0,0,0.2);
}

.switch input:checked + .slider{
    background:#de4f07;
}

.switch input:checked + .slider:before{
    transform:translateX(24px);
}
</style>
<script>
 $(document).ready(function () {

    // $('#category').select2({
    //     placeholder: "Select Category",
    //     width: '220px'
    // });

     $('#category').select2({
        placeholder: "Select Category",
        width: 'resolve',
        allowClear: true,
        width: '220px',
    });
});

$(document).ready(function () {

    $('#status').select2({
        placeholder: "All Status",
        allowClear: true,
        width: '220px'
    });
        $('#site').select2({
        placeholder: "All Sites",
        allowClear: true,
        width: '220px'
    });

});
</script>


@endsection
