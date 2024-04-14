@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Edit Data Module
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('modules.index') }}">Data Module</a>
        </li>

        <li class="breadcrumb-item active">Detail Data Module</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Data Module</h5>

            <a href="{{ route('modules.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="name_module">Parent Module</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->module->name_module ?? 'Parent' }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="name_module">Module Name</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->name_module }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="link_module">Module Link</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->link_module }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="icon_module">Icon</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->icon_module }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="order_module">Order Number</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->order_module }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="action_module">Action Module</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->action_module }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="description_module">Description</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->description_module }}</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('after-script')
@endpush
