@props(['textSize' => 'text-sm'])

<span {{ $attributes->merge(['class' => 'relative inline-flex shrink-0 items-center justify-center']) }}>
    <svg viewBox="0 0 100 100" class="absolute inset-0 h-full w-full" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <circle cx="50" cy="50" r="44" stroke="currentColor" stroke-width="6" />

        {{-- clock ticks --}}
        <g stroke="currentColor" stroke-width="4" stroke-linecap="round" opacity="0.55">
            <line x1="50" y1="9" x2="50" y2="17" />
            <line x1="50" y1="83" x2="50" y2="91" />
            <line x1="9" y1="50" x2="17" y2="50" />
            <line x1="83" y1="50" x2="91" y2="50" />
            <line x1="21.5" y1="21.5" x2="27.2" y2="27.2" />
            <line x1="72.8" y1="72.8" x2="78.5" y2="78.5" />
            <line x1="21.5" y1="78.5" x2="27.2" y2="72.8" />
            <line x1="72.8" y1="27.2" x2="78.5" y2="21.5" />
        </g>

        {{-- on-time clock hands (fixed brand green, always on-brand regardless of surrounding text color) --}}
        <g stroke="#00A651" stroke-width="5" stroke-linecap="round">
            <line x1="50" y1="50" x2="50" y2="25" />
            <line x1="50" y1="50" x2="69" y2="37" />
        </g>
        <circle cx="50" cy="50" r="4.5" fill="#00A651" />
    </svg>
    <span class="relative font-extrabold {{ $textSize }}">PS</span>
</span>
