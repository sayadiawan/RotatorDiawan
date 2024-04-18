@extends('admin.layouts.app')

@push('after-style')
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/vendor/css/pages/page-account-settings.css') }}" />
@endpush

@section('title')
    Detail Daftar Site
@endsection

@section('content')
    <link type="text/css" rel="stylesheet" href="{{ asset('admin-assets/assets/css/angle.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('admin-assets/assets/css/compass.css') }}" />
    <script src="https://code.jquery.com/jquery-1.12.2.min.js"></script>
    <script type="text/javascript" src="{{ asset('admin-assets/assets/js/jquery.angle.js') }}"></script>
    <script>
        var degrees = 0;
    </script>



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
                            <div class="col-md-8">
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

                            <div class="col-md-4">
                                <div class="container noselect" style="--bodycolor:rgb(219, 215, 179);">
                                    <div class="heading"></div>
                                    <div class="compass">
                                        <div class="moving">
                                            <div class="outer"></div>
                                            <div class="inner">
                                                <!-- degrees -->
                                                <div class="degs">
                                                    <span style="--i:0;"></span>
                                                    <span style="--i:1;"></span>
                                                    <span style="--i:2;"></span>
                                                    <span style="--i:3;"></span>
                                                    <span style="--i:4;"></span>
                                                    <span style="--i:5;"></span>
                                                    <span style="--i:6;"></span>
                                                    <span style="--i:7;"></span>
                                                    <span style="--i:8;"></span>
                                                    <span style="--i:9;"></span>
                                                    <span style="--i:10;"></span>
                                                    <span style="--i:11;"></span>
                                                    <span style="--i:12;"></span>
                                                    <span style="--i:13;"></span>
                                                    <span style="--i:14;"></span>
                                                    <span style="--i:15;"></span>
                                                    <span style="--i:16;"></span>
                                                    <span style="--i:17;"></span>
                                                    <span style="--i:18;"></span>
                                                    <span style="--i:19;"></span>
                                                    <span style="--i:20;"></span>
                                                    <span style="--i:21;"></span>
                                                    <span style="--i:22;"></span>
                                                    <span style="--i:23;"></span>
                                                    <span style="--i:24;"></span>
                                                    <span style="--i:25;"></span>
                                                    <span style="--i:26;"></span>
                                                    <span style="--i:27;"></span>
                                                    <span style="--i:28;"></span>
                                                    <span style="--i:29;"></span>
                                                    <span style="--i:30;"></span>
                                                    <span style="--i:31;"></span>
                                                    <span style="--i:32;"></span>
                                                    <span style="--i:33;"></span>
                                                    <span style="--i:34;"></span>
                                                    <span style="--i:35;"></span>
                                                </div>
                                                <div class="degcircshape">
                                                    <span style="--i:1;">10</span>
                                                    <span style="--i:2;">20</span>
                                                    <span style="--i:3;">30</span>
                                                    <span style="--i:4;">40</span>
                                                    <span style="--i:5;">50</span>
                                                    <span style="--i:6;">60</span>
                                                    <span style="--i:7;">70</span>
                                                    <span style="--i:8;">80</span>
                                                    <span style="--i:10;">100</span>
                                                    <span style="--i:11;">110</span>
                                                    <span style="--i:12;">120</span>
                                                    <span style="--i:13;">130</span>
                                                    <span style="--i:14;">140</span>
                                                    <span style="--i:15;">150</span>
                                                    <span style="--i:16;">160</span>
                                                    <span style="--i:17;">170</span>
                                                    <span style="--i:19;">190</span>
                                                    <span style="--i:20;">200</span>
                                                    <span style="--i:21;">210</span>
                                                    <span style="--i:22;">220</span>
                                                    <span style="--i:23;">230</span>
                                                    <span style="--i:24;">240</span>
                                                    <span style="--i:25;">250</span>
                                                    <span style="--i:26;">260</span>
                                                    <span style="--i:28;">280</span>
                                                    <span style="--i:29;">290</span>
                                                    <span style="--i:30;">300</span>
                                                    <span style="--i:31;">310</span>
                                                    <span style="--i:32;">320</span>
                                                    <span style="--i:33;">330</span>
                                                    <span style="--i:34;">340</span>
                                                    <span style="--i:35;">350</span>
                                                </div>
                                                <!-- quarters -->
                                                <div class="quarters">
                                                    <span style="--i:0;"></span>
                                                    <span style="--i:9;"></span>
                                                    <span style="--i:18;"></span>
                                                    <span style="--i:27;"></span>
                                                </div>
                                                <div class="quartercircshape">
                                                    <span style="--i:0;">000</span>
                                                    <span style="--i:9;">090</span>
                                                    <span style="--i:18;">180</span>
                                                    <span style="--i:27;">270</span>
                                                </div>
                                                <div class="needle">
                                                    <div class="circle"></div>
                                                    <span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- static needle -->
                                        <div class="static">
                                            <div class="axis"></div>
                                            <div class="arrow">
                                                <div class="head"></div>
                                                <div class="body"></div>
                                            </div>
                                            <!-- gauge shine -->
                                            <div class="gauge-shine"></div>
                                        </div>
                                    </div>
                                    <div class="gear-container">
                                        <div class="gear">
                                            <div class="center">
                                                <div class="outerarrow"></div>
                                                <div class="innerarrow"></div>
                                            </div>
                                            <div class="tooth" style="--i:0;"></div>
                                            <div class="tooth" style="--i:1;"></div>
                                            <div class="tooth" style="--i:2;"></div>
                                            <div class="tooth" style="--i:3;"></div>
                                            <div class="tooth" style="--i:4;"></div>
                                            <div class="tooth" style="--i:5;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="{{ asset('admin-assets/assets/js/compass.js') }}"></script>
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
