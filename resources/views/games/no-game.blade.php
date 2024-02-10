@extends('layouts.master')

@section('title')
    @lang('messages.schedule') | {{ $competition->name }} | {{ $competition->season->name_short ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col-4 col-left">
                    @lang('messages.schedule')
                </div>
                <div class="col-8 col-right d-flex flex-row-reverse">
                    <div class="row">
                        @can('crud_games')
                            <div class="col-auto pr-1">
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <a class="crud-button" href="{{ route('games.create', $competition->id) }}">
                                            <div class="plus"></div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="content text-center">
                <div class="content-block">
                    <div class="py-4 text-center">
                        @lang('messages.no_games')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
