# Testing Standards

This repository follows **Test-Driven Development (TDD)** as a core principle.

## Guidelines

### Test Coverage Target
- **80%+ Coverage**: All new features and bug fixes MUST include corresponding tests.
- High-risk business logic (Transactions, Scheduling, Auth) requires **100% path coverage**.

### Framework
- **PHPUnit 11+**: Standard for this project.
- Use `Tests\TestCase` as the base for all feature tests.
- Use `Tests\UnitTestCase` for isolated logic.

### Livewire Testing
- Every component must have a `Livewire::test()` assertion.
- Verify component rendering (`assertSee`), initial data, and event handling (`call`, `set`).

### Mocks and Fakes
- Mock **External APIs** and filesystem storage.
- Use Laravel's `Bus::fake()`, `Mail::fake()`, `Event::fake()` for side effects.
- Prefer **In-Memory SQLite** for rapid unit testing.

## Execution
- Run `php artisan test` before any PR.
- No `failing tests` are allowed in the main branches.
