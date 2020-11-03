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
                    @lang('messages.create_competition_rules')
                </h4>
            </div>
        </div>
    </div>
</div>
@endsection