<!doctype html>
<html lang="en">
@include('layouts.partial.header')

<body>
    <div class="wrapper">
        @yield('content')
    </div>
    @yield('modals')
    @include('layouts.partial.footer')
    @include('layouts.partial.script')
    @yield('additional_scripts')
</body>

</html>
