@extends('admin.layouts.app')

@section('css')
@endsection

@section('page-title')
  @include('admin.page-title')
@endsection

@section('content')
  <div class="row">

    <div class="col-12 grid-margin stretch-card">

      <div class="card card-menu">

        <div class="d-md-flex justify-content-between align-items-center">

          <nav class="navbar navbar-expand-lg navbar-light ">

            <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse"
              data-target="#navbar4">

              <span class="ti-align-left font-white"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbar4">

              <ul class="navbar-nav mr-auto">


                <li class="jarak-menu">

                  <span class="font-menu-icon">

                    <i class="fas fa-home mr-1"></i> <a href="" class="font-white">Beranda</a>

                  </span>

                </li>


                <li class="jarak-menu">
                  <span class="font-menu-icon" style="font-size:14px;">
                    <i class="fas fa-edit mr-1"></i> <a href="table" class="font-white">Sample
                      Table</a>
                  </span>
                </li>
                <li class="jarak-menu">
                  <span class="font-menu-icon" style="font-size:14px;">
                    <i class="fas fa-truck mr-1"></i> <a href="form" class="font-white">Sample
                      Form</a>
                  </span>
                </li>
                <li class="jarak-menu">
                  <span class="font-menu-icon" style="font-size:14px;">
                    <i class="fas fa-window-maximize mr-1"></i> <a href="notfound" class="font-white">Sample Not Found</a>
                  </span>
                </li>
              </ul>

            </div>

          </nav>

        </div>

      </div>

    </div>

  </div>

  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Import Data User</h4>
          <hr class="md-5">
          <form action="/user-proses-import" method="POST" class="form-sample" id="form">
            @csrf
            <div class="row">

              <div class="col-md-12">
                <div class="form-group row">
                  <label class="ol-form-label">Pastikan File Berformat xlsx atau xls. <a
                      href="https://docs.google.com/spreadsheets/d/1afUhWzYE7Q_2K3SWQ4lTeNiksCzbw4Ro9X9CzTttFHM/edit?usp=sharing"
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
    integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
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
                  document.location = '/user';
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
