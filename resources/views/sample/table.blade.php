@extends('admin.layouts.app')

@section('css')
@endsection

@section('page-title')
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
                    <i class="fas fa-edit mr-1"></i> <a href="sample/table" class="font-white">Sample Table</a>
                  </span>
                </li>
                <li class="jarak-menu">
                  <span class="font-menu-icon" style="font-size:14px;">
                    <i class="fas fa-truck mr-1"></i> <a href="sample/form" class="font-white">Sample Form</a>
                  </span>
                </li>
                <li class="jarak-menu">
                  <span class="font-menu-icon" style="font-size:14px;">
                    <i class="fas fa-window-maximize mr-1"></i> <a href="sample/notfound" class="font-white">Sample Not
                      Found</a>
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
    <div class="col-12 grid-margin">
      <div class="page-header">
        <h3 class="page-title">
          Sample Table
        </h3>
        <nav aria-label="breadcrumb">
          <a href="form">
            <button type="button" class="btn btn-info btn-icon-text">
              <i class="fa fa-plus btn-icon-prepend"></i>
              Tambah
            </button>
          </a>
          <button type="button" class="btn btn-success btn-icon-text">
            <i class="fa-file-excel btn-icon-prepend"></i>
            Ekspor
          </button>
          <button type="button" class="btn btn-dark btn-icon-text">
            <i class="fa fa-download btn-icon-prepend"></i>
            Cetak
          </button>
        </nav>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-2 mb-3">
              <label>Dari Tanggal:</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-md-2 mb-3">
              <label>Sampai Tanggal:</label>
              <input type="date" class="form-control">
            </div>
            <div class="col-md-2 mb-3">
              <label>Cari Berdasarkan:</label>
              <select class="form-control">
                <option>Cari Semua</option>
                <option>Nama Lengkap</option>
                <option>Alamat</option>
                <option>Divis</option>
              </select>
            </div>
            <div class="col-md-2 mb-3">
              <button type="button" class="btn btn-sm btn-light btn-fw mt-4">Cari</button>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="order-listing" class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Lengkap</th>
                      <th>Alamat</th>
                      <th>Nomor Telepon</th>
                      <th>Divisi</th>
                      <th>Status Kontrak</th>
                      <th>Yes/No</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        1
                      </td>
                      <td>
                        Ardika Santosa
                      </td>
                      <td>
                        Kelet-Keling-Jepara
                      </td>
                      <td>
                        082313367777
                      </td>
                      <td>
                        Front End
                      </td>
                      <td>
                        <label class="badge badge-success badge-pill">Aktif</label>
                      </td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-md btn-outline-info" data-toggle="tooltip"
                            data-custom-class="tooltip-info" data-placement="top" onclick="showAlert('alert-status')"
                            title="Aktifkan Pegawai">Yes</button>
                          <button type="button" class="btn btn-md btn-outline-danger" data-toggle="tooltip"
                            data-custom-class="tooltip-danger" data-placement="top" onclick="showAlert('alert-status')"
                            title="Non Aktifkan Pegawai">No</button>
                        </div>
                      </td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-light">Edit</button>
                          <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split"
                            id="dropdownMenuSplitButton1" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                            <a class="dropdown-item" onclick="showAlert('alert-hapus')" href="#">Hapus</a>
                            <a class="dropdown-item" href="#">Detail</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        1
                      </td>
                      <td>
                        Roy Kiyosi
                      </td>
                      <td>
                        Semarang Gajah Mungkur
                      </td>
                      <td>
                        082313367777
                      </td>
                      <td>
                        Konten Kreators
                      </td>
                      <td>
                        <label class="badge badge-danger badge-pill">Tidak Aktif</label>
                      </td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-md btn-outline-info" data-toggle="tooltip"
                            data-custom-class="tooltip-info" data-placement="top" onclick="showAlert('alert-status')"
                            title="Aktifkan Pegawai">Yes</button>
                          <button type="button" class="btn btn-md btn-outline-danger"data-toggle="tooltip"
                            data-custom-class="tooltip-danger" data-placement="top" onclick="showAlert('alert-status')"
                            title="Non Aktifkan Pegawai">No</button>
                        </div>
                      </td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-light">Edit</button>
                          <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split"
                            id="dropdownMenuSplitButton1" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                            <a class="dropdown-item" onclick="showAlert('alert-hapus')" href="#">Hapus</a>
                            <a class="dropdown-item" href="#">Detail</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    (function($) {
      showAlert = function(type) {
        'use strict';
        if (type === 'alert-hapus') {
          swal({
            title: 'Perhatian',
            text: "Apakah anda yakin mengahapus data ini ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3f51b5',
            cancelButtonColor: '#ff4081',
            confirmButtonText: 'Great ',
            buttons: {
              cancel: {
                text: "Cancel",
                value: null,
                visible: true,
                className: "btn btn-danger",
                closeModal: true,
              },
              confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "btn btn-primary",
                closeModal: true
              }
            }
          })
        } else if (type === 'alert-status') {
          swal({
            title: 'Selamat',
            text: 'Data berhasil di ubah',
            icon: 'success',
            timer: 2000,
            button: false
          }).then(
            function() {},
            // handling the promise rejection
            function(dismiss) {
              if (dismiss === 'timer') {
                console.log('I was closed by the timer')
              }
            }
          )
        }
      }

    })(jQuery);
  </script>
@endsection
