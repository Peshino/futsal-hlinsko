@extends('layouts.admin')

@section('title')
@lang('messages.create_competition_rules') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.create_competition_rules')
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content text-center">
            <div class="content-block">
                <div class="container mt-3">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row form-group">
                            <div class="name col-md">
                                <div class="floating-label">
                                    <label for="name">
                                        @lang('messages.name')
                                    </label>
                                    <select class="form-control" id="name" name="name">
                                        <option value="main">@lang('messages.main')</option>
                                        <option value="qualification">@lang('messages.qualification')</option>
                                        <option value="descent">@lang('messages.descent')</option>
                                        <option value="playoff">@lang('messages.playoff')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="system col-md">
                                <div class="floating-label">
                                    <label for="system">
                                        @lang('messages.system')
                                    </label>
                                    <select class="form-control" id="system" name="system">
                                        <option value="one_rounded">@lang('messages.one_rounded')</option>
                                        <option value="two_rounded">@lang('messages.two_rounded')</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="priority col-md">
                                <div class="floating-label">
                                    <label for="priority">@lang('messages.priority')</label>
                                    <input type="number" class="form-control" id="priority" name="priority" min="0"
                                        required />
                                </div>
                            </div>
                            <div class="number-of-rounds col-md">
                                <div class="floating-label">
                                    <label for="number-of-rounds">@lang('messages.number_of_rounds')</label>
                                    <input type="number" class="form-control" id="number-of-rounds"
                                        name="number_of_rounds" min="0" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center mt-2">
                            <button type="submit"
                                class="btn introduction-btn">@lang('messages.create_competition_rules')</button>
                        </div>

                        @include('partials.errors')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection