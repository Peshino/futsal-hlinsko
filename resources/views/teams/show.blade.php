@extends('layouts.master')

@section('title')
{{ $team->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.team')
            </div>
        </div>
    </div>

    <div class="card-body no-padding">
        <div class="content">
            <div class="mt-2">
                <div class="row border-bottom border-dark">
                    <div class="col-sm-3">
                        <div class="text-center">
                            <img src="{{ asset('img/logos/test_logo.png') }}" class="avatar img-circle img-thumbnail"
                                alt="avatar">
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <h1>{{ $team->name ?? '' }}</h1>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item">
                        <a class="nav-link{{ (request()->is('*teams/' . $team->id . '/players')) ? ' active' : '' }}"
                            href="{{ route('team-players', [$competition->id, $team->id]) }}">@lang('messages.players')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ (request()->is('*teams/' . $team->id . '/results')) ? ' active' : '' }}"
                            href="{{ route('team-results', [$competition->id, $team->id]) }}">@lang('messages.results')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ (request()->is('*teams/' . $team->id . '/schedule')) ? ' active' : '' }}"
                            href="{{ route('team-schedule', [$competition->id, $team->id]) }}">@lang('messages.schedule')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ (request()->is('*teams/' . $team->id . '/statistics')) ? ' active' : '' }}"
                            href="#">@lang('messages.statistics')</a>
                    </li>
                </ul>
            </div>

            @isset($teamPlayers)
            @php
            $players = $teamPlayers;
            @endphp
            <div class="mt-2 text-center">
                @include('partials/players')
            </div>
            @endisset

            @isset($teamResults)
            @php
            $games = $teamResults;
            @endphp
            <div class="mt-2 text-center">
                @include('partials/games')
            </div>
            @endisset

            @isset($teamSchedule)
            @php
            $games = $teamSchedule;
            @endphp
            <div class="mt-2 text-center">
                @include('partials/games')
            </div>
            @endisset
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