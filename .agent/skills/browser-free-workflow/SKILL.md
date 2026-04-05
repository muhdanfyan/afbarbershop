# Browser-Free Verification Workflow

This skill defines the canonical process for verifying project changes WITHOUT using the interactive **Antigravity Browser Control** tool.

## Principles

1. **CLI First**: All verification of UI and backend logic uses terminal commands.
2. **Strict Opt-In**: The `Antigravity Browser Control` must ONLY be used if explicitly requested by the user for a specific visual task.
3. **Evidence-Based**: Verification and results must be derived from tool output (e.g. `curl`, `grep`, `artisan`).

## Workflow Steps

### 1. Verification of Content (Logic/Text)
- **Tool**: `curl -s http://localhost:8000/path`
- **Check**: Pipe output to `grep` or search for specific strings/tokens.
- **Example**: `curl -L http://localhost:8000/login | grep "Email Address"`

### 2. Verification of UI State (Conditional Logic)
- **Tool**: `php artisan tinker`
- **Check**: Manually invoke actions/queries to verify state in the database.
- **Example**: `App\Models\Booking::latest()->first()->status`

### 3. Verification of Assets (CSS/JS)
- **Tool**: `grep -r ".my-class" resources/css`
- **Check**: Verify if specific styles exist in the source code rather than visually.

### 4. Headless Testing
- **Tool**: `php artisan test --filter MyTest`
- **Check**: Use existing PHPUnit tests to verify behavior.

## Rules

- **No Visual Assumptions**: Do not guess how something "looks" unless you have verified it with one of the above methods.
- **Report Proof**: Always provide the CLI output as proof of verification.
