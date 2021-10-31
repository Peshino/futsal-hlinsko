<li class="first-schedule app-bg item-tooltip">
    <a href="{{ route('games.show', [$competition->id, $teamFirstSchedule->id]) }}"
        class="item-tooltip-box tooltip-link tooltip-right" role="tooltip">
        <span class="tooltip-content">
            <div class="game-details">
                <div class="text-center pb-1">
                    <strong>@lang('messages.next_game')</strong>
                </div>
                <span class="game-datetime">
                    @php
                    $startDateTime = \Carbon\Carbon::parse($teamFirstSchedule->start_datetime);
                    echo $startDateTime->isoFormat('dddd[,] Do[.] MMMM');
                    @endphp
                </span>
                <span class="game-team">
                    <span title="{{ $teamFirstSchedule->homeTeam->name }}" class="text-uppercase">
                        {{ $teamFirstSchedule->homeTeam->name_short }}
                    </span>
                </span>
                <span class="game-score">
                    {{ $startDateTime->isoFormat('HH:mm') }}
                </span>
                <span class="game-team">
                    <span title="{{ $teamFirstSchedule->awayTeam->name }}" class="text-uppercase">
                        {{ $teamFirstSchedule->awayTeam->name_short }}
                    </span>
                </span>
            </div>
        </span>
    </a>
</li>