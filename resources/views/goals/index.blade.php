@extends('layouts.master')

@section('title')
@lang('messages.goals') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.goals')
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content text-center">
            <div class="content-block container">
                @if (count($competition->goals) > 0)
                <div class="list-group">
                    <table class="table table-striped table-dark table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('messages.player')</th>
                                <th scope="col">@lang('messages.position')</th>
                                <th scope="col">@lang('messages.team')</th>
                                <th scope="col">@lang('messages.goals')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($competition->goals as $key => $goal)
                            @php
                            $key += 1;
                            @endphp
                            <tr>
                                <td>
                                    {{ $key ?? '' }}
                                </td>
                                <td>
                                    <a
                                        href="{{ route('players.show', [$competition->id, $goal->team->id, $goal->player->id]) }}">
                                        {{ $goal->player->lastname }} {{ $goal->player->firstname }}
                                    </a>
                                </td>
                                <td>
                                    @lang('messages.' . $goal->player->position)
                                </td>
                                <td>
                                    <a href="{{ route('teams.show', [$competition->id, $goal->team->id]) }}">
                                        {{ $goal->team->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $goal->amount }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection