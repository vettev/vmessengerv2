<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="/css/app.css">
        <title>VMessenger</title>
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
        @yield('css')
    </head>
    <body>
    	@yield('content')
        <script src="/js/app.js"></script>
        @if(Auth::user())
            @include('layouts.pusher')
        @endif
        @yield('js')
    </body>
</html>