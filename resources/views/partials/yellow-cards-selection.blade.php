@if (isset($yellowCards) && $yellowCards->isNotEmpty())
<div class="row text-center m-0">
    <div class="col selection-box-header p-1">
        <h4>
            <div class="d-inline-flex card-yellow"></div>
        </h4>
    </div>
</div>

<table class="table table-dark table-hover">
    <tbody>
        @foreach ($yellowCards as $key => $card)
        @php
        $key += 1;
        @endphp
        <tr>
            <td class="align-middle">
                {{ $key ?? '' }}.
            </td>
            <td class="text-left">
                <strong>
                    <a href="{{ route('players.show', [$competition->id, $card->team->id, $card->player->id]) }}">
                        {{ $card->player->lastname }} {{ $card->player->firstname }}
                    </a>
                </strong>
                <span class="badge text-light app-bg" title="@lang('messages.' . $card->player->position)">
                    @lang('messages.' . $card->player->position . '_short')
                </span>
                <br />
                <small>
                    <a href="{{ route('teams.show', [$competition->id, $card->team->id]) }}" class="text-secondary">
                        {{ $card->team->name }}
                    </a>
                </small>
            </td>
            <td class="competition-color align-middle">
                <strong>{{ $card->yellow }}</strong>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif