@extends('layouts.admin')

@section('title')
    @lang('messages.sign_in') | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    @lang('messages.sign_in')
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="content text-center">
                <div class="content-block">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row form-group">
                            <div class="email-sign-in col">
                                <div class="floating-label">
                                    <label for="email-sign-in">@lang('messages.sign_in_username')</label>
                                    <input id="email-sign-in" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>

                                @if ($errors->has('email') && Session::get('last_auth_attempt') === 'login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="password-sign-in col">
                                <div class="floating-label">
                                    <label for="password-sign-in">@lang('messages.sign_in_password')</label>
                                    <input id="password-sign-in" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                </div>

                                @if ($errors->has('password') && Session::get('last_auth_attempt') === 'login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn text-center btn-app">
                                @lang('messages.sign_in_button')
                            </button>
                        </div>
                        <div class="mt-4 mb-2">
                            <a href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i>
                                <span class="align-middle">&nbsp;@lang('messages.sign_up')</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
