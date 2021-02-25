@if (count($players) > 0)
<div class="list-group">
    @foreach ($players as $player)
    <a href="{{ route('players.show', [$competition->id, $team->id, $player->id]) }}"
        class="list-group-item list-group-item-action text-uppercase">
        {{ $player->firstname ?? '' }} {{ $player->lastname ?? '' }}
    </a>
    @endforeach
</div>
@endif

@can('crud_players')
<div class="col">
    <ul class="list-inline justify-content-end">
        <li class="list-inline-item">
            <a class="crud-button" href="{{ route('players.create', [$competition->id, $team->id]) }}">
                <div class="plus"></div>
            </a>
        </li>
    </ul>
</div>
@endcan