@extends('layouts.master')

@section('title')
    @lang('messages.teams') | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
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
                    <div class="mx-3">
                        <div class="row d-flex justify-content-center">
                            @foreach ($competition->teams as $team)
                                <a href="{{ route('teams.show', [$competition->id, $team->id]) }}"
                                    class="col-12 col-sm-5 col-md-5 col-lg-3 col-xl-2 py-3 m-2 bg-dark rounded">
                                    {{ $team->name ?? '' }} <br />
                                    <span class="text-secondary">{{ $team->name_short }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
