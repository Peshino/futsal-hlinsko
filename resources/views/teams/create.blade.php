@extends('layouts.admin')

@section('title')
@lang('messages.create_teams') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.create_teams') - {{ $competition->name }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content text-center">
            <div class="content-block">
                <form method="POST" action="{{ route('teams.store', $competition->id) }}">
                    @csrf

                    <div class="row form-group">
                        <div class="name col-md">
                            <div class="floating-label">
                                <label for="name">@lang('messages.name')</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" required />
                            </div>
                        </div>
                        <div class="squad col-md">
                            <div class="floating-label">
                                <label for="squad">
                                    @lang('messages.squad')
                                </label>
                                <select class="form-control" id="squad" name="squad" required>
                                    <option {{ old('squad') === 'A' ? "selected" : "" }} value="A">
                                        A
                                    </option>
                                    <option {{ old('squad') === 'B' ? "selected" : "" }} value="B">
                                        B
                                    </option>
                                    <option {{ old('squad') === 'C' ? "selected" : "" }} value="C">
                                        C
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="competition-id" name="competition_id" value="{{ $competition->id }}">

                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn introduction-btn">@lang('messages.create_teams')</button>
                    </div>

                    @include('partials.errors')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection