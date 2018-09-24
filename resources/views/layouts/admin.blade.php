<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{app()->getLocale() === 'en' ? 'ltr' : 'rtl' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title'){{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script>
        APP_URL = '{{env('APP_URL')}}';
    </script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Cairo|Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->

    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/w3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-right" style="width:200px;" id="mySidebar">
            <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
            <a class="w3-bar-item">
              مرحبًا, {{Auth::user()->name}}
            </a>
            <a href="{{route('dashboard')}}" class="w3-bar-item w3-button{{Request::is('manage/dashboard*') ? ' active': ''}}">
              لوحة التحكم
            </a>
            <a href="{{route('books')}}" class="w3-bar-item w3-button{{Request::is('manage/books*') ? ' active': ''}}">
              الكتب المنشورة
            </a>
            <a href="{{route('categories')}}" class="w3-bar-item w3-button{{Request::is('manage/categories*') ? ' active': ''}}">
              التصنيفات
            </a>
            <a href="{{route('tags')}}" class="w3-bar-item w3-button{{Request::is('manage/tags*') ? ' active': ''}}">
              العلامات
            </a>
            <a href="{{route('authors')}}" class="w3-bar-item w3-button{{Request::is('manage/authors*') ? ' active': ''}}">
              الكُتاب
            </a>
            <a href="{{route('comments')}}" class="w3-bar-item w3-button{{Request::is('manage/comments*') ? ' active': ''}}">
              التعليقات
            </a>
            @role('superadministrator|administrator')
              <a href="{{route('users.index')}}" class="w3-bar-item w3-button{{Request::is('manage/users*') ? ' active': ''}}">
                المستخدمين
              </a>
              <a href="{{route('settings')}}" class="w3-bar-item w3-button{{Request::is('manage/settings*') ? ' active': ''}}">
                الإعدادات
              </a>
            @endrole
            <a href="{{route('logout')}}" class="w3-bar-item w3-button">
              تسجيل خروج
            </a>
        </div>
        <div class="w3-main" style="margin-right:200px">
            <div class="w3-teal row">
                <button class="w3-button w3-teal w3-xlarge w3-hide-large mr-4" onclick="w3_open()">&#9776;</button>
                <div class="w3-container">
                    <a href="{{route('index')}}" style="text-decoration: none;">
                      <h1 class="text-right pr-2">
                        {{env('APP_NAME')}}
                      </h1>
                    </a>
                </div>
            </div>
        </div>
        <main>
            @guest
                <login-form v-if="LoginFormIsClicked" @closeform="LoginFormIsClicked = false"></login-form>
                <register-form v-if="RegisterFormIsClicked" @closeform="RegisterFormIsClicked = false"></register-form>
            @endguest
            @yield('content')
        </main>
    </div>
    <script src="{{asset('js/script.js')}}" defer></script>
    <script>
      function w3_open() {
          document.getElementById("mySidebar").style.display = "block";
      }
      function w3_close() {
          document.getElementById("mySidebar").style.display = "none";
      }
    </script>
    @yield('footer_scripts')
  </body>
</html>
