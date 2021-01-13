@extends('layouts.master')

@section('title')
@lang('messages.table') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.table')
            </div>
            <div class="col-8 col-right d-flex flex-row-reverse">
                <div class="row">
                    @if (count($competition->rules) > 0)
                    <div class="col-auto">
                        <div class="dropdown pr-1">
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
                                    href="{{ route('table.params-index', [$competition->id, $competitionRule->id, $competitionRule->getLastMatchByRound()->round]) }}">
                                    @lang('messages.' . $competitionRule->name ?? '' . '')
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    @if (count($rounds) > 0)
                    <div class="col-auto pr-1">
                        <div class="dropdown">
                            <button class="control-button dropdown-toggle" type="button"
                                id="le-component-vehicle-type-id" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                @lang('messages.to') {{ $toRound }}. @lang('messages.to_n_round')
                            </button>
                            <div class="dropdown-menu dropdown-menu-right"
                                aria-labelledby="le-component-vehicle-type-id">
                                @foreach ($rounds as $round)
                                <a class="dropdown-item{{ $round === $toRound ? " active" : "" }}"
                                    href="{{ route('table.params-index', [$competition->id, $rule->id, $round]) }}">
                                    @lang('messages.to') {{ $round ?? '' }}. @lang('messages.to_n_round')
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
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col" class="text-left">@lang('messages.team')</th>
                            <th scope="col">@lang('messages.matches')</th>
                            <th scope="col">výhry</th>
                            <th scope="col">remízy</th>
                            <th scope="col">prohry</th>
                            <th scope="col">skóre</th>
                            <th scope="col">GR</th>
                            <th scope="col">body</th>
                            <th scope="col">forma</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tableData as $key => $tableItem)
                        <tr>
                            <td>{{ $key + 1 }}.</td>
                            <td class="text-left">{{ $tableItem->team_name }}</td>
                            <td>{{ $tableItem->matches_count }}</td>
                            <td>{{ $tableItem->wins }}</td>
                            <td>{{ $tableItem->draws }}</td>
                            <td>{{ $tableItem->losts }}</td>
                            <td>{{ $tableItem->team_goals_scored }}&nbsp;:&nbsp;{{ $tableItem->team_goals_received }}
                            <td>{{ $tableItem->team_goals_difference }}</td>
                            <td class="competition-color"><strong>{{ $tableItem->points }}</strong></td>
                            <td class="form">
                                @if (count($tableItem->team_form) > 0)
                                @foreach ($tableItem->team_form as $match)
                                <li class="{{ $match->result }} item-tooltip">
                                    <a href="{{ route('matches.show', [$competition->id, $match->id]) }}"
                                        class="item-tooltip-box tooltip-link tooltip-right" role="tooltip">
                                        <span class="tooltip-content">
                                            <div class="match-details">
                                                <span class="match-datetime">
                                                    @php
                                                    $date = \Carbon\Carbon::parse($match->start_date);
                                                    echo $date->isoFormat('dddd[,] Do[.] MMMM[, ]');
                                                    $time = \Carbon\Carbon::parse($match->start_time);
                                                    echo $time->isoFormat('HH:mm');
                                                    @endphp
                                                </span>
                                                <span class="match-team">
                                                    <span title="{{ $match->homeTeam->name }}" class="text-uppercase">
                                                        {{ mb_substr($match->homeTeam->name, 0, 3) }}
                                                    </span>
                                                </span>
                                                <span class="match-score">
                                                    {{ $match->home_team_score }}&nbsp;|&nbsp;{{ $match->away_team_score }}
                                                </span>
                                                <span class="match-team">
                                                    <span title="{{ $match->awayTeam->name }}" class="text-uppercase">
                                                        {{ mb_substr($match->awayTeam->name, 0, 3) }}
                                                    </span>
                                                </span>
                                            </div>
                                        </span>
                                    </a>
                                </li>
                                @endforeach
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // $(document).ready(function () {
    //     $('[data-toggle="popover"]').popover({
    //         trigger: 'focus',
    //         html: true,
    //         placement: 'top',
    //         container: '.form-item'
    //     })
    // });
</script>
@endsection