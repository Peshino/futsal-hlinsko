<div class="row block">
    <div class="col-7">
        <div class="floating-label">
            <label for="{{ $teamType }}-team-card-player-{{ $key }}">
                @lang('messages.' . $teamType . '_card')
            </label>
            <select class="form-control" id="{{ $teamType }}-team-card-player-{{ $key }}"
                name="{{ $teamType }}_team_cards[{{ $key }}][player]" required>
                <option value=""></option>
                @if (count($players) > 0)
                @foreach ($players as $player)
                <option {{ $player->id === $teamCard->player->id ? "selected" : "" }} value="{{ $player->id }}">
                    {{ $player->firstname }}
                    {{ $player->lastname }}
                </option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="yellow-red col-3 p-0 text-center">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="{{ $teamType }}-team-card-yellow-{{ $key }}"
                name="{{ $teamType }}_team_cards[{{ $key }}][yellow]" value="1" {{ $teamCard->yellow === 1 ? ' checked'
            : '' }}>
            <label class="form-check-label" for="{{ $teamType }}-team-card-yellow-{{ $key }}">
                <div class="card-yellow"></div>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="{{ $teamType }}-team-card-red-{{ $key }}"
                name="{{ $teamType }}_team_cards[{{ $key }}][red]" value="1" {{ $teamCard->red === 1 ? ' checked' : ''
            }}>
            <label class="form-check-label" for="{{ $teamType }}-team-card-red-{{ $key }}">
                <div class="card-red"></div>
            </label>
        </div>
    </div>

    <input type="hidden" name="{{ $teamType }}_team_cards[{{ $key }}][team]" value="{{ $team->id }}">
    <input type="hidden" name="{{ $teamType }}_team_cards[{{ $key }}][id]" value="{{ $teamCard->id }}">

    <div class="delete col-2 pt-2">
        <span class="crud-button">
            <i class="far fa-trash-alt"></i>
        </span>
    </div>
</div>