@php
$startDateTime = \Carbon\Carbon::parse($game->start_datetime);
@endphp

<div class="game mb-3 clickable-row" data-url="{{ route('games.show', [$competition->id, $game->id]) }}">
    <div class="row">
        <div class="game-team col-4 d-flex flex-row-reverse">
            <span class="justify-content-center align-self-center">
                @if ($bothGames)
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
        </div>
        @if ($game->hasScore())
        <div class="game-score col-4 text-center">
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
        <div
            class="{{ $game->isCurrentlyBeingPlayed() ? 'game-currently-being-played ' : 'game-schedule '}}col-4 text-center">
            <span class="justify-content-center align-self-center">
                {{ $startDateTime->format('H:i') }}
            </span>
        </div>
        @endif
        <div class="game-team col-4 d-flex">
            <span class="justify-content-center align-self-center">
                @if ($bothGames)
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
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(() => {
        $('.clickable-row').click(function () {
            var url = $(this).data('url');

            window.location.href = url;
        });
    });
</script>
@endsection