@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-text-muted mb-2']) }}>
    {{ $value ?? $slot }}
</label>
