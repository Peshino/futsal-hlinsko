@extends('layouts.master')

@section('title')
@lang('messages.brackets') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.brackets')
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
                                    href="{{ route('games.index', [$competition->id, $competitionRule->type]) }}">
                                    {{ $competitionRule->name ?? '' }}
                                </a>
                                @endif
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
                {{-- https://codepen.io/jimmyhayek/pen/yJkdEB --}}
                {{-- https://www.commoninja.com/brackets/editor/styles/ --}}

                <div class="brackets">
                    @forelse ($brackets as $stage => $bracket)
                    <div class="bracket-round">
                        <h5 class="bracket-round-title">
                            @lang('messages.' . $stage)
                        </h5>
                        <ul class="bracket-list">
                            @foreach ($bracket as $game)
                            <li class="bracket-item">
                                @php
                                if ($game !== null) {
                                $startDateTime = \Carbon\Carbon::parse($game->start_datetime);
                                $startTime = $startDateTime->toTimeString();

                                if ($startTime === '00:00:00') {
                                $startDateTimeIsoFormat = $startDateTime->isoFormat('dddd[,] Do[.] MMMM');
                                } else {
                                $startDateTimeIsoFormat = $startDateTime->isoFormat('dddd[,] Do[.] MMMM[, ] HH:mm');
                                }
                                } else {
                                $startDateTimeIsoFormat = null;
                                }
                                @endphp
                                <div class="row w-100 text-center">
                                    <div class="col">
                                        <div class="schedule-color">
                                            <small>
                                                {{ $startDateTimeIsoFormat }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="bracket-match">
                                    <div class="row pb-2 border-bottom border-dark">
                                        <div class="col col-10 no-padding text-left">
                                            <div class="team-name-long">
                                                {{ $game->homeTeam->name ?? '-' }}
                                            </div>
                                            <div class="team-name-short" title="{{ $game->homeTeam->name ?? '-' }}">
                                                {{ $game->homeTeam->name_short ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col col-2 no-padding text-right">
                                            {{ $game->home_team_score ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="row pt-2">
                                        <div class="col col-10 no-padding text-left">
                                            <div class="team-name-long">
                                                {{ $game->awayTeam->name ?? '-' }}
                                            </div>
                                            <div class="team-name-short" title="{{ $game->awayTeam->name ?? '-' }}">
                                                {{ $game->awayTeam->name_short ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="col col-2 no-padding text-right">
                                            {{ $game->away_team_score ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @empty
                    <h3>
                        žádné zápasy zadané pro playoff
                    </h3>
                    @endforelse
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