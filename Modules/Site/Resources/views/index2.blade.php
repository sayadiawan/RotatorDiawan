@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
    Daftar Site
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('home') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item active">Daftar Site</li>
            </ol>
        </nav>

        <!-- Collapse -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Site</h5>

                        @if (isAccess('create', $get_module, auth()->user()->roles))
                            <a href="{{ route('device.create') }}">
                                <button type="button" class="btn btn-primary btn-icon-text">
                                    <i class="fa fa-plus btn-icon-prepend"></i>
                                    Tambah
                                </button>
                            </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="table-daftar-device" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Site</th>
                                        <th>Tipe Site</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                @if (isAccess('read', $get_module, auth()->user()->roles))
                                    <tbody class="table-border-bottom-0">
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(function() {
            var table = $('#table-daftar-device').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                responsive: true,
                ajax: {
                    url: "{{ route('device.index') }}",
                    type: "GET",
                    data: function(d) {
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name_devices',
                        name: 'name_devices'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            table.on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });



            // datatables responsive
            new $.fn.dataTable.FixedHeader(table);

            //delete
            $('#table-daftar-device').on('click', '.btn-hapus', function() {
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
                                method: 'DELETE',
                                url: 'device/delete/',
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
        })
    </script>
@endpush
