# Employee Account Activation System

## Overview
The HRIS system now uses an email-based account activation flow. When HR registers a new employee, the employee receives an activation email to set their password.

## How It Works

### For HR/Admin:

1. **Register New Employee**
   - Navigate to Employees → Add Employee
   - Fill in employee details:
     - First Name & Last Name
     - Email (activation link will be sent here)
     - Employee ID (unique identifier)
     - Department & Position
     - Hire Date, Employment Type, Salary
   - Click "Create Employee"

2. **After Registration**
   - Employee account is created with status "Pending Activation"
   - Activation email is automatically sent to the employee's email
   - Activation link expires in 48 hours

3. **Resend Activation Email**
   - If employee didn't receive the email, HR can resend it
   - Go to Employees list
   - Find the employee with "Pending Activation" status
   - Click "Resend" button

4. **View Activation Status**
   - Employees list shows "Activated" or "Pending Activation" status
   - Green badge = Account activated
   - Yellow badge = Pending activation

### For Employees:

1. **Receive Activation Email**
   - Check email inbox for "Activate Your HRIS Account"
   - Email contains Employee ID and activation link

2. **Activate Account**
   - Click the activation link in the email
   - You'll see your Employee ID and Email
   - Create a password (minimum 8 characters)
   - Confirm the password
   - Click "Activate Account"

3. **Login**
   - After activation, go to Employee Login page
   - Use your email and the password you created
   - Access your employee dashboard

## Important Notes

- **Activation Link Expiry**: Links expire after 48 hours. Request a new one from HR if expired.
- **Email Configuration**: Email sending requires proper SMTP configuration in `.env` file.
- **Security**: Employees cannot login until they activate their account.
- **Employee ID**: This is your unique identifier in the system (different from user ID).

## Email Configuration

To enable email sending, configure these in your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Routes

- **Activation Form**: `/activate/{token}`
- **Activation Submit**: `POST /activate/{token}`
- **Resend Activation**: `POST /employees/{employee}/resend-activation`

## Database Changes

New fields added to `users` table:
- `account_activated` (boolean) - Whether account is activated
- `activation_token` (string) - Unique activation token
- `activation_token_expires_at` (timestamp) - Token expiry time

## Testing Without Email

If email is not configured, the system will still work:
- Employee is registered successfully
- Activation email sending fails gracefully
- HR sees a message about email configuration
- For testing, you can manually activate accounts in database:

```sql
UPDATE users SET account_activated = 1, activation_token = NULL WHERE email = 'employee@example.com';
```
