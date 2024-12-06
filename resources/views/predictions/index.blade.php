@extends('layouts.master')

@section('title')
    @lang('messages.prediction_competition') | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col-4 col-left">
                    @lang('messages.schedule')
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

                        @if (count($rounds) > 0)
                            <div class="col-auto">
                                <div class="dropdown pr-1">
                                    <button class="control-button dropdown-toggle" type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        {{ $currentRound }}. @lang('messages.round')
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        {{-- <a class="dropdown-item" href="">
                                    @lang('messages.all')
                                </a> --}}
                                        @foreach ($rounds as $round)
                                            <a class="dropdown-item{{ $round === $currentRound ? ' active' : '' }}"
                                                href="{{ route('schedule.params-index', [$competition->id, $rule->id, $round]) }}">
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

        <div class="card-body p-0">
            <div class="content text-center">
                <div class="content-block">
                    @isset($games)
                        <div class="mt-2 text-center">
                            <form method="POST" action="{{ route('predictions.store', [$competition->id]) }}">
                                @csrf

                                <select name="tip" required>
                                    <option value="home">Domácí</option>
                                    <option value="draw">Remíza</option>
                                    <option value="away">Hosté</option>
                                </select>
                                <input type="hidden" name="match_id" value="">
                                <button type="submit">Odeslat tip</button>

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
