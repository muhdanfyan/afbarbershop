# WhatsApp Automation Testing Skill

This skill defines the process for verifying the automated WhatsApp reminder features without a browser.

## Workflow

### 1. Triggering Reminders
Use the custom artisan command to scan for upcoming bookings and trigger reminders.

**Command**:
```bash
php artisan app:send-reminders
```

**Verification Steps**:
- Verify the number of bookings checked in the output.
- Check for "Reminder sent" messages in the console output.
- Check `storage/logs/laravel.log` for any "WA API Error" logs.

### 2. Monitoring the Gateway (wagateway/)
The Node.js gateway must be running for reminders to reach their destination.

**Command**:
```bash
pm2 status wagateway || tail -n 20 wagateway/logs.txt
```

**Verification Steps**:
- Confirm the gateway is online.
- Check the gateway logs for successful `/api/send-message` POST requests.

### 3. Database State Verification (Tinker)
Verify that the `reminded_at` timestamps are updated correctly.

**Script**:
```php
$booking = App\Models\Transaksi::where('status', 'menunggu')->latest()->first();
// Check if reminded_at is set after running the command
$booking->reminded_at !== null;
```

## Rules
- **Mocking for Local Testing**: If the gateway is not active, look for "Http::withHeaders()" failure logs to confirm the system *tried* to send the message.
- **Timestamp Precision**: Verify `reminded_at_10` and `reminded_at_5` for multi-stage reminders.
