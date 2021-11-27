@if (count($players) > 0)
<div class="d-inline-flex flex-wrap">
    @foreach ($players as $player)
    <a href="{{ route('players.show', [$competition->id, $team->id, $player->id]) }}"
        class="px-4 py-25 m-1 text-uppercase">
        {{ $player->firstname ?? '' }} {{ $player->lastname ?? '' }}
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