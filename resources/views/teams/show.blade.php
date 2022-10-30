@extends('layouts.master')

@section('title')
    {{ $team->name ?? '' }} | @lang('messages.app_name')
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

        <div class="card-body">
            <div class="content">
                <div class="mt-2">
                    <div class="row">
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

                            <div class="p-4">
                                <div class="row">
                                    @if ($teamRules->isNotEmpty())
                                        <div class="col-md border-left border-dark mb-4">
                                            <h5>
                                                @lang('messages.position')
                                            </h5>
                                            <div class="pt-1">
                                                @foreach ($teamRules as $teamRule)
                                                    @if ($teamRule->position !== null)
                                                        <div class="row">
                                                            <div class="col">
                                                                <span class="text-secondary">
                                                                    {{ $teamRule->name ?? '' }}
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
                                            <h5>
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
