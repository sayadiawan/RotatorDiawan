@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Edit Data Smart Home
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

        <li class="breadcrumb-item active">Edit Data Smart Home</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Data Smart Home</h5>

            <a href="{{ route('smarthome.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <form action="{{ route('smarthome.update', $data->id_smarthomes) }}" method="POST" id="form">
              @csrf
              @method('PUT')

              <input type="hidden" name="_token-select" id="csrf-token" value="{{ Session::token() }}" />

              <div class="mb-3">
                <label class="form-label" for="rooms_id">Pilih Room</label>

                <select name="rooms_id" id="rooms_id" class="form-control" style="width: 100%">
                  <option value="{{ $data->rooms_id }}" selected>
                    {{ $data->room->name_rooms . ' - ' . $data->room->code_rooms }}
                  </option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label" for="users_id">Pilih User</label>

                <select name="users_id" id="users_id" class="form-control" style="width: 100%">
                  <option value="{{ $data->users_id }}" selected>
                    {{ $data->user->name }}
                  </option>
                </select>
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

      $("#rooms_id").select2({
        ajax: {
          url: "{{ route('getRoomsBySelect2') }}",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              _token: CSRF_TOKEN,
              search: params.term // search term
            };
          },
          processResults: function(response) {
            return {
              results: $.map(response, function(obj) {
                return {
                  id: obj.id,
                  text: obj.text
                };
              })
            };
          },
          cache: true
        },
        placeholder: 'Pilih Room',
        theme: "bootstrap-5"
      });

      $("#users_id").select2({
        ajax: {
          url: "{{ route('getUsersBySelect2') }}",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              _token: CSRF_TOKEN,
              search: params.term // search term
            };
          },
          processResults: function(response) {
            return {
              results: $.map(response, function(obj) {
                return {
                  id: obj.id,
                  text: obj.text
                };
              })
            };
          },
          cache: true
        },
        placeholder: 'Pilih User',
        theme: "bootstrap-5"
      });

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
                  document.location = '/smarthome';
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
