@extends('layouts.admin')

@section('title')
@lang('messages.sign_up') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.sign_up')
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content text-center">
            <div class="content-block">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row form-group">
                        <div class="sign-up-firstname col">
                            <input id="firstname" type="text"
                                class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                value="{{ old('firstname') }}" required autocomplete="firstname" autofocus
                                placeholder="@lang('messages.sign_up_placeholder_firstname')">

                            @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="sign-up-lastname col">
                            <input id="lastname" type="text"
                                class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                value="{{ old('lastname') }}" required autocomplete="lastname"
                                placeholder="@lang('messages.sign_up_placeholder_lastname')">

                            @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <input id="email-sign-up" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email"
                            placeholder="@lang('messages.sign_up_placeholder_username')">

                        @if ($errors->has('email') && Session::get('last_auth_attempt') === 'register')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="input-group form-group">
                        <input id="password-sign-up" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password" placeholder="@lang('messages.sign_up_placeholder_password')">

                        @if ($errors->has('password') && Session::get('last_auth_attempt') === 'register')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="input-group form-group">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password"
                            placeholder="@lang('messages.sign_up_placeholder_password_confirm')">
                    </div>
                    <div class="form-group">
                        <button type="submit"
                            class="btn text-center introduction-btn">@lang('messages.sign_up_button')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection