# WhatsApp Automation System Skill

This skill documents the implementation and verification for the automated WhatsApp messaging ecosystem at AF Barbershop.

## Gateway Setup (Crucial)
The system relies on a Node.js gateway located in the `wagateway/` directory.

- **Start Command**: `cd wagateway && npm run dev`
- **Port**: 3001
- **Status Check**: Admin Dashboard -> Settings -> WhatsApp Gateway card.
- **Troubleshooting**: If "Gateway Offline" appears in the UI, check the terminal where the Node process is running.

## Messaging Architecture
- **Centralized Service**: `app/Services/WAService.php`
- **Dynamic Templates**: Managed via Admin Dashboard -> Settings -> Master WhatsApp Template.
- **Placeholder Engine**: Uses `parseTemplate()` to replace tags like `{{NAMA}}`, `{{JAM}}`, etc.

## Verification & Testing Standards

### 1. Booking Confirmation (Instant)
- **Trigger**: Go to the frontend booking page and complete a booking.
- **Expectation**: `WAService->sendBookingConfirmation()` is called. 
- **Verify**: Check Gateway console for `/api/send-message` POST request with registration details.

### 2. Member Welcome Message (Instant)
- **Trigger**: Admin Dashboard -> Member -> Tambah Member.
- **Expectation**: `WAService->sendWelcomeMember()` is called immediately.
- **Verify**: Check for a greeting message containing the member's current points.

### 3. Automated Reminders (Scheduled)
- **Trigger**: `php artisan app:send-reminders`
- **Verification**:
    - Output: "Reminder sent to [Customer Name]"
    - DB: `reminded_at`, `reminded_at_10`, or `reminded_at_5` should be populated.

### 4. Post-Service Rating Request (Scheduled)
- **Trigger**: `php artisan app:send-review-requests`
- **Logic**: Targets transactions with status `selesai` that were updated > 30 mins ago.
- **Verification**:
    - Output: "Sending review request to [Customer Name]"
    - DB: `review_requested_at` should be populated.

### 5. Customer Re-activation (Scheduled)
- **Trigger**: `php artisan app:send-review-requests` (Note: Ensure daily scheduling)
- **Logic**: Targets members who haven't visited in 30+ days.
- **Verification**:
    - Output: "Sending re-activation message to [Member Name]"
    - DB: `reactivation_sent_at` should be populated.

## Debugging Checklist
1. **Laravel Logs**: Check `storage/logs/laravel.log` for `WAService Error`.
2. **Gateway Logs**: Look for `Connection closed` or `401 Unauthorized` in the Node.js console.
3. **Database State**: Use `php artisan tinker` to verify if tracking timestamps are null (not sent) or populated (sent).
4. **Phone Formatting**: Ensure numbers start with `08` or `628`. The system automatically converts `08` to `628`.
