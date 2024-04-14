@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Edit Data Icon
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('icon.index') }}">Data Icon</a>
        </li>

        <li class="breadcrumb-item active">Edit Data Icon</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Data Icon</h5>

            <a href="{{ route('icon.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <form action="{{ route('icon.update', $item->id_icons) }}" method="POST" id="form">
              @csrf
              @method('PUT')

              <input type="hidden" name="_token-select" id="csrf-token" value="{{ Session::token() }}" />

              {{-- check jika ada icon-nya --}}
              @if (Storage::disk('public')->exists($item->file_icons) && $item->file_icons)
                <div class="mb-3">
                  <a href="{{ Storage::url($item->file_icons) }}" class="btn btn-sm btn-info mb-2 ml-2" download>Download
                    File Icon</a>
                </div>
              @endif

              <div class="mb-3">
                <label class="form-label" for="rooms_id">Pilih Icon</label>

                <input type="file" class="form-control" name="file_icons" id="file_icons">
              </div>

              <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('after-script')
  <script>
    $(function() {
      var CSRF_TOKEN = $('#csrf-token').val();

      $('.btn-simpan').on('click', function() {
        $('#form').ajaxForm({
          success: function(response) {
            if (response.status == true) {
              swal({
                  title: "Success!",
                  text: response.pesan,
                  icon: "success"
                })
                .then(function() {
                  document.location = '/icon';
                });
            } else {
              var pesan = "";
              var data_pesan = response.pesan;
              const wrapper = document.createElement('div');

              if (typeof(data_pesan) == 'object') {
                jQuery.each(data_pesan, function(key, value) {
                  console.log(value);
                  pesan += value + '. <br>';
                  wrapper.innerHTML = pesan;
                });

                swal({
                  title: "Error!",
                  content: wrapper,
                  icon: "warning"
                });
              } else {
                swal({
                  title: "Error!",
                  text: response.pesan,
                  icon: "warning"
                });
              }
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            var err = eval("(" + jqXHR.responseText + ")");
            swal("Error!", err.Message, "error");
          }
        })
      })
    })
  </script>
@endpush
