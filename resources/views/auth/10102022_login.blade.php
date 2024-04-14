<!doctype html>
<html lang="en">
<head>
  @include('admin.metadata')
  @yield('css')
</head>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth" style="margin-top:0px !important">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <a href="."><img src="{{asset('static/'.$option->logo)}}" height="auto" alt=""></a>
              </div>
              <h2>Welcome back!</h2>
              <h5 class="font-weight-light">Happy to see you again!</h5>
              <div class="pt-3" autocomplete="off">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail">Username</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="fa fa-user color-icon-login"></i>
                      </span>
                    </div>
                    <input type="username" value="{{ old('username') }}" class="form-control form-control-lg border-left-0" placeholder="Enter username" required autocomplete="username" name="username" id="username">
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
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" name="remember_me" id="remember_me" value="1" class="form-check-input">
                        Keep me signed in
                      <i class="input-helper"></i></label>
                  </div>
                  <a href="#" data-toggle="modal" data-target="#forgetpass" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="my-3">
                  <button type="submit" class="btn btn-block btn-color-smt btn-lg font-weight-medium auth-form-btn btn-login">Login</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="forgetpass" tabindex="-1" role="dialog" aria-labelledby="forgetpass" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="forgetpasslabel">Form Lupa Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          
              @csrf
              <div class="form-group">
                  <input type="text" class="form-control" placeholder="Masukan Email" name="email" id="email">
              </div>
         
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary btn-simpan-password">Kirim</button>
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
        if ($('#username').val().length==0 || $('#password').val().length==0) {
          swal("Error!", 'username atau password tidak boleh kosong', "error");
        } else {
          $.ajax({
            url:"{{ route('login') }}",
            type:"post",
            data:{
              _token :  $('input[name="_token"]').val(),
              username : $('#username').val(),
              password: $('#password').val(),
              remember_me : remember_me
            },
            dataType: "json",
            success:function(response){
              if (response.status==true) {
                    swal({title: "Berhasil!", text: "Berhasil Melakukan Login", icon: "success"})
                            .then(function(){ 
                                document.location='/home';
                        });
              } else {
                  swal("Error!", response.pesan, "error");
              }
            }
          })
        }
        });
        
        $('.btn-simpan-password').on('click',function () {
            $.ajax({
                url:"{{ route('passwords.email') }}",
                type:"post",
                data:{
                    _token: $('input[name="_token"]').val(),
                    email:$('input[name="email"]').val()
                },
                dataType: "json",
                success:function(response){
                    console.log(response)
                    if (response.status==true) {
                        swal({title: "Berhasil!", text: response.message, icon: "success"})
                                .then(function(){ 
                                    document.location='/home';
                        });
                    }else{
                        swal("Error!", response.message, "error");
                    }
                }
            })
        })
    })
  </script>