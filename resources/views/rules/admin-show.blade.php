@extends('layouts.admin')

@section('title')
{{ $rule->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                {{ $rule->name ?? '' }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content">
            <div class="content-block">
                <h4>
                    @lang('messages.rules')
                </h4>
                @if (count($rules) > 0)
                @foreach ($rules as $rule)
                <div class="p-3">
                    <a href="{{ route('rules.admin-show', [$competition->id, $rule->id]) }}" class="btn btn-lg">
                        {{ $rule->name ?? '' }}
                    </a>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection