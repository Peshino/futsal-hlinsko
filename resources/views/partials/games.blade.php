@if (count($games) > 0)
@php
$gameStartDates = [];
@endphp
@foreach ($games as $game)
@php
$gameStartDate = \Carbon\Carbon::parse($game->start_datetime)->toDateString();
$startDateTime = \Carbon\Carbon::parse($game->start_datetime);
@endphp
@if (!in_array($gameStartDate, $gameStartDates))
<div class="mt-4">
    <h5>
        @php
        echo $startDateTime->isoFormat('dddd[,] Do[.] MMMM');
        @endphp
    </h5>
</div>
@php
$gameStartDates[] = $gameStartDate;
@endphp
@endif

@include('partials/game')

@endforeach
@endif