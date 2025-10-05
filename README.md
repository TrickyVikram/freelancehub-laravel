# FreelanceHub — Laravel + Blade
**Hacktoberfest 2025 friendly open-source project**

---

## Project Overview
**FreelanceHub** is an opinionated, starter open-source marketplace built with Laravel 11 and Blade that models the core features of platforms like Upwork:

- Users: Freelancer, Client, Company, Team, Admin
- Job listings & search
- Proposal submission & tracking
- Contracts & payments (placeholder)
- Messaging
- Profiles, ratings & reviews
- Admin panel for moderation

The purpose of this repo is to provide a Hacktoberfest-friendly playground for contributors to add features, fix issues, and learn Laravel + Blade marketplace development.

---

## Live Demo / Screenshots
*(Add demo link or screenshots here — placeholder images available in `/docs/screenshots/`)*

---

## Key Features
- **User Roles:** Freelancer, Client, Company, Team, Admin
- **Job CRUD & Searching:** Categories, skills, budgets, duration
- **Proposals:** Send proposals with cover letter, pricing, and files
- **Hiring Workflow:** Shortlist, hire, request interviews, accept proposals
- **Messaging:** Basic Blade + AJAX polling
- **Company & Team Pages:** Invite members, manage jobs
- **Profiles:** Portfolio, skills, hourly rate, work history, ratings
- **Notifications:** Database + optional mail placeholders
- **Admin Panel:** Moderate jobs, users, reports
- **API Endpoints:** For mobile/SPA integration (optional)

---

## Tech Stack
- PHP 8.3+ / Laravel 11
- Blade templates
- MySQL / MariaDB (SQLite optional)
- Composer for PHP dependencies
- npm / Vite for frontend assets
- Tailwind CSS (optional) / Bootstrap
- Laravel Breeze / Jetstream for authentication
- Docker + docker-compose (optional)

---

## Roadmap (Suggested)
**Core (MVP)**
- Authentication & roles
- Job CRUD & search/filter
- Proposal submission + tracking
- Basic messaging
- Profile & portfolio
- Admin moderation panel

**Nice-to-have**
- Escrow-like payment integration (Stripe placeholder)
- File upload & delivery system
- Real-time chat (Pusher / Websockets)
- Advanced search & recommendations
- Multi-language support

---

## Hacktoberfest 2025 — Good First Issues
Examples:
- Add skills seeder and factory for jobs and freelancers
- Create Blade partial for job card used in listing/search pages
- Improve validation messages for proposal form
- Add API endpoint to fetch jobs by skill
- Create unit tests for Job model scopes

**Labels for issues:** `good first issue`, `hacktoberfest-2025`, `help wanted`

---

## Repository Layout (Suggested)
