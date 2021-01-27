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
        <div class="content text-center">
            <div class="content-block">
                @if (count($competition->teams) > 0)
                <table class="table table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            <th scope="col">@lang('messages.name')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($competition->teams as $team)
                        <div class="container mt-3">
                            <tr class="clickable-row"
                                data-url="{{ route('teams.admin-show', [$competition->id, $team->id]) }}">
                                <td>
                                    {{ $team->name ?? '' }}
                                </td>
                            </tr>
                        </div>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection