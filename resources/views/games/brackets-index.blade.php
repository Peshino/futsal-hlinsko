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

    <div class="card-body no-padding">
        <div class="content text-center">
            <div class="content-block">
                pavouk
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