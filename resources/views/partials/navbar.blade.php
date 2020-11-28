<nav class="navbar navbar-expand-lg navbar-icon-top navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{-- <img src="{{ asset('img/logo_small_navbar.png') }}" class="align-middle" alt="logo"> --}}
            <span class="align-middle">@lang('messages.app_name')</span>
        </a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="@lang('messages.toggle_navigation')">
            <span class="icon-bar top-bar"></span>
            <span class="icon-bar middle-bar"></span>
            <span class="icon-bar bottom-bar"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->

            <ul class="navbar-nav mr-auto">
                <li class="nav-item{{ (request()->is('*competitions/' . $competition->id .'')) ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('competitions.show', $competition->id) }}">
                        <i class="fas fa-home align-middle"></i>&nbsp;
                        <span class="align-middle">@lang('messages.home')</span>
                    </a>
                </li>
                <li class="nav-item{{ (request()->is('*teams*')) ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('teams.index', $competition->id) }}">
                        <i class="fas fa-users align-middle"></i>&nbsp;
                        <span class="align-middle">@lang('messages.teams')</span>
                    </a>
                </li>
                <li class="nav-item{{ (request()->is('*matches*')) ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('matches.index', [$competition->id]) }}">
                        <i class="fas fa-align-center align-middle"></i>&nbsp;
                        <span class="align-middle">@lang('messages.results')</span>
                    </a>
                </li>
                <li class="nav-item{{ (request()->is('*schedule*')) ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('matches.schedule-index', $competition->id) }}">
                        <i class="far fa-calendar-alt align-middle"></i>&nbsp;
                        <span class="align-middle">@lang('messages.schedule')</span>
                    </a>
                </li>
                <li class="nav-item{{ (request()->is('*table*')) ? ' active' : '' }}">
                    <a class="nav-link" href="">
                        <i class="fas fa-sort-amount-down align-middle"></i>&nbsp;
                        <span class="align-middle">@lang('messages.table')</span>
                    </a>
                </li>
                <li class="nav-item{{ (request()->is('*shooters*')) ? ' active' : '' }}">
                    <a class="nav-link" href="">
                        <i class="far fa-futbol align-middle"></i>&nbsp;
                        <span class="align-middle">@lang('messages.shooters')</span>
                    </a>
                </li>
                <li class="nav-item{{ (request()->is('*cards*')) ? ' active' : '' }}">
                    <a class="nav-link" href="">
                        <i class="fas fa-clone align-middle"></i>&nbsp;
                        <span class="align-middle">@lang('messages.cards')</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>