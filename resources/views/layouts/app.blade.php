<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.partial.header')
@include('sweetalert::alert')

<body>
    <div class="wrapper">
        @include('layouts.partial.sidebar')
        @include('layouts.partial.navbar')
        <div class="content-page">
            @yield('content')
        </div>
    </div>
    @yield('modals')
    @include('layouts.partial.footer')
    @include('layouts.partial.script')
    @yield('additional_scripts')
</body>

</html>
