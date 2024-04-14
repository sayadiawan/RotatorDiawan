@extends('admin.layouts.app')

@push('after-style')
  <link rel="stylesheet" href="{{ asset('admin-assets/assets/vendor/css/pages/page-account-settings.css') }}" />
@endpush

@section('title')
  Detail Daftar Device
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item">
          <a href="{{ route('device.index') }}">Daftar Device</a>
        </li>

        <li class="breadcrumb-item active">Detail Daftar Device</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Daftar Device</h5>

            <a href="{{ route('device.index') }}">
              <button type="button" class="btn btn-secondary btn-icon-text">
                <i class="fas fa-arrow-left btn-icon-prepend"></i>
                Kembali
              </button>
            </a>
          </div>

          <div class="card-body">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="name_devices">Nama Device</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ $get_data->name_devices }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="type">Tipe Device</label>
              <div class="col-sm-10">
                <label class="col-form-label">: {{ ucwords($get_data->type) }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="type">Icon Device</label>
              <div class="col-sm-10">
                <label class="col-form-label">:
                  @if (Storage::disk('public')->exists($get_data->icon->file_icons) && $get_data->icon->file_icons)
                    <img src="{{ Storage::url($get_data->icon->file_icons) }}" width="50" alt=""
                      srcset="">
                  @endif
                </label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="type">Attribute Device Switch</label>
              <div class="col-sm-10">
                <label class="col-form-label">:
                  {{ $get_data->deviceattributetype->is_switch_device_attribute_type == '1' ? 'Ada' : 'Tidak Pakai' }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="type">Attribute Device Range</label>
              <div class="col-sm-10">
                <label class="col-form-label">:
                  {{ $get_data->deviceattributetype->is_range_device_attribute_type == '1' ? 'Ada' : 'Tidak Pakai' }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="type">Attribute Device Color</label>
              <div class="col-sm-10">
                <label class="col-form-label">:
                  {{ $get_data->deviceattributetype->is_color_device_attribute_type == '1' ? 'Ada' : 'Tidak Pakai' }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="type">Attribute Device Mode</label>
              <div class="col-sm-10">
                <label class="col-form-label">:
                  {{ $get_data->deviceattributetype->is_mode_device_attribute_type == '1' ? 'Ada' : 'Tidak Pakai' }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="type">Attribute Device Motion</label>
              <div class="col-sm-10">
                <label class="col-form-label">:
                  {{ $get_data->deviceattributetype->is_motion_device_attribute_type == '1' ? 'Ada' : 'Tidak Pakai' }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="type">Attribute Device Lock</label>
              <div class="col-sm-10">
                <label class="col-form-label">:
                  {{ $get_data->deviceattributetype->is_lock_device_attribute_type == '1' ? 'Ada' : 'Tidak Pakai' }}</label>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="type">Attribute Device Monitoring</label>
              <div class="col-sm-10">
                <label class="col-form-label">:
                  {{ $get_data->deviceattributetype->is_monitoring_device_attribute_type == '1' ? 'Ada' : 'Tidak Pakai' }}</label>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- <div class="col-md-12 d-none">
        <div class="form-group">
          <div class="form-row align-items-center" id="fields-1">
            <div class="col-md-12">
              <label for="email">Device Integration</label>

              <textarea rows="10" type="text" class="form-control" readonly id="device-integration" name="username"
                placeholder="Device Integration">{!! $code !!}</textarea>
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
          <h5 class="card-header">Device Integration</h5>
          <div class="card-body">
            <p>An API key is a simple encrypted string that identifies an application without any principal. They are
              useful
              for accessing public data anonymously, and are used to associate API requests with your project for quota
              and
              billing.</p>
            <div class="row">
              <div class="col-md-12">
                <div class="bg-lighter rounded p-3 position-relative mb-3">
                  {{-- Button action --}}
                  {{-- <div class="dropdown api-key-actions">
                    <a class="btn dropdown-toggle text-muted hide-arrow p-0" data-bs-toggle="dropdown"><i
                        class="bx bx-dots-vertical-rounded"></i></a>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a href="javascript:;" class="dropdown-item"><i class="bx bx-pencil me-2"></i>Edit</a>
                      <a href="javascript:;" class="dropdown-item"><i class="bx bx-trash me-2"></i>Delete</a>
                    </div>
                  </div> --}}

                  <div class="d-flex align-items-center flex-wrap mb-3">
                    <h4 class="mb-0 me-3">Client ID</h4>
                    <span class="badge bg-label-primary">Read Only</span>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <span class="fw-semibold me-3">c8879e6e-db31-44e4-905e-ee87f238076a</span>
                    <span class="text-muted cursor-pointer"><i class="bx bx-copy"></i></span>
                  </div>
                  {{-- <span>Created on 12 Feb 2021, 10:30 GTM+2:30</span> --}}
                </div>

                <div class="bg-lighter rounded p-3 position-relative mb-3">
                  {{-- Button action --}}
                  {{-- <div class="dropdown api-key-actions">
                    <a class="btn dropdown-toggle text-muted hide-arrow p-0" data-bs-toggle="dropdown"><i
                        class="bx bx-dots-vertical-rounded"></i></a>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a href="javascript:;" class="dropdown-item"><i class="bx bx-pencil me-2"></i>Edit</a>
                      <a href="javascript:;" class="dropdown-item"><i class="bx bx-trash me-2"></i>Delete</a>
                    </div>
                  </div> --}}

                  <div class="d-flex align-items-center flex-wrap mb-3">
                    <h4 class="mb-0 me-3">User ID</h4>
                    <span class="badge bg-label-primary">Read Only</span>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <span class="fw-semibold me-3">c8879e6e-db31-44e4-905e-ee87f238076a</span>
                    <span class="text-muted cursor-pointer"><i class="bx bx-copy"></i></span>
                  </div>
                  {{-- <span>Created on 12 Feb 2021, 10:30 GTM+2:30</span> --}}
                </div>

                <div class="bg-lighter rounded p-3 position-relative mb-3">
                  {{-- Button action --}}
                  {{-- <div class="dropdown api-key-actions">
                    <a class="btn dropdown-toggle text-muted hide-arrow p-0" data-bs-toggle="dropdown"><i
                        class="bx bx-dots-vertical-rounded"></i></a>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a href="javascript:;" class="dropdown-item"><i class="bx bx-pencil me-2"></i>Edit</a>
                      <a href="javascript:;" class="dropdown-item"><i class="bx bx-trash me-2"></i>Delete</a>
                    </div>
                  </div> --}}

                  <div class="d-flex align-items-center flex-wrap mb-3">
                    <h4 class="mb-0 me-3">ID Device</h4>
                    <span class="badge bg-label-primary">Read Only</span>
                  </div>
                  <div class="d-flex align-items-center mb-2">
                    <span class="fw-semibold me-3">{{ $id }}</span>
                    <span class="text-muted cursor-pointer"><i class="bx bx-copy"></i></span>
                  </div>
                  {{-- <span>Created on 12 Feb 2021, 10:30 GTM+2:30</span> --}}
                </div>
              </div>

              <div class="col-md-12" id="fields-1">
                <button class="btn btn-primary" id="copy">Copy</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('after-script')
@endpush
