<div class="row block">
    <div class="col-7">
        <div class="floating-label">
            <label for="{{ $teamType }}-team-goal-player-{{ $key }}">
                @lang('messages.' . $teamType . '_shooter')
            </label>
            <select class="form-control" id="{{ $teamType }}-team-goal-player-{{ $key }}"
                name="{{ $teamType }}_team_goals[{{ $key }}][player]" required>
                <option value=""></option>
                @if (count($players) > 0)
                @foreach ($players as $player)
                <option {{ $player->id === $teamGoal->player->id ? "selected" : "" }} value="{{ $player->id }}">
                    {{ $player->lastname }}
                    {{ $player->firstname }}
                </option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="amount col-3 no-padding">
        <div class="floating-label">
            <label for="{{ $teamType }}-team-goal-amount-{{ $key }}">@lang('messages.amount')</label>
            <input type="number" class="form-control" id="{{ $teamType }}-team-goal-amount-{{ $key }}"
                name="{{ $teamType }}_team_goals[{{ $key }}][amount]" min="1" max="999" value="{{ $teamGoal->amount }}"
                required />
        </div>
    </div>

    <input type="hidden" name="{{ $teamType }}_team_goals[{{ $key }}][team]" value="{{ $team->id }}">
    <input type="hidden" name="{{ $teamType }}_team_goals[{{ $key }}][id]" value="{{ $teamGoal->id }}">

    <div class="delete col-2 pt-2">
        <span class="crud-button">
            <i class="far fa-trash-alt"></i>
        </span>
    </div>
</div>