@extends('layouts.admin')

@section('title')
{{ $team->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
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
                            <button class="crud-button" type="button" data-toggle="modal"
                                data-target="#modal-team-delete"><i class="far fa-trash-alt"></i></button>

                            <div class="modal fade" id="modal-team-delete" tabindex="-1" role="dialog"
                                aria-labelledby="modal-team-delete-title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal-team-delete-title">
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
                            <input type="text" class="form-control border-dark" id="web-presentation" name="web_presentation"
                                value="{{ $team->web_presentation }}" disabled />
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="superior-team col-md">
                        <div class="floating-label">
                            <label for="superior-team">@lang('messages.superior_team')</label>
                            <input type="text" class="form-control border-dark" id="superior-team" name="superior_team"
                                value="{{ $team->superiorTeam->name ?? '' }}" disabled />
                        </div>
                    </div>
                    <div class="inferior-team col-md">
                        <div class="floating-label">
                            <label for="inferior-team">@lang('messages.inferior_team')</label>
                            <input type="text" class="form-control border-dark" id="inferior-team" name="inferior_team"
                                value="{{ $team->inferiorTeam->name ?? '' }}" disabled />
                        </div>
                    </div>
                </div>

                <h4>
                    @lang('messages.players')
                </h4>
            </div>
        </div>
    </div>
</div>
@endsection