@if (count($players) > 0)
    <div class="row d-flex justify-content-center text-left">
        @foreach ($players as $player)
            <a href="{{ route('players.show', [$competition->id, $team->id, $player->id]) }}"
                class="col-5 col-sm-5 col-md-3 col-lg-2 py-3 m-2 bg-dark rounded">
                {{ $player->lastname ?? '' }} <br />
                <span class="text-secondary">{{ $player->firstname ?? '' }}</span>
            </a>
        @endforeach
    </div>
@endif

@can('crud_players')
    <ul class="list-inline justify-content-center">
        <li class="list-inline-item">
            <a class="crud-button" href="{{ route('players.create', [$competition->id, $team->id]) }}">
                <div class="plus"></div>
            </a>
        </li>
    </ul>
@endcan
