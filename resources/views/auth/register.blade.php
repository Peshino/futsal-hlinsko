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
                            <div class="floating-label">
                                <label for="firstname">@lang('messages.sign_up_firstname')</label>
                                <input id="firstname" type="text"
                                    class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                    value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>
                            </div>

                            @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="sign-up-lastname col">
                            <div class="floating-label">
                                <label for="lastname">@lang('messages.sign_up_lastname')</label>
                                <input id="lastname" type="text"
                                    class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                    value="{{ old('lastname') }}" required autocomplete="lastname">
                            </div>

                            @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="email-sign-up col">
                            <div class="floating-label">
                                <label for="email-sign-up">@lang('messages.sign_up_username')</label>
                                <input id="email-sign-up" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                            </div>

                            @if ($errors->has('email') && Session::get('last_auth_attempt') === 'register')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="password-sign-up col">
                            <div class="floating-label">
                                <label for="password-sign-up">@lang('messages.sign_up_password')</label>
                                <input id="password-sign-up" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">
                            </div>

                            @if ($errors->has('password') && Session::get('last_auth_attempt') === 'register')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="password-confirm col">
                            <div class="floating-label">
                                <label for="password-confirm">@lang('messages.sign_up_password_confirm')</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
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