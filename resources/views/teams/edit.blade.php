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
                        <div class="squad col-md">
                            <div class="floating-label">
                                <label for="squad">
                                    @lang('messages.squad')
                                </label>
                                <select class="form-control" id="squad" name="squad" required>
                                    <option {{ $team->squad === 'A' ? "selected" : "" }} value="A">
                                        A
                                    </option>
                                    <option {{ $team->squad === 'B' ? "selected" : "" }} value="B">
                                        B
                                    </option>
                                    <option {{ $team->squad === 'C' ? "selected" : "" }} value="C">
                                        C
                                    </option>
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