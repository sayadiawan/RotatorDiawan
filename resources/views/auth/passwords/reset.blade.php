{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
<!doctype html>
<html lang="en">
<head>
  @include('admin.metadata')
  @yield('css')
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5 cen">
                            @if($status == 1)
                            <center>
                                <div class="brand-logo">
                                    <img src="{{asset('static/'.$option->logo)}}" alt="Logo Admin">
                                </div>
                                <h4>Reset Password Akun</h4>
                                <h6 class="font-weight-light">Silahkan mengisi form di bawah</h6>
                            </center>
                            <form class="pt-3" method="POST" action="{{ route('passwords.reset') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="password" name="password"
                                        class="form-control form-control-lg"
                                        id="password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password_konfirm"
                                        class="form-control form-control-lg"
                                        id="password_konfirm" placeholder="Password Konfirmasi">
                                </div>
                                <div class="mt-3">
                                    <button type="button"
                                        class="btn btn-reset btn-block btn-info btn-lg font-weight-medium auth-form-btn mr-1"
                                        style="background: #25668E">
                                        Konfirmasi <i class="fa fa-spinner mr-2"></i>
                                    </button>
                                </div>
                            </form>
                            @elseif($status==2)
                                <div class="alert alert-danger" role="alert">
                                    Token Untuk Konfirmasi Password Anda Telah Habis. Silahkan Menginputkan Email Konfirmasi <a href="/sm-master" class="alert-link">Disini.</a>
                                </div>
                            @else
                                <div class="alert alert-danger" role="alert">
                                    Anda Tidak Memiliki Akses Untuk Melakukan Reset Password. Silahkan Menginputkan Email Konfirmasi <a href="/sm-master" class="alert-link">Disini.</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
  </body>
  </html>
  <script>
    $(function () {
        $('.btn-reset').on('click',function () {
            if ($('#password').val().length==0 || $('#password_konfirm').val().length==0) {
                swal("Error!", 'Password atau Konfirmasi Password tidak boleh kosong', "error");
            }else{
                valPass = $('#password').val();
                valResetPass = $('#password_konfirm').val();
                if(valPass == valResetPass){
                    $.ajax({
                        url:"{{ route('passwords.reset') }}",
                        type:"post",
                        data:{
                              _token:$('input[name="_token"]').val(),
                              token_reset:"{{ $token }}",
                              password:$('#password').val(),
                        },
                        dataType: "json",
                        success:function(response){
                            console.log(response)
                            if(response.status==true) {
                                swal({title: "Berhasil!", text: response.message, icon: "success"})
                                    .then(function(){ 
                                        document.location='/login';
                                });
                            }else{
                                swal("Error!", response.message, "error");
                            }
                        }
                    })
                }else{
                    swal("Error!", 'Password dan Password Konfirmasi Tidak Sama', "error");
                }
            }
        });
    })
  </script>