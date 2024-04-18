@extends('admin.layouts.app')

@push('after-style')
    <style>
        .card.device-attribute:hover {
            box-shadow: 1px 1px 1px 1px #3498db;
            transform: scale(1);
        }

        .card.device-attribute>.form-check.form-check-input {
            float: none !important;
        }
    </style>
@endpush

@section('title')
    Tambah Data Site
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('home') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('site.index') }}">Daftar Site</a>
                </li>

                <li class="breadcrumb-item active">Tambah Site</li>
            </ol>
        </nav>

        <!-- Collapse -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tambah Daftar Site</h5>

                        <a href="{{ route('site.index') }}">
                            <button type="button" class="btn btn-secondary btn-icon-text">
                                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                                Kembali
                            </button>
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('site.store') }}" method="POST" id="form"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="name">Site ID</label>

                                <input type="text" class="form-control" id="site_id_number" name="site_id_number"
                                    placeholder="Masukkan nama device" value="{{ old('site_id_number') }}" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Site Name</label>

                                <input type="text" class="form-control" id="site_name" name="site_name"
                                    placeholder="Masukkan nama alias device" value="{{ old('site_name') }}" />
                            </div>


                            {{-- / display attribute monitoring --}}

                            <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        $(function() {

            $('.btn-simpan').on('click', function() {
                $('#form').ajaxForm({
                    success: function(response) {
                        if (response.status == true) {
                            swal({
                                    title: "Success!",
                                    text: response.pesan,
                                    icon: "success"
                                })
                                .then(function() {
                                    document.location = '/site';
                                });
                        } else {
                            var pesan = "";
                            var data_pesan = response.pesan;
                            const wrapper = document.createElement('div');

                            if (typeof(data_pesan) == 'object') {
                                jQuery.each(data_pesan, function(key, value) {
                                    console.log(value);
                                    pesan += value + '. <br>';
                                    wrapper.innerHTML = pesan;
                                });

                                swal({
                                    title: "Error!",
                                    content: wrapper,
                                    icon: "warning"
                                });
                            } else {
                                swal({
                                    title: "Error!",
                                    text: response.pesan,
                                    icon: "warning"
                                });
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        var err = eval("(" + jqXHR.responseText + ")");
                        swal("Error!", err.Message, "error");
                    }
                })
            })
        })
    </script>
@endpush
