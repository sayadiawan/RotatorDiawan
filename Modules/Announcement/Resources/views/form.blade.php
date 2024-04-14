@extends('admin.layouts.app')

@section('css')
@endsection

@section('page-title')
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-8 grid-margin">
      <div class="card">
        <div class="card-body">
          <div class="fc-toolbar fc-header-toolbar">
            <div class="fc-left">
              <h4 class="card-title">Pengumuman</h4>
            </div>
            <div class="fc-center"></div>
            <div class="fc-right">
              <a href="/announcement">
                <button type="button" class="btn btn-sm btn-outline-primary btn-icon-text"><i
                    class="fa fa-chevron-left text-dark btn-icon-prepend"></i> Kembali</button>
              </a>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ route('announcement.store') }}" method="POST" id="form">
              @csrf
              <div class="form-group mb-3 row">
                <div class="col">
                  <textarea name="announcement" id="announcement" cols="30" rows="10" class="form-control">{{ $data->announcement_option }}</textarea>
                </div>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-simpan btn-primary">Simpan</button>
                <a href="/user">
                  <button type="button" class="btn btn-default">Kembali</button>
                </a>
              </div>
            </form>
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
                      // document.location='/announcement';
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
          });

          $('.smt-tags').tagsInput({
            'width': '100%',
            // 'height': '75%',
            'interactive': true,
            'defaultText': 'gunakan koma',
            'removeWithBackspace': true,
            'placeholderColor': '#666666'
          });
        })
      </script>
    @endsection
