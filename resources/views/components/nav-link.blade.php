@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 p-4 border-b-2 border-text-light text-xl font-medium leading-5 text-text-light focus:outline-none focus:border-text-light transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 p-4 border-b-2 border-transparent text-xl font-medium leading-5 text-text-light hover:text-text-light hover:border-text-light focus:outline-none focus:text-text-light focus:border-text-light transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
