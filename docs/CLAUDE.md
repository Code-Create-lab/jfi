# CLAUDE.md — Jumpball Federation of India (JFI) Website

This file tells Claude Code what this project is, what is in scope, and what must NOT be built.
Source of truth: `10xCart_Jumpball_Federation_Quotation_27000.pdf` (fixed-scope quotation, ₹27,000, 45 days).
Progress tracker: section 15 (update it after every phase). Phase-by-phase prompts: `docs/PHASES.md`.

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
- **Admin panel:** Filament 5 panel at `/admin` (`App\Providers\Filament\AdminPanelProvider`, code in `app/Filament/`). Light mode only, JFI logo and blue primary colour. Widgets do not poll (shared hosting).
- **Auth:** Laravel session auth. Admins = the default `users` table on the default `web` guard, logging in through Filament's login page (every user is an admin: `User::canAccessPanel()` returns true). Players = a separate authenticatable `players` table with a `player` guard (configured in a later step). No Breeze/Jetstream, roles or permissions.
- **PDF certificates:** `barryvdh/laravel-dompdf` (one Blade certificate template, font subsetting on)
- **QR codes:** `simplesoftwareio/simple-qrcode` (SVG data URI in the certificate PDF; installs alongside Filament, whose MFA uses `chillerlan/php-qrcode`)
- **CSV export:** native `fputcsv` / streamed response (no heavy Excel package unless needed)
- **Email:** Laravel Mail + Mailables, SMTP from `.env` using **client-supplied credentials**; queue optional (`QUEUE_CONNECTION=database` if hosting supports a worker/cron, else `sync`)
- **Images:** Laravel `Storage` on `public` disk (`php artisan storage:link`)
- **Hosting:** client-provided (domain, hosting, SSL excluded from our cost). Assume shared/cPanel-type hosting may be used — avoid features that require Redis, websockets or long-running daemons.

## 3. Directory Structure (Laravel)

```
/
├── CLAUDE.md
├── docs/                        # PHASES.md (phase prompts); later DEPLOYMENT.md, admin-guide.md, qa-checklist.md
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Frontend/        # public pages (Home, About, Events, Results, Gallery, ...)
│   │   │   └── Player/          # player login area (profile, certificates)
│   │   ├── Middleware/          # e.g. EnsurePlayerApproved
│   │   └── Requests/            # FormRequest validation classes (Frontend/)
│   ├── Filament/                # admin panel: Resources/ (one per module), Widgets/ (dashboard)
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
│   ├── layouts/                 # frontend.blade.php, player.blade.php
│   ├── frontend/                # 29 public pages
│   ├── player/
│   ├── certificates/            # the ONE agreed certificate template (dompdf)
│   └── emails/
├── routes/
│   └── web.php                  # public + player routes (admin routes come from the Filament panel)
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

If a requested change falls in this list or isn't in sections 4–6, flag it as **change request** (separate scope/pricing) and log it in section 15 instead of implementing it.

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

Tick when received. We enter only 1–2 sample items per section; the client enters the rest through `/admin`.

- [ ] Website text (about, history, objectives, mission/vision, about Jumpball, president message)
- [ ] Event details and results
- [x] National office bearers (in `config('jumpball.national_bearers')`)
- [ ] State association info and state office bearers
- [ ] Player data (players register themselves; the client manages the rest in `/admin`)
- [ ] Images: client photos to replace the template placeholders
- [ ] Video links
- [ ] Official documents (rule book, circulars, forms, notices)
- [ ] Privacy policy and terms text
- [ ] Approved certificate design + signatures/seal (needed for Phase 3)
- [ ] Final registration field list + document types (needed for Phase 2B)
- [ ] SMTP credentials (needed to test real emails before go-live)
- [ ] Hosting/domain access: the host must run PHP 8.3+ and MySQL/MariaDB (confirm early, not at deployment)

## 12. Laravel Conventions

- Frontend/player: resource controllers + route model binding; name routes (`frontend.events.upcoming`). All validation in **FormRequest** classes, never inline in controllers.
- Admin: one Filament resource per module in `app/Filament/Resources`; validation lives in the resource form schema (`->required()`, `->rules()`). Use the enums (they implement Filament `HasLabel`/`HasColor`) for selects and badges. Status/ID/review fields are set explicitly in actions (e.g. Approve/Reject), never through mass-assigned form data. Admin CSV export is a streamed `fputcsv` download action, not Filament's queued exporter. Admin file uploads for registration documents use the private `local` disk. Registration documents are downloaded through `RegistrationDocumentController` (admin panel authenticated route `filament.admin.registration-documents.download`). Approve/Reject: both registration models use the `Reviewable` trait (`approve($remarks)` / `reject($remarks)` set status, `admin_remarks`, `reviewed_at`), and both resources use the `App\Filament\Concerns\HasReviewActions` trait, which saves the status and then sends `RegistrationApproved` / `RegistrationRejected` (they accept a Player or a StateAssociation) synchronously; a mail failure is reported and shown as a warning but never undoes the status change. The Players and State Associations resources are the pattern for new admin modules. Selects of state associations outside the registration resources list approved associations only (`Fields::approvedAssociationSelect()`, `StateAssociation::approved()` scope).
- Admin helpers: `App\Filament\Support\Fields` (`richText()` without file attachments — images go through each module's own upload field; `stateOptions()`; `approvedAssociationSelect()`). Models with uploads use the `DeletesStoredFiles` trait (`storedFiles()` lists attribute => disk) so replaced and deleted files are removed; paths under `assets/` are never deleted. Deleting an event deletes its results, a gallery its photos, and a community category its posts, through the models (so their files go too). Gallery photos are added with the "Upload photos" action (up to 20 per batch, resized in the browser to about 1600 px wide). Videos accept YouTube, Vimeo or Facebook links (`Video::URL_PATTERN`); use `$video->embed_url` and `$video->thumbnail_url` (YouTube only). Contact messages are read-only (viewing sets `read_at`). Admin users: every user is an admin; `UserPolicy` stops an admin deleting their own account and has no bulk delete; each admin edits their own name, email and password at `/admin/profile`. Navigation groups: Registrations, Federation, Events & Media, Content, Settings. Pages are edit-only (fixed slugs); Site Settings (`App\Filament\Pages\SiteSettings`) edits only the seeded keys, and `map_embed` stores a Google Maps embed URL, not HTML.
- No Services, Repositories, DTOs or interfaces. Keep logic small, in model hooks/methods or the controller. Player ID and certificate numbers are generated in model `created` hooks.
- Use enums/casts for statuses; never hard-code status strings in views.
- Upcoming / current / previous events: `Event::upcoming()`, `current()`, `previous()` scopes on the dates (a null `end_date` means a single-day event). No status column, no cron job.
- Every frontend query on public content uses the `published()` scope (`Publishable` trait).
- Registration documents and certificate PDFs: private `local` disk, served only via a controller that checks auth (admin, or the owning player; certificate PDFs also through a short-lived signed link after a successful public lookup). Public certificate lookup requires Player ID + date of birth, approved players only.
- Player ID (`players.registration_no`) is built from the auto-increment id right after insert, so it cannot collide; the column also has a unique index.
- Passwords use the `hashed` cast (assign the plain value); throttle login routes (`throttle:login`).
- Mass assignment via `#[Fillable]`, excluding the status/ID/review fields listed in section 14. Eager-load to avoid N+1, paginate admin lists.
- Slugs for clean URLs (pages, news, events, galleries, community categories and posts) via `HasSlug`. State associations have no slug.
- SEO: `<title>`/meta description per page via a Blade `@section('meta')` or a simple `seo` component.
- Keep `.env.example` up to date (DB, MAIL_*, APP_URL). Never commit `.env`.
- Run `php artisan test` / basic feature tests for registration, approval, Player ID, and certificate verification flows.

## 13. Working Notes for Claude Code

- **Progress:** check section 15 before starting work and update it at the end of every phase (rules in `docs/PHASES.md`).
- Keep it simple and maintainable — the client manages content after handover via the admin panel.
- Don't add packages beyond those in section 2 without a clear reason; prefer plain Laravel (Filament plugins count as packages).
- Filament assets are published to `public/{css,js,fonts}/filament` by `php artisan filament:upgrade` (runs on `composer install`) and are git-ignored. When deploying without Composer on the server, run `php artisan filament:assets` before uploading.
- Prefer the template's existing components over custom UI.
- Every public listing (events, news, community, etc.) must be driven from the admin panel, not hard-coded.
- Player ID, certificate number and verification code formats: see section 14.
- **Frontend:** every public page in section 4 (except the admin area) is a Blade view in `resources/views/frontend/` with layout `layouts/frontend.blade.php`; navigation lives in `config('jumpball.navigation')`. Content pages are served by controllers in `app/Http/Controllers/Frontend` (Phase 2A): every query uses `published()` (players: approved only; associations: `approved()`), relations are eager-loaded (`Model::preventLazyLoading()` is on outside production), long lists paginate with `partials/pagination.blade.php`, and unknown or unpublished slugs return 404. The five content pages use `PageController` with the slug passed as a route default. Contact details, social links, footer text and the default meta description come from settings through the view composer in `AppServiceProvider` (`$site`, `$contact`, `$social`). The home hero shows published banners whole, beside the headline (banners are designed artwork with their own lettering), and the JFI logo plate until one is published. Site CSS/JS links use the `@versionedAsset()` Blade directive (file modification time as `?v=`) because the live server caches `public/assets` for a week.
- **Preview data:** none left; `_preview-data.php` was deleted in Phase 3 when the verify page was wired. The player login form posts to `#` until Phase 4.
- **Certificates (Phase 3):** `Certificate::generatePdf()` renders `resources/views/certificates/certificate.blade.php` (A4 landscape, absolute positioning in mm; artwork in `public/assets/images/jfi/certificate-*`: frame and emblem SVGs whose width/height must equal their viewBox because dompdf ignores viewBox scaling, logo and faint watermark PNGs; Times + Helvetica core fonts, with the embedded DejaVu Serif only for a block whose text is outside Windows-1252; long titles, names and citations get smaller type so the page never overflows; QR as an SVG data URI linking to `frontend.certificates.verify`) to `certificates/{certificate_no}.pdf` on the private disk. It runs after create, when a printed attribute changes, on the admin's Regenerate action, and on download if the file is missing. PDFs are served only by `CertificatePdfController`: the admin panel route `filament.admin.certificates.download`, or `frontend.certificates.download` with the `signed:relative` middleware (30-minute relative links from the lookup, so proxies and host aliases don't break them). The lookup (`CertificateController`, `LookupCertificatesRequest`, `throttle:certificate-lookup` = 10/min/IP) posts to `/certificates`, matches Player ID + date of birth for approved players only, and flashes the player id; every wrong combination gets the same message. Redirects land on `#lookup-results` or `#find-certificate` (validation errors too, via `LookupCertificatesRequest::getRedirectUrl()`); each result has Download PDF and Verify; the submit button uses the `data-busy-label` helper in `jfi-forms.js`. The page's sample image (`certificate-sample.webp`) is rendered from the real template with `Certificate::renderPdf()` on unsaved models and stamped SAMPLE; re-render it if the template changes. Unknown verify codes return 404 with "Not a valid certificate"; verify pages are `noindex`. Admin: Certificates resource (Registrations group, no bulk actions) and "Issue certificate" on an approved player's page; deleting a certificate or player deletes the PDFs; correcting a player's name or Player ID re-renders their PDFs (event edits do not: use Regenerate, since re-rendering every certificate of an event would be bulk generation). The title is limited to 40 characters and the achievement to 80 so they fit the template.
- **Public forms (Phase 2B):** Contact (`ContactController`), State Association Registration (`StateAssociationController@create/store`) and Player Registration (`PlayerController@create/store`) post to the same URLs as their pages, validated by FormRequests in `app/Http/Requests/Frontend`. Each form has `@csrf`, the `<x-honeypot/>` field (`website`, rule `prohibited`), the `throttle:public-forms` limiter (5 per minute per IP, `AppServiceProvider`), `<x-form-alert/>` and `<x-form-error/>` for messages, and old input. Uploads: pdf/jpg/png, max 2 MB, stored under generated names with `RegistrationDocument::storeUploads()` (documents on the private disk; player photos private, association logos public); stored files are deleted again if the insert fails. Registrations save as pending in a transaction, then `RegistrationReceived` is sent synchronously (a mail failure is reported, never shown). Success states are flashed to the same page (`registered_player` shows the Player ID, `registered_association`). Players must choose an approved association; while none exists the page shows a message instead of the form.
- **Styles:** brand overrides in `public/assets/css/jfi-theme.css`, page components in `public/assets/css/jfi-components.css`. Do not edit the template's `main.css`.
- **Images:** generated brand graphics in `public/assets/images/jfi/` (cover-1..6 are the fallback covers when no image is uploaded; certificate sample is watermarked SAMPLE). A few photos and icons from the original template in `public/assets/images/` are placeholders on the home page, in preview data and in inner page banners (`config('jumpball.page_banners')`, route pattern => photo); replace them with client photos (section 11). Unused template images were removed; a local copy is in `storage/app/backups/` (git-ignored).
- **Animations:** template scroll-in effect: add `animate-box animate__animated` plus `data-animate="animate__fadeInUp"` (handled by `script.js`). Shared components already do this; cards in a `.row` are staggered by CSS.

## 14. Database Layer (implemented)

- **Development:** not deployed yet, so `php artisan migrate:fresh --seed` is fine during development.
- **Seeding:** `php artisan migrate:fresh --seed` creates the admin (`ADMIN_EMAIL` / `ADMIN_PASSWORD`; falls back to admin@example.com / password only in local), settings, static pages and the national office bearers (`OfficeBearerSeeder`, from `config('jumpball.national_bearers')`, photos copied to the public disk; skips names that already exist). The same config list is the public fallback while no published national bearer exists (`OfficeBearer::nationalForDisplay()`). Demo rows: `php artisan db:seed --class=DemoSeeder` (never in production).
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

- Registration documents and certificate PDFs live on the private `local` disk; serve them only through a controller that checks for the admin or the owning player (certificate PDFs also through a short-lived signed link after a successful public lookup).
- The public player list shows only approved players' name, Player ID and state association. Never show date of birth, phone, email or address.
- Public certificate lookup requires Player ID + date of birth.

### Out of scope

Payment gateway, SMS/WhatsApp, roles/permissions, Aadhaar, complaint/case management, bulk certificates, live scoring, tournament scheduling, multilingual, third-party integrations, APIs.

## 15. Build Progress

Phase prompts: `docs/PHASES.md` (one phase per session). Check progress any time with the "Progress check" in that file.

**Update rules:** at the end of every phase, tick only items that work in the code, set "Current phase", add one line to the Log, and fix any section of this file the phase made outdated. Requests outside sections 4–6 go to "Change requests", never into the code.

**Current phase:** 3 done — next: Phase 4 — Player area

### Done before the phases
- [x] Database layer: migrations, models, enums, `config/jumpball.php`, seeders (section 14)
- [x] Frontend design stage: Blade views for all public pages with preview data (section 13)
- [x] Filament panel at `/admin` with JFI branding
- [x] Admin: Players (search/edit, approve/reject + emails, CSV export, document downloads)
- [x] Admin: Office Bearers

### Phase 1 — Admin panel
- [x] 1A State Associations (approve/reject + emails, documents)
- [x] 1B Events + Results
- [x] 1B News, Downloads, Banners
- [x] 1B Pages (edit only), Site Settings
- [x] 1C Galleries + photos, Videos
- [x] 1C International Players, Community categories + posts
- [x] 1C Contact Messages, admin users + profile, dashboard widgets, navigation groups

### Phase 2 — Frontend wiring
- [x] 2A Home, static pages, office bearers, state associations
- [x] 2A Events, results, news, gallery, videos, downloads, rule book
- [x] 2A International players, community, public player list
- [x] 2B Contact form
- [x] 2B State association registration + confirmation email
- [x] 2B Player registration + Player ID + confirmation email

> Milestone: demo core pages + backend to the client → 2nd payment (40%).

### Phase 3 — Certificates
- [x] dompdf + QR installed, one certificate template
- [x] Admin: issue, download, regenerate (one at a time)
- [x] Public lookup (Player ID + date of birth) and verify page

### Phase 4 — Player area
- [ ] `player` guard, login (email or Player ID), logout, throttle
- [ ] Forgot / reset password
- [ ] Dashboard: details, status/remarks, own certificates (`_preview-data.php` already deleted in Phase 3)

### Phase 5 — Polish
- [ ] Branded emails, SEO meta, error pages, favicon
- [ ] Responsive + performance pass

### Phase 6 — Testing and client review
- [ ] Feature tests green
- [ ] Scope audit (sections 4–6) + `docs/qa-checklist.md`
- [ ] Client review round done

> Milestone: final payment (20%) before handover.

### Phase 7 — Deployment and handover
- [ ] Live on client hosting, smoke test passed
- [ ] `docs/DEPLOYMENT.md` + `docs/admin-guide.md`
- [ ] Source + database handed over; warranty end date in the Log

### Change requests (outside the ₹27,000 scope — quote separately)
- None yet.

### Log
- 2026-11-02 — Database layer, frontend design stage, Filament panel, Players and Office Bearers admin done. Next: Phase 1A.
- 2026-11-02 — Phase 1A: State Associations admin (list/tabs/filters, form with logo + private documents, approve/reject + emails via shared traits, delete warning, approved-only association select for office bearers); DemoSeeder writes placeholder document PDFs. 70 tests green. Next: Phase 1B.
- 2026-11-02 — Phase 1B: Events (period badge + scope filters, featured/published toggles) with Results relation manager, News, Downloads, Banners (reorderable), Pages (edit only), Site Settings page; `DeletesStoredFiles` trait; DemoSeeder now creates real sample images/PDFs. 81 tests green. Not browser-checked (needs admin login). Next: Phase 1C.
- 2026-11-02 — Phase 1C: Galleries (+ batch photo upload, inline captions, reorder), Videos (YouTube/Vimeo/Facebook, `embed_url`, thumbnails), International Players (grouped by country), Community categories + posts (PDF), Contact Messages (read-only, unread badge), Admin Users + profile page, 5-stat dashboard with links, navigation groups. Phase 1 (admin panel) complete. 90 tests green. Not browser-checked (needs admin login). Next: Phase 2A.
- 2026-11-02 — Phase 2A: public pages on real data via Frontend controllers (published/approved only, eager loading, pagination, 404 for unpublished slugs); settings view composer for contact, social links, footer and default meta; preventLazyLoading on outside production; home slideshow fallback photos. All 32 content URLs return 200 with demo data and on an empty database. 95 tests green. Next: Phase 2B.
- 2026-11-03 — Phase 2A audit: OK (published/approved scopes, eager loading, pagination, 404s, SEO, view composer). Phase 2B: Contact, State Association and Player registration forms wired (FormRequests, honeypot, 5/min throttle, inline errors + old input, private uploads with generated names, transaction + file cleanup, `RegistrationReceived` mail with Player ID, success panels, no-association message); preview fallback removed from Player Registration. 106 tests green. Browser check not done (Chrome extension not connected); pages return 200. Next: client demo, then Phase 3.
- 2026-11-05 — Site work between phases: home hero shows banners whole beside the headline, accessible banner slider, 10xCart footer credit, versioned CSS/JS URLs, real contact details in settings, circulars added to Downloads (`DownloadSeeder`). Live server: `APP_URL` fixed to the https domain.
- 2026-11-05 — Phase 3: `barryvdh/laravel-dompdf` + `simplesoftwareio/simple-qrcode` installed; one A4 landscape template; `Certificate::generatePdf()` (private disk, regenerated when printed details change); admin Certificates resource + "Issue certificate" on approved players, Download / Regenerate one at a time, no bulk; public lookup (Player ID + DOB, approved only, generic not-found, 10/min) with 30-minute signed links; verify page (404 + "Not a valid certificate" for unknown codes, noindex); player deletion removes certificate PDFs; `_preview-data.php` deleted. Lookup, signed download, verify page and QR (decoded from the rendered PDF) checked in the browser on demo data; admin issue flow covered by tests only (not browser-checked). `migrate:fresh --seed` + DemoSeeder not run by Claude (blocked as destructive). 139 tests green. Next: Phase 4.
- 2026-11-05 — Phase 3 audit: all Phase 3 items verified (tests, browser, QR decoded from the PDF). Fixes: relative signed links (`signed:relative`), player name/ID corrections re-render their PDFs; new tests for honeypot, trimmed Player ID, missing-PDF rebuild, other host names, admin page loads and search by Player ID. 148 tests green. Next: Phase 4.
