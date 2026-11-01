# CLAUDE.md — Jumpball Federation of India (JFI) Website

This file tells Claude Code what this project is, what is in scope, and what must NOT be built.
Source of truth: `10xCart_Jumpball_Federation_Quotation_27000.pdf` (fixed-scope quotation, ₹27,000, 45 days).

---

## 1. Project Summary

- **Client:** Jumpball Federation of India (JFI). Use this exact name in all site copy, titles and documents.
- **Developer:** 10xCart (https://10xcart.snehal.info/)
- **What we're building:** A responsive, template-based federation website with a basic backend and one admin panel.
- **Core functions:** Federation info, national/state office bearers, state associations, player registration + Player ID, events & results, media galleries, downloads, digital PDF certificates with QR verification, and a community awareness module.
- **Design approach:** Existing template with reasonable branding adjustments. NOT a custom design from scratch.

## 2. Tech Stack

- **Framework:** Laravel 13 (PHP 8.3+). Models use Laravel 13 attributes (`#[Fillable]`, `#[Hidden]`, `#[Scope]`) and a `casts()` method.
- **Views:** Blade, built on the purchased/selected HTML template (`TODO: template name`)
- **Database:** MySQL/MariaDB on shared hosting via Eloquent + migrations (local development uses SQLite). No DB enum or JSON columns.
- **Auth:** Laravel session auth. Admins = the default `users` table on the default `web` guard (every user is an admin). Players = a separate authenticatable `players` table with a `player` guard (configured in a later step). No Breeze/Jetstream, roles or permissions.
- **PDF certificates:** `barryvdh/laravel-dompdf` (one Blade certificate template)
- **QR codes:** `simplesoftwareio/simple-qrcode` (embed QR in the certificate PDF)
- **CSV export:** native `fputcsv` / streamed response (no heavy Excel package unless needed)
- **Email:** Laravel Mail + Mailables, SMTP from `.env` using **client-supplied credentials**; queue optional (`QUEUE_CONNECTION=database` if hosting supports a worker/cron, else `sync`)
- **Images:** Laravel `Storage` on `public` disk (`php artisan storage:link`)
- **Hosting:** client-provided (domain, hosting, SSL excluded from our cost). Assume shared/cPanel-type hosting may be used — avoid features that require Redis, websockets or long-running daemons.

## 3. Directory Structure (Laravel)

```
/
├── CLAUDE.md
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Frontend/        # public pages (Home, About, Events, Results, Gallery, ...)
│   │   │   ├── Admin/           # admin CRUD controllers (resourceful)
│   │   │   └── Player/          # player login area (profile, certificates)
│   │   ├── Middleware/          # e.g. EnsurePlayerApproved
│   │   └── Requests/            # FormRequest validation classes (Admin/, Frontend/)
│   ├── Models/                  # Eloquent models (see section 7)
│   │   └── Concerns/            # Publishable (published() scope), HasSlug
│   ├── Mail/                    # RegistrationReceived, RegistrationApproved, RegistrationRejected
│   └── Enums/                   # RegistrationStatus, Gender, BearerLevel, NewsType, DownloadCategory
├── config/
│   ├── auth.php                 # guards: web (admins, default), player
│   └── jumpball.php             # ID prefixes, states/UTs, document types, admin seed credentials
├── database/
│   ├── migrations/
│   └── seeders/                 # Admin/Setting/Page seeders; DemoSeeder (1–2 sample rows, run manually)
├── resources/views/
│   ├── layouts/                 # frontend.blade.php, admin.blade.php, player.blade.php
│   ├── frontend/                # 29 public pages
│   ├── admin/                   # dashboard + module CRUD views
│   ├── player/
│   ├── certificates/            # the ONE agreed certificate template (dompdf)
│   └── emails/
├── routes/
│   ├── web.php                  # public + player routes
│   └── admin.php                # prefix('admin'), middleware('auth')
├── public/assets/               # template CSS/JS/fonts/images
└── storage/app/
    ├── public/                  # gallery, banners, office bearer photos, downloads (public)
    └── private/                 # registration documents, generated certificates (NOT public)
```

## 4. Public Pages (29 total)

| # | Page | Features |
|---|------|----------|
| 1 | Home | Banner, announcements, featured events, news, gallery highlights, quick links |
| 2 | About Federation | Overview, history, objectives, mission, vision |
| 3 | About Jumpball | Intro to the sport, general info |
| 4 | Founder & President Message | Message, photo, profile |
| 5 | National Office Bearers | Officials, designations, photos |
| 6 | State Associations | Recognized associations and details |
| 7 | State Office Bearers | State officials, designations, photos |
| 8 | State Association Registration | Online form + basic document upload |
| 9 | Player Online Registration | Player details, contact, state association, agreed documents |
| 10 | Player Database & Player ID | Player records, unique registration no./Player ID |
| 11 | International Players | Country-wise listing (client-provided data) |
| 12 | Rule Book | View/download official rules |
| 13 | Current Events | Ongoing events, announcements |
| 14 | Upcoming Events | Dates, venues, details |
| 15 | Previous Events | Past events + photos |
| 16 | Championship Results | Results & standings (admin-entered) |
| 17 | Winner / First Place | First-place results |
| 18 | Runner-up / Second Place | Second-place results |
| 19 | Third Place | Third-place results |
| 20 | Digital Certificates & QR Verification | PDF download + QR verification page |
| 21 | News & Press Releases | News, announcements, dates, images |
| 22 | Photo Gallery | Event-wise image gallery |
| 23 | Video Gallery | Embedded videos (YouTube etc.) |
| 24 | Downloads & Official Notices | Circulars, forms, notices, documents |
| 25 | Contact Us | Contact form + federation contact details |
| 26 | Player Login | Own registration details, Player ID, certificates |
| 27 | Admin Login & Dashboard | Admin access, content/registration management |
| 28 | Privacy Policy | Client-supplied/approved text |
| 29 | Terms & Conditions | Client-supplied/approved text |

## 5. Backend & Admin Panel

**Single admin role only** (advanced roles/permissions are out of scope).

- **Dashboard:** login/logout; overview counts of registrations, applications, events; recent player & association submissions.
- **Page & media management:** edit page content, banners, team images, gallery images; manage news, notices, downloads, office bearers, contact info.
- **Events & results:** CRUD events (dates, venues, descriptions, images); auto-categorize upcoming vs previous **by date**; add championship results with 1st/2nd/3rd place.
- **State association registration:** store applications + uploads; status = `pending | approved | rejected`.
- **Player registration & database:** store details; generate unique Player ID; view/search/edit; approve/reject; **export to CSV**.
- **Player login:** player sees only their own details, Player ID, and available certificates.
- **Certificates:** generate PDF from ONE template; lookup/download by registration no. or Player ID; embedded QR → verification page; admin can download/regenerate (one at a time — no bulk).
- **Email notifications:** registration confirmation (player + association); approval/rejection status emails. Via client SMTP.

## 6. Community & Awareness Module

- Admin-managed **dynamic categories** (e.g. sexual harassment awareness, player safety, respectful conduct, other initiatives).
- Per entry: description, images, guidelines, documents, support contact info.
- Actions: add, edit, publish, unpublish, delete.
- **Only published content is shown publicly.**
- ⚠️ This is **information only**. No complaint submission, case tracking, investigation workflow, private messaging, or escalation.

## 7. Data Entities (implemented — see `database/migrations`)

- `users` — admins (every user is an admin)
- `players` — the Player Database: `registration_no` (public Player ID), personal + contact info, `state_association_id`, status, password (separate login)
- `state_associations` — registration applications; approved rows are the public list of recognized associations (no slug)
- `registration_documents` — polymorphic uploads for players and state associations (private disk)
- `office_bearers` — `level` national | state, `state_association_id` (required for state), name, designation, photo, sort_order
- `international_players` — admin-entered country-wise list, not linked to players
- `events` — dates, venue, description, cover image; current/upcoming/previous derived from dates (no status column)
- `event_results` — event, category, position (1 winner, 2 runner-up, 3 third, 4+ standings), participant name, state association
- `certificates` — player, event, `certificate_no`, `verification_code`, title, achievement, `issued_on`, `pdf_path`
- `news` (type: news | press_release | announcement), `downloads` (category: rule_book | circular | notice | form | document)
- `galleries`, `gallery_images`, `videos` (embed URL)
- `community_categories`, `community_posts` (published flag)
- `pages`, `banners`, `settings` (key/value site settings)
- `contact_messages`

## 8. Technical Requirements

- Responsive: desktop, tablet, mobile.
- Database-backed content and records.
- Basic form validation (client + server side).
- Protected admin routes; player routes scoped to the logged-in player.
- Basic SEO metadata + clean URLs.
- Uploaded registration documents must not be publicly browsable.
- Secrets (DB, SMTP) via env/config — never hard-coded or committed.
- Source code + database handed over after final payment.

## 9. OUT OF SCOPE — Do NOT build

- Payment gateways
- SMS / WhatsApp notifications
- Advanced roles / multi-level permissions
- **Bulk** certificate generation
- Live scoring, advanced tournament scheduling / brackets
- Multilingual support
- Third-party integrations (beyond video embeds and SMTP)
- **Aadhaar / UIDAI** authentication or Aadhaar-based lookup (Player ID / registration no. is the lookup method)
- External identity verification (QR verifies only our own DB record)
- Confidential complaint intake, case management, investigations
- Fully custom design
- Bulk data entry / historical data import (seed only 1–2 sample records per section)

If a requested change falls in this list or isn't in sections 4–6, flag it as **change request** (separate scope/pricing) instead of implementing it.

## 10. Timeline (45 days, starts after advance + content received)

| Days | Work |
|------|------|
| 1–5 | Requirements, content checklist, template setup, initial layout |
| 6–15 | Public pages + responsive layouts |
| 16–25 | Admin panel, content/media mgmt, events, registration modules |
| 26–33 | Player DB, Player ID, certificate PDF/QR, email notifications |
| 34–38 | Community categories & awareness pages |
| 39–42 | Testing, client review, minor corrections |
| 43–45 | Deployment, handover, admin walkthrough |

**Payment milestones:** 40% advance → 40% after core pages + backend demo → 20% before final handover.
**Warranty:** basic bug fixes within scope for 30 days after handover.

## 11. Client-Provided Inputs (blockers if missing)

Website text, event details, office bearer info, state association info, player data, images, video links, official documents, privacy/terms text, approved certificate design, registration field list, SMTP credentials, hosting/domain access.

## 12. Laravel Conventions

- Use resource controllers + route model binding; name routes (`admin.events.index`, `frontend.events.upcoming`).
- All validation in **FormRequest** classes, never inline in controllers.
- No Services, Repositories, DTOs or interfaces. Keep logic small, in model hooks/methods or the controller. Player ID and certificate numbers are generated in model `created` hooks.
- Use enums/casts for statuses; never hard-code status strings in views.
- Upcoming / current / previous events: `Event::upcoming()`, `current()`, `previous()` scopes on the dates (a null `end_date` means a single-day event). No status column, no cron job.
- Every frontend query on public content uses the `published()` scope (`Publishable` trait).
- Registration documents and certificate PDFs: private `local` disk, served only via a controller that checks auth (admin, or the owning player). Public certificate lookup requires Player ID + date of birth, approved players only.
- Player ID (`players.registration_no`) is built from the auto-increment id right after insert, so it cannot collide; the column also has a unique index.
- Passwords use the `hashed` cast (assign the plain value); throttle login routes (`throttle:login`).
- Mass assignment via `#[Fillable]`, excluding the status/ID/review fields listed in section 14. Eager-load to avoid N+1, paginate admin lists.
- Slugs for clean URLs (pages, news, events, galleries, community categories and posts) via `HasSlug`. State associations have no slug.
- SEO: `<title>`/meta description per page via a Blade `@section('meta')` or a simple `seo` component.
- Keep `.env.example` up to date (DB, MAIL_*, APP_URL). Never commit `.env`.
- Run `php artisan test` / basic feature tests for registration, approval, Player ID, and certificate verification flows.

## 13. Working Notes for Claude Code

- Keep it simple and maintainable — the client manages content after handover via the admin panel.
- Don't add packages beyond those in section 2 without a clear reason; prefer plain Laravel.
- Prefer the template's existing components over custom UI.
- Every public listing (events, news, community, etc.) must be driven from the admin panel, not hard-coded.
- Player ID, certificate number and verification code formats: see section 14.

## 14. Database Layer (implemented)

- **Development:** not deployed yet, so `php artisan migrate:fresh --seed` is fine during development.
- **Seeding:** `php artisan migrate:fresh --seed` creates the admin (`ADMIN_EMAIL` / `ADMIN_PASSWORD`; falls back to admin@example.com / password only in local), settings and static pages. Demo rows: `php artisan db:seed --class=DemoSeeder` (never in production).
- **Numbers:** Player ID `players.registration_no` = `JFI-2026-00001` (prefix from `config/jumpball.php`, year, zero-padded id), set in `Player::created`. Certificates: `certificate_no` = `JFI-C-2026-00001`; `verification_code` = random 32 characters, used in the QR verify URL (e.g. `/certificates/verify/{verification_code}`), never the Player ID or certificate number.

### Conventions

- No DB enum or JSON columns. Status/type columns are strings cast to backed enums in `app/Enums` (each has `label()`).
- Public content tables have `is_published` (default true) and a `published()` scope (`App\Models\Concerns\Publishable`). Ordered lists have `sort_order` (default 0).
- Slugs are filled from title/name when empty and get `-2`, `-3` when taken (`App\Models\Concerns\HasSlug`).
- Store relative file paths. Public images/PDFs go on the `public` disk; registration documents and certificate PDFs on the private `local` disk.
- NOT NULL only for required columns, names/titles, slugs, non-nullable foreign keys and status/type columns. Everything else is nullable so the client's final form fields can change without new migrations.
- No soft deletes, UUIDs or roles/permissions. The only polymorphic relation is `registration_documents` (Player, StateAssociation); deleting either deletes its documents (rows and files).
- `status`, `registration_no`, `admin_remarks`, `reviewed_at`, `certificate_no` and `verification_code` are not mass assignable; set them explicitly in code.
- Never name a non-foreign-key column `player_id`; the public Player ID is `players.registration_no`.
- Events have no status column: use `Event::upcoming()`, `current()` and `previous()` (a null `end_date` means a single-day event).
- `Setting::get($key, $default)` reads all settings from one cache entry, cleared on save/delete.
- Document types are keys from `config('jumpball.player_document_types')` / `association_document_types` (placeholders: confirm with client).

### Privacy

- Registration documents and certificate PDFs live on the private `local` disk; serve them only through a controller that checks for the admin or the owning player.
- The public player list shows only approved players' name, Player ID and state association. Never show date of birth, phone, email or address.
- Public certificate lookup requires Player ID + date of birth.

### Out of scope

Payment gateway, SMS/WhatsApp, roles/permissions, Aadhaar, complaint/case management, bulk certificates, live scoring, tournament scheduling, multilingual, third-party integrations, APIs.
