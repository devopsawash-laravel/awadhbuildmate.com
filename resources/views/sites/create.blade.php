@extends('layouts.app')

@section('title', 'Add Site')

@section('page-title', 'Add Site')

@section('content')

<div class="page-header">

    <div>

        <div class="page-title">
            Add Site
        </div>

        <div class="page-subtitle">
            Create new project site
        </div>

    </div>

</div>

<div class="card">

    <div class="card-body">

        <form method="POST"
              action="{{ route('sites.store') }}">

            @csrf

            <div class="form-grid">

                <div class="form-group">

                    <label>Site Name</label>

                    <input type="text"
                           name="name"
                           required>

                </div>

                <div class="form-group">

                    <label>Slug</label>

                    <input type="text"
                           name="slug"
                           required>

                </div>

                <div class="form-group">

                    <label>Location</label>

                    <input type="text"
                           name="location"
                           required>

                </div>

                <div class="form-group">

                    <label>State</label>

                    <input type="text"
                           name="state">

                </div>

                <div class="form-group">

                    <label>Client</label>

                    <input type="text"
                           name="client">

                </div>

                <div class="form-group">

                    <label>Status</label>

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

                <div class="form-group">

                    <label>Site Incharge</label>

                    <input type="text"
                           name="site_incharge">

                </div>

                <div class="form-group">

                    <label>Incharge Phone</label>

                    <input type="text"
                           name="incharge_phone">

                </div>

            </div>

            <div class="form-group">

                <label>Description</label>

                <textarea name="description"
                          rows="4"></textarea>

            </div>

            <div style="margin-top:20px;">

                <button type="submit"
                        class="btn btn-primary">

                    <i class="fas fa-save"></i>

                    Save Site

                </button>

            </div>

        </form>

    </div>

</div>

@endsection