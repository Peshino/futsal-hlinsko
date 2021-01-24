@extends('layouts.master')

@section('title')
@lang('messages.results') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col-4 col-left">
                @lang('messages.results')
            </div>
            <div class="col-8 col-right d-flex flex-row-reverse">
                <div class="row">
                    @can('create_match')
                    <div class="col-auto pr-1">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a class="crud-button" href="{{ route('matches.create', $competition->id) }}">
                                    <div class="plus"></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endcan

                    @if (count($competition->rules) > 0)
                    <div class="col-auto pr-1">
                        <div class="dropdown">
                            <button class="control-button dropdown-toggle" type="button"
                                id="le-component-vehicle-type-id" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                @lang('messages.' . $rule->name ?? '' . '')
                            </button>
                            <div class="dropdown-menu dropdown-menu-right"
                                aria-labelledby="le-component-vehicle-type-id">
                                {{-- <a class="dropdown-item" href="">
                            @lang('messages.all')
                        </a> --}}
                                @foreach ($competition->rules as $competitionRule)
                                <a class="dropdown-item{{ $competitionRule->id === $rule->id ? " active" : "" }}"
                                    href="{{ route('matches.params-index', [$competition->id, $competitionRule->id, $competitionRule->getLastMatchByRound()->round]) }}">
                                    @lang('messages.' . $competitionRule->name ?? '' . '')
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    @if (count($rounds) > 0)
                    <div class="col-auto">
                        <div class="dropdown pr-1">
                            <button class="control-button dropdown-toggle" type="button"
                                id="le-component-vehicle-type-id" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                {{ $actualRound }}. @lang('messages.round')
                            </button>
                            <div class="dropdown-menu dropdown-menu-right"
                                aria-labelledby="le-component-vehicle-type-id">
                                {{-- <a class="dropdown-item" href="">
                            @lang('messages.all')
                        </a> --}}
                                @foreach ($rounds as $round)
                                <a class="dropdown-item{{ $round === $actualRound ? " active" : "" }}"
                                    href="{{ route('matches.params-index', [$competition->id, $rule->id, $round]) }}">
                                    {{ $round ?? '' }}. @lang('messages.round')
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card-body no-padding">
        <div class="content text-center">
            <div class="content-block">
                @if (count($matches) > 0)
                @php
                $matchStartDates = [];
                @endphp
                @foreach ($matches as $match)
                @if (!in_array($match->start_date, $matchStartDates))
                <div class="mt-4">
                    <h5>
                        @php
                        $date = \Carbon\Carbon::parse($match->start_date);
                        echo $date->isoFormat('dddd[,] Do[.] MMMM');
                        @endphp
                    </h5>
                </div>
                @php
                $matchStartDates[] = $match->start_date;
                @endphp
                @endif
                <div class="match mb-3 clickable-row"
                    data-url="{{ route('matches.show', [$competition->id, $match->id]) }}">
                    <div class="row">
                        <div class="match-team col-4 d-flex flex-row-reverse">
                            <span class="justify-content-center align-self-center">
                                <div class="team-name-long">
                                    {{ $match->homeTeam->name }}
                                </div>
                                <div class="team-name-short">
                                    {{ mb_substr($match->homeTeam->name, 0, 3) }}
                                </div>
                            </span>
                        </div>
                        <div class="match-score col-4 text-center">
                            <span class="justify-content-center align-self-center">
                                <div class="row">
                                    <div class="col-6 match-score-home d-flex flex-row-reverse">
                                        {{ $match->home_team_score }}
                                    </div>
                                    <div class="col-6 match-score-away d-flex">
                                        {{ $match->away_team_score }}
                                    </div>
                                </div>
                            </span>
                        </div>
                        <div class="match-team col-4 d-flex">
                            <span class="justify-content-center align-self-center">
                                <div class="team-name-long">
                                    {{ $match->awayTeam->name }}
                                </div>
                                <div class="team-name-short">
                                    {{ mb_substr($match->awayTeam->name, 0, 3) }}
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('.clickable-row').click(function () {
            var url = $(this).data('url');

            window.location.href = url;
        });
    });
</script>
@endsection