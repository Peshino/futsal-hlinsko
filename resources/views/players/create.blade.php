@extends('layouts.admin')

@section('title')
@lang('messages.create_player') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.create_player') - {{ $team->name }} - {{ $competition->name }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content text-center">
            <div class="content-block">
                <form method="POST" action="{{ route('players.store', [$competition->id, $team->id]) }}">
                    @csrf

                    <div class="row form-group">
                        <div class="firstname col-md">
                            <div class="floating-label">
                                <label for="firstname">@lang('messages.firstname')</label>
                                <input type="text" class="form-control" id="firstname" name="firstname"
                                    value="{{ old('firstname') }}" required />
                            </div>
                        </div>
                        <div class="lastname col-md">
                            <div class="floating-label">
                                <label for="lastname">@lang('messages.lastname')</label>
                                <input type="text" class="form-control" id="lastname" name="lastname"
                                    value="{{ old('lastname') }}" required />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="jersey-number col-md">
                            <div class="floating-label">
                                <label for="jersey-number">@lang('messages.jersey_number')</label>
                                <input type="number" class="form-control" id="jersey-number" name="jersey_number"
                                    value="{{ old('jersey_number') }}" />
                            </div>
                        </div>
                        <div class="birthdate col-md">
                            <div class="floating-label">
                                <label for="birthdate">@lang('messages.birthdate')</label>
                                <input type="text" class="form-control input-datepicker" id="birthdate" name="birthdate"
                                    autocomplete="off" value="{{ old('birthdate') }}" />
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
                                    <option {{ old('position') === 'goalkeeper' ? "selected" : "" }} value="goalkeeper">
                                        @lang('messages.goalkeeper')
                                    </option>
                                    <option {{ old('position') === 'defender' ? "selected" : "" }} value="defender">
                                        @lang('messages.defender')
                                    </option>
                                    <option {{ old('position') === 'universal' ? "selected" : "" }} value="universal">
                                        @lang('messages.universal')
                                    </option>
                                    <option {{ old('position') === 'forward' ? "selected" : "" }} value="forward">
                                        @lang('messages.forward')
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="photo col-md">
                            <div class="floating-label">
                                <label for="photo">@lang('messages.photo')</label>
                                <input type="text" class="form-control" id="photo" name="photo"
                                    value="{{ old('photo') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="futis-code col-md">
                            <div class="floating-label">
                                <label for="futis-code">@lang('messages.futis_code')</label>
                                <input type="number" class="form-control" id="futis-code" name="futis_code"
                                    value="{{ old('futis_code') }}" />
                            </div>
                        </div>
                        <div class="height col-md">
                            <div class="floating-label">
                                <label for="height">@lang('messages.height')</label>
                                <input type="number" class="form-control" id="height" name="height"
                                    value="{{ old('height') }}" />
                            </div>
                        </div>
                        <div class="nationality col-md">
                            <div class="floating-label">
                                <label for="nationality">@lang('messages.nationality')</label>
                                <input type="text" class="form-control" id="nationality" name="nationality"
                                    value="{{ old('nationality') }}" />
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="team-id" name="team_id" value="{{ $team->id }}">
                    <input type="hidden" id="competition-id" name="competition_id" value="{{ $competition->id }}">

                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn introduction-btn">@lang('messages.create_player')</button>
                    </div>

                    @include('partials.errors')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection