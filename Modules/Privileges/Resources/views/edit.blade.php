@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Edit Data Hak Akses
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('privileges.index') }}">Data Hak Akses</a>
        </li>

        <li class="breadcrumb-item active">Edit Data Hak Akses</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Data Hak Akses</h5>

            <a href="{{ route('privileges.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <form action="{{ route('privileges.update', $data->id_usergroup) }}" method="POST" id="form">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label class="form-label" for="name_usergroup">Nama Hak Akses</label>
                <input type="text" class="form-control" id="name_usergroup" name="name_usergroup"
                  placeholder="Masukkan nama hak akses" value="{{ $data->name_usergroup ?? old('name_usergroup') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="code_usergroup">Kode Hak Akses</label>
                <input type="text" class="form-control" id="code_usergroup" name="code_usergroup"
                  placeholder="Masukkan kode hak akes" value="{{ $data->code_usergroup ?? old('code_usergroup') }}" />
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
      if ($('.select2').length) {
        $('.select2').select2({
          theme: "bootstrap-5"
        });
      }

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
                  document.location = '/privileges';
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
