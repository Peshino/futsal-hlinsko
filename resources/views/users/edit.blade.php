@extends('layouts.master')

@section('title')
@lang('messages.edit') {{ $user->fullname }} | @lang('messages.krasojizda_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header krasojizda-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.edit_profile')
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content">
            <form method="POST" action="{{ route('users.update', $user->id) }}" autocomplete="off">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-sm-3">
                        <div class="text-center">
                            <img src="{{ asset('img/no_avatar.png') }}" class="avatar img-circle img-thumbnail"
                                alt="avatar">
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <div class="floating-label">
                                <label for="user-email">@lang('messages.email')</label>
                                <input class="form-control" id="user-email" type="email" value="{{ $user->email }}"
                                    disabled />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <div class="floating-label">
                                        <label for="user-firstname">@lang('messages.firstname')</label>
                                        <input class="form-control" id="user-firstname" name="firstname" type="text"
                                            value="{{ $user->name }}" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center mt-1">
                    <button type="submit" class="btn btn-primary">@lang('messages.edit_profile')</button>
                </div>

                @include('partials.errors')
            </form>
        </div>
    </div>
</div>
@endsection