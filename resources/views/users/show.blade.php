@extends('layouts.admin')

@section('title')
    {{ $user->firstname }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    @lang('messages.profile')
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="content">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="text-center">
                            <img src="{{ asset('img/no_avatar.png') }}" class="avatar img-circle img-thumbnail"
                                alt="avatar">
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div>
                            <h2>{{ $user->firstname }} {{ $user->lastname }}</h2>
                        </div>
                        <div>
                            <h4><i class="far fa-envelope pr-3 pt-3"></i>{{ $user->email }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
