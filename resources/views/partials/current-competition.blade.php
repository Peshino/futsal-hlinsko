<div class="text-center">
    <a href="{{ route('competitions.show', $currentCompetition->id) }}" class="navbar-brand">
        {{ $currentCompetition->name ?? '' }} {{ $currentCompetition->season->name ?? '' }}
    </a>
</div>