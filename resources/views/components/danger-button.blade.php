<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-danger border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-danger/80 focus:outline-none focus:ring-2 focus:ring-danger focus:ring-offset-2 focus:ring-offset-primary transition-colors']) }}>
    {{ $slot }}
</button>
