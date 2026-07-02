# LogTrack Insight — Backup Plan (MVP documentation)

Government property records require regular backups even if automation is deferred post-MVP.

## Recommended approach

1. **Daily logical backup** — `mysqldump` (MySQL) or file copy (SQLite dev):
   ```bash
   # MySQL production example
   mysqldump -u logtrack_app -p logtrack_insight > backups/logtrack-$(date +%F).sql

   # SQLite local dev
   cp database/database.sqlite backups/database-$(date +%F).sqlite
   ```

2. **Document storage** — Copy `storage/app/documents/` alongside DB dumps (generated PDFs are not in the DB).

3. **Retention** — Keep 30 daily + 12 monthly snapshots minimum for COA audit readiness.

4. **Restore test** — Quarterly restore drill to a staging environment.

5. **Post-MVP** — Schedule via Windows Task Scheduler or cron on the app server; store off-site (encrypted).
