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

                                @foreach ($games as $game)
                                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                        <label class="btn btn-outline-primary w-33 pt-4 pb-5">
                                            <input type="radio" name="options[{{ $game->id }}]" value="home"
                                                autocomplete="off">
                                            Zvítězí {{ $game->homeTeam->name }}
                                        </label>
                                        <label class="btn btn-outline-primary w-33 pt-4 pb-5">
                                            <input type="radio" name="options[{{ $game->id }}]" value="draw"
                                                autocomplete="off">
                                            Remíza
                                        </label>
                                        <label class="btn btn-outline-primary w-33 pt-4 pb-5">
                                            <input type="radio" name="options[{{ $game->id }}]" value="away"
                                                autocomplete="off">
                                            Zvítězí {{ $game->awayTeam->name }}
                                        </label>
                                    </div>
                                @endforeach

                                <div class="form-group text-center mt-4">
                                    <button type="submit" class="btn btn-app">@lang('messages.save_predictions')</button>
                                </div>
                            </form>
                        </div>
                    @endisset
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
        });
    </script>
@endsection
