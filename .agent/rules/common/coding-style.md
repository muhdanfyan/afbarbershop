# Coding Style Guidelines

Universal principles for this repository, ensuring consistency, maintainability, and clarity.

## Principles

- **Immutability First**: Prefer `readonly` properties and immutable data structures where possible.
- **Explicit over Implicit**: Avoid magic methods if a typed alternative exists.
- **Single Responsibility**: Each class/function should do one thing well.
- **Fail Fast**: Validate inputs early and throw clear exceptions.

## File Organization

- Group related functionality by domain, not just technical layer.
- Keep files focused; if a file exceeds 400 lines, consider refactoring/decomposition.

## Naming Conventions

- Use descriptive, intention-revealing names.
- Avoid abbreviations unless they are industry standard (e.g., `id`, `url`).
- Follow PSR-12 for PHP formatting.
