@extends('layouts.master')

@section('title')
    @lang('messages.table') | {{ $competition->name }} | {{ $competition->season->name_short ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
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
                                                <a class="dropdown-item{{ $competitionRule->id === $rule->id ? ' active' : '' }}"
                                                    href="{{ route($competitionRule->type . '.params-index', [$competition->id, $competitionRule->id, $competitionRule->getLastResultByRound()->round]) }}">
                                                    {{ $competitionRule->name ?? '' }}
                                                </a>
                                            @else
                                                <a class="dropdown-item{{ $competitionRule->id === $rule->id ? ' active' : '' }}"
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
                                            <a class="dropdown-item{{ $round === $toRound ? ' active' : '' }}"
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

        <div class="card-body no-x-padding">
            <div class="content">
                <div class="content-block">
                    <table class="table table-hover table-dark table-index">
                        <thead>
                            <tr style="font-size: 0.8rem;">
                                <th scope="col" class="text-center">
                                    <div class="th-full">
                                        @lang('messages.position')
                                    </div>
                                    <div class="th-short" title="@lang('messages.position')">
                                        @lang('messages.position_short')
                                    </div>
                                </th>
                                <th scope="col" class="text-left">
                                    @lang('messages.team')
                                </th>
                                <th scope="col" class="text-center">
                                    <div class="th-full">
                                        @lang('messages.games')
                                    </div>
                                    <div class="th-short" title="@lang('messages.games')">
                                        @lang('messages.games_short')
                                    </div>
                                </th>
                                <th scope="col" class="text-center">
                                    <div class="th-full">
                                        @lang('messages.wins')
                                    </div>
                                    <div class="th-short" title="@lang('messages.wins')">
                                        @lang('messages.wins_short')
                                    </div>
                                </th>
                                <th scope="col" class="text-center">
                                    <div class="th-full">
                                        @lang('messages.draws')
                                    </div>
                                    <div class="th-short" title="@lang('messages.draws')">
                                        @lang('messages.draws_short')
                                    </div>
                                </th>
                                <th scope="col" class="text-center">
                                    <div class="th-full">
                                        @lang('messages.losses')
                                    </div>
                                    <div class="th-short" title="@lang('messages.losses')">
                                        @lang('messages.losses_short')
                                    </div>
                                </th>
                                <th scope="col" class="text-center hide-medium">
                                    <div class="th-full">
                                        @lang('messages.score')
                                    </div>
                                    <div class="th-short" title="@lang('messages.score')">
                                        @lang('messages.score_short')
                                    </div>
                                </th>
                                <th scope="col" class="text-center">
                                    <div title="@lang('messages.goal_difference')">
                                        @lang('messages.goal_difference_short')
                                    </div>
                                </th>
                                <th scope="col" class="text-center">
                                    <div class="th-full">
                                        @lang('messages.points')
                                    </div>
                                    <div class="th-short" title="@lang('messages.points')">
                                        @lang('messages.points_short')
                                    </div>
                                </th>
                                <th scope="col" class="text-center hide-large">
                                    @lang('messages.form') <i class="fas fa-long-arrow-alt-left"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($tableData !== null)
                                @foreach ($tableData as $tableItem)
                                    @php
                                        // $qualifications =
                                    @endphp
                                    <tr>
                                        <td class="text-center{{ isset($tableItem->team_phase) ? ' ' . $tableItem->team_phase->phase . '-bg-' . $tableItem->team_phase->order : '' }}"
                                            data-toggle="{{ $tableItem->team_previous_position !== null || isset($tableItem->team_phase) ? 'popover' : '' }}"
                                            title="{{ $tableItem->team_name }}"
                                            data-content="
                                    @if ($tableItem->team_previous_position !== null) @lang('messages.previous_position') <strong>{{ $tableItem->team_previous_position }}</strong><br /> @endif
                                    @isset($tableItem->team_phase)
                                        @lang('messages.' . $tableItem->team_phase->phase) <strong>{{ $tableItem->team_phase->toRule->name }}</strong>
                                    @endisset
                                ">
                                            <span class="table-position">
                                                {{ $tableItem->team_current_position ?? '' }}
                                            </span>

                                            @if ($tableItem->team_previous_position !== null)
                                                @php
                                                    $positionDifference = abs($tableItem->team_current_position - $tableItem->team_previous_position);
                                                @endphp

                                                @if ($tableItem->team_current_position < $tableItem->team_previous_position)
                                                    <span class="table-position-difference text-success">
                                                        @if ($positionDifference < 4)
                                                            <i class="fas fa-angle-up"></i>
                                                        @else
                                                            <i class="fas fa-angle-double-up"></i>
                                                        @endif
                                                    </span>
                                                @elseif ($tableItem->team_current_position > $tableItem->team_previous_position)
                                                    <span class="table-position-difference text-danger">
                                                        @if ($positionDifference < 4)
                                                            <i class="fas fa-angle-down"></i>
                                                        @else
                                                            <i class="fas fa-angle-double-down"></i>
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="table-position-difference text-muted">
                                                        <i class="fas fa-circle"></i>
                                                    </span>
                                                @endif
                                            @endif

                                        </td>
                                        <td class="text-left">
                                            <a href="{{ route('teams.show', [$competition->id, $tableItem->team_id]) }}">
                                                <div class="team-name-long">
                                                    {{ $tableItem->team_name }}
                                                </div>
                                                <div class="team-name-short" title="{{ $tableItem->team_name }}">
                                                    {{ $tableItem->team_name_short }}
                                                </div>
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $tableItem->games_count }}</td>
                                        <td class="text-center text-secondary">{{ $tableItem->wins }}</td>
                                        <td class="text-center text-secondary">{{ $tableItem->draws }}</td>
                                        <td class="text-center text-secondary">{{ $tableItem->losses }}</td>
                                        <td class="text-center text-secondary hide-medium">
                                            {{ $tableItem->team_goals_scored }}&nbsp;:&nbsp;{{ $tableItem->team_goals_received }}
                                        </td>

                                        @php
                                            if ((int) $tableItem->team_goals_difference > 0) {
                                                $teamGoalsDifferenceClass = 'text-success';
                                            } elseif ((int) $tableItem->team_goals_difference === 0) {
                                                $teamGoalsDifferenceClass = 'text-muted';
                                            } else {
                                                $teamGoalsDifferenceClass = 'text-danger';
                                            }
                                            
                                        @endphp

                                        <td class="text-center {{ $teamGoalsDifferenceClass }}">
                                            {{ (int) $tableItem->team_goals_difference > 0 ? '+' : '' }}{{ $tableItem->team_goals_difference }}
                                        </td>
                                        <td class="competition-color text-center">
                                            <strong>{{ $tableItem->points }}</strong>
                                        </td>
                                        <td class="form text-center hide-large">
                                            @if ($tableItem->team_first_schedule !== null)
                                                @php
                                                    $teamFirstSchedule = $tableItem->team_first_schedule;
                                                @endphp
                                                @include('partials/teams.first-schedule')
                                            @endif
                                            @if ($tableItem->team_form !== null && $tableItem->team_form->isNotEmpty())
                                                <i class="fas fa-chevron-left text-secondary"></i>
                                                @foreach ($tableItem->team_form as $game)
                                                    @include('partials/teams.form')
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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
