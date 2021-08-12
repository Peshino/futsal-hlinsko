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
            @can('manage_admin_routes')
            <ul class="navbar-nav mr-auto">
                @isset($season)
                @php
                $competition = null;
                @endphp
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('seasons.show', $season->id) }}">
                        <span class="align-middle">{{ $season->name ?? '' }}</span>
                    </a>
                </li>
                @endisset

                @isset($competition->season)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('seasons.show', $competition->season->id) }}">
                        <span class="align-middle">{{ $competition->season->name ?? ''}}</span>
                    </a>
                </li>
                @endisset

                @isset($competition)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('competitions.admin-show', $competition->id) }}">
                        <span class="align-middle">{{ $competition->name ?? ''}}</span>
                    </a>
                </li>
                @endif

                @if(\Request::is('*/rules/*') && isset($rule))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('rules.admin-show', [$competition->id, $rule->id]) }}">
                        <span class="align-middle">{{ $rule->name ?? '' }}</span>
                    </a>
                </li>
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
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
            @endcan
        </div>
    </div>
</nav>