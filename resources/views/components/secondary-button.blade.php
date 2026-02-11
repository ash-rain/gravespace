<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-elevated border border-border rounded-xl font-semibold text-sm text-text-muted hover:text-text focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-primary disabled:opacity-25 transition-colors']) }}>
    {{ $slot }}
</button>
