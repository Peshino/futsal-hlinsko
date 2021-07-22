<li class="{{ $game->result }} item-tooltip">
    <a href="{{ route('games.show', [$competition->id, $game->id]) }}"
        class="item-tooltip-box tooltip-link tooltip-right" role="tooltip">
        <span class="tooltip-content">
            <div class="game-details">
                <span class="game-datetime">
                    @php
                    $startDateTime = \Carbon\Carbon::parse($game->start_datetime);
                    echo $startDateTime->isoFormat('dddd[,] Do[.] MMMM[, ] HH:mm');
                    @endphp
                </span>
                <span class="game-team">
                    <span title="{{ $game->homeTeam->name }}" class="text-uppercase">
                        {{ $game->homeTeam->name_short }}
                    </span>
                </span>
                <span class="game-score">
                    {{ $game->home_team_score }}&nbsp;|&nbsp;{{ $game->away_team_score }}
                </span>
                <span class="game-team">
                    <span title="{{ $game->awayTeam->name }}" class="text-uppercase">
                        {{ $game->awayTeam->name_short }}
                    </span>
                </span>
            </div>
        </span>
    </a>
</li>