<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Jiří Pešek" />
    <meta name="copyright" content="futsal Hlinsko" />
    <meta name="keywords" content="futsal, hlinsko, futsal Hlinsko" />
    <meta name="description" content="futsal Hlinsko - výsledky, statistiky, rozlosování" />

    <title>@lang('messages.app_name')</title>

    <link href="{{ asset('img/favicon_' . config('variants.name') . '.png') }}" rel="shortcut icon">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ekko-lightbox.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet"> --}}
    @yield('styles')
</head>

<body>
    <div id="app">
        <div id="introduction">
            <div class="introduction-header">
                <a href="{{ url('/') }}">
                    <h1>@lang('messages.app_name')</h1>
                </a>

                {{-- <h2>@lang('messages.app_description')</h2> --}}
            </div>
            <div class="text-center">
                @if (count($seasons) > 0)
                <div class="introduction-top text-center">
                    <div class="dropdown p-1 mb-2">
                        <button class="btn btn-lg dropdown-toggle" type="button" id="current-season"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $lastSeason->name ?? '' }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-center" id="seasons"
                            aria-labelledby="important-day-year">
                            @foreach ($seasons as $season)
                            <a href="{{ route('competitions-by-season', $season->id) }}" id="season-{{ $season->id }}"
                                class="dropdown-item season">
                                {{ $season->name ?? '' }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="introduction-middle text-center">
                    <div id="competitions" class="btn-group flex-wrap show">
                        @if (count($lastSeason->competitions) > 0)
                        @foreach ($lastSeason->competitions as $competition)
                        <a href="{{ route('souteze.show', $competition->id) }}" class="btn btn-lg">
                            {{ $competition->name ?? '' }}
                        </a>
                        @endforeach
                        @else
                        -----
                        @endif
                    </div>
                </div>
                @else
                -----
                @endif
            </div>

            <div class="introduction-bottom text-center">
                <a class="" href="{{ route('login') }}">
                    <i class="far fa-user"></i>
                </a>
            </div>

            @include('partials/footer')
        </div>

        @include('partials/cookie-bar')
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('scripts')
</body>

</html>