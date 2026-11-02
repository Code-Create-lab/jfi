# PHASES.md — JFI website build plan

Phase-by-phase prompts for Claude Code. Progress is tracked in CLAUDE.md §15.
Run one phase per session: type `/clear`, then one of these:

| Goal | Type in Claude Code |
|---|---|
| Run a phase | `Read docs/PHASES.md and do Phase 1A.` |
| Resume a phase that stopped midway | `Continue Phase 1A from docs/PHASES.md. Check the code and the §15 Log for what's already done first.` |
| Check progress | `Read docs/PHASES.md and run the Progress check.` |
| Triage a client request | `Read docs/PHASES.md and run the Change request check for: <client's request>` |

Order: 1A → 1B → 1C → 2A → 2B → client demo (40% milestone) → 3 → 4 → 5 → 6 → final payment (20%) → 7

---

## Rules for every phase

1. CLAUDE.md is the source of truth: follow §9 (out of scope), §12 (conventions) and §14 (database).
2. Do only the phase asked. Don't start the next one.
3. Copy existing patterns: the Players resource (`app/Filament/Resources/Players`) for admin work, the existing Blade views and components for frontend work. Where a design-stage view already exists for a page (registration forms, Player Login, Digital Certificates, Contact), wire that view and keep its URL.
4. No new packages unless the phase names them. No services, repositories or DTOs.
5. Need a schema change? Explain why first. Before go-live, edit the migration and run `migrate:fresh`; after go-live, add a new migration.
6. Replacing or deleting an uploaded file also deletes the old file from storage.
7. Anything not in CLAUDE.md §4–6 is not built — add it to §15 "Change requests" instead.
8. Finish every phase by:
   - running `php artisan test` and `vendor/bin/pint --dirty`; if migrations, models or seeders changed, also running `php artisan migrate:fresh --seed` and `php artisan db:seed --class=DemoSeeder` (this wipes the local database);
   - checking the changed pages in a browser if you can, otherwise listing the URLs for me to check;
   - updating CLAUDE.md §15 (tick only what works, set "Current phase", add one Log line) and any CLAUDE.md text this phase made outdated;
   - replying with what's done, how I test it, what I need to do (client input, `.env`), and a suggested commit message. Don't commit.

---

## Phase 1A — Admin: State Associations

Build the State Associations Filament resource by mirroring the Players resource.

- Table: logo, name, state, president, secretary, status badge, submitted date. Filters: status, state. Search: name, email, phone. Newest first. Navigation badge with the pending count.
- Form: all `state_associations` fields; state from `config('jumpball.states')`; logo on the public disk; documents on the private disk with the same upload/download pattern as Players (`RegistrationDocumentController`), types from `config('jumpball.association_document_types')`.
- Approve / Reject exactly like Players: add `StateAssociation::approve()` / `reject($remarks)` (status, `reviewed_at`, `admin_remarks`), then send `RegistrationApproved` / `RegistrationRejected` synchronously; a mail failure shows a warning and keeps the status. If the mailables are player-only, make them work for both with the least code.
- The admin can add an already-recognized association: it saves as pending and is approved with the action.
- The delete confirmation says its players lose the link and its state office bearers are deleted (FK rules in §14).
- Check that the Office Bearers resource offers approved associations only.
- Tests: approve and reject change status and `reviewed_at` and send the right mail (`Mail::fake()`).

Done when: a demo association can be approved and rejected, its documents download in `/admin`, and the emails appear in the mail log.

---

## Phase 1B — Admin: Events, Results, News, Downloads, Banners, Pages, Settings

- Events: fields per §14; state from config; `end_date` on or after `start_date`; cover image on the public disk. The table shows an Upcoming / Current / Previous badge worked out from the dates (no column), filters that use the Event scopes, and toggle columns for featured and published.
- Results: relation manager on Event. Position: 1 Winner, 2 Runner-up, 3 Third place, or a number for standings. The state association select lists approved associations only. Sorted by category, then position.
- News: type select (NewsType), `published_on` defaults to today, filter by type.
- Downloads: category select (DownloadCategory); file on the public disk; pdf, doc, docx, xls, xlsx, jpg, png; max 10 MB, shown as helper text.
- Banners: image required; reorderable by `sort_order`.
- Pages: edit only, no create or delete (routes use the 5 seeded slugs); slug read-only.
- Site Settings: one custom Filament page with a form for the seeded keys (sections: Contact, Social links, Footer & SEO), saved through the Setting model so the cache clears. No adding or removing keys from the UI.

Done when: each module above can create, edit and delete with DemoSeeder data, and uploaded images show in the tables.

---

## Phase 1C — Admin: Media, Community, Messages, Users, Dashboard

- Galleries: optional event, cover image. Photos through a relation manager with an "Upload photos" header action (multiple images, up to 20 per batch) that creates one GalleryImage per file; captions editable; reorderable. Use FileUpload's built-in client-side resize (about 1600 px wide) so phone photos upload fast — no server-side image package.
- Videos: URL must be YouTube, Vimeo or Facebook; add an `embed_url` accessor on Video; YouTube thumbnail in the table.
- International Players: filter and group by country.
- Community: Categories resource with a Posts relation manager; publish/unpublish toggles on both; post document (PDF) on the public disk.
- Contact Messages: list and view only; viewing sets `read_at`; unread count as navigation badge; delete allowed.
- Admin users: enable Filament's profile page (own name, email, password) and a simple Users resource (name, email, password). An admin can't delete their own account.
- Dashboard: a stats widget (pending players, approved players, pending associations, upcoming events, unread messages) and two small tables (latest 5 players, latest 5 association applications) linking to the records. No polling.
- Navigation groups for all resources: Registrations, Federation, Events & Media, Content, Settings.

Done when: everything in CLAUDE.md §5–6 can be managed from `/admin`.

---

## Phase 2A — Frontend: public pages on real data

Replace the `Route::view()` calls for content pages with controllers in `app/Http/Controllers/Frontend`. Keep every URL and `frontend.*` route name. (Forms, certificates and player login are wired in 2B, 3 and 4.)

- Pass the variable names the views already use (see `_preview-data.php`). Every public query uses `published()`; eager-load relations; paginate long lists (news, events, gallery albums, player list).
- Detail pages by slug (news, events, gallery albums, community categories/posts); unpublished → 404. Use the existing detail views; if one is missing, build it from the template's existing components.
- Home: published banners, latest announcements (news type `announcement`), featured events (current and upcoming first), latest news, latest gallery photos, quick links.
- Static pages from `pages` by slug: about-federation, about-jumpball, president-message, privacy-policy, terms-and-conditions.
- Office bearers: national via `OfficeBearer::nationalForDisplay()`; state grouped by approved association.
- State associations: approved only, grouped by state.
- Events: `current()`, `upcoming()`, `previous()`; the event detail shows its results, gallery and videos.
- Results: championship results grouped by event → category → position; the Winner / Runner-up / Third place pages filter position 1 / 2 / 3.
- Downloads with a category filter; the Rule Book page shows the `rule_book` category.
- Gallery albums and album page; videos through `embed_url` with lazy-loaded iframes.
- International players grouped by country. Community index and category page (published posts + support contact).
- Player Database: approved players only — name, Player ID, state association. Search by name or Player ID, filter by association. Never DOB, phone, email, address or photo.
- Contact details, social links and footer text from settings through a view composer.
- SEO: title and meta description on every page (pages: their meta fields; news/events: title + excerpt/summary; default from settings).
- Every list has a friendly empty state — production starts empty.
- Turn on `Model::preventLazyLoading()` outside production and fix anything it flags (admin included).
- Remove the preview-data fallback lines from every page you wire. Pages wired later keep theirs; `_preview-data.php` is deleted once no view uses it (Phase 4 at the latest). Update CLAUDE.md §13.

Done when: every `frontend.*` route returns 200 on an empty database and with DemoSeeder data, nothing triggers lazy loading, and a pending player never appears publicly.

---

## Phase 2B — Frontend: contact and registration forms

FormRequests in `app/Http/Requests/Frontend`; old input and inline errors in the template's form style; a success message after submit.

- Every public form: CSRF, a honeypot field, throttle 5 per minute per IP, max upload size shown as helper text.
- Contact: save a ContactMessage (admins read it in `/admin`).
- State Association Registration: fields per §14; state from config; optional logo (public disk); documents from `config('jumpball.association_document_types')` on the private disk (pdf, jpg, png; max 2 MB each); terms checkbox → `terms_accepted_at`. Save in a DB transaction; status stays pending; send `RegistrationReceived` to the association email (sync; a mail failure is logged and never breaks the submission).
- Player Registration: name, father/guardian name, date of birth (past date), gender, email (unique), 10-digit Indian mobile, password + confirmation (min 8), address, city, state, 6-digit pincode, state association (approved only), photo (stored the same way as in the Players admin resource), documents from `config('jumpball.player_document_types')` on the private disk, terms checkbox. Transaction → Player ID generated → `RegistrationReceived` with the Player ID → success page shows the Player ID and says approval is pending.
- If no approved state association exists yet, show a short message instead of the player form.
- Uploaded files get generated names; `original_name` is kept only for display.
- Create `RegistrationReceived` if it doesn't exist yet.
- Tests: both registrations save as pending with files on the private disk and send the mail; a filled honeypot is rejected.

Done when: both registrations show up as pending in `/admin` with downloadable documents, the files are in `storage/app/private`, and the confirmation emails appear in the mail log.

> Milestone: demo core pages + backend to the client (2nd payment, 40%).

---

## Phase 3 — Certificates (PDF + QR)

- Install `barryvdh/laravel-dompdf` and `simplesoftwareio/simple-qrcode` (CLAUDE.md §2). If the QR package conflicts with what's installed (for example a `bacon/bacon-qr-code` version Filament already needs), use `bacon/bacon-qr-code` directly with SVG output and update §2. If dompdf won't install, stop and tell me.
- One template, `resources/views/certificates/certificate.blade.php`: A4 landscape, inline CSS only (dompdf has no flexbox or grid — use tables or absolute positioning), DejaVu Sans or one embedded font. It shows the JFI logo, title, player name, Player ID, achievement, the event and its date (if any), issue date, certificate no., signature/seal placeholders, and the QR code as an SVG data URI (no Imagick needed) linking to `/certificates/verify/{verification_code}`. Until the client's design arrives, use JFI colours and keep "Approved certificate design" unticked in §11.
- `Certificate::generatePdf()`: render → save on the private disk as `certificates/{certificate_no}.pdf` → set `pdf_path`. Runs after create and on Regenerate.
- Admin: a Certificates resource (Registrations group) and an "Issue certificate" action on the player page. Approved players only; title defaults to "Certificate of Participation"; event optional; `issued_on` defaults to today. Actions: Download and Regenerate — one at a time, no bulk actions.
- Public lookup on the existing Digital Certificates page: Player ID + date of birth → that approved player's certificates with 30-minute signed download links. Throttle 10 per minute per IP. Any wrong combination gets one generic "not found" message.
- Verify page `/certificates/verify/{verification_code}`: "Valid" with name, Player ID, title, achievement, event, issue date and certificate no.; an unknown code shows "Not valid". Nothing else.
- PDFs are only served by a controller: admin, a valid signed link, or (Phase 4) the owning player.
- Tests: generation creates the file; verify valid/invalid; lookup needs the right DOB; an unsigned or expired link is rejected.

Done when: the admin issues a certificate for a demo player, the PDF opens correctly, and the QR's URL opens the verify page.

---

## Phase 4 — Player login and player area

- `config/auth.php`: `player` guard (session), `players` provider, `players` password broker (`password_reset_tokens` table).
- Wire the existing Player Login page (keep its URL). Player-only pages go under `/player` with names `player.*`: dashboard, certificate download, logout, forgot and reset password.
- Login with email OR Player ID + password, "remember me", `throttle:login` (define the limiter if missing: 5 per minute per identifier + IP), session regenerated. Guests on player pages go to the player login; `/admin` keeps Filament's own login.
- Pending and rejected players can log in: the dashboard shows the status, plus the admin remarks when rejected. Certificate downloads are for approved players only (`EnsurePlayerApproved`, create it if missing).
- Dashboard (read-only): Player ID, status, photo, personal and contact details, state association, own certificates, and a note: "Contact the federation to change your details."
- Password reset: Laravel's broker; `Player::sendPasswordResetNotification()` points to the player reset route; mail via SMTP.
- The header shows "Player Login" or "My Account / Logout" based on `auth('player')`.
- Always load the player from `auth('player')->user()`; certificate downloads check ownership.
- Delete `_preview-data.php` and any remaining fallback lines; update CLAUDE.md §13.
- Tests: login by email, login by Player ID, throttling, a pending player sees the status, a player can't download another player's certificate.

Done when: a demo player can log in both ways, reset the password through the link in the mail log, and download only their own certificates.

---

## Phase 5 — Polish

- Emails: one branded layout (JFI logo and colours, federation contact in the footer), clear subjects, sender from `MAIL_FROM_*`. Render each mail once to check it.
- SEO: a unique title and meta description on every page, basic Open Graph tags (title, description, image), canonical URL, and a `robots.txt` that disallows `/admin` and `/player`.
- Error pages (404, 419, 500, 503) in the template style; favicon from the JFI logo.
- Responsive pass on all public pages at 375, 768 and 1280 px: no sideways scrolling, wide tables scroll inside a wrapper, the menu works.
- Images: lazy loading, fallback covers when nothing is uploaded, alt text from titles. Labels on every form field.
- Performance: pagination everywhere; `php artisan optimize` runs clean and the site still works afterwards (no `env()` outside config files).
- List every page that still uses template placeholder photos (needs client photos, §11).

Done when: everything above passes and anything blocked by missing client content is listed.

---

## Phase 6 — Testing, scope audit, client review

- Feature tests for the important flows only: player registration (pending, Player ID format, private files, mail), association registration, approve/reject (status, `reviewed_at`, mail), Event scopes, the public player list hides pending players and private fields, registration documents can't be reached by URL, certificate generate/verify/lookup/signed download, player login (email and Player ID) and ownership checks.
- Run the full suite and fix failures.
- Scope audit: go through CLAUDE.md §4 (all 29 pages), §5 and §6 and report each as ✅ done / ⚠️ partial / ❌ missing, with its route or file. Fix small gaps; list the rest.
- Write `docs/qa-checklist.md`: a short manual checklist (every page on phone and desktop, each form, each admin module, each email) to tick with the client.
- After the client review: sort each feedback item into bug, minor correction (in scope) or change request (log it in §15, don't build it).

Done when: tests are green, the audit has no ❌, and the QA checklist is ready.

> Milestone: final payment (20%) before handover.

---

## Phase 7 — Deployment and handover

- Production config: `.env.example` complete (APP_*, DB_*, MAIL_*, ADMIN_EMAIL / ADMIN_PASSWORD, `QUEUE_CONNECTION=sync` unless the host runs cron). Production uses `APP_ENV=production`, `APP_DEBUG=false` and an https `APP_URL`.
- Write `docs/DEPLOYMENT.md` for shared/cPanel hosting:
  - requirements: PHP 8.3+ with the extensions Laravel, dompdf and the QR package need; `upload_max_filesize` / `post_max_size` above the form limits; enough `memory_limit` for dompdf
  - build locally if the host has no SSH or Composer: `composer install --no-dev --optimize-autoloader` and `php artisan filament:assets`, then upload (no `.env`, no `node_modules`)
  - document root → `public/` (or the `public_html` + `index.php` path change when the host can't)
  - writable `storage/` and `bootstrap/cache`
  - `php artisan migrate --force` and `php artisan db:seed --force` — never DemoSeeder on production
  - `php artisan storage:link`, and the fallback when symlinks are blocked
  - `php artisan optimize` (and `optimize:clear` after every update)
  - a cron line only if the scheduler or a queue is used
  - backups: hosting backups plus a regular database export
- Live smoke-test list: every page, both registrations, emails through the client's SMTP, admin login, certificate PDF and QR with the live domain, private documents unreachable by URL.
- Write `docs/admin-guide.md`: a short how-to per admin module for the client walkthrough, including changing the admin password.
- Handover checklist: source zip (without `vendor`, `node_modules`, `.env`), database export, and the credentials the client must keep safe. Log the handover date and the 30-day warranty end date in §15.

Done when: both docs are written and the live smoke test passes.

---

## Utility — Progress check

Don't write feature code.

1. Compare CLAUDE.md §15 with the actual code: `php artisan route:list --except-vendor`, Filament resources, controllers, views, and `php artisan test`.
2. For every §15 item, report ✅ done / ⚠️ partial / ❌ missing with one line of evidence (route or file). Don't trust existing ticks.
3. Correct the ticks in §15, set "Current phase", and add a Log line.
4. Reply with: rough % done, what's left in the current phase, blockers (unticked client inputs in §11), and the next 3 steps.

## Utility — Change request check

Don't write code.

1. Compare the request with CLAUDE.md §4–6 (in scope) and §9 (out of scope).
2. Answer: in scope (and which phase covers it) or change request (and why), with a rough size: small, medium or large.
3. If it's a change request, add one line to §15 "Change requests".