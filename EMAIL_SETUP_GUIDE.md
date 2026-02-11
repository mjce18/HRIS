# Email Configuration Guide for HRIS System

## Current Issue
When HR registers a new employee, the activation email is not being sent because email is not configured.

---

## 🚀 Quick Fix: Use Log Driver (For Testing Only)

The system is currently using `MAIL_MAILER=log` which means emails are saved to log files instead of being sent.

### View Emails in Log
1. Open: `storage/logs/laravel.log`
2. Search for the activation link
3. Copy the activation URL and paste it in browser

**This is already configured and working!** Check your log file to see the activation emails.

---

## 📧 Option 1: Mailtrap (Recommended for Testing)

Mailtrap is a fake SMTP server perfect for testing emails without sending real emails.

### Setup Steps:

1. **Create Free Account**
   - Go to: https://mailtrap.io
   - Sign up for free account
   - Verify your email

2. **Get SMTP Credentials**
   - Login to Mailtrap
   - Go to "Email Testing" → "Inboxes"
   - Click on your inbox
   - Go to "SMTP Settings"
   - Select "Laravel 9+"
   - Copy the credentials

3. **Update Your `.env` File**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mailtrap_username
   MAIL_PASSWORD=your_mailtrap_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="noreply@hris.com"
   MAIL_FROM_NAME="HRIS System"
   ```

4. **Clear Config Cache**
   ```bash
   php artisan config:clear
   ```

5. **Test It**
   - Register a new employee as HR
   - Check Mailtrap inbox
   - You'll see the activation email!

---

## 📧 Option 2: Gmail SMTP

Use your Gmail account to send real emails.

### Setup Steps:

1. **Enable 2-Step Verification**
   - Go to: https://myaccount.google.com/security
   - Enable "2-Step Verification"

2. **Create App Password**
   - Go to: https://myaccount.google.com/apppasswords
   - Select "Mail" and "Windows Computer"
   - Click "Generate"
   - Copy the 16-character password

3. **Update Your `.env` File**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-16-char-app-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="your-email@gmail.com"
   MAIL_FROM_NAME="HRIS System"
   ```

4. **Clear Config Cache**
   ```bash
   php artisan config:clear
   ```

5. **Test It**
   - Register a new employee
   - Check the employee's email inbox
   - They'll receive the activation email!

---

## 📧 Option 3: Keep Using Log (Simplest)

If you just want to test without setting up email:

### Current Configuration (Already Set)
```env
MAIL_MAILER=log
```

### How to Get Activation Links:

1. **After registering an employee**, open:
   ```
   storage/logs/laravel.log
   ```

2. **Search for** (Ctrl+F):
   ```
   Activation URL
   ```

3. **Copy the URL** that looks like:
   ```
   http://127.0.0.1:8000/activate/abc123def456...
   ```

4. **Paste it in browser** to activate the account

5. **Employee can now login** with the password they set

---

## 🔧 Step-by-Step: Update .env File

1. **Open your `.env` file** in the project root

2. **Find the MAIL section** (around line 40)

3. **Replace with one of the options above**

4. **Save the file**

5. **Clear config cache**:
   ```bash
   php artisan config:clear
   ```

6. **Restart the server** (if needed):
   ```bash
   # Stop: Ctrl+C
   # Start: php artisan serve
   ```

---

## 🧪 Testing Email Configuration

### Test Command (Optional)
Create a test route to send a test email:

1. Add to `routes/web.php`:
```php
Route::get('/test-email', function () {
    try {
        Mail::raw('Test email from HRIS System', function ($message) {
            $message->to('test@example.com')
                    ->subject('Test Email');
        });
        return 'Email sent! Check your inbox or Mailtrap.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
```

2. Visit: http://127.0.0.1:8000/test-email

---

## 📋 Complete .env Mail Configuration Examples

### For Mailtrap:
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=1a2b3c4d5e6f7g
MAIL_PASSWORD=1a2b3c4d5e6f7g
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@hris.com"
MAIL_FROM_NAME="HRIS System"
```

### For Gmail:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=youremail@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="youremail@gmail.com"
MAIL_FROM_NAME="HRIS System"
```

### For Log (Current):
```env
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@hris.com"
MAIL_FROM_NAME="HRIS System"
```

---

## 🎯 Recommended Approach for Testing

**Use Mailtrap** because:
- ✅ Free and easy to set up
- ✅ See emails in a nice interface
- ✅ No risk of sending emails to real people
- ✅ Can test with any email address
- ✅ Shows email HTML preview
- ✅ Can test spam score

---

## 🐛 Troubleshooting

### Error: "Connection refused"
- Check MAIL_HOST and MAIL_PORT
- Make sure you cleared config cache
- Restart the development server

### Error: "Authentication failed"
- Check MAIL_USERNAME and MAIL_PASSWORD
- For Gmail, make sure you're using App Password, not regular password
- Clear config cache

### Emails not appearing in Mailtrap
- Check you're using correct inbox credentials
- Verify MAIL_MAILER=smtp (not 'log')
- Clear config cache: `php artisan config:clear`

### Gmail "Less secure app access"
- Gmail no longer supports this
- You MUST use App Password (see Option 2 above)

---

## 📝 Current Workaround (No Email Setup Needed)

Since email is set to `log`, you can still test the activation system:

1. **HR registers employee**: `newemployee@example.com`

2. **Check log file**: `storage/logs/laravel.log`

3. **Find activation URL**:
   ```
   http://127.0.0.1:8000/activate/abc123...
   ```

4. **Copy and paste URL** in browser

5. **Employee sets password** and activates account

6. **Employee can login** at employee portal

---

## 🎉 Quick Start (Mailtrap - 5 Minutes)

1. Go to https://mailtrap.io and sign up
2. Get your SMTP credentials
3. Update `.env` with Mailtrap settings
4. Run: `php artisan config:clear`
5. Register a new employee
6. Check Mailtrap inbox - email is there!

---

## 💡 Pro Tip

For production, you should use:
- **SendGrid** (free tier: 100 emails/day)
- **Mailgun** (free tier: 5,000 emails/month)
- **Amazon SES** (very cheap)
- **Postmark** (reliable and fast)

But for testing, **Mailtrap** or **Log** driver is perfect!

---

**Need Help?** 
- Check `storage/logs/laravel.log` for email content
- Make sure to run `php artisan config:clear` after changing `.env`
- Restart the server if emails still don't work
