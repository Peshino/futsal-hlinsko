<div class="selection-box">
    <div class="row text-center m-0">
        <div class="col selection-box-header p-1">
            <h4>
                <div class="d-inline-flex card-red"></div>
            </h4>
        </div>
    </div>

    <div class="selection-box-content">
        <table class="table table-dark table-hover">
            <tbody>
                @foreach ($redCards as $key => $card)
                @php
                $key += 1;
                @endphp
                <tr>
                    <td class="align-middle text-center">
                        {{ $key ?? '' }}.
                    </td>
                    <td class="align-middle text-left">
                        <strong>
                            <a
                                href="{{ route('players.show', [$competition->id, $card->team->id, $card->player->id]) }}">
                                {{ $card->player->lastname }} {{ $card->player->firstname }}
                            </a>
                        </strong>
                        <span class="badge text-light app-bg" title="@lang('messages.' . $card->player->position)">
                            @lang('messages.' . $card->player->position . '_short')
                        </span>
                        <br />
                        <small>
                            <a href="{{ route('teams.show', [$competition->id, $card->team->id]) }}"
                                class="text-secondary">
                                {{ $card->team->name }}
                            </a>
                        </small>
                    </td>
                    <td class="competition-color align-middle text-center">
                        <strong>{{ $card->red }}</strong>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row text-center m-0">
        <div class="col selection-box-footer p-1">
            <a href="{{ route('cards.index', $competition->id) }}">
                <h4>
                    <i class="fas fa-ellipsis-h"></i>
                </h4>
            </a>
        </div>
    </div>
</div>