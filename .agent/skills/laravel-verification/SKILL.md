# Laravel Verification Loops

Canonical workflow for automated project-level verification in Laravel.

## Workflow

1. **Static Analysis**: Run `php artisan lint` or `php artisan insights` (if installed).
2. **Database Integrity**: Check migrations and relationship counts.
3. **API Contracts**: Verify API responses (status code, JSON structure) via `curl`.
4. **Behavioral Testing**: Run `php artisan test` (Pest/PHPUnit).

## Automation

- Use `php artisan test --parallel` for faster feedback cycles.
- Run `php artisan tinker` for rapid database state inspection.

## Rules

- No `dd()` or `dump()` in production-ready branches.
- No `env()` outside of config files.
- Always check the `Log` for error exceptions.
