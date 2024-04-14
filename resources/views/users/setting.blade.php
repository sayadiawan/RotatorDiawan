@extends('admin.layouts.app')

@section('css')
@endsection

@section('page-title')
  @include('admin.page-title')
@endsection

@section('content')
  <div class="row align-items-center mb-3">
    <div class="col">
      <div class="text-muted mt-1">Profile</div>
      <h2 class="page-title">
        User
      </h2>
    </div>
  </div>

  @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Selamat!</strong> {{ $message }}
    </div>
  @endif

  @if ($message = Session::get('failed'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Oops!</strong> {{ $message }}
    </div>
  @endif

  <div class="row justify-content-center ">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Settings</h3>
        </div>

        <div class="card-body">
          <form id="form-setting" action="{{ route('usersetting.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Password saat ini</label>
              <div class="col">
                <input type="password" name="current_password" id="current_password"
                  class="@error('current_password') is-invalid @enderror form-control" aria-describedby="nameHelp"
                  placeholder="Enter current password" value="{{ old('current_password') }}" required>

                @error('current_password')
                  <small class="form-text text-red">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Password baru</label>
              <div class="col">
                <input type="password" name="new_password" id="new_password"
                  class="@error('new_password') is-invalid @enderror form-control" aria-describedby="nameHelp"
                  placeholder="Enter password baru" value="{{ old('new_password') }}" required>

                @error('new_password')
                  <small class="form-text text-red">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Konfirmasi password baru</label>
              <div class="col">
                <input type="password" name="confirm_password" id="confirm_password"
                  class="@error('confirm_password') is-invalid @enderror form-control" aria-describedby="nameHelp"
                  placeholder="Enter konfirmasi password baru" value="{{ old('confirm_password') }}" required>

                @error('confirm_password')
                  <small class="form-text text-red">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <div class="form-footer">
              <a href="{{ url('home') }}" class="btn btn-secondary">Back</a>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      $('#form-setting').validate();
    });
  </script>
@endsection
