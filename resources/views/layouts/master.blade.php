<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @if (\Illuminate\Support\Facades\App::environment('production'))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-FQC6J4MVRL"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-FQC6J4MVRL');
        </script>
    @endif

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Jiří Pešek" />
    <meta name="copyright" content="futsal Hlinsko" />
    <meta name="keywords" content="futsal, hlinsko, futsal Hlinsko" />
    <meta name="description"
        content="Oficiální web hlineckých futsalových soutěží. Výsledky, statistiky, rozlosování a další." />

    <title>
        @yield('title')

        @if (\Illuminate\Support\Facades\App::environment('local'))
            | test
        @endif
    </title>

    <link href="{{ asset('img/favicon.png') }}" rel="shortcut icon">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ekko-lightbox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body>
    <div id="app">
        <div id="main" class="text-white">
            @include('partials/navbar')

            @include('partials/flash-messages')

            <main class="pb-4">
                <div class="container content">
                    @yield('content')

                    @include('partials/current-competition')
                </div>
            </main>

            @include('partials/footer')
        </div>

        @include('partials/cookie-bar')
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/ekko-lightbox.js') }}" defer></script>
    <script src="{{ asset('js/moment.min.js') }}" defer></script>
    <script src="{{ asset('js/daterangepicker.min.js') }}" defer></script>
    @yield('scripts')
</body>

</html>
