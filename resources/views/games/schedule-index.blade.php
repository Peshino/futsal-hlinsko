@extends('layouts.master')

@section('title')
@lang('messages.schedule') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.schedule')
            </div>
            @can('crud_games')
            <div class="col justify-content-end">
                <ul class="list-inline justify-content-end">
                    <li class="list-inline-item">
                        <a class="" href="{{ route('games.create', $competition->id) }}">
                            základní část
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="" href="{{ route('games.create', $competition->id) }}">
                            7. kolo
                        </a>
                    </li>
                </ul>
            </div>
            @endcan
        </div>
    </div>

    <div class="card-body no-padding">
        <div class="content text-center">
            <div class="content-block">
                <div class="mt-4">
                    <h3>
                        neděle 16. února
                    </h3>
                </div>
                <div class="mt-2">
                    <div class="game game-even mb-3">
                        <div class="row">
                            <div class="game-team col-5 text-right align-middle">
                                Jamaica Slaves Hlinsko
                            </div>
                            <div class="game-schedule col-2 text-center align-middle">
                                14:00
                            </div>
                            <div class="game-team col-5 text-left align-middle">
                                Bison Steak Hlinsko
                            </div>
                        </div>
                    </div>
                    <div class="game game-odd mb-3">
                        <div class="row">
                            <div class="game-team col-5 text-right">
                                Sokol Holetín
                            </div>
                            <div class="game-schedule col-2 text-center">
                                17:45
                            </div>
                            <div class="game-team col-5 text-left">
                                Matuláci Včelákov
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h3>
                        sobota 15. února
                    </h3>
                </div>
                <div class="mt-2">
                    <div class="game game-even mb-3">
                        <div class="row">
                            <div class="game-team col-5 text-right">
                                <span class="align-middle">Jamaica Slaves Hlinsko</span>
                            </div>
                            <div class="game-schedule col-2 text-center">
                                <span class="align-middle">14:00</span>
                            </div>
                            <div class="game-team col-5 text-left">
                                <span class="align-middle">Bison Steak Hlinsko</span>
                            </div>
                        </div>
                    </div>
                    <div class="game game-odd mb-3">
                        <div class="row">
                            <div class="game-team col-5 text-right">
                                Sokol Holetín
                            </div>
                            <div class="game-schedule col-2 text-center">
                                17:45
                            </div>
                            <div class="game-team col-5 text-left">
                                Matuláci Včelákov
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection