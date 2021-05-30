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
                            <button class="control-button dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                @lang('messages.' . $rule->name ?? '' . '')
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                {{-- <a class="dropdown-item" href="">
                            @lang('messages.all')
                        </a> --}}
                                @foreach ($competition->rules as $competitionRule)
                                @if ($competitionRule->getLastResultByRound() !== null)
                                <a class="dropdown-item{{ $competitionRule->id === $rule->id ? " active" : "" }}"
                                    href="{{ route($competitionRule->display_as . '.params-index', [$competition->id, $competitionRule->id, $competitionRule->getLastResultByRound()->round]) }}">
                                    @lang('messages.' . $competitionRule->name ?? '' . '')
                                </a>
                                @else
                                <a class="dropdown-item{{ $competitionRule->id === $rule->id ? " active" : "" }}"
                                    href="{{ route('games.index', [$competition->id, $competitionRule->display_as, $competitionRule->id]) }}">
                                    @lang('messages.' . $competitionRule->name ?? '' . '')
                                </a>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    @if (count($rounds) > 0)
                    <div class="col-auto pr-1">
                        <div class="dropdown">
                            <button class="control-button dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                @lang('messages.to') {{ $toRound }}. @lang('messages.to_n_round')
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @foreach ($rounds as $round)
                                <a class="dropdown-item{{ $round === $toRound ? " active" : "" }}"
                                    href="{{ route($rule->display_as . '.params-index', [$competition->id, $rule->id, $round]) }}">
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

    <div class="card-body">
        <div class="content text-center">
            <div class="content-block">
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col" class="text-left">@lang('messages.team')</th>
                            <th scope="col">@lang('messages.games')</th>
                            <th scope="col">výhry</th>
                            <th scope="col">remízy</th>
                            <th scope="col">prohry</th>
                            <th scope="col">skóre</th>
                            <th scope="col">GR</th>
                            <th scope="col">body</th>
                            <th scope="col">forma <i class="fas fa-long-arrow-alt-left"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tableData as $key => $tableItem)
                        <tr>
                            <td>{{ $key + 1 }}.</td>
                            <td class="text-left">
                                <a href="{{ route('teams.show', [$competition->id, $tableItem->team_id]) }}">
                                    {{ $tableItem->team_name }}
                                </a>
                            </td>
                            <td>{{ $tableItem->games_count }}</td>
                            <td>{{ $tableItem->wins }}</td>
                            <td>{{ $tableItem->draws }}</td>
                            <td>{{ $tableItem->losts }}</td>
                            <td>{{ $tableItem->team_goals_scored }}&nbsp;:&nbsp;{{ $tableItem->team_goals_received }}
                            <td>{{ $tableItem->team_goals_difference }}</td>
                            <td class="competition-color"><strong>{{ $tableItem->points }}</strong></td>
                            <td class="form">
                                @if (count($tableItem->team_form) > 0)
                                <i class="fas fa-chevron-left text-white-50"></i>
                                @foreach ($tableItem->team_form as $game)
                                <li class="{{ $game->result }} item-tooltip">
                                    <a href="{{ route('games.show', [$competition->id, $game->id]) }}"
                                        class="item-tooltip-box tooltip-link tooltip-right" role="tooltip">
                                        <span class="tooltip-content">
                                            <div class="game-details">
                                                <span class="game-datetime">
                                                    @php
                                                    $startDateTime = \Carbon\Carbon::parse($game->start_datetime);
                                                    echo $startDateTime->isoFormat('dddd[,] Do[.] MMMM[, ] HH:mm');
                                                    @endphp
                                                </span>
                                                <span class="game-team">
                                                    <span title="{{ $game->homeTeam->name }}" class="text-uppercase">
                                                        {{ $game->homeTeam->name_short }}
                                                    </span>
                                                </span>
                                                <span class="game-score">
                                                    {{ $game->home_team_score }}&nbsp;|&nbsp;{{ $game->away_team_score }}
                                                </span>
                                                <span class="game-team">
                                                    <span title="{{ $game->awayTeam->name }}" class="text-uppercase">
                                                        {{ $game->awayTeam->name_short }}
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

                <div class="p-3">
                    @if ($rule->isAppliedMutualBalance())
                    <p>@lang('messages.apply_mutual_balance_info')</p>
                    @endif
                </div>
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