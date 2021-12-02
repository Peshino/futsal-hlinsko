@if ($cards->isNotEmpty())
<table class="table table-dark table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col" class="text-left">@lang('messages.player')</th>
            <th scope="col" class="text-left">@lang('messages.team')</th>
            <th scope="col">
                <div class="d-inline-flex card-{{ $cardType }}"></div>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cards as $key => $card)
        @php
        $key += 1;
        @endphp
        <tr>
            <td>
                {{ $key ?? '' }}.
            </td>
            <td class="text-left">
                <a href="{{ route('players.show', [$competition->id, $card->team->id, $card->player->id]) }}">
                    {{ ucwords(mb_strtolower($card->player->firstname)) }} {{
                    ucwords(mb_strtolower($card->player->lastname)) }}
                </a>
                @if ($card->player->position !== null)
                <span class="badge text-light app-bg" title="@lang('messages.' . $card->player->position)">
                    @lang('messages.' . $card->player->position . '_short')
                </span>
                @endif
            </td>
            <td class="text-left">
                <a href="{{ route('teams.show', [$competition->id, $card->team->id]) }}"
                    title="{{ $card->team->name }}">
                    {{ $card->team->name_short }}
                </a>
            </td>
            <td class="competition-color">
                <strong>{{ $card->$cardType }}</strong>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
-----
@endif