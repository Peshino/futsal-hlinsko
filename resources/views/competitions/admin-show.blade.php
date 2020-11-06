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
                <div class="row">
                    <div class="col border-right border-dark">
                        <h4>
                            @lang('messages.rules')
                        </h4>
                        @if (count($competition->rules) > 0)
                        <table class="table table-striped table-dark table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('messages.name')</th>
                                    <th scope="col">@lang('messages.system')</th>
                                    <th scope="col" class="text-center">Počet kol</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($competition->rules as $rule)
                                <div class="container mt-3">
                                    <tr>
                                        <td>
                                            <a href="{{ route('rules.admin-show', [$competition->id, $rule->id]) }}">
                                                @lang('messages.'
                                                . $rule->name ?? '' . '')
                                            </a>
                                        </td>
                                        <td>@lang('messages.' . $rule->system ?? '' . '')</td>
                                        <td class="text-center">{{ $rule->number_of_rounds }}</td>
                                    </tr>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                        @endif

                        <div class="mt-3 text-center">
                            <a href="{{ route('rules.create', $competition->id) }}" class="btn btn-primary">
                                @lang('messages.create_rules')
                            </a>
                        </div>
                    </div>

                    <div class="col">
                        <h4>
                            @lang('messages.teams')
                        </h4>
                        {{-- @if (count($competition->teams) > 0)
                        <table class="table table-striped table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('messages.name')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($competition->teams as $team)
                                <div class="container mt-3">
                                    <tr>
                                        <td>{{ $team->id ?? '' }}</td>
                        </tr>
                    </div>
                    @endforeach
                    </tbody>
                    </table>
                    @endif --}}

                    <div class="mt-3 text-center">
                        <a href="{{ route('teams.create', $competition->id) }}" class="btn btn-primary">
                            @lang('messages.create_teams')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection