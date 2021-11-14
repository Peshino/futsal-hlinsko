@php
$startDateTime = \Carbon\Carbon::parse($teamFirstSchedule->start_datetime);
@endphp
<a href="{{ route('games.show', [$competition->id, $teamFirstSchedule->id]) }}">
    <li class="first-schedule app-bg" data-toggle="popover"
        title='
        <div class="row">
            <div class="col">
                {{ $teamFirstSchedule->homeTeam->name_short }}
            </div>
            <div class="col">
                {{ $startDateTime->isoFormat('HH:mm') }}
            </div>
            <div class="col">
                {{ $teamFirstSchedule->awayTeam->name_short }}
            </div>
        </div>
        ' data-content='
        <div class="text-center">
            {{ $teamFirstSchedule->round ?? '' }}. @lang('messages.round')<br />
            {{ $startDateTime->isoFormat(' dddd[,] Do[.] MMMM') }}
        </div>
    '>
    </li>
</a>