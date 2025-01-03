@extends('layouts.master')

@section('title')
    @lang('messages.results') | {{ $competition->name }} | {{ $competition->season->name_short ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col-4 col-left">
                    @lang('messages.results')
                </div>
                <div class="col-8 col-right d-flex flex-row-reverse">
                    <div class="row">
                        @can('crud_games')
                            <div class="col-auto pr-1">
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        @if ($rule !== null)
                                            <a class="crud-button"
                                                href="{{ route('games-rule.create', [$competition->id, $rule->id]) }}">
                                                <div class="plus"></div>
                                            </a>
                                        @else
                                            <a class="crud-button" href="{{ route('games.create', $competition->id) }}">
                                                <div class="plus"></div>
                                            </a>
                                        @endif
                                    </li>
                                </ul>
                            </div>

                            <div class="col-auto pr-1">
                                <div class="dropdown">
                                    <button class="control-button dropdown-toggle" type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        @lang('messages.prediction_competition')
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item"
                                            href="{{ route('admin.recalculate-leaderboard', [$competition->id, $rule->id, $currentRound]) }}">
                                            @lang('messages.recalculate')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endcan

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
                                            @if ($competitionRule->getLastResultByRound() !== null)
                                                <a class="dropdown-item{{ $competitionRule->id === $rule->id ? ' active' : '' }}"
                                                    href="{{ route('results.params-index', [$competition->id, $competitionRule->id, $competitionRule->getLastResultByRound()->round]) }}">
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
                                                href="{{ route('results.params-index', [$competition->id, $rule->id, $round]) }}">
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
                            @include('partials/games')
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
