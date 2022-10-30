@extends('layouts.master')

@section('title')
    @lang('messages.competitions') | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    @lang('messages.competitions')
                </div>
                <div class="col">
                    <ul class="list-inline justify-content-end">
                        <li class="list-inline-item">
                            <a class="crud-button" href="{{ route('competitions.create') }}">
                                <div class="plus"></div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="content text-center">
                <div class="content-block">
                    {{-- @if (count($conversations) > 0)
                @foreach ($conversations as $conversation)
                @include('conversations.conversation')
                @endforeach
                @else
                -----
                @endif --}}
                </div>
            </div>
        </div>
    </div>
@endsection
