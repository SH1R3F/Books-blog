<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{app()->getLocale() === 'en' ? 'ltr' : 'rtl' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title') {{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script>
        APP_URL = '{{env('APP_URL')}}';
    </script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Cairo|Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        @include('layouts.navbar')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <div class="footer pt-4 pb-3">
      <div class="container text-center">
        <a class="text-muted text-center">جميع الحقوق محفوظة لمؤلفين الكتب.</a>
        <ul class="pt-2">
          <li>
            <a href="#">اتفاقية الاستخدام</a>
          </li>
          <li>
            <a href="#">الخصوصية</a>
          </li>
          <li>
            <a href="#">حقوق الملكية</a>
          </li>
          <li>
            <a href="#">الخصوصية</a>
          </li>
        </ul>
      </div>
    </div>
    <script src="{{asset('js/script.js')}}"></script>
  </body>
</html>
