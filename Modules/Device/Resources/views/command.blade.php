@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
Tambah Data Device Command
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ url('home') }}">Dashboard</a>
      </li>


      <li class="breadcrumb-item active">Command Device</li>
    </ol>
  </nav>

  <!-- Collapse -->
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">List/Add Command Device</h5>

          <a href="{{ route('device.index') }}">
            <button type="button" class="btn btn-secondary btn-icon-text">
              <i class="fas fa-arrow-left btn-icon-prepend"></i>
              Kembali
            </button>
          </a>
        </div>
        <div class="card-body">
          <form action="{{ route('set_command', [$get_data->id_devices]) }}" method="POST" id="form">
            @csrf
            <div class="row">

              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nama Device</label>
                  <div class="col-sm-10">
                    <label class="col-form-label">: {{ $get_data->name_devices }}</label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tipe Device</label>
                  <div class="col-sm-10">
                    @php

                    switch ($get_data->type) {
                    case 'lamp':
                    # code...
                    $type = 'Lampu';
                    break;
                    case 'humidifier':
                    # code...
                    $type = 'Humidifier';
                    break;
                    case 'fan':
                    # code...
                    $type = 'Fan';
                    break;
                    case 'door':
                    # code...
                    $type = 'Door';
                    break;
                    case 'curtains':
                    # code...
                    $type = 'Curtains';
                    break;
                    case 'ac':
                    # code...
                    $type = 'AC (Air Conditioner)';
                    break;
                    default:
                    # code...
                    $type = 'Window';
                    break;
                    }
                    @endphp
                    <label class="col-form-label">: {{ $type }}</label>
                  </div>
                </div>
              </div>

              <div class="mb-3">
              </div>
              <div class="mb-3">
                <label class="form-label" for="type">Pilih Tipe Command</label>

                <select class="form-control select2" name="type" id="type" style="width: 100%">
                  <option value="">Pilih Tipe Command</option>
                  @foreach ($get_data->deviceAttribute as $deviceAttribute)
                  <option value="{{ $deviceAttribute->id_device_atribute }}">
                    {{ $deviceAttribute->name_device_atribute }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label " for="name">Voice Command</label>

                <input type="text" class="form-control" id="voice_command" name="voice_command"
                  placeholder="Masukkan Voice command" value="{{ old('voice_command') }}" />
              </div>

              <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-simpan">Add Command <i class="fa fa-plus"
                    aria-hidden="true"></i></button>
              </div>
            </div>
          </form>
        </div>
      </div>


    </div>

    <div class="col-md-12 grid-margin">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">List Command Device</h5>
        </div>
        <div class="card-body">
          {{-- <form action="#" method="POST" id="form"> --}}

            <div class="row">


              <div class="col-md-12">
                <table class="table" id="table-command">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Type Command</th>
                      <th scope="col">Voice Command</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($get_data->deviceCommand as $command)
                    @if ((!isset($command->command_is_ori))|| $command->command_is_ori!=1)
                    <tr>
                      <th scope="row">{{ $no }}</th>
                      <td>{{ $command->deviceAtribute->name_device_atribute }}</td>
                      <td>"{{ $command->command }}"</td>
                      <td>
                        <button type="button" data-id="{{ $command->id_devices_command }}"
                          data-device="{{ $get_data->name_devices }}" data-command="{{ $command->command }}"
                          class="btn btn-danger btn-rounded btn-hapus btn-icon">
                          <i class="fa fa-times"></i>
                        </button>
                      </td>
                    </tr>
                    @php
                    $no++;
                    @endphp
                    @endif
                    @endforeach


                  </tbody>
                </table>
              </div>

            </div>
            {{--
          </form> --}}
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('after-script')
<script>
  $('.btn-hapus').on('click', function() {
      var kode = $(this).data('id');
      var nama = $(this).data('device');
      var command = $(this).data('command');
      swal({
          title: "Apakah anda yakin?",
          text: "Untuk menghapus comand : '" + command + "'' pada device '" + nama + "'",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              type: 'ajax',
              method: 'DELETE',
              url: 'delete',
              data: {
                'id': kode,
                '_token': "{{ csrf_token() }}",
              },
              async: true,
              dataType: 'json',
              success: function(response) {
                if (response.status == true) {
                  swal({
                      title: "Success!",
                      text: "Berhasil Menghapus Data",
                      icon: "success"
                    })
                    .then(function() {
                      location.reload(true);
                    });
                } else {
                  swal("Hapus Data Gagal !", {
                    icon: "warning",
                  });
                }
              },
              error: function() {
                swal("ERROR", "Hapus Data Gagal.", "error");
              }
            });
          } else {
            swal("Cancelled", "Hapus Data Dibatalkan.", "error");
          }
        });
    });


    $('.btn-simpan').on('click', function() {
      $('#form').ajaxForm({
        success: function(response) {

          if (response.status == true) {
            swal({
                title: "Success!",
                text: "Berhasil Menyimpan Data",
                icon: "success"
              })
              .then(function() {
                document.location = response.set_url;
              });
          } else {
            var pesan = "";
            jQuery.each(response.pesan, function(key, value) {
              pesan += value + '. ';
            });
            swal("Error!", pesan, "error");
          }
        },
        error: function() {
          swal("Error!", "Proses Gagal", "error");
        }
      })
    })
</script>

<script>
  $(function() {

      $("#copy").click(function() {
        $("#device-integration").select();
        document.execCommand('copy');
      });



    })
</script>
@endpush