# GraveSpace — CLAUDE.md

## Project Overview
GraveSpace is a premium virtual memorial/graveyard platform built with Laravel. Users create elegant memorial pages for loved ones, with a freemium model monetized through Stripe subscriptions.

## Tech Stack
- **Backend:** Laravel 11, PHP 8.3+
- **Frontend:** Blade + Livewire 3 + Alpine.js
- **Styling:** Tailwind CSS v4 (dark-first design)
- **Database:** MySQL 8 (or PostgreSQL 16)
- **Auth:** Laravel Breeze
- **Payments:** Laravel Cashier (Stripe)
- **Storage:** S3-compatible via Laravel filesystem
- **Queue:** Laravel Queues with Redis
- **Search:** Laravel Scout + Meilisearch
- **Media:** Spatie Media Library
- **Admin:** Filament (Phase 3)

## Commands
- `php artisan serve` — Start development server
- `npm run dev` — Vite dev server (Tailwind + JS hot reload)
- `npm run build` — Production build
- `php artisan test` — Run full test suite
- `php artisan test --filter=MemorialTest` — Run specific test
- `php artisan migrate` — Run migrations
- `php artisan migrate:fresh --seed` — Reset DB with seeders
- `php artisan queue:work` — Process background jobs
- `php artisan tinker` — REPL

## Project Structure
```
app/Http/Controllers/     — Route controllers
app/Http/Livewire/        — Livewire interactive components
app/Http/Middleware/       — Premium gating, access control
app/Models/               — Eloquent models
app/Policies/             — Authorization policies
app/Services/             — Business logic services
app/Jobs/                 — Queued background jobs
app/Notifications/        — Email/notification classes
resources/views/          — Blade templates
resources/views/components/ui/        — Reusable UI components
resources/views/components/memorial/  — Memorial-specific components
resources/css/app.css     — Tailwind v4 theme + custom properties
routes/web.php            — Public + auth routes
routes/dashboard.php      — Protected dashboard routes
database/migrations/      — Database migrations
database/seeders/         — Test/demo data seeders
tests/Feature/            — Feature tests
tests/Unit/               — Unit tests
```

## Code Style & Conventions
- Follow PSR-12 coding standard
- Use strict types: `declare(strict_types=1);` in all PHP files
- Type-hint all method parameters and return types
- Use Laravel conventions: resourceful controllers, form requests for validation, policies for authorization
- Blade components over partials — use `<x-component>` syntax
- Livewire for interactive elements (editors, galleries, forms), static Blade for everything else
- Alpine.js for small client-side interactions (toggles, dropdowns, modals)
- All database queries through Eloquent (no raw queries unless performance-critical)
- Use Laravel's built-in features: middleware for gating, events/listeners for side effects, jobs for heavy work

## Design System
- **Dark-first** design — primary bg `#0a0a0f`, surface `#12121a`, elevated `#1a1a2e`
- **Accent color:** muted gold `#c9a84c` for CTAs and premium highlights
- **Typography:** Serif headings (Playfair Display), sans-serif body (Inter)
- **Principles:** generous whitespace, photography-forward, subtle animations, glassmorphism accents
- All Blade UI components should respect the dark theme tokens defined in `resources/css/app.css`
- Use Tailwind utility classes — avoid custom CSS unless absolutely necessary

## Stripe / Billing
- Laravel Cashier manages all Stripe interactions
- `User` model uses the `Billable` trait
- Free tier: enforce limits at application level (1 memorial, 5 photos)
- Premium: checked via `$user->subscribed('default')` or `$user->hasLifetimePremium()`
- Stripe webhooks handled at `POST /stripe/webhook`
- Never trust client-side price data — always resolve prices server-side

## Testing
- Write Feature tests for all controller actions and Livewire components
- Write Unit tests for services and business logic
- Use factories and seeders for test data
- Test premium gating: verify free users hit limits, premium users bypass them
- Test Stripe webhook handling with mocked payloads

## Important Rules
- Never commit `.env` or any file containing secrets
- Never expose Stripe secret keys client-side
- Always validate and sanitize user input (form requests)
- Always authorize actions through policies
- Media uploads must go through queued processing jobs (thumbnails, optimization)
- Public memorial pages must have proper OG meta tags for social sharing
- All memorial content must be moderable (tributes require approval by default)
