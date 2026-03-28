@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-semibold uppercase tracking-wide text-gray-500']) }}>
    {{ $value ?? $slot }}
</label>
