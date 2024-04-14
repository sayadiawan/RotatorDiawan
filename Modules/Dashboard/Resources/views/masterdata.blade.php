@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Dashboard User Management
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item active">User Management</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row mb-5">

      @foreach ($master_modules as $mn)
        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="badge bg-label-info p-3 rounded mb-3">
                <i class="{{ $mn->icon_module }}"></i>
              </div>
              <h4>
                {{ $mn->name_module }}
              </h4>
              <p>
                {{ $mn->description_module }}
              </p>

              <p class="fw-bold mb-0">
                <a class="stretched-link" href="{{ url($mn->link_module) }}">Selengkapnya <i
                    class="bx bx-chevron-right"></i></a>
              </p>
            </div>
          </div>
        </div>
      @endforeach

    </div>
  </div>
@endsection

@push('after-script')
@endpush
