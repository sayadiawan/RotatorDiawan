@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Detail Data Smart Home
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('smarthome.index') }}">Data Smart Home</a>
        </li>

        <li class="breadcrumb-item active">Detail Data Smart Home</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Data Smart Home</h5>

            <a href="{{ route('smarthome.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="rooms_id">Nama Room</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->room->name_rooms . ' - ' . $data->room->code_rooms }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="users_id">Kode User</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->user->name }}</label>
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
