@extends('layouts.master')

@section('title')
    @lang('messages.prediction_competition') | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col-4 col-left">
                    @lang('messages.prediction_competition') - {{ $currentRound ?? '' }}. @lang('messages.round')
                </div>
                <div class="col-8 col-right d-flex flex-row-reverse">
                    <div class="row">
                        @if (count($competition->rules) > 0)
                            <div class="col-auto pr-1">
                                <div class="dropdown">
                                    <button class="control-button dropdown-toggle" type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        {{ $rule->name ?? '' }}
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        {{-- <a class="dropdown-item" href="">
                                    @lang('messages.all')
                                </a> --}}
                                        @foreach ($competition->rules as $competitionRule)
                                            @if ($competitionRule->getFirstSchedule() !== null)
                                                <a class="dropdown-item{{ $competitionRule->id === $rule->id ? ' active' : '' }}"
                                                    href="{{ route('schedule.params-index', [$competition->id, $competitionRule->id, $competitionRule->getFirstSchedule()->round]) }}">
                                                    {{ $competitionRule->name ?? '' }}
                                                </a>
                                            @else
                                                @continue
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

        <div class="card-body p-0">
            <div class="content text-center">
                <div class="content-block">
                    @isset($games)
                        <div class="mt-2 text-center predictions-games">
                            <form method="POST" action="{{ route('predictions.store', [$competition->id]) }}">
                                @csrf

                                @forelse ($games as $game)
                                    @php
                                        $startDateTime = \Carbon\Carbon::parse($game->start_datetime);
                                    @endphp
                                    <div class="mt-3 mb-3">
                                        <div class="game-schedule-color text-center -mb-10 z-50">
                                            <span class="justify-content-center align-self-center">
                                                {{ $startDateTime->isoFormat('dddd[,] Do[.] Mo[.]') }}
                                                {{ $startDateTime->format('H:i') }}
                                            </span>
                                        </div>
                                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons"
                                            @if ($game->homeTeam?->primary_color_id !== null && $game->awayTeam?->primary_color_id !== null) style="background: linear-gradient(to right, rgba(7,14,30,0.65) 0%, rgba({{ $game->homeTeam?->primaryColor?->rgb_code }},0.65) 10%, rgba(7,14,30,0.65) 37%, rgba(7,14,30,0.65) 63%, rgba({{ $game->awayTeam?->primaryColor?->rgb_code }},0.65) 90%, rgba(7,14,30,0.65) 100%);" @endif>
                                            <label class="btn predictions-label predictions-label-home pt-4 pb-5">
                                                <input type="radio" name="options[{{ $game->id }}]" value="home"
                                                    autocomplete="off">
                                                <small class="text-lowercase" style="color: #acacac;">@lang('messages.will_win')</small>
                                                <span class="text-uppercase">{{ $game->homeTeam->name }}</span>
                                            </label>
                                            <label class="btn predictions-label predictions-label-draw pt-4 pb-5">
                                                <input type="radio" name="options[{{ $game->id }}]" value="draw"
                                                    autocomplete="off">
                                                <span class="text-lowercase">@lang('messages.draw')</span>
                                            </label>
                                            <label class="btn predictions-label predictions-label-away pt-4 pb-5">
                                                <input type="radio" name="options[{{ $game->id }}]" value="away"
                                                    autocomplete="off">
                                                <small class="text-lowercase" style="color: #acacac;">@lang('messages.will_win')</small>
                                                <span class="text-uppercase">{{ $game->awayTeam->name }}</span>
                                            </label>
                                            <input type="hidden" name="startDateTime[{{ $game->id }}]"
                                                value="{{ $startDateTime->timestamp }}">
                                        </div>
                                    </div>
                                @empty
                                    <div class="card-body p-0">
                                        <div class="content text-center">
                                            <div class="content-block">
                                                <div class="py-4 text-center">
                                                    @lang('messages.no_games_to_predict')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse

                                @if (count($games) > 0)
                                    <div class="form-group text-center mt-4">
                                        <button type="submit" class="btn btn-app">@lang('messages.save_predictions')</button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    @endisset

                    <div class="text-slate mt-4 mb-3">
                        <p>
                            <span><span class="badge bg-success text-dark rounded-pill p-1 pl-2 pr-2">2 body</span>
                                za správně
                                tipnutou
                                remízu</span>
                        </p>
                        <p>
                            <span><span class="badge bg-primary text-dark rounded-pill p-1 pl-2 pr-2">1 bod</span> za
                                správně
                                tipnutého
                                vítěze
                                zápasu</span>
                        </p>
                        <p>
                            <span><span class="badge bg-secondary text-white rounded-pill p-1 pl-2 pr-2">0 bodů</span> za
                                nesprávný
                                tip</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(() => {
            $('.clickable-row').click(function() {
                var url = $(this).data('url');
                window.location.href = url;
            });

            function checkGameTimes() {
                const now = Math.floor(Date.now() / 1000);
                $('.predictions-games .game-schedule-color').each(function() {
                    const gameDiv = $(this).closest('.mt-3.mb-3');
                    const startDateTime = parseInt(gameDiv.find('input[name^="startDateTime"]').val());

                    if (startDateTime < now) {
                        gameDiv.remove();
                    }
                });
            }

            setInterval(checkGameTimes, 10000);
        });
    </script>
@endsection
