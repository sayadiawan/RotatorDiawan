@extends('admin.layouts.app')

@push('after-style')
@endpush

@section('title')
  Data Icon
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ url('home') }}">Dashboard</a>
        </li>

        <li class="breadcrumb-item active">Data Icon</li>
      </ol>
    </nav>

    <!-- Collapse -->
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Icon</h5>

            @if (isAccess('create', $get_module, auth()->user()->roles))
              <a href="{{ route('icon.create') }}">
                <button type="button" class="btn btn-primary btn-icon-text">
                  <i class="fa fa-plus btn-icon-prepend"></i>
                  Tambah
                </button>
              </a>
            @endif
          </div>

          <div class="card-body">

            @if (isAccess('read', $get_module, auth()->user()->roles))
              <div class="row mb-3">

                <form action="{{ route('icon.index') }}" method="GET" id="form-search">
                  <div class="col-md-6 mb-3 float-end">
                    <div class="input-group input-group-merge">
                      <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                      <input type="text" class="form-control" placeholder="Search..." aria-label="Search..."
                        aria-describedby="basic-addon-search31" name="search" id="icon_search"
                        value="{{ request('search') }}">

                      <button type="submit" class="btn btn-secondary" id="button-search">Cari</button>
                    </div>
                  </div>
                </form>

              </div>

              <div class="row" id="list-icons">

                @if (count($result) > 0)
                  {{-- loop --}}
                  @foreach ($result as $item)
                    @if (Storage::disk('public')->exists($item->file_icons) && $item->file_icons)
                      <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100">
                          <div class="card-body">
                            <h5 class="card-title">{{ $item->originalfilename_icons }}</h5>
                            <h6 class="card-subtitle text-muted">{{ $item->mimetype_icons }}</h6>
                          </div>

                          <div style="text-align: center !important">
                            <img class="img-fluid" width="200" src="{{ Storage::url($item->file_icons) }}"
                              alt="Icon">
                          </div>

                          <div class="card-body">
                            <p class="card-text">{{ $item->file_icons }}</p>
                            <a href="{{ route('icon.edit', $item->id_icons) }}" class="card-link">Edit</a>
                            <a href="javascript:void(0);" class="card-link text-danger btn-hapus"
                              data-nama="{{ $item->originalfilename_icons }}" data-id="{{ $item->id_icons }}">Hapus</a>
                          </div>
                        </div>
                      </div>
                    @endif
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
                      <a href="{{ route('icon.create') }}" class="btn btn-primary">Tambahkan Data</a>
                    @endif
                  </div>
                @endif

              </div>
            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('after-script')
  <script>
    $(function() {
      $('#list-icons').on('click', '.btn-hapus', function() {
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
                url: '/icon/delete/' + kode,
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
