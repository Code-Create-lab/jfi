# QA checklist — Jumpball Federation of India website

Tick each line with the client during the review round. Check every page on a
phone (about 375 px wide) and on a desktop browser. Note anything that fails in
the "Notes" column of the review sheet and sort it into: bug, minor correction
(in scope) or change request (log it in CLAUDE.md §15, do not build it).

## 1. Public pages (phone and desktop)

For every page: it loads, the menu works, nothing scrolls sideways, images
show, the page title in the browser tab is correct.

- [ ] Home: banner shown whole beside the headline, notices strip, founder, office bearers, quick links, events, news, footer contact details
- [ ] About the Federation (client text in place)
- [ ] About Jumpball (client text in place)
- [ ] President's Message (client text in place)
- [ ] National Office Bearers
- [ ] State Office Bearers
- [ ] State Associations (only approved associations listed)
- [ ] State Association Registration
- [ ] Player Registration
- [ ] Player Database: search by name or Player ID, filter by association; no date of birth, phone, email or address shown
- [ ] International Players
- [ ] Rule Book
- [ ] Current / Upcoming / Previous Events (events move between them by date)
- [ ] Event detail page: results, gallery, videos
- [ ] Championship Results, Winners, Runners-up, Third Place
- [ ] Certificates & Verification
- [ ] Certificate verification page (scan a real certificate's QR code with a phone)
- [ ] News & Press Releases, and a news article
- [ ] Photo Gallery and an album
- [ ] Video Gallery (videos play)
- [ ] Downloads & Official Notices: category tabs, View and Download buttons
- [ ] Awareness (Community) categories and posts
- [ ] Contact Us: details and map
- [ ] Privacy Policy and Terms & Conditions (client text in place)
- [ ] Player Login, Forgotten Password
- [ ] A missing page shows the styled "Page Not Found" page

## 2. Forms

- [ ] Contact form: sends, shows the thank-you message, appears in Admin → Contact Messages
- [ ] Contact form: empty submit shows errors next to the fields and keeps what was typed
- [ ] State Association Registration with documents: saved as pending, confirmation email received
- [ ] Player Registration with photo and documents: Player ID shown on screen, confirmation email received
- [ ] Certificate lookup: right Player ID + date of birth lists certificates; wrong date of birth shows the "could not find" message
- [ ] Certificate lookup: Download PDF opens the certificate; Verify opens the verification page
- [ ] Player login with email, and with Player ID
- [ ] Forgotten password: email arrives, link sets a new password, old password no longer works
- [ ] Too many wrong logins in a minute shows the "Too Many Attempts" page

## 3. Player area

- [ ] Pending player: dashboard shows "Registration pending", no certificates
- [ ] Rejected player: dashboard shows the reason entered by the admin
- [ ] Approved player: details, photo and own certificates; Download PDF and Verify work
- [ ] Header shows "My Account" and "Log out" after signing in; Log out works

## 4. Admin panel (/admin)

- [ ] Sign in, dashboard counts and latest registrations
- [ ] Players: search, filters, view documents, approve (email sent), reject with reason (email sent), CSV export
- [ ] State Associations: approve and reject (emails sent), documents download
- [ ] Office Bearers (national and state), International Players
- [ ] Events with results (1st, 2nd, 3rd and standings); featured and published toggles
- [ ] Galleries with photo upload, Videos
- [ ] News & Notices (announcements appear on the home page notices strip)
- [ ] Downloads & Rule Book
- [ ] Home Banners: upload, reorder, show/hide
- [ ] Pages (edit the five content pages), Site Settings (contact details, social links)
- [ ] Community categories and posts: publish and unpublish
- [ ] Contact Messages
- [ ] Certificates: issue from a player's page, download, regenerate; correcting a player's name updates the PDF
- [ ] Admin Users and own profile (change password)

## 5. Emails (sent through the client's SMTP)

- [ ] Registration received (player, with Player ID)
- [ ] Registration received (state association)
- [ ] Registration approved
- [ ] Registration rejected (with the reason)
- [ ] Player password reset
- [ ] Every email shows the JFI logo, comes from "Jumpball Federation of India" (not "Laravel") and has the federation's contact details in the footer

## 6. Security spot checks

- [ ] A registration document URL cannot be opened without signing in to /admin
- [ ] A certificate download link stops working after 30 minutes
- [ ] A player cannot open another player's certificate
- [ ] /admin and /player are listed as disallowed in /robots.txt
