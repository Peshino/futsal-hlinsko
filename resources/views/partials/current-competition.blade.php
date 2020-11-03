<div class="text-center">
    <a href="{{ route('competitions.show', $competition->id) }}" class="navbar-brand">
        {{ $competition->name ?? '' }} {{ $competition->season->name ?? '' }}
    </a>

    @foreach ($competition->rules as $rule)
    {{ $rule->name ?? '' }}
    @endforeach
</div>