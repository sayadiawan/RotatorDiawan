@extends('admin.layouts.app')

@section('css')
@endsection

@section('page-title')
@endsection

@section('content')
  @include('admin.menu.masterdata')
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Import Data</h4>
          <hr class="md-5">
          <form action="{{ route('import.store') }}" method="POST" class="form-sample" id="form">
            @csrf
            <div class="row">

              <div class="col-md-12">
                <div class="form-group row">
                  <label for="">Jenis Import</label>
                  <select name="set_jenis" id="set_jenis" class="form-control" onchange="jenis_import(this)">
                    <option value="">Pilih Jenis Import</option>
                    <option value="1">Module User</option>
                    <option value="2">Module Pegawai</option>
                  </select>
                </div>

                <div class="form-group row">
                  <label class="ol-form-label">Pastikan File Berformat xlsx atau xls. <a id="link_temp"
                      target="_blank">downlaod template</a></label>
                  <input type="file" name="file" class="form-control" />
                </div>
              </div>
            </div>
            <div class="form-group row">
              <button type="submit" class="btn btn-simpan btn-primary mr-2">Simpan</button>
              <a href="/user">
                <button type="button" class="btn btn-ligh">Kembali</button>
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
@endsection
@section('script')
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script> --}}
  <script>
    $(function() {
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
                  document.location = '/import';
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

    function jenis_import(param) {
      var val = param.value;
      if (val == "1") {
        var link = '/temp-import/user';
      } else if (val == "2") {
        var link = '/temp-import/employee';
      }

      $('#link_temp').attr('href', function(index, attr) {
        return attr == link ? null : link;
      });
    }
  </script>
@endsection
