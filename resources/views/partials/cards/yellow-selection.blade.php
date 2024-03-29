<div class="selection-box">
    <div class="row text-center m-0">
        <div class="col selection-box-header">
            <div class="icons float-right">
                <div class="d-inline-flex card-yellow"></div>
            </div>
        </div>
    </div>

    <div class="selection-box-content">
        <table class="table table-dark table-hover">
            <tbody>
                @foreach ($yellowCards as $key => $card)
                    @php
                        $key += 1;
                    @endphp
                    <tr>
                        <td class="align-middle text-center">
                            {{ $key ?? '' }}.
                        </td>
                        <td class="align-middle text-left">
                            <a
                                href="{{ route('players.show', [$competition->id, $card->team->id, $card->player->id]) }}">
                                {{ mb_convert_case($card->player->firstname, MB_CASE_TITLE, 'UTF-8') }}
                                {{ mb_convert_case($card->player->lastname, MB_CASE_TITLE, 'UTF-8') }}
                            </a>
                            @if ($card->player->position !== null)
                                <span class="badge text-light app-bg" title="@lang('messages.' . $card->player->position)">
                                    @lang('messages.' . $card->player->position . '_short')
                                </span>
                            @endif
                            <br />
                            <small>
                                <a href="{{ route('teams.show', [$competition->id, $card->team->id]) }}"
                                    class="text-secondary">
                                    {{ $card->team->name }}
                                </a>
                            </small>
                        </td>
                        <td class="competition-color align-middle text-center font-size-large">
                            <strong>{{ $card->yellow }}</strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row text-center m-0">
        <div class="col selection-box-footer">
            <a href="{{ route('cards.index', $competition->id) }}">
                <i class="fas fa-ellipsis-h px-4 py-2"></i>
            </a>
        </div>
    </div>
</div>
