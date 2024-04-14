@extends('admin.layouts.app')

@section('css')
@endsection

@section('page-title')
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="page-header">
        <h3 class="page-title">
          Detail Data Pegawai
        </h3>
        <nav>
          <a href="/employee">
            <button type="button" class="btn btn-sm btn-outline-primary btn-icon-text"><i
                class="fa fa-chevron-left text-dark btn-icon-prepend"></i> Kembali</button>
          </a>
        </nav>
      </div>
      <div class="card">
        <div class="card-body">
          <form action="#" method="POST" id="form">

            <div class="row">

              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nama Pegawai</label>
                  <div class="col-sm-10">
                    <label class="col-form-label">: {{ $get_data->name_employee }}</label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nomor KTP Pegawai</label>
                  <div class="col-sm-10">
                    <label class="col-form-label">: {{ $get_data->noktp_employee }}</label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nomor Telepon</label>
                  <div class="col-sm-10">
                    <label class="col-form-label">: {{ $get_data->phone_employee }}</label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <label class="col-form-label">: {{ $get_data->email_employee }}</label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                    <label class="col-form-label">: {{ $get_data->address_employee }}</label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Jabatan</label>
                  <div class="col-sm-10">
                    <label class="col-form-label">: {{ $get_data->position->name_position }}</label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">status</label>
                  <div class="col-sm-10">
                    <label class="col-form-label">: {{ reference('status', $get_data->status) }}</label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Foto</label>
                  <div class="col-sm-10">
                    @php
                      if (!empty($get_data->avatar)) {
                          $url = asset('storage/images/user_thub/' . $get_data->avatar);
                      } else {
                          $url = null;
                      }
                    @endphp
                    <a href="https://docs.google.com/viewer?url={{ $url }}" target="_blank">
                      <img src="{{ $url }}" onclick="" alt="" style="width: 50%">
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script>
    $(function() {
      //on load
      $('.dropify').dropify();
      $('#datepicker-popup').datepicker({
        enableOnReadonly: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
      });
      $(".js-example-basic-single").select2();

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
                  document.location = '/employee';
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
    })
  </script>
@endsection
