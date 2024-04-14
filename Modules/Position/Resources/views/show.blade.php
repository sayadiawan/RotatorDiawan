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
          Detail Data Jabatan
        </h3>
        <nav>
          <a href="/position">
            <button type="button" class="btn btn-sm btn-outline-primary btn-icon-text"><i
                class="fa fa-chevron-left text-dark btn-icon-prepend"></i> Kembali</button>
          </a>
        </nav>
      </div>
      <div class="card">
        <div class="card-body">
          <form action="{{ route('position.update', [$get_data->id_position]) }}" method="POST" class="form-sample"
            id="form">
            @csrf
            <input type="hidden" value="PUT" name="_method">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nama Jabatan</label>
                  <div class="col-sm-10">
                    <label class="col-form-label">: {{ $get_data->name_position }}</label>
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
                  document.location = '/position';
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
