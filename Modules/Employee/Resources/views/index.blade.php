@extends('admin.layouts.app')

@section('css')
@endsection

@section('page-title')
@endsection

@section('content')
  @include('admin.menu.masterdata')
  <div class="row">
    <div class="col-12">
      <div class="page-header">
        <div class="col">
          <div class="text-muted mt-1"></div>
          <h2 class="page-title">
            Data Pegawai
          </h2>
        </div>
        <nav aria-label="breadcrumb">
          {{-- akses craete --}}
          @if (isAccess('create', $get_module, auth()->user()->roles))
            <a href="{{ url(route('employee.create')) }}" class="btn btn-light w-9 me-2">
              <i class="fas fa-plus me-3"></i>
              Tambah
            </a>
          @endif
          {{-- akses export --}}
          @if (isAccess('export', $get_module, auth()->user()->roles))
            <a href="/employee-excel" class="btn btn-success w-9 me-2">
              <i class="fas fa-file-excel me-3"></i>
              Export
            </a>
          @endif
          {{-- akses import --}}
          @if (isAccess('import', $get_module, auth()->user()->roles))
            <a href="/import" class="btn btn-info w-9 me-2">
              <i class="fas fa-download me-3"></i>
              Import
            </a>
          @endif
        </nav>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-vcenter table-mobile-md card-table dt-responsive nowrap"
              id="smt-table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Pegawai</th>
                  <th>Nomor Telepon</th>
                  <th>Jabatan</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              {{-- akses read --}}
              @if (isAccess('read', $get_module, auth()->user()->roles))
                <tbody id="tabel-body"></tbody>
              @endif
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
@endsection
@section('script')
  <script>
    $(function() {
      var table = $('#smt-table').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        ajax: '/employee-data',
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'name_employee',
            name: 'name_employee'
          },
          {
            data: 'phone_employee',
            name: 'phone_employee'
          },
          {
            data: 'set_posisi',
            name: 'set_posisi'
          },
          {
            data: 'set_status',
            name: 'set_status'
          },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
          }
        ],
        columnDefs: [{
          width: 25,
          targets: 0
        }],
      });
      table.on('draw', function() {
        $('[data-toggle="tooltip"]').tooltip();
      });
      //delete
      $('#tabel-body').on('click', '.btn-hapus', function() {
        var kode = $(this).data('id');
        var nama = $(this).data('nama');
        swal({
            title: "Apakah anda yakin?",
            text: "Untuk menghapus data : " + nama,
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                type: 'ajax',
                method: 'get',
                url: '/employee-destroy/' + kode,
                async: true,
                dataType: 'json',
                success: function(response) {
                  if (response == true) {
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
    });
  </script>
@endsection
