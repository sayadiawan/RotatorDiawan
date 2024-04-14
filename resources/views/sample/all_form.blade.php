@extends('admin.layouts.app')

@section('css')
@endsection

@section('page-title')
@endsection

@section('content')
  <div class="row">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="template-demo">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><i class="fas fa-home mr-1"></i><a href="#"></a></li>
              <li class="breadcrumb-item"><a href="#">Data</a></li>
              <li class="breadcrumb-item active" aria-current="page"><a href="#">Sample All Form</a></li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <div class="row">

    <div class="col-12 grid-margin stretch-card">

      <div class="card card-menu">

        <div class="d-md-flex justify-content-between align-items-center">

          <nav class="navbar navbar-expand-lg navbar-light ">

            <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse"
              data-target="#navbar4">

              <span class="ti-align-left font-white"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbar4">

              <ul class="navbar-nav mr-auto">


                <li class="jarak-menu">

                  <span class="font-menu-icon">

                    <i class="fas fa-home mr-1"></i> <a href="" class="font-white">Beranda</a>

                  </span>

                </li>


                <li class="jarak-menu">
                  <span class="font-menu-icon" style="font-size:14px;">
                    <i class="fas fa-edit mr-1"></i> <a href="table" class="font-white">Sample
                      Table</a>
                  </span>
                </li>
                <li class="jarak-menu">
                  <span class="font-menu-icon" style="font-size:14px;">
                    <i class="fas fa-truck mr-1"></i> <a href="form" class="font-white">Sample
                      Form</a>
                  </span>
                </li>
                <li class="jarak-menu">
                  <span class="font-menu-icon" style="font-size:14px;">
                    <i class="fas fa-window-maximize mr-1"></i> <a href="notfound" class="font-white">Sample Not Found</a>
                  </span>
                </li>
              </ul>

            </div>

          </nav>

        </div>

      </div>

    </div>

  </div>
  <div class="row">
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Form Standar</h4>
          <form class="forms-sample">
            <div class="form-group">
              <label for="exampleInputUsername1">Username</label>
              <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Username">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group">
              <label for="exampleInputConfirmPassword1">Confirm Password</label>
              <input type="password" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password">
            </div>
            <div class="form-group">
              <div class="form-check form-check-flat form-check-primary">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input">
                  Remember me
                </label>
              </div>
            </div>
            <div class="form-group">
              <label>File upload</label>
              <input type="file" name="img[]" class="file-upload-default">
              <div class="input-group col-xs-12">
                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                <span class="input-group-append">
                  <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputCity1">City</label>
              <input type="text" class="form-control" id="exampleInputCity1" placeholder="Location">
            </div>
            <div class="form-group">
              <label for="exampleTextarea1">Textarea</label>
              <textarea class="form-control" id="exampleTextarea1" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
            <button class="btn btn-light">Cancel</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Form Label Di Kiri</h4>
          <form class="forms-sample">
            <div class="form-group row">
              <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
              </div>
            </div>
            <div class="form-group row">
              <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email">
              </div>
            </div>
            <div class="form-group row">
              <label for="exampleInputMobile" class="col-sm-3 col-form-label">Mobile</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="exampleInputMobile" placeholder="Mobile number">
              </div>
            </div>
            <div class="form-group row">
              <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
              </div>
            </div>
            <div class="form-group row">
              <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Re Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="exampleInputConfirmPassword2" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <div class="form-check form-check-flat form-check-primary">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input">
                  Remember me
                </label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
            <button class="btn btn-light">Cancel</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Form Grup</h4>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">@</span>
              </div>
              <input type="text" class="form-control" placeholder="Username" aria-label="Username">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-primary text-white">$</span>
              </div>
              <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
              <div class="input-group-append">
                <span class="input-group-text">.00</span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">$</span>
              </div>
              <div class="input-group-prepend">
                <span class="input-group-text">0.00</span>
              </div>
              <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Recipient's username"
                aria-label="Recipient's username">
              <div class="input-group-append">
                <button class="btn btn-sm btn-primary" type="button">Search</button>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">Dropdown</button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                  <div role="separator" class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Separated link</a>
                </div>
              </div>
              <input type="text" class="form-control" aria-label="Text input with dropdown button">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Find in facebook"
                aria-label="Recipient's username">
              <div class="input-group-append">
                <button class="btn btn-sm btn-facebook" type="button">
                  <i class="fab fa-facebook-f"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Single select box using select 2</label>
            <select class="js-example-basic-single w-100">
              <option value="AL">Alabama</option>
              <option value="WY">Wyoming</option>
              <option value="AM">America</option>
              <option value="CA">Canada</option>
              <option value="RU">Russia</option>
            </select>
          </div>
          <div class="form-group">
            <label>Multiple select using select 2</label>
            <select class="js-example-basic-multiple w-100" multiple="multiple">
              <option value="AL">Alabama</option>
              <option value="WY">Wyoming</option>
              <option value="AM">America</option>
              <option value="CA">Canada</option>
              <option value="RU">Russia</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Form type checkbox</h4>
          <form>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input">
                      Default
                    </label>
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked>
                      Checked
                    </label>
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" disabled>
                      Disabled
                    </label>
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" disabled checked>
                      Disabled checked
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1"
                        value="">
                      Default
                    </label>
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2"
                        value="option2" checked>
                      Selected
                    </label>
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="optionsRadios2" id="optionsRadios3"
                        value="option3" disabled>
                      Disabled
                    </label>
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="optionsRadio2" id="optionsRadios4"
                        value="option4" disabled checked>
                      Selected and disabled
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="card-body">
          <p class="card-description">Add class <code>.form-check-{color}</code> for checkbox and radio controls in theme
            colors</p>
          <form>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="form-check form-check-primary">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked>
                      Primary
                    </label>
                  </div>
                  <div class="form-check form-check-success">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked>
                      Success
                    </label>
                  </div>
                  <div class="form-check form-check-info">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked>
                      Info
                    </label>
                  </div>
                  <div class="form-check form-check-danger">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked>
                      Danger
                    </label>
                  </div>
                  <div class="form-check form-check-warning">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked>
                      Warning
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="form-check form-check-primary">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="ExampleRadio1" id="ExampleRadio1" checked>
                      Primary
                    </label>
                  </div>
                  <div class="form-check form-check-success">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="ExampleRadio2" id="ExampleRadio2" checked>
                      Success
                    </label>
                  </div>
                  <div class="form-check form-check-info">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="ExampleRadio3" id="ExampleRadio3" checked>
                      Info
                    </label>
                  </div>
                  <div class="form-check form-check-danger">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="ExampleRadio4" id="ExampleRadio4" checked>
                      Danger
                    </label>
                  </div>
                  <div class="form-check form-check-warning">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="ExampleRadio5" id="ExampleRadio5" checked>
                      Warning
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Form Kanan Kiri</h4>
          <form class="form-sample">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">First Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Last Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Gender</label>
                  <div class="col-sm-9">
                    <select class="form-control">
                      <option>Male</option>
                      <option>Female</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Date of Birth</label>
                  <div class="col-sm-9">
                    <input class="form-control" placeholder="dd/mm/yyyy" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Category</label>
                  <div class="col-sm-9">
                    <select class="form-control">
                      <option>Category1</option>
                      <option>Category2</option>
                      <option>Category3</option>
                      <option>Category4</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Membership</label>
                  <div class="col-sm-4">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios1"
                          value="" checked>
                        Free
                      </label>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios2"
                          value="option2">
                        Professional
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <p class="card-description">
              Address
            </p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Address 1</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">State</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Address 2</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Postcode</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">City</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Country</label>
                  <div class="col-sm-9">
                    <select class="form-control">
                      <option>America</option>
                      <option>Italy</option>
                      <option>Russia</option>
                      <option>Britain</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-8 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Form mask</h4>
          <p class="card-description">Gives a preview of input format</p>
          <form class="forms-sample">
            <div class="form-group row">
              <div class="col">
                <label>Date:</label>
                <input class="form-control" data-inputmask="'alias': 'date'" />
              </div>
              <div class="col">
                <label>Date time:</label>
                <input class="form-control" data-inputmask="'alias': 'datetime'" />
              </div>
            </div>
            <div class="form-group">
              <label>Date with custom placeholder:</label>
              <input class="form-control" data-inputmask="'alias': 'date','placeholder': '*'" />
            </div>
            <div class="form-group">
              <label>Phone:</label>
              <input class="form-control" data-inputmask="'alias': 'phonebe'" />
            </div>
            <div class="form-group">
              <label>Currency:</label>
              <input class="form-control" data-inputmask="'alias': 'currency'" />
            </div>
            <div class="form-group row">
              <div class="col">
                <label>Email:</label>
                <input class="form-control" data-inputmask="'alias': 'email'" />
              </div>
              <div class="col">
                <label>Ip:</label>
                <input class="form-control" data-inputmask="'alias': 'ip'" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-4 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title d-flex">Upload Image
            <small class="ml-auto align-self-end">
              <a href="dropify.html" class="font-weight-light" target="_blank">More dropify examples</a>
            </small>
          </h4>
          <input type="file" class="dropify" />
        </div>
      </div>
      <br>
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Datepicker (default)</h4>
          <p class="card-description">Click to open datepicker</p>
          <div id="datepicker-popup" class="input-group date datepicker">
            <input type="text" class="form-control">
            <span class="input-group-addon input-group-append border-left">
              <span class="far fa-calendar input-group-text"></span>
            </span>
          </div>
        </div>
      </div>
      <br>
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Clockpicker (default)</h4>
          <p class="card-description">A simple clockpicker</p>
          <div class="input-group date" id="timepicker-example" data-target-input="nearest">
            <div class="input-group" data-target="#timepicker-example" data-toggle="datetimepicker">
              <input type="text" class="form-control datetimepicker-input" data-target="#timepicker-example" />
              <div class="input-group-addon input-group-append"><i class="far fa-clock input-group-text"></i></div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Input Tag</h4>
          <p class="card-description">Type to add a new tag</p>
          <input name="tags" id="tags" value="London,Canada,Australia,Mexico" />
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
  </script>
@endsection
