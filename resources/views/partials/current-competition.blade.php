@isset($competition)
<div class="mb-3 text-center current-competition">
    <a href="{{ route('competitions.show', $competition->id) }}" class="navbar-brand">
        {{ $competition->name ?? '' }} {{ $competition->season->name ?? '' }}
    </a>
</div>
@endisset