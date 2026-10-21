# Production domain

The canonical public address is `https://paliy.cz`. WordPress and Nuxt share
this origin. `www.paliy.cz` and the previous `vip-client.duckdns.org` address
redirect permanently to the canonical address, preserving the path and query.

## Server routing

- Nginx serves ports 80 and 443.
- `vip-client.service` runs Nuxt at `127.0.0.1:3001` from `/var/www/vip-client`.
- Nginx reaches WordPress in `paliy-wordpress-1` via `127.0.0.1:8080`.
- `/wp-admin/`, `/wp-login.php`, `/wp-includes/`, `/wp-content/`, `/wp-json/`,
  and requests with `rest_route` go to WordPress. Other paths go to Nuxt.
- The older `paliy-frontend-1` container on port 3000 is not the public Nuxt.

Nginx source configurations are in `deploy/nginx/`. On the server,
`paliy.cz.conf` is installed as `/etc/nginx/sites-available/paliy.cz`, and
`vip-client-redirect.conf` as `/etc/nginx/sites-available/vip-client`.
Validate with `nginx -t` before reloading Nginx.

## Domain settings

- Nuxt's `runtimeConfig.public.apiBase` defaults to `https://paliy.cz`.
- The `NUXT_PUBLIC_API_BASE` environment variable in `vip-client.service`
  must also be `https://paliy.cz`; it overrides the source default.
- WordPress `home` and `siteurl` are `https://paliy.cz`.
- Stored WordPress URLs were migrated with WP-CLI `search-replace`, preserving
  serialized data and excluding `guid` identifiers. Content IDs were retained.

## TLS and deployment

The `paliy.cz` Let's Encrypt certificate covers `paliy.cz` and `www.paliy.cz`.
Certbot uses the webroot `/var/www/letsencrypt`; Nginx must continue to serve
`/.well-known/acme-challenge/` over HTTP. The configured renewal deploy hook
reloads Nginx, and `certbot.timer` schedules renewal.

Rebuild Nuxt directly in `/var/www/vip-client`, replacing `.output`, then
restart `vip-client.service`. Do not create separate build directories or
retain old Nuxt builds. Follow `AGENTS.md` for deployment constraints.
