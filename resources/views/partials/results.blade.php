@if (count($games) > 0)
@php
$gameStartDateTimes = [];
@endphp
@foreach ($games as $game)
@if (!in_array($game->start_datetime, $gameStartDateTimes))
<div class="mt-4">
    <h5>
        @php
        $startDateTime = \Carbon\Carbon::parse($game->start_datetime);
        echo $startDateTime->isoFormat('dddd[,] Do[.] MMMM');
        @endphp
    </h5>
</div>
@php
$gameStartDateTimes[] = $game->start_datetime;
@endphp
@endif
<div class="game mb-3 clickable-row" data-url="{{ route('games.show', [$competition->id, $game->id]) }}">
    <div class="row">
        <div class="game-team col-4 d-flex flex-row-reverse">
            <span class="justify-content-center align-self-center">
                <div class="team-name-long">
                    {{ $game->homeTeam->name }}
                </div>
                <div class="team-name-short">
                    {{ $game->homeTeam->name_short }}
                </div>
            </span>
        </div>
        @if ($game->home_team_score === null && $game->away_team_score === null)
        <div class="game-schedule col-4 text-center">
            <span class="justify-content-center align-self-center">
                {{ $startDateTime->format('H:i') }}
            </span>
        </div>
        @else
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
        @endif
        <div class="game-team col-4 d-flex">
            <span class="justify-content-center align-self-center">
                <div class="team-name-long">
                    {{ $game->awayTeam->name }}
                </div>
                <div class="team-name-short">
                    {{ $game->awayTeam->name_short }}
                </div>
            </span>
        </div>
    </div>
</div>
@endforeach
@endif

@section('scripts')
<script>
    $(document).ready(function () {
        $('.clickable-row').click(function () {
            var url = $(this).data('url');

            window.location.href = url;
        });
    });
</script>
@endsection