@php
$startDateTime = \Carbon\Carbon::parse($game->start_datetime);
$startTime = $startDateTime->toTimeString();
@endphp
<a href="{{ route('games.show', [$competition->id, $game->id]) }}">
    <li class="{{ $game->result }}" data-toggle="popover"
        title='
        <div class="row text-center">
            <div class="col">
                {{ $game->homeTeam->name_short }}
            </div>
            <div class="col">
                {{ $game->home_team_score }}&nbsp;|&nbsp;{{ $game->away_team_score }}
            </div>
            <div class="col">
                {{ $game->awayTeam->name_short }}
            </div>
        </div>
        ' data-content='
        <div class="text-center">
            {{ $game->round ?? '' }}. @lang('messages.round')<br />
            <span class="text-lowercase">@lang('messages.halftime')</span> {{ $game->home_team_halftime_score }}&nbsp;|&nbsp;{{ $game->away_team_halftime_score }}<br />
            @if ($startTime === '00:00:00')
            {{ $startDateTime->isoFormat('dddd[,] Do[.] MMMM') }}
            @else
            {{ $startDateTime->isoFormat('dddd[,] Do[.] MMMM[, ] HH:mm') }}
            @endif
        </div>
    '>
    </li>
</a>