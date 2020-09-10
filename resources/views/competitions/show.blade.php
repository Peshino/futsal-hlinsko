@extends('layouts.master')

@section('competition-url')
<a href="{{ route('competitions.show', $competition->id) }}" class="navbar-brand">
    {{ $competition->name ?? '' }}
</a>
@endsection

@section('title')
{{ $competition->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header app-bg">
        <div class="row">
            <div class="col col-left">
                @lang('messages.competition') {{ $competition->name ?? '' }} {{ $competition->season->name ?? '' }}
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
        <div class="content">
            <div class="content-block">
                <h2>na homepagi soutěže by mohlo být:</h2>
                <ul>
                    <li>důležitá upozornění od administrátora</li>
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