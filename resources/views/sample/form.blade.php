@extends('admin.layouts.app')

@section('css')
@endsection

@section('page-title')
@endsection

@section('content')
  <div class="row justify-content-center">
    <div class="col-8 grid-margin">
      <div class="card">
        <div class="card-body">
          <div class="fc-toolbar fc-header-toolbar">
            <div class="fc-left">
              <h4 class="card-title">Tambah Data Pegawai</h4>
            </div>
            <div class="fc-center"></div>
            <div class="fc-right">
              <button type="button" class="btn btn-sm btn-outline-primary btn-icon-text"><i
                  class="fa fa-chevron-left text-dark btn-icon-prepend"></i> Kembali</button>
            </div>
          </div>
          <hr class="mt-4">
          <form class="form-sample">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NIP</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nip" placeholder="Masukkan NIP" />
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nama Pegawai</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama_pegawai" placeholder="Masukkan Nama Lengkap" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                  <div class="col-sm-2">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios1"
                          value="" checked>
                        Laki-laki
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios2"
                          value="option2">
                        Perempuan
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                  <div class="col-sm-10">
                    <div id="datepicker-popup" class="input-group date datepicker">
                      <input type="text" class="form-control">
                      <span class="input-group-addon input-group-append border-left">
                        <span class="far fa-calendar input-group-text icon-size-form"></span>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Kota/Kab</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <select class="js-example-basic-single width-100" data-placeholder="Pilih Kota/Kab">
                        <option value='1101'>KABUPATEN SIMEULUE</option>
                        <option value='1102'>KABUPATEN ACEH SINGKIL</option>
                        <option value='1103'>KABUPATEN ACEH SELATAN</option>
                        <option value='1104'>KABUPATEN ACEH TENGGARA</option>
                        <option value='1105'>KABUPATEN ACEH TIMUR</option>
                        <option value='1106'>KABUPATEN ACEH TENGAH</option>
                        <option value='1107'>KABUPATEN ACEH BARAT</option>
                        <option value='1108'>KABUPATEN ACEH BESAR</option>
                        <option value='1109'>KABUPATEN PIDIE</option>
                        <option value='1110'>KABUPATEN BIREUEN</option>
                        <option value='1111'>KABUPATEN ACEH UTARA</option>
                        <option value='1112'>KABUPATEN ACEH BARAT DAYA</option>
                        <option value='1113'>KABUPATEN GAYO LUES</option>
                        <option value='1114'>KABUPATEN ACEH TAMIANG</option>
                        <option value='1115'>KABUPATEN NAGAN RAYA</option>
                        <option value='1116'>KABUPATEN ACEH JAYA</option>
                        <option value='1117'>KABUPATEN BENER MERIAH</option>
                        <option value='1118'>KABUPATEN PIDIE JAYA</option>
                        <option value='1171'>KOTA BANDA ACEH</option>
                        <option value='1172'>KOTA SABANG</option>
                        <option value='1173'>KOTA LANGSA</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Provinsi</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <select class="js-example-basic-single width-100" data-placeholder="Pilih Provinsi">
                        <option value='11'>ACEH</option>
                        <option value='12'>SUMATERA UTARA</option>
                        <option value='13'>SUMATERA BARAT</option>
                        <option value='14'>RIAU</option>
                        <option value='15'>JAMBI</option>
                        <option value='16'>SUMATERA SELATAN</option>
                        <option value='17'>BENGKULU</option>
                        <option value='18'>LAMPUNG</option>
                        <option value='19'>KEPULAUAN BANGKA BELITUNG</option>
                        <option value='21'>KEPULAUAN RIAU</option>
                        <option value='31'>DKI JAKARTA</option>
                        <option value='32'>JAWA BARAT</option>
                        <option value='33'>JAWA TENGAH</option>
                        <option value='34'>DI YOGYAKARTA</option>
                        <option value='35'>JAWA TIMUR</option>
                        <option value='36'>BANTEN</option>
                        <option value='51'>BALI</option>
                        <option value='52'>NUSA TENGGARA BARAT</option>
                        <option value='53'>NUSA TENGGARA TIMUR</option>
                        <option value='61'>KALIMANTAN BARAT</option>
                        <option value='62'>KALIMANTAN TENGAH</option>
                        <option value='63'>KALIMANTAN SELATAN</option>
                        <option value='64'>KALIMANTAN TIMUR</option>
                        <option value='65'>KALIMANTAN UTARA</option>
                        <option value='71'>SULAWESI UTARA</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 mt-3 col-form-label">Alamat Lengkap</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="exampleTextarea1" placeholder="Masukkan Alamat Lengkap" rows="2"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nomor Telepon</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nip" placeholder="Masukkan Nomor Telepon" />
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nip" placeholder="Masukkan Email" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Jabatan</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <select class="js-example-basic-single width-100" data-placeholder="Pilih Jabatan">
                        <option value='e9f54044-039e-4f85-acd6-8e9d1dbed4cf'>Admin</option>
                        <option value='9783bc2a-64b7-4889-9c14-92730157177a'>Customer Service</option>
                        <option value='ca31b786-39a6-4fd6-bc13-f7794c5840bf'>Direktur</option>
                        <option value='d92eca39-9a97-40b2-a62c-d9444e1d6159'>Finance</option>
                        <option value='54505230-c24d-43bd-83de-ec37fa3fc7b2'>HRD</option>
                        <option value='1f63620f-e234-4c2c-91f2-f33892121de0'>Koordinator TS</option>
                        <option value='4251c464-819a-4874-8554-00ba657c852e'>Leader TS</option>
                        <option value='475037f9-11d3-4049-b2e5-f90621c7f628'>Logistik</option>
                        <option value='1d324a74-8b5b-4c75-9d94-e544036bee3a'>Marketing</option>
                        <option value='f9ac8b30-a88b-4e64-ab91-6c6168cd2631'>Marketing Manager</option>
                        <option value='16da167b-e3b2-490c-a00a-741da7d8ecf4'>PPIC</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Divisi</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <select class="js-example-basic-single width-100" data-placeholder="Pilih Divisi">
                        <option value='5d36d96e-bf67-11eb-9558-ecf4bbc4f914'>Management</option>
                        <option value='5ced3daa-e462-497f-be1a-2101597f5c87'>Marketing</option>
                        <option value='3eff6af5-69b0-4d39-abb8-3b9aff87ecd1'>Team Support</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tanggal Bergabung</label>
                  <div class="col-sm-10">
                    <div id="datepicker-tanggal-bergabung" class="input-group date datepicker">
                      <input type="text" class="form-control">
                      <span class="input-group-addon input-group-append border-left">
                        <span class="far fa-calendar input-group-text icon-size-form"></span>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Area Marketing</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <select class="js-example-basic-single width-100" data-placeholder="Pilih Divisi">
                        <option value='840a024f-0f7d-11eb-8e30-ecf4bbc4f914'>CSO</option>
                        <option value='91fe4e99-0f7d-11eb-8e30-ecf4bbc4f914'>JOS</option>
                        <option value='76bb23b6-c18c-11ea-95c5-4a149675b0ac'>SG1</option>
                        <option value='7cec0ce6-c18c-11ea-95c5-4a149675b0ac'>SG2</option>
                        <option value='8409f409-0f7d-11eb-8e30-ecf4bbc4f914'>SG3</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Status KTP</label>
                  <div class="col-sm-10">
                    <div class="form-group">
                      <select class="js-example-basic-single width-100" data-placeholder="Pilih Divisi">
                        <option value='85306209-28dc-44ee-99b3-8ee9b6298fc3'>K/0</option>
                        <option value='86625daa-a995-4f6b-b93b-ef1b3f2b97a8'>K/1</option>
                        <option value='f2cd9fdb-3d3c-4a89-be4f-d80dc93b2291'>K/2</option>
                        <option value='b22c21fe-f552-4fc5-9082-442e10fbef0b'>K/3</option>
                        <option value='791dc796-d014-4c86-b626-f53b7796d4f4'>K/I/0</option>
                        <option value='694d1735-2cca-4bb1-9f0d-d4b2bd3c36ff'>K/I/1</option>
                        <option value='505127d7-283d-42d9-b9ee-34d024632218'>K/I/2</option>
                        <option value='8e1be5a6-ee3e-49bd-b271-bbc687f2b91d'>K/I/3</option>
                        <option value='a4f6ad63-77ab-4172-a5b3-ec3553e1e881'>TK/0</option>
                        <option value='2c21b2db-0e00-42d2-af23-9aa9446d7123'>TK/1</option>
                        <option value='e16f5ecd-1edb-4d2c-8de7-c5b1caa6eb01'>TK/2</option>
                        <option value='9f15447f-883e-4da6-bd8b-c93b285758e2'>TK/3</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Status Kontrak</label>
                  <div class="col-sm-2">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios1"
                          value="" checked>
                        Aktif
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios2"
                          value="option2">
                        Tidak Aktif
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nomor Kontrak</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama_pegawai"
                      placeholder="Masukkan Nomor Kontrak" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Status NPWP</label>
                  <div class="col-sm-2">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios1"
                          value="" checked>
                        Aktif
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios2"
                          value="option2">
                        Tidak Aktif
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Unggah Foto</label>
                  <div class="col-sm-5">
                    <small class="ml-auto align-self-end">
                      <a href="dropify.html" class="font-weight-light" target="_blank"></a>
                    </small>
                    </h4>
                    <input type="file" class="dropify" />
                  </div>
                </div>
              </div>
            </div>
            <div class="ml-mt-button">
              <button type="submit" class="btn btn-primary mr-2" onclick="showAlert('alert-simpan')">Simpan</button>
              <input type="reset" class="btn btn-light" value="Batal">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    {{--  Select 2  --}}
      (function($) {
        'use strict';

        if ($(".js-example-basic-single").length) {
          $(".js-example-basic-single").select2();
        }
        if ($(".js-example-basic-multiple").length) {
          $(".js-example-basic-multiple").select2();
        }
      })(jQuery);
    {{--  Endt Select 2  --}}
    {{--  Drop Image  --}}
      (function($) {
        'use strict';
        $('.dropify').dropify();
      })(jQuery);
    {{--  End Drop Image  --}}
    {{--  Time  --}}
      (function($) {
        'use strict';
        if ($("#timepicker-example").length) {
          $('#timepicker-example').datetimepicker({
            format: 'LT'
          });
        }
        if ($(".color-picker").length) {
          $('.color-picker').asColorPicker();
        }
        if ($("#datepicker-popup").length) {
          $('#datepicker-popup').datepicker({
            enableOnReadonly: true,
            todayHighlight: true,
          });
        }
        if ($("#datepicker-tanggal-bergabung").length) {
          $('#datepicker-tanggal-bergabung').datepicker({
            enableOnReadonly: true,
            todayHighlight: true,
          });
        }
        if ($("#inline-datepicker").length) {
          $('#inline-datepicker').datepicker({
            enableOnReadonly: true,
            todayHighlight: true,
          });
        }
        if ($(".datepicker-autoclose").length) {
          $('.datepicker-autoclose').datepicker({
            autoclose: true
          });
        }
        if ($('input[name="date-range"]').length) {
          $('input[name="date-range"]').daterangepicker();
        }
        if ($('input[name="date-time-range"]').length) {
          $('input[name="date-time-range"]').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
              format: 'MM/DD/YYYY h:mm A'
            }
          });
        }
      })(jQuery);
    {{--  End Time  --}}
    {{--  Input Tag  --}}
      (function($) {
        'use strict';

        // Jquery Tag Input Starts
        $('#tags').tagsInput({
          'width': '100%',
          'height': '75%',
          'interactive': true,
          'defaultText': 'Tambah',
          'removeWithBackspace': true,
          'minChars': 0,
          'maxChars': 20, // if not provided there is no limit
          'placeholderColor': '#666666'
        });

        // Jquery Tag Input Ends
        // Jquery Bar Rating Starts

        $(function() {
          function ratingEnable() {
            $('#example-1to10').barrating('show', {
              theme: 'bars-1to10'
            });

            $('#example-movie').barrating('show', {
              theme: 'bars-movie'
            });

            $('#example-movie').barrating('set', 'Mediocre');

            $('#example-square').barrating('show', {
              theme: 'bars-square',
              showValues: true,
              showSelectedRating: false
            });

            $('#example-pill').barrating('show', {
              theme: 'bars-pill',
              initialRating: 'A',
              showValues: true,
              showSelectedRating: false,
              allowEmpty: true,
              emptyValue: '-- no rating selected --',
              onSelect: function(value, text) {
                alert('Selected rating: ' + value);
              }
            });

            $('#example-reversed').barrating('show', {
              theme: 'bars-reversed',
              showSelectedRating: true,
              reverse: true
            });

            $('#example-horizontal').barrating('show', {
              theme: 'bars-horizontal',
              reverse: true,
              hoverState: false
            });

            $('#example-fontawesome').barrating({
              theme: 'fontawesome-stars',
              showSelectedRating: false
            });

            $('#example-css').barrating({
              theme: 'css-stars',
              showSelectedRating: false
            });

            $('#example-bootstrap').barrating({
              theme: 'bootstrap-stars',
              showSelectedRating: false
            });

            var currentRating = $('#example-fontawesome-o').data('current-rating');

            $('.stars-example-fontawesome-o .current-rating')
              .find('span')
              .html(currentRating);

            $('.stars-example-fontawesome-o .clear-rating').on('click', function(event) {
              event.preventDefault();

              $('#example-fontawesome-o')
                .barrating('clear');
            });

            $('#example-fontawesome-o').barrating({
              theme: 'fontawesome-stars-o',
              showSelectedRating: false,
              initialRating: currentRating,
              onSelect: function(value, text) {
                if (!value) {
                  $('#example-fontawesome-o')
                    .barrating('clear');
                } else {
                  $('.stars-example-fontawesome-o .current-rating')
                    .addClass('hidden');

                  $('.stars-example-fontawesome-o .your-rating')
                    .removeClass('hidden')
                    .find('span')
                    .html(value);
                }
              },
              onClear: function(value, text) {
                $('.stars-example-fontawesome-o')
                  .find('.current-rating')
                  .removeClass('hidden')
                  .end()
                  .find('.your-rating')
                  .addClass('hidden');
              }
            });
          }

          function ratingDisable() {
            $('select').barrating('destroy');
          }

          $('.rating-enable').on("click", function(event) {
            event.preventDefault();

            ratingEnable();

            $(this).addClass('deactivated');
            $('.rating-disable').removeClass('deactivated');
          });

          $('.rating-disable').on("click", function(event) {
            event.preventDefault();

            ratingDisable();

            $(this).addClass('deactivated');
            $('.rating-enable').removeClass('deactivated');
          });

          ratingEnable();
        });


        // Jquery Bar Rating Ends

      })(jQuery);
    {{--  End Input Tag  --}}
      (function($) {
        showAlert = function(type) {
          'use strict';
          if (type === 'alert-simpan') {
            swal({
              title: 'Selamat',
              text: 'Data berhasil di simpan',
              icon: 'success',
              timer: 2000,
              button: false
            }).then(
              function() {},
              // handling the promise rejection
              function(dismiss) {
                if (dismiss === 'timer') {
                  console.log('I was closed by the timer')
                }
              }
            )
          }
        }

      })(jQuery);
  </script>
@endsection
