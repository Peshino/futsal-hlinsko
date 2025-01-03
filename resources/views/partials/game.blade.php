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
<div class="game mb-3 clickable-row" data-url="{{ route('games.show', [$competition->id, $game->id]) }}"
    @if ($game->homeTeam->primary_color_id !== null && $game->awayTeam->primary_color_id !== null) style="background: linear-gradient(to right, rgba(7,14,30,0.65) 0%, rgba({{ $game->homeTeam?->primaryColor?->rgb_code }},0.65) 10%, rgba(7,14,30,0.65) 37%, rgba(7,14,30,0.65) 63%, rgba({{ $game->awayTeam?->primaryColor?->rgb_code }},0.65) 90%, rgba(7,14,30,0.65) 100%); @endif ">
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
        <div class="game-schedule col-4 col-sm-2 text-center position-relative">
            <span class="justify-content-center align-self-center">
                {{ $startDateTime->format('H:i') }}
            </span>

            @if (
                $game->homeTeam->primary_color_id !== null &&
                    $game->awayTeam->primary_color_id !== null &&
                    $game->homeTeam->primary_color_id === $game->awayTeam->primary_color_id)
                <div class="position-absolute z-50" style="color: orange; top: -24px; right: 0; left: -6px;">
                    <div class="">
                        <style>
                            .icon {
                                font-size: 0.5em;
                                width: 2em;
                                height: 1em;
                            }
                        </style>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" aria-hidden="true" focusable="false"
                            viewBox="0 0 512 512" style="">
                            <path fill="currentColor"
                                d="M211.8 0c7.8 0 14.3 5.7 16.7 13.2C240.8 51.9 277.1 80 320 80s79.2-28.1 91.5-66.8C413.9 5.7 420.4 0 428.2 0l12.6 0c22.5 0 44.2 7.9 61.5 22.3L628.5 127.4c6.6 5.5 10.7 13.5 11.4 22.1s-2.1 17.1-7.8 23.6l-56 64c-11.4 13.1-31.2 14.6-44.6 3.5L480 197.7 480 448c0 35.3-28.7 64-64 64l-192 0c-35.3 0-64-28.7-64-64l0-250.3-51.5 42.9c-13.3 11.1-33.1 9.6-44.6-3.5l-56-64c-5.7-6.5-8.5-15-7.8-23.6s4.8-16.6 11.4-22.1L137.7 22.3C155 7.9 176.7 0 199.2 0l12.6 0z" />
                        </svg>
                    </div>
                </div>
            @endif
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
