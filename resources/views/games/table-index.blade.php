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
        <div class="content">
            <div class="content-block">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr style="font-size: 0.8rem;">
                            <th scope="col" class="text-center">@lang('messages.position')</th>
                            <th scope="col" class="text-left">@lang('messages.team')</th>
                            <th scope="col" class="text-center">@lang('messages.games')</th>
                            <th scope="col" class="text-center">Výhry</th>
                            <th scope="col" class="text-center">Remízy</th>
                            <th scope="col" class="text-center">Prohry</th>
                            <th scope="col" class="text-center">Skóre</th>
                            <th scope="col" class="text-center">GR</th>
                            <th scope="col" class="text-center">Body</th>
                            <th scope="col" class="text-center">Forma <i class="fas fa-long-arrow-alt-left"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tableData as $tableItem)
                        @php
                        // $qualifications =
                        @endphp
                        <tr>
                            <td class="text-center{{ isset($tableItem->team_phase) ? ' ' . $tableItem->team_phase->phase . '-bg-' . $tableItem->team_phase->order : '' }}"
                                data-toggle="popover" title="{{ $tableItem->team_name }}" data-content="
                                    @if ($tableItem->team_previous_position !== null)
                                        @lang('messages.previous_position') <strong>{{ $tableItem->team_previous_position }}</strong><br />
                                    @endif
                                    @isset ($tableItem->team_phase)
                                        @lang('messages.' . $tableItem->team_phase->phase) <strong>{{ $tableItem->team_phase->toRule->name }}</strong>
                                    @endisset
                                ">
                                @if ($tableItem->team_previous_position !== null)
                                @php
                                $positionDifference = abs($tableItem->team_current_position -
                                $tableItem->team_previous_position);
                                @endphp

                                @if ($tableItem->team_current_position < $tableItem->team_previous_position)
                                    <span class="table-position-difference text-success">
                                        @if ($positionDifference < 4) <i class="fas fa-angle-up"></i>
                                            @else
                                            <i class="fas fa-angle-double-up"></i>
                                            @endif
                                    </span>
                                    @elseif ($tableItem->team_current_position > $tableItem->team_previous_position)
                                    <span class="table-position-difference text-danger">
                                        @if ($positionDifference < 4) <i class="fas fa-angle-down"></i>
                                            @else
                                            <i class="fas fa-angle-double-down"></i>
                                            @endif
                                    </span>
                                    @else
                                    <span class="table-position-difference text-primary">
                                        <i class="fas fa-circle"></i>
                                    </span>
                                    @endif
                                    @endif
                                    <span class="table-position">
                                        {{ $tableItem->team_current_position ?? '' }}.
                                    </span>
                            </td>
                            <td class="text-left">
                                <a href="{{ route('teams.show', [$competition->id, $tableItem->team_id]) }}">
                                    {{ $tableItem->team_name }}
                                </a>
                            </td>
                            <td class="text-center">{{ $tableItem->games_count }}</td>
                            <td class="text-center">{{ $tableItem->wins }}</td>
                            <td class="text-center">{{ $tableItem->draws }}</td>
                            <td class="text-center">{{ $tableItem->losts }}</td>
                            <td class="text-center">{{ $tableItem->team_goals_scored }}&nbsp;:&nbsp;{{
                                $tableItem->team_goals_received }}
                            <td class="text-center">{{ $tableItem->team_goals_difference }}</td>
                            <td class="competition-color text-center"><strong>{{ $tableItem->points }}</strong></td>
                            <td class="form text-center">
                                @if ($tableItem->team_first_schedule !== null)
                                @php
                                $teamFirstSchedule = $tableItem->team_first_schedule;
                                @endphp
                                @include('partials/team-first-schedule')
                                @endif
                                @if ($tableItem->team_form !== null && $tableItem->team_form->isNotEmpty())
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
    // $(() => {
    //     $('[data-toggle="popover"]').popover({
    //         trigger: 'focus',
    //         html: true,
    //         placement: 'top',
    //         container: '.form-item'
    //     })
    // });
</script>
@endsection