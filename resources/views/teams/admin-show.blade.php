@extends('layouts.admin')

@section('title')
    {{ $team->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    {{ $team->name ?? '' }} - {{ $competition->name }}
                </div>

                <div class="col">
                    <ul class="list-inline justify-content-end">
                        <li class="list-inline-item">
                            <a class="crud-button" href="{{ route('teams.edit', [$competition->id, $team->id]) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <form method="POST" action="{{ route('teams.destroy', [$competition->id, $team->id]) }}"
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
                    <div class="row form-group">
                        <div class="name col-md">
                            <div class="floating-label">
                                <label for="name">@lang('messages.name')</label>
                                <input type="text" class="form-control border-dark" id="name" name="name"
                                    value="{{ $team->name }}" disabled />
                            </div>
                        </div>
                        <div class="name-short col-md">
                            <div class="floating-label">
                                <label for="name-short">@lang('messages.name_short')</label>
                                <input type="text" class="form-control border-dark" id="name-short" name="name_short"
                                    value="{{ $team->name_short }}" disabled />
                            </div>
                        </div>
                        <div class="web-presentation col-md">
                            <div class="floating-label">
                                <label for="web-presentation">@lang('messages.web_presentation')</label>
                                <input type="text" class="form-control border-dark" id="web-presentation"
                                    name="web_presentation" value="{{ $team->web_presentation }}" disabled />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="superior-team col-md">
                            <div class="floating-label">
                                <label for="superior-team">@lang('messages.superior_team')</label>
                                <input type="text" class="form-control border-dark" id="superior-team"
                                    name="superior_team" value="{{ $team->superiorTeam->name ?? '' }}" disabled />
                            </div>
                        </div>
                        <div class="inferior-team col-md">
                            <div class="floating-label">
                                <label for="inferior-team">@lang('messages.inferior_team')</label>
                                <input type="text" class="form-control border-dark" id="inferior-team"
                                    name="inferior_team" value="{{ $team->inferiorTeam->name ?? '' }}" disabled />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
