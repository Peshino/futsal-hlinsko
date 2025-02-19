@extends('layouts.admin')

@section('title')
    {{ $competition->name ?? '' }} | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
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
                        <div class="col-md mb-3 border-right border-dark">
                            <h4>
                                @lang('messages.rules')
                            </h4>
                            @if (count($competition->rules) > 0)
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">@lang('messages.name')</th>
                                            <th scope="col">@lang('messages.system')</th>
                                            <th scope="col" class="text-center">Počet kol</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($competition->rules as $competitionRule)
                                            <div class="container mt-3">
                                                <tr class="clickable-row"
                                                    data-url="{{ route('rules.admin-show', [$competition->id, $competitionRule->id]) }}">
                                                    <td>
                                                        {{ $competitionRule->name ?? '' }}
                                                    </td>
                                                    <td>
                                                        @lang('messages.' . $competitionRule->system ?? '' . '')
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $competitionRule->number_of_rounds }}
                                                    </td>
                                                </tr>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                            <div class="mt-3 text-center">
                                <a href="{{ route('rules.create', $competition->id) }}" class="btn btn-app">
                                    @lang('messages.create_rules')
                                </a>
                            </div>
                        </div>

                        <div class="col-md">
                            <h4>
                                @lang('messages.teams')
                            </h4>
                            @if (count($competition->teams) > 0)
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">@lang('messages.name')</th>
                                            <th scope="col">@lang('messages.name_short')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($competition->teams as $team)
                                            <div class="container mt-3">
                                                <tr class="clickable-row"
                                                    data-url="{{ route('teams.admin-show', [$competition->id, $team->id]) }}">
                                                    <td>
                                                        {{ $team->name ?? '' }}
                                                    </td>
                                                    <td>
                                                        {{ $team->name_short ?? '' }}
                                                    </td>
                                                </tr>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                            <div class="mt-3 text-center">
                                <a href="{{ route('teams.create', $competition->id) }}" class="btn btn-app">
                                    @lang('messages.create_team')
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md">
                            <div class="col-md mb-3 pt-3 border-top border-dark">
                                <h4>
                                    @lang('messages.synchronization_players')
                                </h4>
                            </div>

                            <form method="POST" action="{{ route('players-synchronize', [$competition->id]) }}">
                                @csrf

                                <div class="archive col-md">
                                    <div class="floating-label">
                                        <label for="archive">Archive</label>
                                        <input type="number" min="0" max="9999" class="form-control"
                                            id="archive" name="archive" value="{{ old('archive') }}" />
                                    </div>
                                </div>

                                <input type="hidden" id="competition-id" name="competition_id"
                                    value="{{ $competition->id }}">

                                <div class="form-group text-center mt-3">
                                    <button type="submit" class="btn btn-app">@lang('messages.synchronize_players')</button>
                                </div>

                                @include('partials.errors')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(() => {
            $('.clickable-row').click(function() {
                var url = $(this).data('url');

                window.location.href = url;
            });
        });
    </script>
@endsection
