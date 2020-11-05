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
                <h4>
                    @lang('messages.rules')
                </h4>
                @if (count($competition->rules) > 0)
                @foreach ($competition->rules as $rule)
                <div class="p-3">
                    <a href="{{ route('rules.admin-show', [$competition->id, $rule->id]) }}" class="btn btn-lg">
                        @lang('messages.' . $rule->name ?? '' . '')
                    </a>
                </div>
                @endforeach
                @endif

                <div class="p-3">
                    <a href="{{ route('rules.create', $competition->id) }}" class="btn btn-primary">
                        @lang('messages.create_competition_rules')
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection