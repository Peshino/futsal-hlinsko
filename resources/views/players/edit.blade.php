@extends('layouts.admin')

@section('title')
    {{ $player->firstname }} {{ $player->lastname }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    @lang('messages.edit') - {{ $player->firstname }} {{ $player->lastname }}
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="content">
                <div class="content-block">
                    <form method="POST" action="{{ route('players.update', [$competition->id, $team->id, $player->id]) }}"
                        autocomplete="off">
                        @csrf
                        @method('PATCH')

                        <div class="row form-group">
                            <div class="firstname col-md">
                                <div class="floating-label">
                                    <label for="firstname">@lang('messages.firstname')</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                        value="{{ $player->firstname }}" required />
                                </div>
                            </div>
                            <div class="lastname col-md">
                                <div class="floating-label">
                                    <label for="lastname">@lang('messages.lastname')</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        value="{{ $player->lastname }}" required />
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="jersey-number col-md">
                                <div class="floating-label">
                                    <label for="jersey-number">@lang('messages.jersey_number')</label>
                                    <input type="number" min="1" max="999" class="form-control"
                                        id="jersey-number" name="jersey_number" value="{{ $player->jersey_number }}" />
                                </div>
                            </div>
                            <div class="birthdate col-md">
                                <div class="floating-label">
                                    <label for="birthdate">@lang('messages.birthdate')</label>
                                    <input type="text" class="form-control input-datepicker" id="birthdate"
                                        name="birthdate" autocomplete="off" value="{{ $player->birthdate }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="position col-md">
                                <div class="floating-label">
                                    <label for="position">
                                        @lang('messages.position')
                                    </label>
                                    <select class="form-control" id="position" name="position">
                                        <option value=""></option>
                                        <option {{ $player->position === 'goalkeeper' ? 'selected' : '' }}
                                            value="goalkeeper">
                                            @lang('messages.goalkeeper')
                                        </option>
                                        <option {{ $player->position === 'defender' ? 'selected' : '' }} value="defender">
                                            @lang('messages.defender')
                                        </option>
                                        <option {{ $player->position === 'universal' ? 'selected' : '' }}
                                            value="universal">
                                            @lang('messages.universal')
                                        </option>
                                        <option {{ $player->position === 'forward' ? 'selected' : '' }} value="forward">
                                            @lang('messages.forward')
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="photo col-md">
                                <div class="floating-label">
                                    <label for="photo">@lang('messages.photo')</label>
                                    <input type="text" class="form-control" id="photo" name="photo"
                                        value="{{ $player->photo }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="futis-code col-md">
                                <div class="floating-label">
                                    <label for="futis-code">@lang('messages.futis_code')</label>
                                    <input type="number" min="0" class="form-control" id="futis-code"
                                        name="futis_code" value="{{ $player->futis_code }}" />
                                </div>
                            </div>
                            <div class="height col-md">
                                <div class="floating-label">
                                    <label for="height">@lang('messages.height')</label>
                                    <input type="number" min="0" max="999" class="form-control" id="height"
                                        name="height" value="{{ $player->height }}" />
                                </div>
                            </div>
                            <div class="nationality col-md">
                                <div class="floating-label">
                                    <label for="nationality">@lang('messages.nationality')</label>
                                    <input type="text" class="form-control" id="nationality" name="nationality"
                                        value="{{ $player->nationality }}" />
                                </div>
                            </div>
                        </div>


                        <input type="hidden" id="team-id" name="team_id" value="{{ $team->id }}">
                        <input type="hidden" id="competition-id" name="competition_id" value="{{ $competition->id }}">

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-app">@lang('messages.edit_player')</button>
                        </div>

                        @include('partials.errors')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
