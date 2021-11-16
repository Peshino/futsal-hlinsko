<div class="selection-box">
    <div class="row text-center m-0">
        <div class="col selection-box-header p-1">
            <h4>
                <i class="far fa-futbol"></i>
            </h4>
        </div>
    </div>

    <div class="selection-box-content">
        <table class="table table-dark table-hover">
            <tbody>
                @foreach ($goals as $key => $goal)
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
                                href="{{ route('players.show', [$competition->id, $goal->team->id, $goal->player->id]) }}">
                                {{ $goal->player->lastname }} {{ $goal->player->firstname }}
                            </a>
                        </strong>
                        <span class="badge text-light app-bg" title="@lang('messages.' . $goal->player->position)">
                            @lang('messages.' . $goal->player->position . '_short')
                        </span>
                        <br />
                        <small>
                            <a href="{{ route('teams.show', [$competition->id, $goal->team->id]) }}"
                                class="text-secondary">
                                {{ $goal->team->name }}
                            </a>
                        </small>
                    </td>
                    <td class="competition-color align-middle text-center">
                        <strong>{{ $goal->amount }}</strong>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row text-center m-0">
        <div class="col selection-box-footer p-1">
            <a href="{{ route('goals.index', $competition->id) }}">
                <h4>
                    <i class="fas fa-ellipsis-h"></i>
                </h4>
            </a>
        </div>
    </div>
</div>