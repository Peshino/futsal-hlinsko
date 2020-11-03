@extends('layouts.admin')

@section('title')
@lang('messages.sign_in') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
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
                    <div class="input-group form-group">
                        <input id="email-sign-in" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="@lang('messages.sign_in_placeholder_username')">

                        @if ($errors->has('email') && Session::get('last_auth_attempt') === 'login')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="input-group form-group">
                        <input id="password-sign-in" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password"
                            placeholder="@lang('messages.sign_in_placeholder_password')">

                        @if ($errors->has('password') && Session::get('last_auth_attempt') === 'login')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group mt-2">
                        <button type="submit" class="btn text-center introduction-btn">
                            @lang('messages.sign_in_button')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection