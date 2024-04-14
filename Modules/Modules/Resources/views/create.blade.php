@extends('admin.layouts.app')

@push('after-style')
  <style>
    div.tagsinput span.tag {
      background: #2980b9;
      color: #ecf0f1;
      padding: 4px;
      margin: 1px;
      font-size: 14px;
      text-transform: lowercase !important;
      border: none;
    }

    div.tagsinput span.tag a {
      color: #ecf0f1;
    }
  </style>
@endpush

@section('title')
  Tambah Data Module
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

        <li class="breadcrumb-item active">Tambah Data Module</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tambah Data Module</h5>

            <a href="{{ route('modules.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <form action="{{ route('modules.store') }}" method="POST" id="form">
              @csrf

              <div class="mb-3">
                <label class="form-label" for="upid_module">Parent Module</label>

                <select name="upid_module" id="upid_module" class="form-control select2">
                  <option value="">Pilih Parent Module</option>
                  @foreach ($modules as $mdl)
                    <option value="{{ $mdl->id_module }}">{{ $mdl->name_module }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label" for="code_module">Kode Module</label>
                <input type="text" class="form-control" id="code_module" name="code_module"
                  placeholder="Masukkan kode module" value="{{ old('code_module') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="name_module">Nama Module</label>
                <input type="text" class="form-control" id="name_module" name="name_module"
                  placeholder="Masukkan nama module" value="{{ old('name_module') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="link_module">Link Module</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text" id="link_module">https://example.com/</span>
                  <input type="text" class="form-control" id="link_module" name="link_module"
                    aria-describedby="basic-addon34" value="{{ old('link_module') }}">
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label" for="icon_module">Icon Module</label>
                <input type="text" class="form-control" id="icon_module" name="icon_module"
                  placeholder="Masukkan icon module" value="{{ old('icon_module') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="order_module">Urutan Module</label>
                <input type="text" class="form-control" id="order_module" name="order_module"
                  placeholder="Masukkan urutan module" value="{{ old('order_module') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="action_module">Aksi Module</label>
                <input type="text" class="form-control smt-tags" id="action_module" name="action_module"
                  placeholder="Masukkan aksi module" value="{{ old('action_module') }}" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="description_module">Deskripsi Module</label>

                <textarea class="form-control" name="description_module" id="description_module" cols="20" rows="5"
                  placeholder="Masukkan deskripsi module">{{ old('description_module') }}</textarea>
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

      $('.smt-tags').tagsInput({
        'width': '100%',
        'height': '75%',
        'interactive': true,
        'defaultText': 'gunakan koma',
        'removeWithBackspace': true,
        'placeholderColor': '#666666'
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
                  document.location = '/modules';
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
