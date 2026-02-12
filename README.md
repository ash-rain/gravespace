# GraveSpace

A premium virtual memorial platform where families create beautiful, lasting memorial pages for loved ones. Dark, elegant design with a freemium model powered by Stripe.

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12, PHP 8.2+ |
| Frontend | Blade + Livewire 3 + Alpine.js |
| Styling | Tailwind CSS v4 (dark-first, CSS-first config) |
| Auth | Laravel Breeze (Blade stack) |
| Payments | Laravel Cashier v16 (Stripe) |
| Database | SQLite (dev) / MySQL 8 or PostgreSQL 16 (prod) |
| Queue | Laravel Queues (database driver) |
| i18n | EN, FR, DE, BG via JSON translation files |
| AI Tooling | Laravel Boost v2 (MCP server) |

## Requirements

- PHP 8.2 or higher
- Composer 2.x
- Node.js 18+ and npm
- SQLite (dev) or MySQL 8 / PostgreSQL 16 (prod)
- Stripe account (for billing features)

## Setup

### 1. Clone and install dependencies

```bash
git clone <repository-url> gravespace
cd gravespace
composer install
npm install
```

### 2. Environment configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and configure:

```dotenv
APP_NAME=GraveSpace
APP_URL=http://localhost:8000

# Stripe (required for billing)
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
STRIPE_MONTHLY_PRICE_ID=price_...
STRIPE_LIFETIME_PRICE_ID=price_...
CASHIER_CURRENCY=usd
```

### 3. Database

```bash
# SQLite (default for development)
touch database/database.sqlite
php artisan migrate

# Seed with test data (1 test user + 100 celebrity memorials)
php artisan db:seed
```

The test user credentials are:
- Email: `test@example.com`
- Password: `password`

### 4. Build frontend assets

```bash
npm run build
```

### 5. Start the development server

```bash
# All-in-one (server + queue + logs + vite)
composer run dev

# Or individually:
php artisan serve        # HTTP server at http://localhost:8000
npm run dev              # Vite dev server with HMR
php artisan queue:work   # Process background jobs
```

## Quick Setup (one command)

```bash
composer run setup
```

This runs `composer install`, copies `.env`, generates app key, runs migrations, installs npm packages, and builds assets.

## Project Structure

```
app/
  Http/Controllers/      Route controllers
  Http/Middleware/        Premium gating, access control, locale
  Http/Requests/         Form request validation
  Livewire/              Interactive components (tributes, gallery, gifts, search, timeline)
  Models/                Eloquent models (Memorial, Tribute, Photo, VirtualGift, etc.)
  Policies/              Authorization policies
  Services/              Business logic (MemorialService, MediaService, ReminderService)
  Jobs/                  Background jobs (photo/video processing, reminders)
  Notifications/         Email notifications (tributes, reminders, invitations)

resources/
  views/
    components/layouts/  Layout templates (app, public, memorial, guest)
    pages/               Public marketing pages (home, pricing, about, explore)
    dashboard/           Dashboard views (index, memorials CRUD, billing)
    memorial/            Public memorial views (show, gallery, timeline, password)
    livewire/            Livewire component views
  css/app.css            Tailwind v4 theme with design tokens

routes/
  web.php               All routes (public, dashboard, memorial catch-all)
  auth.php              Authentication routes (Breeze)

lang/
  en.json               English translations (360 keys)
  fr.json               French translations
  de.json               German translations
  bg.json               Bulgarian translations

database/
  migrations/           19 migration files
  seeders/              DatabaseSeeder + CelebritySeeder (100 celebrities)
```

## Key Features

- **Memorial Pages** -- rich profiles with obituary, photo gallery, timeline, and tributes
- **Virtual Gifts** -- candles, flowers, trees, wreaths, and stars with optional messages
- **Tribute Wall** -- moderated guest book for visitors to share memories
- **Photo Gallery** -- with lightbox viewer and lazy-loaded masonry grid
- **Life Timeline** -- chronological milestones with dates and photos
- **Privacy Controls** -- public, password-protected, or invite-only memorials
- **QR Codes** -- generate printable codes for gravestones (premium)
- **Custom URLs** -- `gravespace.com/john-doe` style slugs (premium)
- **Stripe Billing** -- monthly subscription or one-time lifetime purchase
- **Multilanguage** -- English, French, German, Bulgarian with header switcher
- **Dark Design** -- elegant dark theme with gold accents, serif headings, glassmorphism

## Pricing Tiers

| Feature | Free | Premium ($7.99/mo or $79 one-time) | Concierge ($299) |
|---------|------|------|-----------|
| Memorial pages | 1 | Unlimited | Unlimited |
| Photos per memorial | 5 | Unlimited | Unlimited |
| Virtual gifts | Yes | Yes | Yes |
| QR code generation | -- | Yes | Yes |
| Custom URL slug | -- | Yes | Yes |
| Privacy controls | -- | Yes | Yes |
| Professional setup | -- | -- | Yes |

## Common Commands

```bash
# Development
composer run dev                  # Start all dev services
php artisan serve                 # HTTP server only
npm run dev                       # Vite HMR only

# Database
php artisan migrate               # Run migrations
php artisan migrate:fresh --seed  # Reset DB with all seeders
php artisan db:seed --class=CelebritySeeder  # Seed 100 celebrities

# Testing
php artisan test                  # Full test suite
php artisan test --filter=Name    # Run specific test

# Code quality
vendor/bin/pint                   # Fix code style (Laravel Pint)

# Build
npm run build                     # Production frontend build

# Queue
php artisan queue:work            # Process background jobs

# Cache
php artisan config:clear          # Clear config cache
php artisan route:clear           # Clear route cache
php artisan view:clear            # Clear compiled views

# Stripe webhook (local testing)
stripe listen --forward-to localhost:8000/stripe/webhook
```

## Design System

The app uses a dark-first design with CSS-first Tailwind v4 configuration in `resources/css/app.css`:

| Token | Value | Usage |
|-------|-------|-------|
| `--color-primary` | `#0a0a0f` | Page background |
| `--color-surface` | `#12121a` | Cards, nav |
| `--color-elevated` | `#1a1a2e` | Inputs, dropdowns |
| `--color-border` | `#2a2a3e` | All borders |
| `--color-text` | `#f5f5f0` | Primary text |
| `--color-text-muted` | `#8a8a9a` | Secondary text |
| `--color-accent` | `#c9a84c` | Gold CTAs, highlights |

Typography: **Playfair Display** (serif headings) + **Inter** (sans body) via Bunny Fonts.

## License

MIT
