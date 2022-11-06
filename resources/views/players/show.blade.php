@extends('layouts.master')

@section('title')
    {{ $player->firstname }} {{ $player->lastname }} | {{ $competition->name }} |
    {{ $competition->season->name_short ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    @lang('messages.player')
                </div>

                @can('crud_players')
                    <div class="col">
                        <ul class="list-inline justify-content-end">
                            <li class="list-inline-item">
                                <a class="crud-button"
                                    href="{{ route('players.edit', [$competition->id, $team->id, $player->id]) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <form method="POST"
                                    action="{{ route('players.destroy', [$competition->id, $team->id, $player->id]) }}"
                                    autocomplete="off">
                                    @csrf
                                    @method('DELETE')

                                    @include('partials/modals.delete')
                                </form>
                            </li>
                        </ul>
                    </div>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <div class="content">
                <div class="content-block">
                    <h1>
                        {{ mb_convert_case($player->firstname, MB_CASE_TITLE, 'UTF-8') }}
                        {{ mb_convert_case($player->lastname, MB_CASE_TITLE, 'UTF-8') }} {{ $player->jersey_number }}
                    </h1>

                    <div class="row mt-5">
                        <div class="col">
                            <h5>
                                @if ($age !== null)
                                    {{ $age }} |
                                @endif
                                @if ($player->position !== null)
                                    @lang('messages.' . $player->position) |
                                @endif
                                @if ($player->height !== null)
                                    {{ $player->height }} |
                                @endif
                                @if ($player->nationality !== null)
                                    {{ $player->nationality }}
                                @endif
                            </h5>
                        </div>
                    </div>

                    <div class="my-4 row justify-content-center">
                        @if (isset($goals) && $goals->isNotEmpty())
                            <div class="col-lg-4">
                                @include('partials/goals.selection')
                            </div>
                        @endif

                        @if (isset($yellowCards) && $yellowCards->isNotEmpty())
                            <div class="col-lg-4">
                                @include('partials/cards.yellow-selection')
                            </div>
                        @endif

                        @if (isset($redCards) && $redCards->isNotEmpty())
                            <div class="col-lg-4">
                                @include('partials/cards.red-selection')
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
