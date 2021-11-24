@extends('layouts.master')

@section('title')
@lang('messages.goals') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.goals')
            </div>

            <div class="col-8 col-right d-flex flex-row-reverse">
                <div class="row">
                    @if (count($competition->rules) > 0)
                    <div class="col-auto pr-1">
                        <div class="dropdown">
                            <button class="control-button dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                @if ($rule === null)
                                @lang('messages.rules')
                                @else
                                {{ $rule->name ?? '' }}
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('goals.index', [$competition->id]) }}">
                                    @lang('messages.all')
                                </a>
                                @foreach ($competition->rules as $competitionRule)
                                <a class="dropdown-item{{ $rule !== null && $competitionRule->id === $rule->id ? "
                                    active" : "" }}"
                                    href="{{ route('goals.rule-index', [$competition->id, $competitionRule->id, null]) }}">
                                    {{ $competitionRule->name ?? '' }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    @if (count($goalsTeams) > 0)
                    <div class="col-auto pr-1">
                        <div class="dropdown">
                            <button class="control-button dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                @if ($team === null)
                                @lang('messages.teams')
                                @else
                                {{ $team->name_short ?? '' }}
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item"
                                    href="{{ route('goals.' . ($rule !== null ? 'rule-' : '') . 'index', [$competition->id, $rule !== null ? $rule->id : 'all', null]) }}">
                                    @lang('messages.all')
                                </a>
                                @foreach ($goalsTeams as $goalsTeam)
                                <a class="dropdown-item{{ ($team !== null && $goalsTeam->id === $team->id) ? " active"
                                    : "" }}"
                                    href="{{ route('goals.team-index', [$competition->id, $rule !== null ? $rule->id : 'all', $goalsTeam->id]) }}">
                                    {{ $goalsTeam->name ?? '' }}
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
            <div class="content-block container">
                @if (count($goals) > 0)
                <div class="list-group">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" class="text-left">@lang('messages.player')</th>
                                <th scope="col" class="text-left">@lang('messages.team')</th>
                                <th scope="col"><i class="far fa-futbol ball"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($goals as $key => $goal)
                            @php
                            $key += 1;
                            @endphp
                            <tr>
                                <td>
                                    {{ $key ?? '' }}.
                                </td>
                                <td class="text-left">
                                    <a
                                        href="{{ route('players.show', [$competition->id, $goal->team->id, $goal->player->id]) }}">
                                        {{ $goal->player->lastname }} {{ $goal->player->firstname }}
                                    </a>
                                    <span class="badge text-light app-bg"
                                        title="@lang('messages.' . $goal->player->position)">
                                        @lang('messages.' . $goal->player->position . '_short')
                                    </span>
                                </td>
                                <td class="text-left">
                                    <a href="{{ route('teams.show', [$competition->id, $goal->team->id]) }}">
                                        <div class="team-name-long">
                                            {{ $goal->team->name }}
                                        </div>
                                        <div class="team-name-short" title="{{ $goal->team->name }}">
                                            {{ $goal->team->name_short }}
                                        </div>
                                    </a>
                                </td>
                                <td class="competition-color">
                                    <strong>{{ $goal->amount }}</strong>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                -----
                @endif
            </div>
        </div>
    </div>
</div>
@endsection