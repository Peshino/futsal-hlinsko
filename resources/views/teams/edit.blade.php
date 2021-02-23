@extends('layouts.admin')

@section('title')
@lang('messages.edit') {{ $team->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.edit') {{ $team->name ?? '' }} - {{ $competition->name }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content">
            <div class="content-block">
                <form method="POST" action="{{ route('teams.update', [$competition->id, $team->id]) }}"
                    autocomplete="off">
                    @csrf
                    @method('PATCH')

                    <div class="row form-group">
                        <div class="name col-md">
                            <div class="floating-label">
                                <label for="name">@lang('messages.name')</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $team->name ?? '' }}" required />
                            </div>
                        </div>
                        <div class="name-short col-md">
                            <div class="floating-label">
                                <label for="name-short">@lang('messages.name_short')</label>
                                <input type="text" class="form-control" id="name-short" name="name_short"
                                    value="{{ $team->name_short }}" required />
                            </div>
                        </div>
                        <div class="web-presentation col-md">
                            <div class="floating-label">
                                <label for="web-presentation">@lang('messages.web_presentation')</label>
                                <input type="text" class="form-control" id="web-presentation" name="web_presentation"
                                    value="{{ $team->web_presentation }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="superior-team-id col-md">
                            <div class="floating-label">
                                <label for="superior-team-id">
                                    @lang('messages.superior_team')
                                </label>
                                <select class="form-control" id="superior-team-id" name="superior_team_id">
                                    <option value=""></option>
                                    @if (count($otherTeams) > 0)
                                    @foreach ($otherTeams as $otherTeam)
                                    <option {{ $team->superior_team_id === $otherTeam->id ? "selected" : "" }}
                                        value="{{ $otherTeam->id }}">
                                        {{ $otherTeam->name ?? '' }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="inferior-team-id col-md">
                            <div class="floating-label">
                                <label for="inferior-team-id">
                                    @lang('messages.inferior_team')
                                </label>
                                <select class="form-control" id="inferior-team-id" name="inferior_team_id">
                                    <option value=""></option>
                                    @if (count($otherTeams) > 0)
                                    @foreach ($otherTeams as $otherTeam)
                                    <option {{ $team->inferior_team_id === $otherTeam->id ? "selected" : "" }}
                                        value="{{ $otherTeam->id }}">
                                        {{ $otherTeam->name ?? '' }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="competition-id" name="competition_id" value="{{ $team->competition_id }}">

                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn introduction-btn">@lang('messages.edit_team')</button>
                    </div>

                    @include('partials.errors')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection