<div class="toasts-position-relative" aria-live="polite" aria-atomic="true">
    <div class="toasts-position-absolute">

        @if (Session::has('closingImportantDays') && !Session::has('closingImportantDaysDisplayed'))
        @foreach (Session::get('closingImportantDays') as $closingImportantDay)
        @php
        $now = \Carbon\Carbon::now();
        $timeFromNow = $closingImportantDay->date->diffForHumans($now, [
        'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW,
        'options' => \Carbon\Carbon::JUST_NOW | \Carbon\Carbon::ONE_DAY_WORDS |
        \Carbon\Carbon::TWO_DAY_WORDS,
        ],
        false,
        2);
        @endphp
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="15000">
            <div class="toast-header">
                <img src="{{ asset('img/logo_small.png') }}" class="pr-2" alt="logo">
                <span class="mr-auto toast-title">@lang('messages.important_day')</span>
                <small class="text-light align-middle">{{ $timeFromNow }}</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                <a href="{{ route('important-days.index') }}">{{ $closingImportantDay->title }}</a>
            </div>
        </div>
        @endforeach

        {{ Session::put('closingImportantDaysDisplayed', true) }}
        @endif
    </div>
</div>