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
          Tambah Data Pegawai
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
          <form action="{{ route('employee.store') }}" method="POST" id="form" enctype="multipart/form-data">
            @csrf
            <div class="row">

              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nama Pegawai</label>
                  <div class="col-sm-10">
                    <input type="text" name="name_employee" class="form-control" aria-describedby="nameHelp"
                      placeholder="Nama..">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nomor KTP Pegawai</label>
                  <div class="col-sm-10">
                    <input type="text" name="noktp_employee" class="form-control" placeholder="Nomor KTP..">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nomor Telepon</label>
                  <div class="col-sm-10">
                    <input type="text" name="phone_employee" class="form-control" placeholder="Nomor Telepon..">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" name="email_employee" id="email_employee" class="form-control"
                      placeholder="email..">
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                    <textarea name="address_employee" id="address_employee" class="form-control" cols="30" rows="3"></textarea>
                    <small class="form-hint"></small>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Jabatan</label>
                  <div class="col-sm-10">
                    <select name="position_employee" id="position_employee" class="js-example-basic-single width-100"
                      data-placeholder="Pilih Jabatan">
                      <option value="">Pilih Jabatan</option>
                      @foreach ($data_jabatan as $item)
                        <option value="{{ $item->id_position }}">{{ $item->name_position }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">status</label>
                  <div class="col-sm-10">
                    <select name="status" id="status" class="js-example-basic-single width-100"
                      data-placeholder="Pilih Status">
                      <option value="1">Aktif</option>
                      <option value="0">Tidak Aktif</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Foto</label>
                  <div class="col-sm-10">
                    <input type="file" name="avatar" id="avatar" class="dropify" />
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 row">
              <button type="submit" class="btn btn-simpan btn-primary mr-2">Simpan</button>
            </div>
          </form>
        </div>
        <div class="col-md-12 row">
          <button type="submit" class="btn btn-simpan btn-primary mr-2">Simpan</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <<<<<<< Updated upstream </div>
    =======
    </div>
    >>>>>>> Stashed changes
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
