@extends('layouts.master')

@section('title')
{{ $competition->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.homepage')
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="content">
            <div class="content-block">
                <h3>Zde na homepagi soutěže by mohlo být:</h3>
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
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection