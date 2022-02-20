# Laravel Template

## Initial setup

### Deploy to shared hosting checklist

This steps must be followed inside server BEFORE first deploy:

- [ ] deploy keys generated and uploaded
- [ ] DB created
- [ ] `.env` created
- [ ] migrations ran
- [ ] `public/.htaccess` created

### Github Secrets

Set this secrets before running workflows:

- `SSH_HOST`
- `SSH_PORT`
- `SSH_USER`
- `SSH_KEY`
- `REMOTE_PATH_MAIN`
- `REMOTE_PATH_PROD`
- `REMOTE_URL_MAIN`
- `REMOTE_URL_PROD`
- `SENTRY_PROJECT` (not used)
- `SENTRY_ORG` (not used)
- `SENTRY_TOKEN` (not used)

### First Deploy

You MUST manually run "Deploy first time" Github Workflow.

## Actions

- Deploy main (to staging)
- Deploy prod (to production)

### .rsyncigore

All inside this file will be ignored when deploying.

Notes:

- All items inside `storage/app` are ignored. If a new filesystem inside there is defined, you must create the forlder first.

## Conventions

- [Good practices](https://github.com/alexeymezenin/laravel-best-practices)

## Tools

- Laravel Dusk
- Laravel Telescope
- Sentry
- Laravel Ide Helper
- Laravel Tlint
