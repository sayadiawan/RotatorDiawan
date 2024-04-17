@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
    Data Smart Home
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('home') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item active">Data Site</li>
            </ol>
        </nav>

        <!-- Collapse -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Site</h5>

                        @if (isAccess('create', $get_module, auth()->user()->roles))
                            <a href="{{ route('smarthome.create') }}">
                                <button type="button" class="btn btn-primary btn-icon-text">
                                    <i class="fa fa-plus btn-icon-prepend"></i>
                                    Tambah
                                </button>
                            </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">

                            <form action="{{ route('smarthome.index') }}" method="GET" id="form-search">
                                <div class="col-md-6 mb-3 float-end">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text" id="basic-addon-search31"><i
                                                class="bx bx-search"></i></span>
                                        <input type="text" class="form-control" placeholder="Search..."
                                            aria-label="Search..." aria-describedby="basic-addon-search31" name="search"
                                            id="smarthome_search" value="{{ request('search') }}">

                                        <button type="submit" class="btn btn-secondary" id="button-search">Cari</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                        <div class="row" id="list-smarthomes">

                            @if (isAccess('read', $get_module, auth()->user()->roles))
                                @if (count($result) > 0)
                                    {{-- loop --}}
                                    @foreach ($result as $item)
                                        <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                                            <div class="card h-100 border border-primary">
                                                <div
                                                    class="card-header d-flex align-items-center justify-content-between pb-10">
                                                    <div class="card-title mb-0">
                                                        <h5 class="m-0 me-2">{{ $item-> }}</h5>
                                                        <small class="text-muted">{{ $item->user->name }}</small>
                                                    </div>

                                                    <div class="dropdown">
                                                        <button class="btn p-0" type="button" id="orederStatistics"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end"
                                                            aria-labelledby="orederStatistics">
                                                            <a class="dropdown-item"
                                                                href="{{ url('smarthome/device', $item->id_smarthomes) }}">Lihat
                                                                Site</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item"
                                                                href="{{ route('smarthome.show', $item->id_smarthomes) }}">Detail</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('smarthomedevicemqtt.device.index', $item->id_smarthomes) }}">Detail
                                                                MQTT</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('smarthome.edit', $item->id_smarthomes) }}">Edit</a>
                                                            <a class="dropdown-item btn-hapus text-danger"
                                                                href="javascript:void(0);"
                                                                data-id="{{ $item->id_smarthomes }}"
                                                                data-nama="{{ $item->user->name . ' - ' . $item->room->name_rooms }}">Hapus</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                @php
                                                    $count_smarthomedevice = \Modules\SmartHomeDevice\Entities\SmartHomeDevice::where(
                                                        'smarthomes_id',
                                                        $item->id_smarthomes,
                                                    )
                                                        ->whereHas('device', function ($query) {
                                                            return $query->whereNull('deleted_at');
                                                        })
                                                        ->count();
                                                @endphp

                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div class="d-flex flex-column align-items-center gap-1">
                                                            <h2 class="mb-2">{{ $count_smarthomedevice }}</h2>
                                                            <span>Total Site</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{-- loop --}}


                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            {{ $result->appends($_GET)->links() }}
                                        </ul>
                                    </nav>
                                @else
                                    <div class="col-md-12 text-center">
                                        <h5 class="card-title">Sorry!</h5>
                                        <p class="card-text">Data {!! '<strong>' . request('search') . '</strong>' !!} tidak ditemukan atau tidak
                                            ada data yang terkait.
                                        </p>
                                        @if (isAccess('create', $get_module, auth()->user()->roles))
                                            <a href="{{ route('smarthome.create') }}" class="btn btn-primary">Tambahkan
                                                Data</a>
                                        @endif
                                    </div>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        $(function() {
            $('#list-smarthomes').on('click', '.btn-hapus', function() {
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
                                url: '/smarthome/delete/' + kode,
                                async: true,
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status == true) {
                                        swal({
                                                title: "Success!",
                                                text: response.pesan,
                                                icon: "success"
                                            })
                                            .then(function() {
                                                location.reload(true);
                                            });
                                    } else {
                                        swal("Hapus Data Gagal!", {
                                            icon: "warning",
                                            title: "Failed!",
                                            text: response.pesan,
                                        });
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    var err = eval("(" + jqXHR.responseText + ")");
                                    swal("Error!", err.Message, "error");
                                }
                            });
                        } else {
                            swal("Cancelled", "Hapus Data Dibatalkan.", "error");
                        }
                    });
            });
        });
    </script>
@endpush
