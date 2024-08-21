<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('additional_meta')
    <title>
        @yield('title', 'Dashboard') | {{ config('app.name') }}
    </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/fonts/remixicon.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">

    @yield('additional_css')
</head>
