@extends('layouts.admin')

@section('title')
@lang('messages.create_season') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.create_season')
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content text-center">
            <div class="content-block">
                <form method="POST" action="{{ route('seasons.store') }}" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <div class="floating-label">
                            <label for="season-name">@lang('messages.name')</label>
                            <input type="text" class="form-control" id="season-name" name="name"
                                value="{{ old('name') }}" required />
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">@lang('messages.create_season')</button>
                    </div>

                    @include('partials.errors')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection