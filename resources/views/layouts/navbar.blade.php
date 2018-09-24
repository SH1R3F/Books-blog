{{\Visitor::log()}}
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="/" class="navbar-brand">
        {{env('APP_NAME')}}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            @foreach((new \App\Http\Controllers\HomeController)->categories() as $category)
                <li class="nav-item text-right">
                    <a class="nav-link" href="{{route('category.show', $category->slug)}}">{{$category->title}}</a>
                </li>
            @endforeach
        </ul>
        <div class="navbar-nav flex-row mr-auto">
            <ul class="navbar-nav">
              @guest
                <li class="nav-item cursor-pointer">
                    <a class="nav-link" @click.prevent="LoginFormIsClicked = true">
                        تسجيل دخول
                    </a>
                </li>
                <li class="nav-item cursor-pointer">
                    <a class="nav-link" @click.prevent="RegisterFormIsClicked = true">
                        إنشاء حساب
                    </a>
                </li>
              @else
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        {{ auth()->user()->name }}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      @role('superadministrator|administrator|author|editor')
                        <li class="nav-item">
                          <a class="nav-link" href="{{route('dashboard')}}">Admin Panel</a>
                        </li>
                      @endrole
                        <li class="nav-item">
                          <a class="nav-link" href="/logout">Logout</a>
                        </li>
                    </ul>
                </li>
              @endguest
            </ul>
        </div>
    </div>
</nav>
@guest
    <login-form v-if="LoginFormIsClicked" @closeform="LoginFormIsClicked = false"></login-form>
    <register-form v-if="RegisterFormIsClicked" @closeform="RegisterFormIsClicked = false"></register-form>
@endguest
<h2 class="text-center mt-5 mb-5">
  {{env('APP_NAME')}} - تحميل كتب وروايات
</h2>
