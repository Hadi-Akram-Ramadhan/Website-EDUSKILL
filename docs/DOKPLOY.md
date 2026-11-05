# EduSkill web: Dokploy preparation

Status: repository packaging only. No production deployment or production DB changes performed.

## Application

- Dokploy service: Application (Dockerfile), not the local `docker-compose.yml`.
- Repository: `Hadi-Akram-Ramadhan/Website-EDUSKILL`; build context: `/`; Dockerfile: `Dockerfile`; source branch: the reviewed commit on `main` after Hadi explicitly approves commit/push. No branch was pushed by this preparation.
- Container HTTP port: `80`; HTTP health path: `GET /up` (Laravel's built-in health route). Domain HTTPS: set in Dokploy for the actual hostname.
- One replica initially. Apache `mod_php` hosts Blade web and `/api/v1` for Android on the same origin. Static Vite assets build during image construction.
- PostgreSQL: connect app to the existing Dokploy PostgreSQL service over a private shared network. Do not create a second database or expose its port publicly. Verify the actual database name/user/password/network and backup schedule in Dokploy. No existing database was inspected or modified.
- No Redis/worker needed for currently inspected app paths. Database-backed sessions/cache; `QUEUE_CONNECTION=sync` until a real async job requires a worker. No automatic migration, seeding, or key generation in the image/startup.

## Runtime environment in Dokploy (values are placeholders)

```dotenv
APP_NAME=EduSkill
APP_ENV=production
APP_DEBUG=false
APP_URL=https://YOUR_WEB_DOMAIN
APP_KEY=base64:GENERATE_ONCE_AND_STORE_AS_SECRET
DB_CONNECTION=pgsql
DB_HOST=YOUR_PRIVATE_POSTGRES_HOST
DB_PORT=5432
DB_DATABASE=YOUR_EXISTING_DB_NAME
DB_USERNAME=YOUR_EXISTING_DB_USER
DB_PASSWORD=YOUR_EXISTING_DB_PASSWORD
DB_SSLMODE=prefer
SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
CACHE_STORE=database
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr
LOG_LEVEL=warning
MAIL_MAILER=log
```

Generate a new key locally with `php artisan key:generate --show`; put only the resulting value into Dokploy secrets. Preserve that key across all redeploys. Use the existing key instead for an existing EduSkill installation; changing it invalidates encrypted cookies/sessions. `DB_SSLMODE` must match the real PostgreSQL connection policy (e.g. `require` when TLS is mandatory). Never paste values into Git or a Docker build arg. `APP_URL` must match the public HTTPS domain. No `localhost` DB host in the container. Set Dokploy build-time variables only if future client Vite code consumes them; current Vite assets have none.

## Safe initial rollout

1. Review DB backup/restore and migration files against the live schema. In particular `2026_09_30_000005_make_nis_nim_unique_in_users_table.php` nulls duplicate `nis_nim` and suppresses unique-index errors; inspect duplicates and approve the data consequence before migration. Do not run `migrate:fresh`, `db:seed`, `composer run setup`, or README's legacy reset commands on an existing database. The seeder creates demo accounts with published password `password`.
2. Apply the reviewed migrations once via a separately gated Dokploy one-off shell command: `php artisan migrate --force`. Use the same runtime secrets and DB network; complete successfully before routing traffic to a new version. If DB is empty, create the real initial admin by a separately approved secure procedure; never seed the demo accounts in production.
3. Deploy the application. Check `GET https://YOUR_WEB_DOMAIN/up` returns HTTP 200; check `/` and `/login` render; `/login` must not show demo accounts; `GET /auth/quick-login/1` must return 403. Exercise web login, Android API login, and a read-only authenticated route using authorized test accounts. Verify HTTPS redirect, session persistence, logs, and a browser request for `/build/assets/...`.
4. Record the exact deployed commit and retain its prior image for rollback. Do not roll back the database blindly. If a new migration changes data, assess forward-fix/compatibility before switching application images. Monitor errors and DB connection health after release.

## Known verification gaps

- Local tests use SQLite `:memory:` only; PostgreSQL migrations and real DB networking have not been exercised against an isolated PG instance. Production DB must remain untouched until separately approved.
- Image/runtime health requires a successful local Docker build and smoke test; see final preparation report for actual result.
- CI Pint baseline formatting was fixed locally; CI on the pushed revision is still unverified until Hadi authorizes commit/push.
- `db_eduskill` and `ngrok.exe` are tracked in the Git repository; excluded from the Docker context, but remain repository hygiene/security review items. Verify whether `db_eduskill` contains sensitive records before sharing the repo.
