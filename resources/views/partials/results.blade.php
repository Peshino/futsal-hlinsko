@if (count($matches) > 0)
@php
$matchStartDates = [];
@endphp
@foreach ($matches as $match)
@if (!in_array($match->start_date, $matchStartDates))
<div class="mt-4">
    <h5>
        @php
        $date = \Carbon\Carbon::parse($match->start_date);
        echo $date->isoFormat('dddd[,] Do[.] MMMM');
        @endphp
    </h5>
</div>
@php
$matchStartDates[] = $match->start_date;
@endphp
@endif
<div class="match mb-3 clickable-row" data-url="{{ route('matches.show', [$competition->id, $match->id]) }}">
    <div class="row">
        <div class="match-team col-4 d-flex flex-row-reverse">
            <span class="justify-content-center align-self-center">
                <div class="team-name-long">
                    {{ $match->homeTeam->name }}
                </div>
                <div class="team-name-short">
                    {{ $match->homeTeam->name_short }}
                </div>
            </span>
        </div>
        <div class="match-score col-4 text-center">
            <span class="justify-content-center align-self-center">
                <div class="row">
                    <div class="col-6 match-score-home d-flex flex-row-reverse">
                        {{ $match->home_team_score }}
                    </div>
                    <div class="col-6 match-score-away d-flex">
                        {{ $match->away_team_score }}
                    </div>
                </div>
            </span>
        </div>
        <div class="match-team col-4 d-flex">
            <span class="justify-content-center align-self-center">
                <div class="team-name-long">
                    {{ $match->awayTeam->name }}
                </div>
                <div class="team-name-short">
                    {{ $match->awayTeam->name_short }}
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