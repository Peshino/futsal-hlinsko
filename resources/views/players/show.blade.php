@extends('layouts.master')

@section('title')
{{ $player->firstname }} {{ $player->lastname }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
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
                            <button class="crud-button" type="button" data-toggle="modal"
                                data-target="#modal-player-delete"><i class="far fa-trash-alt"></i></button>

                            <div class="modal fade" id="modal-player-delete" tabindex="-1" role="dialog"
                                aria-labelledby="modal-player-delete-title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal-player-delete-title">
                                                @lang('messages.really_delete')
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">
                                                @lang('messages.delete')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                <h1>{{ $player->firstname }} {{$player->lastname}} {{ $player->jersey_number }}</h1>

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
            </div>
        </div>
    </div>
</div>
@endsection