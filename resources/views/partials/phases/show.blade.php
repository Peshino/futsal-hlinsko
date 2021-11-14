<div class="row block">
    <div class="from-position col-md-2">
        <div class="floating-label">
            <label for="phase-from-position-{{ $key }}">@lang('messages.from_position')</label>
            <input type="number" class="form-control border-dark" id="phase-from-position-{{ $key }}"
                name="phases[{{ $key }}][from_position]" min="1" max="999" value="{{ $phase->from_position }}"
                disabled />
        </div>
    </div>
    <div class="to-position col-md-2">
        <div class="floating-label">
            <label for="phase-to-position-{{ $key }}">@lang('messages.to_position')</label>
            <input type="number" class="form-control border-dark" id="phase-to-position-{{ $key }}"
                name="phases[{{ $key }}][to_position]" min="1" max="999" value="{{ $phase->to_position }}" disabled />
        </div>
    </div>
    <div class="phase col-md-2">
        <div class="floating-label">
            <label for="phase-phase-{{ $key }}">
                @lang('messages.phase')
            </label>
            <select class="form-control border-dark" id="phase-phase-{{ $key }}" name="phases[{{ $key }}][phase]"
                disabled>
                <option {{ $phase->phase === null ? "selected" : "" }} value="">
                </option>
                <option {{ $phase->phase === 'qualification' ? "selected" : "" }} value="qualification">
                    @lang('messages.qualification')
                </option>
                <option {{ $phase->phase === 'descent' ? "selected" : "" }} value="descent">
                    @lang('messages.descent')
                </option>
            </select>
        </div>
    </div>
    <div class="to-rule col-md-6">
        <div class="floating-label">
            <label for="phase-to-rule-{{ $key }}">
                @lang('messages.to_rule')
            </label>
            <select class="form-control border-dark" id="phase-to-rule-{{ $key }}" name="phases[{{ $key }}][to_rule_id]"
                disabled>
                <option {{ $phase->to_rule_id === $rule->id ? "selected" : "" }} value="{{ $rule->id }}">
                </option>
                @foreach ($competition->rules as $competitionRule)
                @if ($rule->id === $competitionRule->id)
                @continue
                @endif
                <option {{ $phase->to_rule_id === $competitionRule->id ? "selected" : "" }}
                    value="{{ $competitionRule->id }}">
                    {{ $competitionRule->name }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
</div>