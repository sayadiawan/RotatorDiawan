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
          <h3 class="card-title">Profile & account</h3>
        </div>

        <div class="card-body">
          <form id="form-profile" action="{{ route('userprofile.update', Auth::id()) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Name</label>
              <div class="col">
                <input type="text" name="name" id="name"
                  class="@error('name') is-invalid @enderror form-control" aria-describedby="nameHelp"
                  placeholder="Enter name" value="{{ Auth::user()->name }}" required>

                @error('name')
                  <small class="form-text text-red">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Email address</label>
              <div class="col">
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter email"
                  value="{{ Auth::user()->email }}" readonly>
              </div>
            </div>

            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Picture</label>
              <div class="col">
                @if (Auth::user()->avatar)
                  <img class="img-fluid" src="{{ asset('storage/' . Auth::user()->avatar) }}" style="margin-bottom: 10px"
                    height="75" width="125">

                  <a href="{{ route('userprofile.delete', Auth::id()) }}"
                    onclick="event.preventDefault();document.getElementById('remove-image').submit();"
                    class="btn btn-sm btn-danger">Hapus</a>

                  <input type="hidden" name="avatar_old" id="avatar_old" value="{{ Auth::user()->avatar }}" readonly>
                @endif

                <input type="file" name="avatar" id="avatar"
                  class="@error('avatar') is-invalid @enderror form-control">

                @error('avatar')
                  <small class="form-text text-red">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <div class="form-footer">
              <a href="{{ url('home') }}" class="btn btn-secondary">Back</a>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>

          <form action="{{ route('userprofile.delete', Auth::id()) }}" id="remove-image" method="POST">
            @csrf
            @method('DELETE')
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      $('#form-profile').validate();
    });
  </script>
@endsection
