@extends('admin.layouts.app')

@push('after-style')
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/vendor/css/pages/page-account-settings.css') }}" />
@endpush

@section('title')
    Detail Daftar Site
@endsection

@section('content')
    <link type="text/css" rel="stylesheet" href="{{ asset('admin-assets/assets/css/angle.css') }}" />
    <script src="https://code.jquery.com/jquery-1.12.2.min.js"></script>
    <script type="text/javascript" src="{{ asset('admin-assets/assets/js/jquery.angle.js') }}"></script>
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('home') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('site.index') }}">Daftar Site</a>
                </li>

                <li class="breadcrumb-item active">Detail Daftar Site</li>
            </ol>
        </nav>

        <!-- Collapse -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Daftar Site</h5>

                        <a href="{{ route('site.index') }}">
                            <button type="button" class="btn btn-secondary btn-icon-text">
                                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                                Kembali
                            </button>
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name_devices">Site ID</label>
                            <div class="col-sm-10">
                                <label class="col-form-label">: {{ $get_data->site_id_number }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="type">Site Name</label>
                            <div class="col-sm-10">
                                <label class="col-form-label">: {{ ucwords($get_data->site_name) }}</label>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            {{-- <div class="col-md-12 d-none">
        <div class="form-group">
          <div class="form-row align-items-center" id="fields-1">
            <div class="col-md-12">
              <label for="email">Site Integration</label>

              <textarea rows="10" type="text" class="form-control" readonly id="device-integration" name="username"
                placeholder="Site Integration">{!! $code !!}</textarea>
            </div>
          </div>
        </div>
        <div class="form-group" style="margin-top: 10px">
          <div class="form-row align-items-center" id="fields-1">

            <div class="col-md-12">
              <button class="btn btn-primary" id="copy">Copy</button>
            </div>

          </div>
        </div>
      </div> --}}
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="card mb-4">
                    <h5 class="card-header">Site Angle</h5>
                    <div class="card-body">
                        <p>Silahkan sesuaikan arah yang diinginkan :</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bg-lighter rounded p-3 position-relative mb-3">
                                    <div class="angle-view" id="angle-view1">
                                        <ul>




                                            <li><img src="{{ asset('admin-assets/assets/img/rotate/01.png') }}"
                                                    alt="01" /></li>
                                            <li><img src="{{ asset('admin-assets/assets/img/rotate/02.png') }}"
                                                    alt="02" /></li>
                                            <li><img src="{{ asset('admin-assets/assets/img/rotate/03.png') }}"
                                                    alt="03" /></li>
                                            <li><img src="{{ asset('admin-assets/assets/img/rotate/04.png') }}"
                                                    alt="04" /></li>
                                            <li><img src="{{ asset('admin-assets/assets/img/rotate/05.png') }}"
                                                    alt="05" /></li>
                                            <li><img src="{{ asset('admin-assets/assets/img/rotate/06.png') }}"
                                                    alt="06" /></li>
                                            <li><img src="{{ asset('admin-assets/assets/img/rotate/07.png') }}"
                                                    alt="07" /></li>
                                            <li><img src="{{ asset('admin-assets/assets/img/rotate/08.png') }}"
                                                    alt="08" /></li>
                                            <li><img src="{{ asset('admin-assets/assets/img/rotate/09.png') }}"
                                                    alt="09" /></li>
                                            <li><img src="{{ asset('admin-assets/assets/img/rotate/10.png') }}"
                                                    alt="10" /></li>
                                        </ul>
                                    </div>
                                    <p style="text-align:center; margin-bottom:50px;">
                                        <button class="btn btn-primary prev-image"><i class="fa fa-angle-left"></i></button>
                                        <button class="btn btn-primary next-image"><i
                                                class="fa fa-angle-right"></i></button>
                                    </p>


                                </div>


                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#angle-view1').angle({
                speed: 1,
                previous: '.prev-image',
                next: '.next-image',
            });
        });
    </script>
@endpush
