@props(['latitude', 'longitude', 'name' => ''])

@if ($latitude && $longitude)
    @push('head')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    @endpush

    <div id="memorial-map" class="w-full h-64 rounded-xl overflow-hidden border border-border mt-4"></div>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const map = L.map('memorial-map', {
                    scrollWheelZoom: false,
                }).setView([{{ $latitude }}, {{ $longitude }}], 15);

                L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/">CARTO</a>',
                    subdomains: 'abcd',
                    maxZoom: 20,
                }).addTo(map);

                const markerIcon = L.divIcon({
                    className: 'memorial-marker',
                    html: '<div style="width: 24px; height: 24px; background: #c9a84c; border: 3px solid #0a0a0f; border-radius: 50%; box-shadow: 0 0 10px rgba(201,168,76,0.5);"></div>',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12],
                });

                L.marker([{{ $latitude }}, {{ $longitude }}], { icon: markerIcon })
                    .addTo(map)
                    @if ($name)
                        .bindPopup('<span style="color: #1a1a2e; font-weight: 600;">{{ e($name) }}</span>');
                    @endif
            });
        </script>
    @endpush
@endif
