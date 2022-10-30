@extends('layouts.master')

@section('title')
    @lang('messages.players') | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    @lang('messages.players')
                </div>
                @can('crud_players')
                    <div class="col">
                        <ul class="list-inline justify-content-end">
                            <li class="list-inline-item">
                                <a class="crud-button" href="{{ route('players.create', [$competition->id, $team->id]) }}">
                                    <div class="plus"></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <div class="content text-center">
                <div class="content-block container">
                    @if (count($team->players) > 0)
                        <div class="list-group">
                            @foreach ($team->players as $player)
                                <a href="{{ route('players.show', [$competition->id, $team->id, $player->id]) }}"
                                    class="list-group-item list-group-item-action text-uppercase">
                                    {{ $player->firstname ?? '' }} {{ $player->lastname ?? '' }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
