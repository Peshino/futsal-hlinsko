@php
    $startDateTime = \Carbon\Carbon::parse($game->start_datetime);
@endphp

{{-- dateTime format fixed for mobile browsers (Apple) --}}
<span class="d-none" id="start-date-time">{{ $startDateTime->format('Y/m/d H:i:s') }}</span>
<span class="d-none" id="game-duration">{{ $game->rule->game_duration }}</span>

@if ($game->isCurrentlyBeingPlayed())
    <div class="currently-being-played text-center halftime live-color">
        <strong>
            <span class="blinking">
                @lang('messages.live')
            </span>
        </strong>
        |
        <span class="d-none first-half">
            @lang('messages.first_half')
        </span>
        <span class="d-none second-half">
            @lang('messages.second_half')
        </span>
    </div>
@endif
<div class="game mb-3 clickable-row" data-url="{{ route('games.show', [$competition->id, $game->id]) }}">
    <div class="row">
        <div class="game-team col-4 col-sm-5 d-flex flex-row-reverse">
            @isset($game->homeTeam)
                <span class="justify-content-center align-self-center">
                    @if (isset($bothGames) && $bothGames === true)
                        <div title="{{ $game->homeTeam->name }}">
                            {{ $game->homeTeam->name_short }}
                        </div>
                    @else
                        <div class="team-name-long">
                            {{ $game->homeTeam->name }}
                        </div>
                        <div class="team-name-short" title="{{ $game->homeTeam->name }}">
                            {{ $game->homeTeam->name_short }}
                        </div>
                    @endif
                </span>
            @endisset
        </div>
        @if ($game->hasScore())
            <div class="game-score col-4 col-sm-2 text-center">
                <span class="justify-content-center align-self-center">
                    <div class="row">
                        <div class="col-6 game-score-home d-flex flex-row-reverse">
                            {{ $game->home_team_score }}
                        </div>
                        <div class="col-6 game-score-away d-flex">
                            {{ $game->away_team_score }}
                        </div>
                    </div>
                </span>
            </div>
        @else
            @if ($game->isCurrentlyBeingPlayed())
                <div class="currently-being-played game-live col-4 col-sm-2 text-center">
                    <span class="game-current-minute live-color">
                        <span class="show-game-current-minute"></span><strong><span class="blinking">'</span></strong>
                    </span>
                    <span class="finished d-none text-secondary">
                        @lang('messages.finished')
                    </span>
                </div>
            @else
                <div class="game-schedule col-4 col-sm-2 text-center">
                    <span class="justify-content-center align-self-center">
                        {{ $startDateTime->format('H:i') }}
                    </span>
                </div>
            @endif
        @endif
        <div class="game-team col-4 col-sm-5 d-flex">
            @isset($game->awayTeam)
                <span class="justify-content-center align-self-center">
                    @if (isset($bothGames) && $bothGames === true)
                        <div title="{{ $game->awayTeam->name }}">
                            {{ $game->awayTeam->name_short }}
                        </div>
                    @else
                        <div class="team-name-long">
                            {{ $game->awayTeam->name }}
                        </div>
                        <div class="team-name-short" title="{{ $game->awayTeam->name }}">
                            {{ $game->awayTeam->name_short }}
                        </div>
                    @endif
                </span>
            @endisset
        </div>
    </div>
</div>

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
