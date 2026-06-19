@extends('layouts.app')

@section('title', 'Add Site')

@section('page-title', 'Add Site')

@section('content')

<div class="page-header"
     style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:12px;
     ">

    <div>

        <div class="page-title"
             style="
                font-size:28px;
                font-weight:700;
             ">

            <i class="fas fa-building"
               style="
                    color:var(--primary);
                    margin-right:8px;
               "></i>

            Add Site

        </div>

        <div class="page-subtitle"
             style="
                margin-top:4px;
                color:var(--text-muted);
             ">

            Create and manage construction project sites

        </div>

    </div>

</div>


<div class="card"
     style="
        border:none;
        box-shadow:0 4px 18px rgba(0,0,0,0.06);
        border-radius:14px;
        overflow:hidden;
     ">

    {{-- Header --}}
    <div class="card-header"
         style="
            background:#f8fafc;
            border-bottom:1px solid #e5e7eb;
            padding:18px 24px;
            display:flex;
            align-items:center;
            gap:10px;
         ">

        <i class="fas fa-map-marker-alt"
           style="
                color:var(--primary);
                font-size:18px;
           "></i>

        <span style="
            font-size:17px;
            font-weight:600;
        ">

            Site Information

        </span>

    </div>


    <div class="card-body"
         style="
            padding:28px;
         ">

        <form method="POST" action="{{ route('sites.update', $site->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid"
                 style="
                    display:grid;
                    grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));
                    gap:22px;
                 ">

                {{-- Site Name --}}
                <div class="form-group">

                    <label>
                        Site Name
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $site->name) }}"
                           placeholder="Dahej Refinery Project"
                           required>

                </div>


                {{-- Slug --}}
                <div class="form-group">

                    <label>
                        Slug
                    </label>

                    <input type="text"
                           name="slug"
                           placeholder="dahej-refinery"
                           value="{{ old('slug', $site->slug) }}"
                           required>

                </div>


                {{-- Location --}}
                <div class="form-group">

                    <label>
                        Location
                    </label>

                    <input type="text"
                           name="location"
                           placeholder="Dahej, Gujarat"
                           value="{{ old('location', $site->location) }}"
                           required>

                </div>


                {{-- State --}}
                <div class="form-group">

                    <label>
                        State
                    </label>

                    <input type="text"
                           name="state"
                           value="{{ old('State', $site->State) }}"
                           placeholder="Gujarat">

                </div>


                {{-- Client --}}
                <div class="form-group">

                    <label>
                        Client
                    </label>

                    <input type="text"
                           name="client"
                           value="{{ old('client', $site->client) }}"
                           placeholder="HPCL / IOCL">
                </div>


                {{-- Status --}}
                <div class="form-group">

                    <label>
                        Status
                    </label>

                    <select name="status">

                        <option value="active">
                            Active
                        </option>

                        <option value="inactive">
                            Inactive
                        </option>

                        <option value="completed">
                            Completed
                        </option>

                    </select>

                </div>


                {{-- Site Incharge --}}
                <div class="form-group">

                    <label>
                        Site Incharge
                    </label>

                    <input type="text"
                           name="site_incharge"
                           value="{{ old('site_incharge', $site->site_incharge) }}"
                           placeholder="Mr. Rajesh Kumar">

                </div>


                {{-- Incharge Phone --}}
                <div class="form-group">

                    <label>
                        Incharge Phone
                    </label>

                    <input type="text"
                           name="incharge_phone"
                           value="{{ old('incharge_phone', $site->incharge_phone) }}"
                           placeholder="9876543210">
                </div>

                  <div class="form-group">

                    <label>
                        Start Date
                    </label>

                    <input type="date"
                           name="start_date"
                           value="{{ old('start_date', $site->start_date) }}">
                </div>

                <div class="form-group">

                    <label>
                        Expected End Date
                    </label>

                    <input type="date"
                           name="start_date"
                           value="{{ old('expected_end_date', $site->expected_end_date) }}">
                </div>


            </div>


            {{-- Description --}}
            <div class="form-group"
                 style="margin-top:24px;">

                <label>
                    Description
                </label>

                <textarea name="description"
                          rows="5"
                          value="{{ old('description', $site->description) }}"
                          placeholder="Enter project/site details..."></textarea>

            </div>


            {{-- Buttons --}}
            <div style="
                margin-top:30px;
                display:flex;
                gap:12px;
                flex-wrap:wrap;
            ">

                <button type="submit"
                        class="btn btn-primary"
                        style="
                            min-width:180px;
                        ">

                    <i class="fas fa-save"></i>

                    Save Site

                </button>

                <a href="{{ route('sites.index') }}"
                   class="btn btn-secondary"
                   style="
                        min-width:180px;
                   ">

                    <i class="fas fa-arrow-left"></i>

                    Back

                </a>

            </div>

        </form>

    </div>

</div>

@endsection