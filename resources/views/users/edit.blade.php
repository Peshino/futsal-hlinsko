@extends('layouts.admin')

@section('title')
    @lang('messages.edit') {{ $user->firstname }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
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
                                                value="{{ $user->firstname }}" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <div class="floating-label">
                                            <label for="user-lastname">@lang('messages.lastname')</label>
                                            <input class="form-control" id="user-lastname" name="lastname" type="text"
                                                value="{{ $user->lastname }}" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center mt-1">
                        <button type="submit" class="btn btn-app">@lang('messages.edit_profile')</button>
                    </div>

                    @include('partials.errors')
                </form>
            </div>
        </div>
    </div>
@endsection
