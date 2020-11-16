@extends('layouts.master')

@section('title')
@lang('messages.results') | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.results')
            </div>
            @auth
            <div class="col">
                <ul class="list-inline justify-content-end">
                    <li class="list-inline-item">
                        <a class="crud-button" href="{{ route('matches.create', $competition->id) }}">
                            <div class="plus"></div>
                        </a>
                    </li>
                </ul>
            </div>
            @endauth
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
                    <div class="match match-even mb-3">
                        <div class="row">
                            <div class="match-team col-5 text-right">
                                <span class="align-middle">Jamaica Slaves Hlinsko</span>
                            </div>
                            <div class="match-score col-2 text-center">
                                <span class="align-middle">4 : 1</span>
                            </div>
                            <div class="match-team col-5 text-left">
                                <span class="align-middle">Bison Steak Hlinsko</span>
                            </div>
                        </div>
                    </div>
                    <div class="match match-odd mb-3">
                        <div class="row">
                            <div class="match-team col-5 text-right">
                                Sokol Holetín
                            </div>
                            <div class="match-score col-2 text-center">
                                2 : 0
                            </div>
                            <div class="match-team col-5 text-left">
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
                    <div class="match match-even mb-3">
                        <div class="row">
                            <div class="match-team col-5 text-right">
                                <span class="align-middle">Jamaica Slaves Hlinsko</span>
                            </div>
                            <div class="match-score col-2 text-center">
                                <span class="align-middle">8 : 5</span>
                            </div>
                            <div class="match-team col-5 text-left">
                                <span class="align-middle">Bison Steak Hlinsko</span>
                            </div>
                        </div>
                    </div>
                    <div class="match match-odd mb-3">
                        <div class="row">
                            <div class="match-team col-5 text-right">
                                Sokol Holetín
                            </div>
                            <div class="match-score col-2 text-center">
                                2 : 0
                            </div>
                            <div class="match-team col-5 text-left">
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