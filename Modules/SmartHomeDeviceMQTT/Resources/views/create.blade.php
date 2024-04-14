@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Tambah Data Device untuk Smart Home
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('smarthome.device.index', $id_smarthome) }}">Data Smart Home</a>
        </li>

        <li class="breadcrumb-item active">Tambah Data Device untuk Smart Home</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tambah Data Device untuk Smart Home</h5>

            <a href="{{ route('smarthome.device.index', $id_smarthome) }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <form action="{{ route('smarthome.device.store') }}" method="POST" id="form">
              @csrf

              <input type="hidden" name="_token-select" id="csrf-token" value="{{ Session::token() }}" />
              <input type="hidden" name="smarthomes_id" id="smarthomes_id" value="{{ $id_smarthome }}" readonly>

              <div class="row mb-3" style="width: 100%">
                <div class="col-md-12">
                  <div class="form-check float-end">
                    <input class="form-check-input" type="checkbox" id="checkall-device">
                    <label class="form-check-label" for="checkall-device">
                      Check All
                    </label>
                  </div>
                </div>
              </div>

              <div class="row" style="width: 100%">
                {{-- loop --}}
                @if (count($data_device) > 0)
                  @php
                    $device_in_smarthome = [];
                    
                    foreach ($data_smarthome_device as $key => $value) {
                        array_push($device_in_smarthome, $value->devices_id);
                    }
                  @endphp

                  @foreach ($data_device as $index => $item)
                    @if (in_array($item->id_devices, $device_in_smarthome))
                      <div class="col-lg-3 col-md-6 col-xs-12 mb-3">
                        <div class="form-check">
                          <input class="form-check-input smarthome_device" type="checkbox" value="{{ $item->id_devices }}"
                            id="smarthome_device_{{ $index }}" name="smarthome_device[{{ $item->id_devices }}]"
                            data-name="{{ $item->name_devices }}" data-index="{{ $index }}" checked disabled>
                          <label class="form-check-label" for="defaultCheck3">
                            {{ $item->name_devices }}
                          </label>
                        </div>
                      </div>
                    @else
                      <div class="col-lg-3 col-md-6 col-xs-12 mb-3">
                        <div class="form-check">
                          <input class="form-check-input smarthome_device" type="checkbox"
                            value="{{ $item->id_devices }}" id="smarthome_device_{{ $index }}"
                            name="smarthome_device[{{ $item->id_devices }}]" data-name="{{ $item->name_devices }}"
                            data-index="{{ $index }}">
                          <label class="form-check-label" for="defaultCheck3">
                            {{ $item->name_devices }}
                          </label>
                        </div>
                      </div>
                    @endif
                  @endforeach
                @else
                  <div class="col-12">
                    <div class="col-md-12 text-center">
                      <h5 class="card-title">Sorry!</h5>
                      <p class="card-text">Data device belum tersedia.
                      </p>
                    </div>
                  </div>
                @endif

                {{-- loop --}}

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

      // check all
      $("#checkall-device").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);

        if ($('input:checkbox').is(':checked')) {
          $('input:checkbox.smarthome_device').attr('checked', 'checked');
        }
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
                  document.location = response.url_home;
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
