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
              <h4 class="card-title">Edit Data Artikel
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
                    <input type="text" name="title_article" value="{{ $get_data->title_article }}" class="form-control"
                      placeholder="Judul..">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tanggal</label>
                  <div class="col-sm-10">
                    <input type="date" name="date_article" value="{{ $get_data->date_article }}" class="form-control">
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Isi</label>
                  <div class="col-sm-10">
                    <textarea name="content_article" id="content_article" class="form-control my-editor" cols="30" rows="3">{{ $get_data->content_article }}</textarea>
                    <small class="form-hint"></small>
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
                    <input type="file" name="thumbnail_article" id="thumbnail_article" class="dropify"
                      data-default-file="{{ $url }}" />
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">status</label>
                  <div class="col-sm-10">
                    <select name="publish" id="publish" class="js-example-basic-single width-100"
                      data-placeholder="Pilih Status">
                      <option value="1" {{ IsSelected($get_data->publish, '1') }}>Aktif</option>
                      <option value="0" {{ IsSelected($get_data->publish, '0') }}>Tidak Aktif</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="ml-mt-button">
              <button type="submit" class="btn btn-simpan btn-primary mr-2">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('vendors/tinymce/themes/modern/theme.js') }}"></script>
  <script>
    $(function() {
      //on load
      $('.dropify').dropify();
      $('#datepicker-popup').datepicker({
        enableOnReadonly: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
      });
      $(".js-example-basic-single").select2();

      $('.btn-simpan').on('click', function() {
        $('#form').ajaxForm({
          success: function(response) {
            if (response.status == true) {
              swal({
                  title: "Success!",
                  text: "Berhasil Menyimpan Data",
                  icon: "success"
                })
                .then(function() {
                  document.location = '/article';
                });
            } else {
              var pesan = "";
              jQuery.each(response.pesan, function(key, value) {
                pesan += value + '. ';
              });
              swal("Error!", pesan, "error");
            }
          },
          error: function() {
            swal("Error!", "Proses Gagal", "error");
          }
        })
      })

      //text editor
      var editor_config = {
        path_absolute: "/",
        selector: "textarea.my-editor",
        plugins: [
          "advlist autolink lists link image charmap print preview hr anchor pagebreak",
          "searchreplace wordcount visualblocks visualchars code fullscreen",
          "insertdatetime media nonbreaking save table contextmenu directionality",
          "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
        file_browser_callback: function(field_name, url, type, win) {
          var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
              'body')[0]
            .clientWidth;
          var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName(
            'body')[
            0].clientHeight;

          var cmsURL = editor_config.path_absolute + 'file-manager?field_name=' + field_name;
          if (type == 'image') {
            cmsURL = cmsURL + "&type=Images";
          } else {
            cmsURL = cmsURL + "&type=Files";
          }

          tinyMCE.activeEditor.windowManager.open({
            file: cmsURL,
            title: 'Filemanager',
            width: x * 0.8,
            height: y * 0.8,
            resizable: "yes",
            close_previous: "no"
          });
        }
      };

      tinymce.init(editor_config);
    })
  </script>
@endsection
