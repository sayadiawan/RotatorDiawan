<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
<title>{{$option->name_company}}</title>
<meta name="author" content="Seven Media Technology">
<meta name="copyright" content="Seven Media Technology" />
<meta name="description" content="{{ $option->description }}">
<link rel="icon" type="image/png" href="{{asset('static/'.$option->favicon)}}">

{{--  Css Wajib  --}}
<link rel="stylesheet" href="{{asset('vendors/iconfonts/font-awesome/css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('vendors/iconfonts/flag-icon-css/css/flag-icon.min.css')}}" />
<link rel="stylesheet" href="{{asset('vendors/iconfonts/ti-icons/css/themify-icons.css')}}">
<link rel="stylesheet" href="{{asset('vendors/iconfonts/simple-line-icon/css/simple-line-icons.css')}}">
<link rel="stylesheet" href="{{asset('css/result_combine.css')}}">

{{--  JS Wajib  --}}
<script defer src="{{ asset('js/result_combine.js') }}"></script>
<script src="{{asset('vendors/js/vendor.bundle.base.js')}}"></script>