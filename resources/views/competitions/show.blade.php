@extends('layouts.master')

@section('title')
{{ $competition->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                {{ $competition->name ?? __('messages.homepage') }}
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content">
            <div class="content-block">
                {{-- <h3>Zde na homepage soutěže by mohlo být:</h3>
                <ul class="pl-5">
                    <li>důležitá upozornění od administrátora, novinky přidané do aplikace</li>
                    <ul class="pl-5">
                        <li>toto by mohlo být komentovatelné a likovatelné přihlášenými osobami, případně vytvořit
                            možnost přihlášení skrze facebook?</li>
                        <li>cílem je aplikaci více socializovat, udělat věci, které by zde registrovaní mohli dělat -
                            větší návštěvnost a sledovanost</li>
                    </ul>
                    <li>seznam týmů</li>
                    <li>první tým postupové skupiny, první tým sestupové skupiny (případně aktuálně postupující a
                        aktuálně sestupující tým)</li>
                    <li>poslední a nadcházející zápasy (hodnocení atraktivity zápasů?)</li>
                    <li>statistiky - nejlepší střelec soutěže, nejvíc žlutých, nejvíc červených karet (+ 3 další)</li>
                    <li>gólů celkem v soutěži, průměr gólů na zápas, nejvíce gólový zápas</li>
                    <li>část tabulky nebo playoff</li>
                    <li>základní informace o soutěži (systém, sezona, atd.)</li>
                </ul> --}}

                {{-- <div class="news alert-warning">
                    <div class="news-header pb-1 border-bottom border-dark">
                        <div class="d-inline">
                            Pozor, změna hracího termínu
                        </div>
                        <div class="d-inline float-right">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="news-body">
                        <p>
                            Hrací den se z pátečního večera přesouvá na sobotní dopoledne. Toto platí pro všechny týmy.
                        </p>
                    </div>
                </div> --}}

                <div class="row">
                    <div class="col">
                        @include('partials/goals.selection')
                    </div>

                    <div class="col">
                        @include('partials/cards.yellow-selection')
                    </div>

                    <div class="col">
                        @include('partials/cards.red-selection')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection