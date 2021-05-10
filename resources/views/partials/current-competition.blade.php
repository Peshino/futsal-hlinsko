@isset($competition)
<div class="mb-3 text-center">
    <a href="{{ route('competitions.show', $competition->id) }}" class="navbar-brand">
        {{ $competition->name ?? '' }} {{ $competition->season->name ?? '' }}
    </a>
</div>
@endisset