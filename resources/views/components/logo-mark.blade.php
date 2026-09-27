@props(['class' => 'h-10 w-10'])

<img src="{{ asset('images/logo.png') }}" alt="PSCM Logo" {{ $attributes->merge(['class' => 'inline-block shrink-0 object-contain ' . $class]) }}>
