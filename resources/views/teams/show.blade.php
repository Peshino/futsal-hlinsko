@extends('layouts.master')

@section('title')
{{ $team->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                {{ $team->name ?? '' }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content">
            <div class="content-block">
                {{ $team->name ?? '' }}
                @foreach ($team->getMatchesFormByCompetition($competition) as $match)
                {{ $match->id }}
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('competition-url')
<div class="text-center">
    <a href="{{ route('competitions.show', $competition->id) }}" class="navbar-brand">
        {{ $competition->name ?? '' }} {{ $competition->season->name ?? '' }}
    </a>
</div>
@endsection