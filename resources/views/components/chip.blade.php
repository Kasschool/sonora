@props(['activo' => false, 'href' => null])
@php
    $clases = 'inline-block rounded-pill bg-surface-high px-4 py-2 text-xs font-bold uppercase tracking-wider text-ink transition duration-120 aria-pressed:bg-accent aria-pressed:text-on-accent focus-visible:outline-[3px] focus-visible:outline-offset-2 focus-visible:outline-focus';
@endphp
@if($href)
    <a href="{{ $href }}" aria-pressed="{{ $activo ? 'true' : 'false' }}" {{ $attributes->merge(['class' => $clases]) }}>{{ $slot }}</a>
@else
    <button type="button" aria-pressed="{{ $activo ? 'true' : 'false' }}" {{ $attributes->merge(['class' => $clases]) }}>{{ $slot }}</button>
@endif