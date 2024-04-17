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
    Edit Data Site
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('home') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('device.index') }}">Daftar Site</a>
                </li>

                <li class="breadcrumb-item active">Edit Site</li>
            </ol>
        </nav>

        <!-- Collapse -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Daftar Site</h5>

                        <a href="{{ route('device.index') }}">
                            <button type="button" class="btn btn-secondary btn-icon-text">
                                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                                Kembali
                            </button>
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('device.update', $device->id_sites) }}" method="POST" id="form"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label" for="name">Nama Site</label>

                                <input type="text" class="form-control" id="name_devices" name="name_devices"
                                    placeholder="Masukkan nama device"
                                    value="{{ $device->name_devices ?? old('name_devices') }}" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Alias</label>

                                <input type="text" class="form-control" id="alias_devices" name="alias_devices"
                                    placeholder="Masukkan nama alias device"
                                    value="{{ $device->alias_devices ?? old('alias_devices') }}" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="type">Pilih Tipe Site</label>

                                <select class="form-control select2" name="type" id="type" style="width: 100%">
                                    <option value="">Pilih Tipe Site</option>

                                    <option value="lamp" {{ IsSelected($device->type, 'lamp') }}>Lamp</option>
                                    <option value="ac" {{ IsSelected($device->type, 'ac') }}>AC (Air Conditioner)
                                    </option>
                                    <option value="humidifier" {{ IsSelected($device->type, 'humidifier') }}>Humidifier
                                    </option>
                                    <option value="fan" {{ IsSelected($device->type, 'fan') }}>Fan</option>
                                    <option value="door" {{ IsSelected($device->type, 'door') }}>Door</option>
                                    <option value="curtains" {{ IsSelected($device->type, 'curtains') }}>Curtains</option>
                                    <option value="window" {{ IsSelected($device->type, 'window') }}>Window</option>
                                    <option value="cctv" {{ IsSelected($device->type, 'cctv') }}>Cctv</option>
                                    <option value="stopkontak" {{ IsSelected($device->type, 'stopkontak') }}>Stopkontak
                                    </option>
                                </select>
                            </div>

                            <div class="mb-5 mt-5">
                                <div class="col-12">
                                    <h6 class="mt-2 fw-semibold"> Pilih icon device</h6>
                                    <hr class="mt-0">
                                </div>

                                <div class="row">

                                    @if (count($data_icon) > 0)
                                        @foreach ($data_icon as $index => $item)
                                            @if (Storage::disk('public')->exists($item->file_icons) && $item->file_icons)
                                                <div class="col-md mb-md-0 mb-2">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                            for="customRadioSvg1">
                                                            <span class="custom-option-body">
                                                                <img src="{{ Storage::url($item->file_icons) }}"
                                                                    class="w-px-40 mb-2" alt="paypal">
                                                            </span>
                                                            <input name="icons" class="form-check-input" type="radio"
                                                                value="{{ $item->id_icons }}"
                                                                id="icons{{ $index }}"
                                                                {{ $device->icons_id == $item->id_icons ? 'checked' : '' }}>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                            </div>

                            <div class="mb-5 mt-5">
                                <div class="col-12">
                                    <h6 class="mt-2 fw-semibold"> Pilih attribut device</h6>
                                    <hr class="mt-0">
                                </div>

                                <div class="row">

                                    {{-- attribute switch --}}
                                    <div class="col-md-4 mb-md-10 mb-5">
                                        <div class="card device-attribute">
                                            <div class="card-body">
                                                <div class="form-check custom-option custom-option-icon">
                                                    <label class="form-check-label custom-option-content"
                                                        for="is_switch_device_attribute_type">
                                                        <img src="{{ asset('admin-assets/assets/img/icons/unicons/turn-on.png') }}"
                                                            width="50" style="margin-bottom: 5px">

                                                        <h5 class="card-title">Attribute Switch</h5>
                                                        <p class="card-text">Berisikan controlling seperti tombol on dan
                                                            off.
                                                        </p>

                                                        <input name="is_switch_device_attribute_type"
                                                            class="form-check-input float-none"
                                                            style="margin-left: 0em !important" type="checkbox"
                                                            value="1" id="is_switch_device_attribute_type"
                                                            {{ $device->deviceattributetype->is_switch_device_attribute_type == '1' ? 'checked' : '' }}>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- attribute range --}}
                                    <div class="col-md-4 mb-md-10 mb-5">
                                        <div class="card device-attribute">
                                            <div class="card-body">
                                                <div class="form-check custom-option custom-option-icon">
                                                    <label class="form-check-label custom-option-content"
                                                        for="is_range_device_attribute_type">
                                                        <img src="{{ asset('admin-assets/assets/img/icons/unicons/slider.png') }}"
                                                            width="50" style="margin-bottom: 5px">

                                                        <h5 class="card-title">Attribute Range</h5>
                                                        <p class="card-text">Berisikan controlling seperti slider dengan
                                                            memiliki nilai minimal dan
                                                            maksimal.
                                                        </p>

                                                        <input name="is_range_device_attribute_type"
                                                            class="form-check-input float-none"
                                                            style="margin-left: 0em !important" type="checkbox"
                                                            value="1" id="is_range_device_attribute_type"
                                                            {{ $device->deviceattributetype->is_range_device_attribute_type == '1' ? 'checked' : '' }}>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- attribute color --}}
                                    <div class="col-md-4 mb-md-10 mb-5">
                                        <div class="card device-attribute">
                                            <div class="card-body">
                                                <div class="form-check custom-option custom-option-icon">
                                                    <label class="form-check-label custom-option-content"
                                                        for="is_color_device_attribute_type">
                                                        <img src="{{ asset('admin-assets/assets/img/icons/unicons/color-palette.png') }}"
                                                            width="50" style="margin-bottom: 5px">

                                                        <h5 class="card-title">Attribute Color</h5>
                                                        <p class="card-text">Berisikan controlling seperti mengubah warna.
                                                        </p>

                                                        <input name="is_color_device_attribute_type"
                                                            class="form-check-input float-none"
                                                            style="margin-left: 0em !important" type="checkbox"
                                                            value="1" id="is_color_device_attribute_type"
                                                            {{ $device->deviceattributetype->is_color_device_attribute_type == '1' ? 'checked' : '' }}>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- attribute mode --}}
                                    <div class="col-md-4 mb-md-10 mb-5">
                                        <div class="card device-attribute">
                                            <div class="card-body">
                                                <div class="form-check custom-option custom-option-icon">
                                                    <label class="form-check-label custom-option-content"
                                                        for="is_mode_device_attribute_type">
                                                        <img src="{{ asset('admin-assets/assets/img/icons/unicons/mode.png') }}"
                                                            width="50" style="margin-bottom: 5px">

                                                        <h5 class="card-title">Attribute Mode</h5>
                                                        <p class="card-text">Berisikan controlling seperti memindah mode.
                                                        </p>

                                                        <input name="is_mode_device_attribute_type"
                                                            class="form-check-input float-none"
                                                            style="margin-left: 0em !important" type="checkbox"
                                                            value="1" id="is_mode_device_attribute_type"
                                                            {{ $device->deviceattributetype->is_mode_device_attribute_type == '1' ? 'checked' : '' }}>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- attribute motion --}}
                                    <div class="col-md-4 mb-md-10 mb-5">
                                        <div class="card device-attribute">
                                            <div class="card-body">
                                                <div class="form-check custom-option custom-option-icon">
                                                    <label class="form-check-label custom-option-content"
                                                        for="is_motion_device_attribute_type">
                                                        <img src="{{ asset('admin-assets/assets/img/icons/unicons/motion-sensor.png') }}"
                                                            width="50" style="margin-bottom: 5px">

                                                        <h5 class="card-title">Attribute Gerak</h5>
                                                        <p class="card-text">Berisikan controlling seperti menggerakkan
                                                            object.
                                                        </p>

                                                        <input name="is_motion_device_attribute_type"
                                                            class="form-check-input float-none"
                                                            style="margin-left: 0em !important" type="checkbox"
                                                            value="is_motion_device_attribute_type"
                                                            id="is_motion_device_attribute_type"
                                                            {{ $device->deviceattributetype->is_motion_device_attribute_type == '1' ? 'checked' : '' }}>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- attribute lock --}}
                                    <div class="col-md-4 mb-md-10 mb-5">
                                        <div class="card device-attribute">
                                            <div class="card-body">
                                                <div class="form-check custom-option custom-option-icon">
                                                    <label class="form-check-label custom-option-content"
                                                        for="is_lock_device_attribute_type">
                                                        <img src="{{ asset('admin-assets/assets/img/icons/unicons/unlock.png') }}"
                                                            width="50" style="margin-bottom: 5px">

                                                        <h5 class="card-title">Attribute Kunci</h5>
                                                        <p class="card-text">Berisikan controlling seperti lock atau unlock
                                                            object.
                                                        </p>

                                                        <input name="is_lock_device_attribute_type"
                                                            class="form-check-input float-none"
                                                            style="margin-left: 0em !important" type="checkbox"
                                                            value="is_lock_device_attribute_type"
                                                            id="is_lock_device_attribute_type"
                                                            {{ $device->deviceattributetype->is_lock_device_attribute_type == '1' ? 'checked' : '' }}>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- attribute monitoring --}}
                                    <div class="col-md-4 mb-md-10 mb-5">
                                        <div class="card device-attribute">
                                            <div class="card-body">
                                                <div class="form-check custom-option custom-option-icon">
                                                    <label class="form-check-label custom-option-content"
                                                        for="is_monitoring_device_attribute_type">
                                                        <img src="{{ asset('admin-assets/assets/img/icons/unicons/security-camera.png') }}"
                                                            width="50" style="margin-bottom: 5px">

                                                        <h5 class="card-title">Attribute Kunci</h5>
                                                        <p class="card-text">Berisikan controlling untuk melihat object
                                                            dengan kamera.
                                                        </p>

                                                        <input name="is_monitoring_device_attribute_type"
                                                            class="form-check-input float-none"
                                                            style="margin-left: 0em !important" type="checkbox"
                                                            value="is_monitoring_device_attribute_type"
                                                            id="is_monitoring_device_attribute_type"
                                                            {{ $device->deviceattributetype->is_monitoring_device_attribute_type == '1' ? 'checked' : '' }}>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- display attribute switch --}}
                            <div class="mb-5 mt-5" id="display-attribute-switch" {!! $device->deviceattributetype->is_switch_device_attribute_type == '1' ? '' : 'style="display: none;"' !!}>
                                <div class="col-12">
                                    <h6 class="mt-2 fw-semibold"> Kondisi attribut switch device</h6>
                                    <hr class="mt-0">
                                </div>

                                {{-- show inputan detail dari attribute switch --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="label_switch_device_attribute_type">Nama atau Label
                                            Tombol
                                            Switch</label>

                                        <input type="text" class="form-control"
                                            id="label_switch_device_attribute_type"
                                            name="label_switch_device_attribute_type" placeholder="Nama label switch"
                                            value="{{ $device->deviceattributetype->label_switch_device_attribute_type ?? old('label_switch_device_attribute_type') }}" />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="name">Kondisi text on</label>

                                        <input type="text" class="form-control"
                                            id="on_txt_device_attribute_type_switch"
                                            name="on_txt_device_attribute_type_switch" placeholder="Menyala/Hidup/On"
                                            value="{{ $device->deviceattributetype->deviceattributetypeswitch->on_txt_device_attribute_type_switch ?? old('on_txt_device_attribute_type_switch') }}" />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="name">Kondisi text off</label>

                                        <input type="text" class="form-control"
                                            id="off_txt_device_attribute_type_switch"
                                            name="off_txt_device_attribute_type_switch" placeholder="Mati/Off"
                                            value="{{ $device->deviceattributetype->deviceattributetypeswitch->off_txt_device_attribute_type_switch ?? old('off_txt_device_attribute_type_switch') }}" />
                                    </div>
                                </div>
                                {{-- / show inputan detail dari attribute switch --}}
                            </div>
                            {{-- / display attribute switch --}}

                            {{-- display attribute range --}}
                            <div class="mb-5 mt-5" id="display-attribute-range" {!! $device->deviceattributetype->is_range_device_attribute_type == '1' ? '' : 'style="display: none;"' !!}>
                                <div class="col-12">
                                    <h6 class="mt-2 fw-semibold"> Kondisi attribut range device</h6>
                                    <hr class="mt-0">
                                </div>

                                {{-- show inputan detail dari attribute range --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="label_range_device_attribute_type">Nama atau Label
                                            Range</label>

                                        <input type="text" class="form-control" id="label_range_device_attribute_type"
                                            name="label_range_device_attribute_type" placeholder="Nama label range"
                                            value="{{ $device->deviceattributetype->label_range_device_attribute_type ?? old('label_range_device_attribute_type') }}" />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="name">Nilai minimal</label>

                                        <input type="number" class="form-control" id="min_device_attribute_type_range"
                                            name="min_device_attribute_type_range" placeholder="0"
                                            value="{{ $device->deviceattributetype->deviceattributetyperange->min_device_attribute_type_range ?? old('min_device_attribute_type_range') }}" />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="name">Nilai maksimal</label>

                                        <input type="number" class="form-control" id="max_device_attribute_type_range"
                                            name="max_device_attribute_type_range" placeholder="10"
                                            value="{{ $device->deviceattributetype->deviceattributetyperange->max_device_attribute_type_range ?? old('max_device_attribute_type_range') }}" />
                                    </div>
                                </div>
                                {{-- / show inputan detail dari attribute range --}}
                            </div>
                            {{-- / display attribute range --}}

                            {{-- display attribute color --}}
                            <div class="mb-5 mt-5" id="display-attribute-color" {!! $device->deviceattributetype->is_color_device_attribute_type == '1' ? '' : 'style="display: none;"' !!}>
                                <div class="col-12">
                                    <h6 class="mt-2 fw-semibold"> Kondisi attribut color device</h6>
                                    <hr class="mt-0">
                                </div>

                                {{-- show inputan detail dari attribute color --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="label_color_device_attribute_type">Nama atau Label
                                            Color</label>

                                        <input type="text" class="form-control" id="label_color_device_attribute_type"
                                            name="label_color_device_attribute_type" placeholder="Nama label color"
                                            value="{{ $device->deviceattributetype->label_color_device_attribute_type ?? old('label_color_device_attribute_type') }}" />
                                    </div>
                                </div>
                                {{-- / show inputan detail dari attribute color --}}
                            </div>
                            {{-- / display attribute color --}}

                            {{-- display attribute mode --}}
                            <div class="mb-5 mt-5" id="display-attribute-mode" {!! $device->deviceattributetype->is_mode_device_attribute_type == '1' ? '' : 'style="display: none;"' !!}>
                                <div class="col-12">
                                    <h6 class="mt-2 fw-semibold"> Kondisi attribut mode device</h6>
                                    <hr class="mt-0">
                                </div>

                                {{-- show inputan detail dari attribute mode --}}
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="label_mode_device_attribute_type">Nama atau Label
                                            Mode</label>

                                        <input type="text" class="form-control" id="label_mode_device_attribute_type"
                                            name="label_mode_device_attribute_type" placeholder="Nama label mode"
                                            value="{{ $device->deviceattributetype->label_mode_device_attribute_type ?? old('label_mode_device_attribute_type') }}" />
                                    </div>

                                    <div class="col-md-12 set-grid-attribute-mode mb-3">

                                        {{-- loop --}}
                                        @if (
                                            $device->deviceattributetype->is_mode_device_attribute_type == '1' ||
                                                count($device->deviceattributetype->deviceattributetypemode) > 0)
                                            @foreach ($device->deviceattributetype->deviceattributetypemode as $key => $item)
                                                <div class="card card-main mb-2">
                                                    <div class="card-body">
                                                        <div class="row grid-margin">
                                                            <div class="col-md-4 name_device_attribute_type_mode">
                                                                <input type="text" class="form-control"
                                                                    name="name_device_attribute_type_mode[]"
                                                                    id="name_device_attribute_type_mode"
                                                                    placeholder="Nama mode.."
                                                                    value="{{ $item->name_device_attribute_type_mode }}">
                                                            </div>

                                                            <div class="col-md-4 value_device_attribute_type_mode">
                                                                <input type="text" class="form-control"
                                                                    name="value_device_attribute_type_mode[]"
                                                                    id="value_device_attribute_type_mode"
                                                                    placeholder="Value parameter.."
                                                                    value="{{ $item->value_device_attribute_type_mode }}">
                                                            </div>

                                                            <div class="col-md-4">
                                                                <button type="button"
                                                                    class="btn float-right btn-danger btn-sm btn-remove-attribute-mode">Hapus
                                                                    Mode</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="card card-main mb-2">
                                                <div class="card-body">
                                                    <div class="row grid-margin">
                                                        <div class="col-md-4 name_device_attribute_type_mode">
                                                            <input type="text" class="form-control"
                                                                name="name_device_attribute_type_mode[]"
                                                                id="name_device_attribute_type_mode"
                                                                placeholder="Nama mode..">
                                                        </div>

                                                        <div class="col-md-4 value_device_attribute_type_mode">
                                                            <input type="text" class="form-control"
                                                                name="value_device_attribute_type_mode[]"
                                                                id="value_device_attribute_type_mode"
                                                                placeholder="Value parameter..">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <button type="button"
                                                                class="btn float-right btn-danger btn-sm btn-remove-attribute-mode">Hapus
                                                                Mode</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- /end loop --}}

                                    </div>

                                    <div class="col-md-12 text-center mb-3">
                                        <button type="button" class="btn btn-success btn-sm btn-add-attribute-mode"
                                            data-param="0">Tambah
                                            Mode</button>
                                    </div>
                                </div>
                                {{-- / show inputan detail dari attribute mode --}}
                            </div>
                            {{-- / display attribute mode --}}

                            {{-- display attribute motion --}}
                            <div class="mb-5 mt-5" id="display-attribute-motion" {!! $device->deviceattributetype->is_motion_device_attribute_type == '1' ? '' : 'style="display: none;"' !!}>
                                <div class="col-12">
                                    <h6 class="mt-2 fw-semibold"> Kondisi attribut motion device</h6>
                                    <hr class="mt-0">
                                </div>

                                {{-- show inputan detail dari attribute motion --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="label_motion_device_attribute_type">Nama atau Label
                                            Motion</label>

                                        <input type="text" class="form-control"
                                            id="label_motion_device_attribute_type"
                                            name="label_motion_device_attribute_type" placeholder="Nama label motion"
                                            value="{{ $device->deviceattributetype->label_motion_device_attribute_type ?? old('label_motion_device_attribute_type') }}" />
                                    </div>
                                </div>
                                {{-- / show inputan detail dari attribute motion --}}
                            </div>
                            {{-- / display attribute motion --}}

                            {{-- display attribute lock --}}
                            <div class="mb-5 mt-5" id="display-attribute-lock" {!! $device->deviceattributetype->is_lock_device_attribute_type == '1' ? '' : 'style="display: none;"' !!}>
                                <div class="col-12">
                                    <h6 class="mt-2 fw-semibold"> Kondisi attribut lock device</h6>
                                    <hr class="mt-0">
                                </div>

                                {{-- show inputan detail dari attribute lock --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="label_lock_device_attribute_type">Nama atau Label
                                            Lock</label>

                                        <input type="text" class="form-control" id="label_lock_device_attribute_type"
                                            name="label_lock_device_attribute_type" placeholder="Nama label lock"
                                            value="{{ $device->deviceattributetype->label_lock_device_attribute_type ?? old('label_lock_device_attribute_type') }}" />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="name">Kondisi unlock</label>

                                        <input type="text" class="form-control" id="on_txt_device_attribute_type_lock"
                                            name="on_txt_device_attribute_type_lock" placeholder="Membuka/On/1"
                                            value="{{ isset($device->deviceattributetype->deviceattributetypelock[0]->on_txt_device_attribute_type_lock) ? $device->deviceattributetype->deviceattributetypelock[0]->on_txt_device_attribute_type_lock : old('on_txt_device_attribute_type_lock') }}" />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="name">Kondisi lock</label>

                                        <input type="text" class="form-control"
                                            id="off_txt_device_attribute_type_lock"
                                            name="off_txt_device_attribute_type_lock" placeholder="Menutup/Off/0"
                                            value="{{ isset($device->deviceattributetype->deviceattributetypelock[0]->off_txt_device_attribute_type_lock) ? $device->deviceattributetype->deviceattributetypelock[0]->off_txt_device_attribute_type_lock : old('off_txt_device_attribute_type_lock') }}" />
                                    </div>
                                </div>
                                {{-- / show inputan detail dari attribute lock --}}
                            </div>
                            {{-- / display attribute lock --}}

                            {{-- display attribute monitoring --}}
                            <div class="mb-5 mt-5" id="display-attribute-monitoring" {!! $device->deviceattributetype->is_monitoring_device_attribute_type == '1' ? '' : 'style="display: none;"' !!}>
                                <div class="col-12">
                                    <h6 class="mt-2 fw-semibold"> Kondisi attribut monitoring device</h6>
                                    <hr class="mt-0">
                                </div>

                                {{-- show inputan detail dari attribute monitoring --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="label_monitoring_device_attribute_type">Nama atau
                                            Label
                                            Monitoring</label>

                                        <input type="text" class="form-control"
                                            id="label_monitoring_device_attribute_type"
                                            name="label_monitoring_device_attribute_type"
                                            placeholder="Nama label monitoring"
                                            value="{{ $device->deviceattributetype->label_monitoring_device_attribute_type ?? old('label_monitoring_device_attribute_type') }}" />
                                    </div>
                                </div>
                                {{-- / show inputan detail dari attribute lock --}}
                            </div>
                            {{-- / display attribute lock --}}

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
            $('.select2').select2({
                theme: "bootstrap-5"
            });

            // logic memilih attribut
            $('#is_switch_device_attribute_type').click(function() {
                if ($(this).is(":checked")) // "this" refers to the element that fired the event
                {
                    $('#display-attribute-switch').show();
                } else {
                    $('#display-attribute-switch').hide();
                }
            });

            $('#is_range_device_attribute_type').click(function() {
                if ($(this).is(":checked")) // "this" refers to the element that fired the event
                {
                    $('#display-attribute-range').show();
                } else {
                    $('#display-attribute-range').hide();
                }
            });

            $('#is_color_device_attribute_type').click(function() {
                if ($(this).is(":checked")) // "this" refers to the element that fired the event
                {
                    $('#display-attribute-color').show();
                } else {
                    $('#display-attribute-color').hide();
                }
            });

            $('#is_mode_device_attribute_type').click(function() {
                if ($(this).is(":checked")) // "this" refers to the element that fired the event
                {
                    $('#display-attribute-mode').show();
                } else {
                    $('#display-attribute-mode').hide();
                }
            });

            $('#is_motion_device_attribute_type').click(function() {
                if ($(this).is(":checked")) // "this" refers to the element that fired the event
                {
                    $('#display-attribute-motion').show();
                } else {
                    $('#display-attribute-motion').hide();
                }
            });

            $('#is_lock_device_attribute_type').click(function() {
                if ($(this).is(":checked")) // "this" refers to the element that fired the event
                {
                    $('#display-attribute-lock').show();
                } else {
                    $('#display-attribute-lock').hide();
                }
            });

            $('#is_monitoring_device_attribute_type').click(function() {
                if ($(this).is(":checked")) // "this" refers to the element that fired the event
                {
                    $('#display-attribute-monitoring').show();
                } else {
                    $('#display-attribute-monitoring').hide();
                }
            });

            // settingan jquery untuk attribute mode 
            $('.btn-add-attribute-mode').on('click', function() {
                var id_html = $('.card-main').length;
                var html =
                    `
            <div class="card card-main mb-2">
              <div class="card-body">
                <div class="row grid-margin">
                  <div class="col-md-4 name_device_attribute_type_mode">
                    <input type="text" class="form-control" name="name_device_attribute_type_mode[]"
                      id="name_device_attribute_type_mode" placeholder="Nama mode..">
                  </div>

                  <div class="col-md-4 value_device_attribute_type_mode">
                    <input type="text" class="form-control" name="value_device_attribute_type_mode[]"
                      id="value_device_attribute_type_mode" placeholder="Value parameter..">
                  </div>

                  <div class="col-md-4">
                    <button type="button" class="btn float-right btn-danger btn-sm btn-remove-attribute-mode">Hapus
                      Mode</button>
                  </div>
                </div>
              </div>
            </div>
          `;

                $('.set-grid-attribute-mode').append(html);
            });

            $('body').on('click', '.btn-remove-attribute-mode', function() {
                // $(this).parent().parent().parent().remove();

                if ($('.card-main').length > 1) {
                    $(this).parent().parent().parent().parent().remove();
                } else {
                    swal({
                        title: "Perhatian!",
                        text: "Anda harus menyisakan setidaknya satu mode untuk device Anda!",
                        icon: "warning",
                        button: "Mengerti!",
                    });
                }
            });

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
                                    document.location = '/device';
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
