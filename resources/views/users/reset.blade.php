<!doctype html>
<html lang="en">
<head>
  @include('admin.metadata')
  @yield('css')
</head>
<body>
  
  <div class="container-scroller">
    <div class="page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg" style="margin-top:0px !important">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo">
                <a href="."><img src="{{asset('static/favicon-omsayoer.png')}}" height="auto" alt=""></a>
              </div>
              <h2>Hallo {{ $data->name_customer }}</h2>
              <h5 class="font-weight-light">Silahkan Masukan Password Baru Anda</h5>
              <div class="pt-3" autocomplete="off">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail">Email address</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="fa fa-user color-icon-login"></i>
                      </span>
                    </div>
                    <input type="email" value="{{ $data->email }}" class="form-control form-control-lg border-left-0" placeholder="Enter Email" required autocomplete="email" name="email" id="email">
                    @error('username')
                    <span class="invalid-feedback" role="alert">
                   
                    </span>
                    @enderror
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword">Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="fa fa-lock color-icon-login"></i>
                      </span>
                    </div>
                    <input type="password" class="form-control form-control-lg border-left-0" name="password" id="password" placeholder="Password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                   
                    </span>
                    @enderror
                  </div>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword">Confirm Password</label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="fa fa-lock color-icon-login"></i>
                        </span>
                      </div>
                      <input type="password" class="form-control form-control-lg border-left-0" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required autocomplete="current-password">
                      @error('password')
                      <span class="invalid-feedback" role="alert">
                     
                      </span>
                      @enderror
                    </div>
                  </div>
                <div class="my-3">
                  <button type="submit" class="btn btn-block btn-color-smt btn-lg font-weight-medium auth-form-btn btn-login">Reset Password</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end">CV. Seven Media Technology © 2021 | Hak cipta dilindungi undang-undang</p>
            
          </div>
        </div>
      </div>
    </div>
  </body>
  </html>
  <script>
    $(function () {
     
      $('.btn-login').on('click',function () {
        var remember_me = $('#remember_me:checked').val();;
        if ($('#email').val().length==0 || $('#password').val().length==0 || $('#password_confirmation').val().length==0) {
          swal("Error!", 'email atau password tidak boleh kosong', "error");
        } else {
          $.ajax({
            url:"/send-reset-password-email",
            type:"post",
            data:{
              _token :  $('input[name="_token"]').val(),
              email : $('#email').val(),
              password: $('#password').val(),
              password_confirmation: $('#password_confirmation').val(),
            },
            dataType: "json",
            success:function(response){
              if (response.status==true) {
                    swal({title: "Success!", text: "Berhasil Melakukan Reset Password", icon: "success"})
                            .then(function(){ 
                                location.reload();
                        });
              } else {
                  swal("Error!", response.pesan, "error");
              }
            }
          })
        }
        });
    })
  </script>