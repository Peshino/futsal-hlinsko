@extends('layouts.admin')

@section('title')
{{ $player->firstname ?? '' }} {{ $player->lastname ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                {{ $player->firstname ?? '' }} {{ $player->lastname ?? '' }} - {{ $team->name ?? '' }} -
                {{ $competition->name }}
            </div>

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
        </div>
    </div>

    <div class="card-body">
        <div class="content">
            <div class="content-block">


                <h4>
                    @lang('messages.players')
                </h4>
            </div>
        </div>
    </div>
</div>
@endsection