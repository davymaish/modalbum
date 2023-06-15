<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="_base_url" content="{{ url('/') }}">
    <title>{{ meta()->metaTitle() }}</title>
    @if(meta()->description())
        <meta name="description" content="{{ meta()->description() }}">
    @endif
    {{--<link rel="shortcut icon" href="{{ url('favicon.png') }}">--}}
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('header_css')
</head>
<body>
    <div id="app">
        @include('layouts.partials.navbar')
        <main class="py-4">
            <section class="container content" id="content-area">
                @include('layouts.partials.notifications')
                @yield('content')
            </section>
        </main>
        @include('layouts.partials.footer')
    </div>
    @yield('footer_js')

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', '{{ env('GOOGLE_ANALYTICS') }}', 'auto');
        ga('send', 'pageview');
    </script>
</body>
</html>
