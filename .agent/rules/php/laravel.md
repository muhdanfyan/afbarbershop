# Laravel Development Standards

This repository follows standard Laravel practices, with an emphasis on the "Lean Controller, Fat Model/Action" pattern.

## Guidelines

### Controllers
- Keep controllers lean.
- Use **Actions** or **Services** for complex business logic.
- Avoid multi-stage queries in controllers.

### Models & Eloquent
- Use **Strong Typing** with `AsArrayObject` or collections for JSON/Attribute storage.
- Prefer `Strict` mode in development.
- Always use `$guarded = []` or `$fillable` correctly.
- Implement **Global Scopes** only when absolutely necessary for multi-tenancy.

### Livewire
- Since this project uses Livewire v4:
- Prefer **Functional Components** for small UI elements.
- Ensure all Livewire actions are idempotent.
- Minimize data passed between server and client; use `wire:model.live` only when necessary.

### Database
- Use **Foreign Key Constraints** for data integrity.
- Index all columns used in filtering/sorting.
- Use Laravel's `Schema` builder for all migrations.

## Quality Gates
- No `env()` outside of config files.
- No `dd()` or `dump()` in production-ready PRs.
- No `SELECT *` in complex queries.
