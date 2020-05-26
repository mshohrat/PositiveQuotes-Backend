
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@include('layouts.navbars.sidebar')
<div id="main" class="main-panel" style="position: absolute;left: 0;right: auto">
    @include('layouts.navbars.navs.auth')
    @yield('content')
    @include('layouts.footer')
</div>
