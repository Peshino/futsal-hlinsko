@extends('layouts.admin')

@section('title')
{{ $competition->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                {{ $competition->name ?? '' }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content">
            <div class="content-block">
                <div class="row">
                    <div class="col border-right border-dark">
                        <h4>
                            @lang('messages.rules')
                        </h4>
                        @if (count($competition->rules) > 0)
                        @foreach ($competition->rules as $rule)
                        <div class="container mt-3">
                            <a href="{{ route('rules.admin-show', [$competition->id, $rule->id]) }}" class="btn btn-lg">
                                @lang('messages.' . $rule->name ?? '' . '')
                            </a>
                        </div>
                        @endforeach
                        @endif

                        <div class="mt-3 text-center">
                            <a href="{{ route('rules.create', $competition->id) }}" class="btn btn-primary">
                                @lang('messages.create_rules')
                            </a>
                        </div>
                    </div>

                    <div class="col">
                        <h4>
                            @lang('messages.teams')
                        </h4>
                        @if (count($competition->rules) > 0)
                        @foreach ($competition->rules as $rule)
                        <div class="container mt-3">
                            <a href="{{ route('rules.admin-show', [$competition->id, $rule->id]) }}" class="btn btn-lg">
                                @lang('messages.' . $rule->name ?? '' . '')
                            </a>
                        </div>
                        @endforeach
                        @endif

                        <div class="mt-3 text-center">
                            <a href="{{ route('teams.create', $competition->id) }}" class="btn btn-primary">
                                @lang('messages.create_teams')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection