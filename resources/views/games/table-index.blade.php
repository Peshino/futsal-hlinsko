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
                                {{ $rule->name ?? '' }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                {{-- <a class="dropdown-item" href="">
                            @lang('messages.all')
                        </a> --}}
                                @foreach ($competition->rules as $competitionRule)
                                @if ($competitionRule->getLastResultByRound() !== null)
                                <a class="dropdown-item{{ $competitionRule->id === $rule->id ? " active" : "" }}"
                                    href="{{ route($competitionRule->type . '.params-index', [$competition->id, $competitionRule->id, $competitionRule->getLastResultByRound()->round]) }}">
                                    {{ $competitionRule->name ?? '' }}
                                </a>
                                @else
                                <a class="dropdown-item{{ $competitionRule->id === $rule->id ? " active" : "" }}"
                                    href="{{ route('games.index', [$competition->id, $competitionRule->type, $competitionRule->id]) }}">
                                    {{ $competitionRule->name ?? '' }}
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
                                    href="{{ route($rule->type . '.params-index', [$competition->id, $rule->id, $round]) }}">
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
                        <tr style="font-size: 0.8rem;">
                            <th scope="col">@lang('messages.position')</th>
                            <th scope="col" class="text-left">@lang('messages.team')</th>
                            <th scope="col">@lang('messages.games')</th>
                            <th scope="col">Výhry</th>
                            <th scope="col">Remízy</th>
                            <th scope="col">Prohry</th>
                            <th scope="col">Skóre</th>
                            <th scope="col">GR</th>
                            <th scope="col">Body</th>
                            <th scope="col">Forma <i class="fas fa-long-arrow-alt-left"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tableData as $tableItem)
                        <tr>
                            <td>
                                @if ($tableItem->team_previous_position !== null)
                                @php
                                $positionDifference = abs($tableItem->team_actual_position -
                                $tableItem->team_previous_position);
                                @endphp

                                @if ($tableItem->team_actual_position < $tableItem->team_previous_position)
                                    <span class="text-success">
                                        @if ($positionDifference < 4) <i class="fas fa-angle-up"></i>
                                            @else
                                            <i class="fas fa-angle-double-up"></i>
                                            @endif
                                    </span>
                                    @elseif ($tableItem->team_actual_position > $tableItem->team_previous_position)
                                    <span class="text-danger">
                                        @if ($positionDifference < 4) <i class="fas fa-angle-down"></i>
                                            @else
                                            <i class="fas fa-angle-double-down"></i>
                                            @endif
                                    </span>
                                    @else
                                    <span class="text-primary" style="font-size: 0.45rem;">
                                        <i class="fas fa-circle"></i>
                                    </span>
                                    @endif
                                    &nbsp;

                                    @endif
                                    {{ $tableItem->team_actual_position }}
                            </td>
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
                                @include('partials/team-form')
                                @endforeach
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-3">
                    @if ($rule->isAppliedMutualBalance())
                    <p class="text-left">
                        <i class="fas fa-info-circle text-info"></i> @lang('messages.apply_mutual_balance_info')
                    </p>
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