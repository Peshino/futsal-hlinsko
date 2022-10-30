@extends('layouts.admin')

@section('title')
    @lang('messages.create_team') | @lang('messages.app_name')
@endsection

@section('content')
    <div class="card">
        <div class="card-header app-bg">
            <div class="row">
                <div class="col col-left">
                    @lang('messages.create_team') - {{ $competition->name }}
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="content text-center">
                <div class="content-block">
                    <form method="POST" action="{{ route('teams.store', $competition->id) }}">
                        @csrf

                        <div class="row form-group">
                            <div class="name col-md">
                                <div class="floating-label">
                                    <label for="name">@lang('messages.name')</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" required />
                                </div>
                            </div>
                            <div class="name-short col-md">
                                <div class="floating-label">
                                    <label for="name-short">@lang('messages.name_short')</label>
                                    <input type="text" class="form-control" id="name-short" name="name_short"
                                        value="{{ old('name_short') }}" required />
                                </div>
                            </div>
                            <div class="web-presentation col-md">
                                <div class="floating-label">
                                    <label for="web-presentation">@lang('messages.web_presentation')</label>
                                    <input type="text" class="form-control" id="web-presentation" name="web_presentation"
                                        value="{{ old('web_presentation') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="superior-team-id col-md">
                                <div class="floating-label">
                                    <label for="superior-team-id">
                                        @lang('messages.superior_team')
                                    </label>
                                    <select class="form-control" id="superior-team-id" name="superior_team_id">
                                        <option value=""></option>
                                        @if (count($otherTeams) > 0)
                                            @foreach ($otherTeams as $otherTeam)
                                                <option {{ old('superior_team_id') === $otherTeam->id ? 'selected' : '' }}
                                                    value="{{ $otherTeam->id }}">
                                                    {{ $otherTeam->name ?? '' }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="inferior-team-id col-md">
                                <div class="floating-label">
                                    <label for="inferior-team-id">
                                        @lang('messages.inferior_team')
                                    </label>
                                    <select class="form-control" id="inferior-team-id" name="inferior_team_id">
                                        <option value=""></option>
                                        @if (count($otherTeams) > 0)
                                            @foreach ($otherTeams as $otherTeam)
                                                <option {{ old('inferior_team_id') === $otherTeam->id ? 'selected' : '' }}
                                                    value="{{ $otherTeam->id }}">
                                                    {{ $otherTeam->name ?? '' }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="competition-id" name="competition_id" value="{{ $competition->id }}">

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-app">@lang('messages.create_team')</button>
                        </div>

                        @include('partials.errors')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(() => {
            var $name = $('#name'),
                $shortName = $('#name-short'),
                $shortNameLabel = $('label[for="' + $shortName.attr('id') + '"]');
            shortNameLabelValue = $shortNameLabel.text();
            shortNameLabelSuggestedValue = '';

            $name.change(function() {
                var nameValue = $name.val();

                if (nameValue && nameValue.length >= 3) {
                    shortNameLabelSuggestedValue = shortNameLabelValue + ' - @lang('messages.for_example') ' +
                        nameValue.substring(0, 3).toUpperCase();
                    $shortNameLabel.text(shortNameLabelSuggestedValue);
                }
            });
        });
    </script>
@endsection
