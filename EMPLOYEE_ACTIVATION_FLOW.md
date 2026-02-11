# Employee Activation Flow - Complete Guide

## 📋 Overview

When HR registers a new employee, the employee receives an activation email and must create their own password before they can login.

---

## 🔄 Complete Activation Flow

### Step 1: HR Registers New Employee

**HR Actions:**
1. Login to HR portal: http://127.0.0.1:8000
   - Email: `hr@hris.com`
   - Password: `HR@2024`

2. Go to **Employees** → Click **"Add Employee"**

3. Fill in employee details:
   - First Name: John
   - Last Name: Smith
   - Email: `john.smith@example.com` ← Employee's email
   - Employee ID: EMP004
   - Department: IT
   - Position: Developer
   - Hire Date: Today
   - Employment Type: Full-time
   - Salary: 50000

4. Click **"Register Employee"**

**What Happens:**
- ✅ Employee account created (inactive)
- ✅ Activation token generated (valid for 48 hours)
- ✅ Activation email sent to employee
- ✅ Temporary random password set (will be replaced)

---

### Step 2: Employee Receives Activation Email

**Email Content:**
```
Subject: Activate Your HRIS Account

Hello,

Your employee account has been created successfully.

Employee ID: EMP004

Please click the button below to activate your account and set your password.

[Activate Account Button]

This link will expire in 48 hours.
```

**Activation Link Format:**
```
http://127.0.0.1:8000/activate/abc123def456...
```

---

### Step 3: Employee Clicks Activation Link

**What Employee Sees:**

1. **Activation Page** opens with:
   - Welcome message
   - Employee ID displayed
   - Email address displayed
   - Password creation form

2. **Form Fields:**
   - Create Password (minimum 8 characters)
   - Confirm Password

3. **Employee enters their desired password:**
   - Example: `MySecure@Pass123`
   - Confirms it

4. **Clicks "Activate Account" button**

---

### Step 4: Account Activated

**What Happens:**
- ✅ Password is saved (encrypted)
- ✅ Account status changed to "activated"
- ✅ Activation token removed
- ✅ Employee redirected to login page
- ✅ Success message shown

**Success Message:**
```
"Account activated successfully! You can now login with your credentials."
```

---

### Step 5: Employee Can Now Login

**Employee Login:**
1. Go to: http://127.0.0.1:8000
2. Click **"Employee Login"**
3. Enter credentials:
   - Email: `john.smith@example.com`
   - Password: `MySecure@Pass123` (the one they created)
4. Click **"Sign In as Employee"**
5. Access employee portal! 🎉

---

## 🔐 Security Features

### Password Requirements
- ✅ Minimum 8 characters
- ✅ Must be confirmed (typed twice)
- ✅ Encrypted using bcrypt
- ✅ Cannot be same as temporary password

### Token Security
- ✅ Unique random 64-character token
- ✅ Expires after 48 hours
- ✅ Single-use only
- ✅ Deleted after activation

### Account Protection
- ✅ Cannot login before activation
- ✅ Cannot use expired activation link
- ✅ Cannot reuse activation token
- ✅ Password must meet requirements

---

## 📧 Getting Activation Links (Current Setup)

Since email is set to `log`, activation emails are saved to log file:

### Method 1: Check Log File
1. Open: `storage/logs/laravel.log`
2. Search for: `activate/`
3. Copy the full URL
4. Send to employee via:
   - Chat
   - SMS
   - WhatsApp
   - Any messaging app

### Method 2: Use Mailtrap (Optional)
1. Set up Mailtrap (see EMAIL_SETUP_GUIDE.md)
2. Emails will appear in Mailtrap inbox
3. Copy activation link from email
4. Send to employee

---

## 🧪 Testing the Complete Flow

### Test Scenario 1: Successful Activation

1. **HR registers employee**: `test@example.com`
2. **Get activation link** from log file
3. **Open link** in browser
4. **See activation page** with employee details
5. **Create password**: `Test@1234`
6. **Confirm password**: `Test@1234`
7. **Click "Activate Account"**
8. **Redirected to login** with success message
9. **Login with**:
   - Email: `test@example.com`
   - Password: `Test@1234`
10. **Access employee portal** ✅

---

### Test Scenario 2: Expired Token

1. **HR registers employee**
2. **Wait 48+ hours** (or manually expire in database)
3. **Try to use activation link**
4. **See error**: "Invalid or expired activation link"
5. **HR must resend activation** from employees page

---

### Test Scenario 3: Password Mismatch

1. **Open activation link**
2. **Enter password**: `Test@1234`
3. **Confirm password**: `Different@5678`
4. **Click "Activate Account"**
5. **See error**: "The password confirmation does not match"
6. **Try again** with matching passwords

---

### Test Scenario 4: Weak Password

1. **Open activation link**
2. **Enter password**: `123` (too short)
3. **Click "Activate Account"**
4. **See error**: "The password must be at least 8 characters"
5. **Enter stronger password**

---

## 🔄 Resending Activation Email

If employee didn't receive email or link expired:

1. **HR goes to Employees page**
2. **Find the employee** (shows "Pending Activation" badge)
3. **Click "Resend" button**
4. **New activation email sent**
5. **New 48-hour token generated**
6. **Old token invalidated**

---

## 📊 Activation Status Indicators

### In Employees List (HR View):

**Activated Account:**
```
✅ Green badge: "Activated"
```

**Pending Activation:**
```
⏳ Yellow badge: "Pending"
[Resend] button available
```

---

## 💡 Important Notes

### For HR:
- ✅ Employee cannot login until they activate
- ✅ Activation link expires in 48 hours
- ✅ You can resend activation anytime
- ✅ Employee creates their own password
- ✅ You never see their password

### For Employees:
- ✅ Check email for activation link
- ✅ Click link within 48 hours
- ✅ Create a strong password
- ✅ Remember your password
- ✅ Login at employee portal

---

## 🎯 Current Configuration

**Email Method:** Log file
**Activation Link Location:** `storage/logs/laravel.log`
**Token Expiry:** 48 hours
**Password Minimum:** 8 characters
**Login Portal:** http://127.0.0.1:8000 → "Employee Login"

---

## 🚀 Quick Test Now

1. **Login as HR**
2. **Register a test employee**:
   - Email: `testuser@example.com`
   - Employee ID: TEST001
   - Fill other required fields
3. **Check log file**: `storage/logs/laravel.log`
4. **Find activation URL** (search for "activate/")
5. **Copy the URL**
6. **Open in new browser tab**
7. **Create password**: `TestPass@123`
8. **Confirm password**: `TestPass@123`
9. **Click "Activate Account"**
10. **Login with new credentials** ✅

---

## ✅ System is Working!

The activation flow is **fully functional**:
- ✅ HR registers employee
- ✅ Activation email generated
- ✅ Employee receives link (via log/email)
- ✅ Employee creates password
- ✅ Account activated
- ✅ Employee can login

**Everything is working as designed!** 🎉
