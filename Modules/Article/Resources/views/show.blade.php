@extends('admin.layouts.app')

@section('css')
@endsection

@section('page-title')
  @include('admin.page-title')
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <div class="d-sm-flex justify-content-center justify-content-sm-between mb-3">
            <div class="text-sm-left d-block d-sm-inline-block">
              <h4 class="card-title">Detail Data Artikel
              </h4>
            </div>
            <div class="float-sm-right d-block mt-1 mt-sm-0">
              <a href="/article">
                <button type="button" class="btn btn-sm btn-outline-primary btn-icon-text"><i
                    class="fa fa-chevron-left text-dark btn-icon-prepend"></i> Kembali</button>
              </a>
            </div>
          </div>
          <form action="{{ route('article.update', [$get_data->id_article]) }}" method="POST" id="form"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="PUT" name="_method">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Judul</label>
                  <div class="col-sm-10">
                    <label class="col-form-label">: {{ $get_data->title_article }}</label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tanggal</label>
                  <div class="col-sm-10">
                    <label class="col-form-label">: {{ fdate($get_data->date_article, 'DDMMYYYY') }}</label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Isi</label>
                  <div class="col-sm-10">
                    {!! $get_data->content_article !!}
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Gambar</label>
                  <div class="col-sm-10">
                    @php
                      if (!empty($get_data->thumbnail_article)) {
                          $url = asset('storage/images/artikel_thub/' . $get_data->thumbnail_article);
                      } else {
                          $url = null;
                      }
                    @endphp
                    <img src="{{ $url }}" alt="" style="width:30%">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">status</label>
                  <div class="col-sm-10">
                    <label class="col-form-label">: {{ reference('status', $get_data->publish) }}</label>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
@endsection
