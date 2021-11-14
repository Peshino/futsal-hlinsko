@if (isset($goals) && $goals->isNotEmpty())
<div class="row text-center m-0">
    <div class="col selection-box-header p-1">
        <h4>
            <i class="far fa-futbol"></i>
        </h4>
    </div>
</div>

<table class="table table-dark table-hover">
    <tbody>
        @foreach ($goals as $key => $goal)
        @php
        $key += 1;
        @endphp
        <tr>
            <td class="align-middle">
                {{ $key ?? '' }}.
            </td>
            <td class="text-left">
                <strong>
                    <a href="{{ route('players.show', [$competition->id, $goal->team->id, $goal->player->id]) }}">
                        {{ $goal->player->lastname }} {{ $goal->player->firstname }}
                    </a>
                </strong>
                <span class="badge text-light app-bg" title="@lang('messages.' . $goal->player->position)">
                    @lang('messages.' . $goal->player->position . '_short')
                </span>
                <br />
                <small>
                    <a href="{{ route('teams.show', [$competition->id, $goal->team->id]) }}" class="text-secondary">
                        {{ $goal->team->name }}
                    </a>
                </small>
            </td>
            <td class="competition-color align-middle">
                <strong>{{ $goal->amount }}</strong>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif