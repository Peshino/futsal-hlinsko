@extends('layouts.admin')

@section('title')
{{ $season->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.season') {{ $season->name ?? '' }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content">
            <div class="content-block">
                <h4>
                    @lang('messages.competitions')
                </h4>
                @if (count($season->competitions) > 0)
                @foreach ($season->competitions as $competition)
                <div class="p-3">
                    <a href="{{ route('competitions.admin-show', $competition->id) }}" class="btn btn-lg">
                        {{ $competition->name ?? '' }}
                    </a>
                </div>
                @endforeach
                @endif

                <div class="p-3">
                    <a href="{{ route('competitions.create', $season->id) }}" class="btn btn-primary">
                        @lang('messages.create_competition')
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection