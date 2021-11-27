@extends('layouts.master')

@section('title')
@lang('messages.teams') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.teams')
            </div>
            @can('crud_teams')
            <div class="col">
                <ul class="list-inline justify-content-end">
                    <li class="list-inline-item">
                        <a class="crud-button" href="{{ route('teams.create', $competition->id) }}">
                            <div class="plus"></div>
                        </a>
                    </li>
                </ul>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body">
        <div class="content">
            @if (count($competition->teams) > 0)
            <div class="d-inline-flex flex-wrap justify-content-center">
                @foreach ($competition->teams as $team)
                <a href="{{ route('teams.show', [$competition->id, $team->id]) }}"
                    class="px-4 py-25 m-1 text-uppercase">
                    {{ $team->name ?? '' }}
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection