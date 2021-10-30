@extends('layouts.admin')

@section('title')
{{ $competition->name }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.edit') - {{ $competition->name }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content text-center">
            <div class="content-block">
                <form method="POST" action="{{ route('competitions.update', $competition->id) }}" autocomplete="off">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <div class="floating-label">
                            <label for="competition-name">@lang('messages.name')</label>
                            <input type="text" class="form-control" id="competition-name" name="name"
                                value="{{ $competition->name }}" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="floating-label">
                            <input type="hidden" class="form-control" id="competition-season-id" name="season_id"
                                value="{{ $season->id }}" />
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-app">@lang('messages.edit_competition')</button>
                    </div>

                    @include('partials.errors')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection