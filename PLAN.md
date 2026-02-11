# GraveSpace — Virtual Memorial Platform

## Vision

A premium virtual graveyard platform where families create beautiful, lasting memorial pages for loved ones. Dark, elegant design language that conveys reverence and permanence. Monetized through Stripe subscriptions with a generous free tier to capture users at their moment of need.

---

## Market Context

| Competitor       | Free Tier | Paid Model          | Price Range       |
| ---------------- | --------- | ------------------- | ----------------- |
| Ever Loved       | Yes       | One-time            | $199.99           |
| ForeverMissed    | Yes       | Monthly/Yearly/Life | $6.99–$124.99     |
| Keeper Memorials | Yes       | One-time + Tiers    | $99–$350          |
| Remembered       | Yes       | One-time            | $100              |
| Ecorial          | Yes       | Free (app)          | Free              |

**GraveSpace positioning:** A modern, dark-themed, mobile-first memorial platform at the $79–$99 price point — undercutting Ever Loved while matching Keeper. Most competitors have dated, light-mode designs. None combine a premium dark aesthetic with a modern SaaS architecture.

---

## Tech Stack

| Layer          | Technology                                           |
| -------------- | ---------------------------------------------------- |
| Backend        | **Laravel 12** (PHP 8.3+)                            |
| Frontend       | **Blade** + **Livewire 3** + **Alpine.js**           |
| Styling        | **Tailwind CSS v4** (dark-first design)              |
| Components     | Custom Blade component library (dark/elegant theme)  |
| Database       | **MySQL 8** (or PostgreSQL 16)                       |
| Auth           | **Laravel Breeze** (or Fortify)                      |
| Payments       | **Laravel Cashier (Stripe)**                         |
| File Storage   | **Laravel Storage** → S3-compatible (media uploads)  |
| Queue/Jobs     | **Laravel Queues** (Redis driver)                    |
| Search         | **Laravel Scout** + Meilisearch                      |
| Cache          | **Redis**                                            |
| Mail           | **Laravel Mail** (Resend / SES)                      |
| Maps           | Leaflet.js or Mapbox GL JS                           |
| Media          | Spatie Media Library (image/video processing)        |
| Deploy         | Forge / Vapor / VPS with Laravel Octane              |

---

## Pricing Tiers

### Free (Starter)
- 1 memorial page
- Up to 5 photos
- Basic obituary text editor
- Public guest book (moderated)
- GraveSpace branding/watermark
- Shareable link

### Premium — $79 one-time (or $7.99/month)
- Unlimited memorial pages
- Unlimited photos + HD video uploads
- Rich text editor with life timeline
- Custom URL slug (`gravespace.com/john-doe`)
- Privacy controls (password-protected, invite-only)
- QR code generation for headstones
- GPS resting place mapping
- Family tree builder
- Multiple co-managers per memorial
- Remove GraveSpace branding
- Virtual candles & flowers
- Anniversary/birthday reminders (email)
- Content moderation tools

### Concierge — $299 one-time
- Everything in Premium
- Professional memorial setup by GraveSpace team
- Obituary writing assistance
- Photo curation and timeline assembly
- 2x 30-min video consultations
- Priority support

### Future Revenue Streams
- Virtual memorial gifts (candles, flowers, trees) — micro-transactions $1–5
- Printed tribute books — e-commerce fulfillment
- Physical QR plaques — partnership/drop-ship
- Funeral home B2B white-label partnerships
- AI-powered features (obituary writing, memory prompts) — feature-gated

---

## Database Schema (Core Models)

```
users
├── id, name, email, password, avatar
├── stripe_id, pm_type, pm_last_four, trial_ends_at
├── created_at, updated_at

subscriptions (managed by Cashier)
├── id, user_id, type, stripe_id, stripe_status
├── stripe_price, quantity, trial_ends_at, ends_at
├── created_at, updated_at

memorials
├── id, user_id (owner)
├── slug (unique, custom URL)
├── first_name, last_name, maiden_name
├── date_of_birth, date_of_death
├── place_of_birth, place_of_death
├── obituary (rich text / markdown)
├── cover_photo, profile_photo
├── privacy (enum: public, password, invite_only)
├── password_hash (nullable, for password-protected)
├── latitude, longitude (resting place GPS)
├── cemetery_name, cemetery_address
├── is_published (boolean)
├── created_at, updated_at

memorial_managers
├── id, memorial_id, user_id, role (enum: owner, editor, viewer)

photos
├── id, memorial_id, uploaded_by (user_id)
├── file_path, thumbnail_path
├── caption, date_taken, sort_order
├── created_at

videos
├── id, memorial_id, uploaded_by
├── file_path, thumbnail_path
├── caption, duration, sort_order
├── created_at

timeline_events
├── id, memorial_id
├── title, description, event_date
├── photo_id (nullable)
├── sort_order, created_at

tributes (guest book entries)
├── id, memorial_id
├── author_name, author_email (nullable, for non-users)
├── user_id (nullable, for logged-in users)
├── body (text), photo_path (nullable)
├── is_approved (boolean, moderation)
├── created_at

virtual_gifts
├── id, memorial_id, user_id
├── type (enum: candle, flower, tree, wreath, star)
├── message (nullable)
├── created_at

family_links
├── id, memorial_id, related_memorial_id
├── relationship (enum: parent, child, sibling, spouse, etc.)

reminders
├── id, user_id, memorial_id
├── type (enum: birthday, anniversary, death_anniversary)
├── notify_at, last_sent_at
├── is_active (boolean)

qr_codes
├── id, memorial_id
├── code (unique identifier)
├── generated_at, downloaded_at
```

---

## Application Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php
│   │   ├── MemorialController.php
│   │   ├── TributeController.php
│   │   ├── PhotoController.php
│   │   ├── VideoController.php
│   │   ├── TimelineController.php
│   │   ├── FamilyLinkController.php
│   │   ├── QrCodeController.php
│   │   ├── ReminderController.php
│   │   ├── VirtualGiftController.php
│   │   ├── BillingController.php      (Cashier / Stripe portal)
│   │   └── Webhook/
│   │       └── StripeWebhookController.php
│   ├── Middleware/
│   │   ├── EnsureSubscribed.php        (premium gate)
│   │   ├── MemorialAccessControl.php   (privacy enforcement)
│   │   └── EnforceFreeLimit.php        (free tier limits)
│   └── Livewire/
│       ├── MemorialEditor.php
│       ├── PhotoGallery.php
│       ├── TimelineBuilder.php
│       ├── TributeWall.php
│       ├── FamilyTree.php
│       ├── VirtualGiftPanel.php
│       └── SearchMemorials.php
├── Models/
│   ├── User.php (Billable trait)
│   ├── Memorial.php
│   ├── Photo.php
│   ├── Video.php
│   ├── TimelineEvent.php
│   ├── Tribute.php
│   ├── VirtualGift.php
│   ├── FamilyLink.php
│   ├── Reminder.php
│   └── QrCode.php
├── Policies/
│   ├── MemorialPolicy.php
│   ├── TributePolicy.php
│   └── PhotoPolicy.php
├── Services/
│   ├── MemorialService.php
│   ├── MediaService.php
│   ├── QrCodeService.php
│   ├── GeocodingService.php
│   └── ReminderService.php
├── Jobs/
│   ├── ProcessPhotoUpload.php
│   ├── ProcessVideoUpload.php
│   ├── SendReminderNotification.php
│   └── GenerateQrCode.php
└── Notifications/
    ├── TributeReceived.php
    ├── ReminderDue.php
    └── MemorialInvitation.php

resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php          (dashboard layout, dark)
│   │   ├── public.blade.php       (marketing layout)
│   │   └── memorial.blade.php     (public memorial layout)
│   ├── components/
│   │   ├── ui/                    (buttons, cards, modals, inputs...)
│   │   └── memorial/              (memorial-specific components)
│   ├── pages/
│   │   ├── home.blade.php         (landing page)
│   │   ├── pricing.blade.php
│   │   └── about.blade.php
│   ├── dashboard/
│   │   ├── index.blade.php
│   │   ├── memorials/
│   │   └── billing/
│   ├── memorial/
│   │   ├── show.blade.php         (public memorial page)
│   │   ├── tributes.blade.php
│   │   ├── gallery.blade.php
│   │   ├── timeline.blade.php
│   │   └── family-tree.blade.php
│   └── livewire/
│       └── ...
├── css/
│   └── app.css                    (Tailwind v4 entry, theme tokens)
└── js/
    └── app.js                     (Alpine.js, map init, etc.)

routes/
├── web.php                        (public + auth routes)
├── dashboard.php                  (protected dashboard routes)
└── api.php                        (optional API for mobile/embeds)
```

---

## Design System — Dark Elegance

### Color Palette

| Token         | Value                  | Usage                              |
| ------------- | ---------------------- | ---------------------------------- |
| `bg-primary`  | `#0a0a0f`             | Page background                    |
| `bg-surface`  | `#12121a`             | Cards, panels                      |
| `bg-elevated` | `#1a1a2e`             | Modals, dropdowns, hover states    |
| `border`      | `#2a2a3e`             | Borders, dividers                  |
| `text`        | `#f5f5f0`             | Primary text                       |
| `text-muted`  | `#8a8a9a`             | Secondary text, labels             |
| `accent`      | `#c9a84c` (muted gold)| CTAs, highlights, premium accents  |
| `accent-hover`| `#dbb85c`             | Hover state for accent             |
| `candle`      | `#f5a623`             | Virtual candle glow                |
| `success`     | `#4ade80`             | Success states                     |
| `danger`      | `#ef4444`             | Destructive actions                |

### Typography
- **Headings:** Serif font (Playfair Display or Cormorant Garamond) — conveys elegance and permanence
- **Body:** Clean sans-serif (Inter or DM Sans)
- **Memorial names:** Larger, tracked-out serif with subtle gold accent

### Design Principles
- **Dark-first:** All interfaces default to dark. Optional light mode later.
- **Generous whitespace:** Let content breathe. Grief needs space.
- **Subtle animations:** Gentle fade-ins, soft parallax on memorial pages. No jarring transitions.
- **Photography-forward:** Large, high-quality images. Minimal chrome.
- **Candlelight motif:** Warm amber glows, soft radial gradients as background accents.
- **Glassmorphism accents:** Frosted-glass cards with subtle backdrop-blur on elevated surfaces.

### Key UI Patterns
- Memorial cards with cover photo, soft gradient overlay, gold-accented name
- Full-bleed hero on public memorial pages with parallax cover photo
- Tribute wall as a masonry grid of cards with soft glow borders
- Virtual candle animation (CSS/SVG) with real-time counter
- Photo gallery as a responsive masonry layout with lightbox
- Timeline as a vertical line with alternating event cards
- Family tree as a connected node graph (SVG or Canvas)

---

## Stripe Integration (Laravel Cashier)

### Setup
1. Install `laravel/cashier` — handles Stripe subscriptions, one-time charges, customer portal
2. Add `Billable` trait to `User` model
3. Configure Stripe keys in `.env`
4. Run Cashier migrations (adds `stripe_id`, `pm_type`, `pm_last_four`, `trial_ends_at` to users; creates `subscriptions` and `subscription_items` tables)

### Checkout Flows

**Subscription (monthly):**
```php
return $user->newSubscription('default', $monthlyPriceId)
    ->checkout([
        'success_url' => route('dashboard'),
        'cancel_url' => route('pricing'),
    ]);
```

**One-time (lifetime Premium):**
```php
return $user->checkout($lifetimePriceId, [
    'success_url' => route('dashboard'),
    'cancel_url' => route('pricing'),
    'mode' => 'payment',
]);
```

### Webhook Handling
- Extend `CashierController` or use `Laravel\Cashier\Http\Controllers\WebhookController`
- Key events: `customer.subscription.created`, `customer.subscription.updated`, `customer.subscription.deleted`, `invoice.payment_succeeded`, `invoice.payment_failed`, `checkout.session.completed`
- Sync subscription status to local DB for fast gate checks

### Premium Gating
```php
// Middleware
if (! $user->subscribed('default') && ! $user->hasLifetimePremium()) {
    return redirect()->route('pricing');
}

// Blade directive
@subscribed
    {{-- Premium content --}}
@else
    {{-- Upgrade prompt --}}
@endsubscribed

// Free tier enforcement
if (! $user->subscribed('default') && $user->memorials()->count() >= 1) {
    return redirect()->route('pricing')->with('message', 'Upgrade to create more memorials.');
}
```

### Customer Portal
```php
return $user->redirectToBillingPortal(route('dashboard'));
```

---

## Routes Overview

### Public
| Method | URI                        | Description                |
| ------ | -------------------------- | -------------------------- |
| GET    | `/`                        | Landing page               |
| GET    | `/pricing`                 | Pricing page               |
| GET    | `/about`                   | About / mission            |
| GET    | `/explore`                 | Public memorial directory  |
| GET    | `/{slug}`                  | Public memorial page       |
| GET    | `/{slug}/gallery`          | Memorial photo gallery     |
| GET    | `/{slug}/timeline`         | Memorial life timeline     |
| GET    | `/{slug}/tributes`         | Memorial tribute wall      |
| POST   | `/{slug}/tributes`         | Submit a tribute           |
| POST   | `/{slug}/gifts`            | Leave a virtual gift       |
| GET    | `/qr/{code}`              | QR code redirect           |

### Authenticated (Dashboard)
| Method | URI                                  | Description                     |
| ------ | ------------------------------------ | ------------------------------- |
| GET    | `/dashboard`                         | User dashboard                  |
| GET    | `/dashboard/memorials`               | List user's memorials           |
| GET    | `/dashboard/memorials/create`        | Create memorial form            |
| POST   | `/dashboard/memorials`               | Store memorial                  |
| GET    | `/dashboard/memorials/{id}/edit`     | Edit memorial                   |
| PUT    | `/dashboard/memorials/{id}`          | Update memorial                 |
| DELETE | `/dashboard/memorials/{id}`          | Delete memorial                 |
| POST   | `/dashboard/memorials/{id}/photos`   | Upload photos                   |
| POST   | `/dashboard/memorials/{id}/videos`   | Upload videos                   |
| GET    | `/dashboard/memorials/{id}/managers` | Manage co-managers              |
| GET    | `/dashboard/memorials/{id}/qr`      | Generate/download QR code       |
| GET    | `/dashboard/billing`                 | Billing / Stripe portal redirect|
| POST   | `/dashboard/checkout`                | Initiate Stripe checkout        |

### Webhooks
| Method | URI                    | Description            |
| ------ | ---------------------- | ---------------------- |
| POST   | `/stripe/webhook`      | Stripe webhook handler |

---

## Implementation Phases

### Phase 1 — Foundation (MVP)
- [ ] Laravel project setup (Breeze auth, Tailwind v4, Livewire 3)
- [ ] Database migrations for core models (users, memorials, photos, tributes)
- [ ] Dark theme design system (Tailwind config, Blade components)
- [ ] Landing page + pricing page
- [ ] User registration + login
- [ ] Memorial CRUD (create, edit, delete, publish)
- [ ] Basic photo upload (up to 5 free, unlimited premium)
- [ ] Public memorial page with obituary, photos, guest book
- [ ] Tribute/guest book (submit + moderation)
- [ ] Stripe integration via Cashier (subscription + one-time checkout)
- [ ] Premium gating middleware
- [ ] Stripe customer portal for billing management

### Phase 2 — Rich Features
- [ ] Life timeline builder (Livewire)
- [ ] HD video uploads with processing (queued jobs)
- [ ] Custom URL slugs for memorials
- [ ] Privacy controls (password-protected, invite-only)
- [ ] Multiple co-managers per memorial
- [ ] QR code generation + download
- [ ] GPS mapping of resting places (Leaflet.js)
- [ ] Virtual candles + flowers with animations
- [ ] Email reminders (birthday, anniversary)
- [ ] Explore/search public memorials (Scout + Meilisearch)

### Phase 3 — Growth & Polish
- [ ] Family tree builder (visual node graph)
- [ ] Concierge tier implementation + admin workflow
- [ ] Virtual gift micro-transactions
- [ ] Social sharing OG tags + rich previews
- [ ] PWA support (service worker, offline memorial viewing)
- [ ] Admin panel (Filament) for platform management
- [ ] Analytics dashboard for memorial owners (visit counts, tribute counts)
- [ ] Performance optimization (Octane, caching, CDN for media)
- [ ] SEO optimization for memorial pages

### Phase 4 — Expansion
- [ ] AI obituary writing assistant
- [ ] Printed tribute book generation (PDF → fulfillment)
- [ ] Physical QR plaque ordering (e-commerce)
- [ ] Funeral home B2B white-label partnerships
- [ ] API for third-party integrations
- [ ] Mobile app (or deeper PWA)

---

## Key Technical Decisions

| Decision                     | Choice                          | Rationale                                                    |
| ---------------------------- | ------------------------------- | ------------------------------------------------------------ |
| Frontend interactivity       | Livewire 3 + Alpine.js         | Server-driven, minimal JS, great DX with Laravel             |
| Payment processing           | Laravel Cashier (Stripe)        | First-party integration, handles subscriptions + one-time    |
| File storage                 | S3-compatible via Laravel       | Scalable, CDN-friendly, cheap for media-heavy platform       |
| Image processing             | Spatie Media Library            | Thumbnails, conversions, responsive images out of the box    |
| Search                       | Scout + Meilisearch             | Fast, typo-tolerant search for public memorial directory     |
| Background jobs              | Laravel Queues (Redis)          | Photo/video processing, email sending, QR generation         |
| Admin panel                  | Filament                        | Laravel-native, beautiful admin UI, minimal setup            |
| QR codes                     | `simplesoftwareio/simple-qrcode`| Well-maintained Laravel QR package                           |
| Maps                         | Leaflet.js (free) or Mapbox     | No Google Maps dependency, open-source option                |
| Rich text                    | Tiptap (via Livewire)           | Modern, extensible, works well with Livewire                 |
