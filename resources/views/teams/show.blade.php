@extends('layouts.master')

@section('title')
    {{ $team->name ?? '' }} | {{ $competition->name }} | {{ $competition->season->name_short ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    @lang('messages.team')
                </div>
            </div>
        </div>

        <div class="card-body no-x-padding">
            <div class="content">
                <div class="mt-2">
                    <div class="row card-body-x-padding">
                        <div class="col-sm-3">
                            <div class="text-center">
                                <img src="{{ asset('img/logos/test_logo.png') }}" class="avatar img-circle img-thumbnail"
                                    alt="avatar">
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="mt-2 d-flex justify-content-center justify-content-md-start">
                                <h1>
                                    {{ $team->name ?? '' }} <span class="text-secondary"> |
                                        {{ $team->name_short ?? '' }}</span>
                                </h1>
                            </div>

                            @if ($team->web_presentation !== null)
                                <div class="mt-2 ml-sm-1 d-flex justify-content-center justify-content-md-start">
                                    <a href="{{ $team->web_presentation }}" target="_blank">
                                        {{ 'www.' . parse_url($team->web_presentation)['host'] }}
                                    </a>
                                </div>
                            @endif

                            <div class="p-4">
                                <div class="row">
                                    @if ($teamRules->isNotEmpty())
                                        <div class="col-md border-left border-dark mb-4">
                                            <h5 class="competition-second-color">
                                                @lang('messages.position')
                                            </h5>
                                            <div class="pt-1">
                                                @foreach ($teamRules as $teamRule)
                                                    @if ($teamRule->position !== null)
                                                        <div class="row mb-1">
                                                            <div class="col">
                                                                {{-- <span class="text-secondary">
                                                                    {{ $teamRule->name ?? '' }}
                                                                </span> --}}
                                                                <span class="text-center text-secondary">
                                                                    <span data-toggle="popover"
                                                                        title="@lang('messages.rules') <strong>{{ $teamRule->name ?? '' }}</strong>"
                                                                        data-content="
                                                        @lang('messages.number_of_rounds') <strong>{{ $teamRule->number_of_rounds ?? '' }}</strong><br />
                                                        @lang('messages.system') <strong>@lang('messages.' . $teamRule->system ?? '' . '')</strong><br />
                                                        @lang('messages.game_duration') <strong>{{ $teamRule->game_duration ?? '' }} [@lang('messages.minutes')]</strong><br />
                                                        @lang('messages.case_of_draw') <strong>@lang('messages.' . $teamRule->case_of_draw ?? '' . '')</strong><br />
                                                        @lang('messages.type') <strong>@lang('messages.' . $teamRule->type ?? '' . '')</strong><br />
                                                        <strong>{{ $teamRule->isAppliedMutualBalance() ? __('messages.mutual_balance_applied') : __('messages.mutual_balance_not_applied') }}</strong><br />
                                                        ">
                                                                        <span
                                                                            class="anchor">{{ $teamRule->name ?? '' }}</span>
                                                                    </span>
                                                                </span>
                                                                &nbsp;|&nbsp;
                                                                <span class="competition-color">
                                                                    {{ $teamRule->position ?? '' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if ($teamForm !== null)
                                        <div class="col-md border-left border-dark mb-4">
                                            <h5 class="competition-second-color">
                                                @lang('messages.form')
                                            </h5>
                                            <div class="form pt-1">
                                                @if ($teamFirstSchedule !== null)
                                                    @include('partials/teams.first-schedule')
                                                @endif
                                                <i class="fas fa-chevron-left text-secondary"></i>
                                                @foreach ($teamForm as $game)
                                                    @include('partials/teams.form')
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top border-dark">
                    <ul class="nav nav-pills nav-fill">
                        @foreach ($sections as $section)
                            <li class="nav-item">
                                <a class="nav-link{{ request()->is('*teams/' . $team->id . '/' . $section) ? ' active' : '' }}"
                                    href="{{ route('team-section', [$competition->id, $team->id, $section]) }}">
                                    @lang('messages.' . $section)
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if ($teamPlayers !== null)
                    @php
                        $players = $teamPlayers;
                    @endphp
                    <div class="mt-2 text-center">
                        @include('partials/players')
                    </div>
                @endif

                @if ($teamResults !== null)
                    @php
                        $games = $teamResults;
                    @endphp
                    <div class="mt-2 text-center">
                        @include('partials/games')
                    </div>
                @endif

                @if ($teamSchedule !== null)
                    @php
                        $games = $teamSchedule;
                    @endphp
                    <div class="mt-2 text-center">
                        @include('partials/games')
                    </div>
                @endif

                @if ($showTeamStatistics)
                    <div class="my-4 row justify-content-center">
                        @if (isset($goals) && $goals->isNotEmpty())
                            <div class="col-lg-4">
                                @include('partials/goals.selection')
                            </div>
                        @endif

                        @if (isset($yellowCards) && $yellowCards->isNotEmpty())
                            <div class="col-lg-4">
                                @include('partials/cards.yellow-selection')
                            </div>
                        @endif

                        @if (isset($redCards) && $redCards->isNotEmpty())
                            <div class="col-lg-4">
                                @include('partials/cards.red-selection')
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('competition-url')
    <div class="text-center">
        <a href="{{ route('competitions.show', $competition->id) }}" class="navbar-brand">
            {{ $competition->name ?? '' }} {{ $competition->season->name ?? '' }}
        </a>
    </div>
@endsection
