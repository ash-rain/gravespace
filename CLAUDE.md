# GraveSpace — CLAUDE.md

## Project Overview
GraveSpace is a premium virtual memorial/graveyard platform built with Laravel 12. Users create elegant memorial pages for loved ones, with a freemium model monetized through Stripe subscriptions. Multilanguage support (EN, FR, DE, BG).

## Tech Stack
- **Backend:** Laravel 12, PHP 8.5+
- **Frontend:** Blade + Livewire 3 (v4.x) + Alpine.js
- **Styling:** Tailwind CSS v4 (dark-first design, CSS-first config)
- **Database:** SQLite (dev) / MySQL 8 or PostgreSQL 16 (prod)
- **Auth:** Laravel Breeze (Blade stack)
- **Payments:** Laravel Cashier v16 (Stripe)
- **Storage:** S3-compatible via Laravel filesystem
- **Queue:** Laravel Queues (database driver dev, Redis prod)
- **i18n:** Laravel localization (`lang/` directory, `__()` helper)

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

**Note:** Use `/usr/local/Cellar/php/8.5.1_2/bin/php` if system PHP is not 8.5.

## Project Structure
```
app/Http/Controllers/       — Route controllers
app/Livewire/               — Livewire interactive components
app/Http/Middleware/         — Premium gating, access control
app/Http/Requests/          — Form request validation
app/Models/                 — Eloquent models
app/Policies/               — Authorization policies
app/Services/               — Business logic services
app/Jobs/                   — Queued background jobs
app/Notifications/          — Email/notification classes
resources/views/layouts/    — Layout templates (app, public, memorial, guest)
resources/views/pages/      — Public marketing pages
resources/views/dashboard/  — Dashboard views
resources/views/memorial/   — Public memorial views
resources/views/livewire/   — Livewire component views
resources/views/components/ — Reusable Blade components (ui/, memorial/)
resources/css/app.css       — Tailwind v4 theme (CSS-first config)
lang/en/                    — English translations
lang/fr/                    — French translations
lang/de/                    — German translations
lang/bg/                    — Bulgarian translations
routes/web.php              — All routes (public + dashboard + memorial)
database/migrations/        — Database migrations
database/seeders/           — Test/demo data seeders
tests/Feature/              — Feature tests
tests/Unit/                 — Unit tests
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
- All user-facing strings wrapped in `__()` for translation support

## Design System
- **Dark-first** design — primary bg `#0a0a0f`, surface `#12121a`, elevated `#1a1a2e`
- **Accent color:** muted gold `#c9a84c` for CTAs and premium highlights
- **Typography:** Serif headings (Playfair Display), sans-serif body (Inter)
- **Principles:** generous whitespace, photography-forward, subtle animations, glassmorphism accents
- Tailwind v4 CSS-first config in `resources/css/app.css` with `@theme` block
- Colors available as: `bg-primary`, `bg-surface`, `bg-elevated`, `text-text`, `text-text-muted`, `text-accent`, `border-border`

## Stripe / Billing
- Laravel Cashier manages all Stripe interactions
- `User` model uses the `Billable` trait
- Free tier: enforce limits at application level (1 memorial, 5 photos)
- Premium: checked via `$user->isPremium()` (subscription or lifetime)
- Lifetime: checked via `$user->hasLifetimePremium()` (one-time payment sets `lifetime_premium_at`)
- Stripe webhooks handled at `POST /stripe/webhook` via `StripeWebhookController`
- Config keys in `config/services.php` → `stripe.monthly_price_id`, `stripe.lifetime_price_id`

## Multilanguage
- Supported locales: `en`, `fr`, `de`, `bg`
- Translation files in `lang/{locale}/` directories
- All user-facing strings use `__('key')` or `@lang('key')` in Blade
- Locale can be set via URL prefix or user preference

## Testing
- Write Feature tests for all controller actions and Livewire components
- Write Unit tests for services and business logic
- Use factories and seeders for test data
- Test premium gating: verify free users hit limits, premium users bypass them

## Important Rules
- Never commit `.env` or any file containing secrets
- Never expose Stripe secret keys client-side
- Always validate and sanitize user input (form requests)
- Always authorize actions through policies
- Media uploads must go through queued processing jobs
- Public memorial pages must have proper OG meta tags for social sharing
- All memorial content must be moderable (tributes require approval by default)
