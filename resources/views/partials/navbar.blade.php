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
                    <a class="nav-link" href="{{ route('matches.index', [$competition->id, 'matches']) }}">
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
                    <a class="nav-link" href="{{ route('matches.index', [$competition->id, 'table']) }}">
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
            
            <!-- Right Side Of Navbar -->
            @auth
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="profile-dropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="far fa-user align-middle"></i>&nbsp; <span
                            class="caret align-middle">{{ Auth::user()->firstname }}
                            {{ Auth::user()->lastname }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown">
                        <a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id) }}">
                            <i class="far fa-user-circle"></i>&nbsp; @lang('messages.profile')
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off"></i>&nbsp; @lang('messages.user_logout')
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            @endauth

            @guest
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="far fa-user"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i>
                    </a>
                </li>
            </ul>
            @endguest
        </div>
    </div>
</nav>