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

    <link href="{{ asset('img/favicon.png') }}" rel="shortcut icon">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ekko-lightbox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body>
    <div id="app container">
        <div id="introduction">
            <div class="text-center">
                @if (count($seasons) > 0)
                <div class="introduction-top text-center">
                    <div class="introduction-header">
                        <h1>
                            <a href="{{ url('/') }}">
                                @lang('messages.app_name')
                            </a>
                        </h1>

                        {{-- <h2>@lang('messages.app_description')</h2> --}}
                    </div>
                    <div class="dropdown p-1 mb-2">
                        <button class="btn btn-lg dropdown-toggle" type="button" id="current-season"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $lastSeason->name ?? '' }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-center" id="seasons"
                            aria-labelledby="important-day-year">
                            @foreach ($seasons as $season)
                            <a href="{{ route('competitions-by-season', $season->id) }}" id="{{ $season->id }}"
                                class="dropdown-item season">
                                {{ $season->name ?? '' }}
                            </a>
                            @endforeach
                            @can('crud_seasons')
                            <a href="{{ route('seasons.create') }}" class="dropdown-item">
                                <div class="plus"></div>
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="introduction-middle text-center">
                    <div id="competitions" class="btn-group flex-wrap show">
                        @if (count($lastSeason->competitions) > 0)
                        @foreach ($lastSeason->competitions as $competition)
                        <a href="{{ route('competitions.show', $competition->id) }}" class="btn btn-lg">
                            {{ $competition->name ?? '' }}
                        </a>
                        @endforeach
                        @else
                        -----
                        @endif
                        @can('crud_competitions')
                        <a href="{{ route('competitions.create', $lastSeason->id) }}"
                            class="crud-button btn-plus btn btn-lg">
                            <div class="plus"></div>
                        </a>
                        @endcan
                    </div>
                </div>
                @else
                -----
                @endif

                <div class="introduction-bottom text-center">
                    @auth
                    <a class="" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-power-off"></i>&nbsp; @lang('messages.user_logout')
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @endauth

                    @guest
                    <div class="row justify-content-center">
                        <div class="col-1 text-right">
                            <a href="{{ route('login') }}">
                                <i class="far fa-user"></i>
                            </a>
                        </div>
                        <div class="col-1 text-left">
                            <a href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i>
                            </a>
                        </div>
                    </div>
                    @endguest
                </div>
            </div>

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