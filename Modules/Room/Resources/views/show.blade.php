@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Detail Data Room
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('room.index') }}">Data Room</a>
        </li>

        <li class="breadcrumb-item active">Detail Data Room</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Data Room</h5>

            <a href="{{ route('room.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="name_rooms">Nama Room</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->name_rooms }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="code_rooms">Kode Room</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $data->code_rooms }}</label>
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
