# Testing HR and Employee Simultaneously

## The Issue
When you're logged in as HR in one browser tab and try to login as Employee in another tab of the **same browser**, you get a 419 error because Laravel uses the same session cookie for both tabs.

## ✅ Solution: Use Different Browsers or Incognito Mode

### Method 1: Use Two Different Browsers (RECOMMENDED)
1. **Browser 1 (Chrome)**: Login as HR
   - Go to: http://127.0.0.1:8000
   - Click "HR/Admin Login"
   - Email: `hr@hris.com`
   - Password: `HR@2024`

2. **Browser 2 (Edge/Firefox)**: Login as Employee
   - Go to: http://127.0.0.1:8000
   - Click "Employee Login"
   - Email: `employee@hris.com`
   - Password: `Employee@2024`

### Method 2: Use Incognito/Private Window
1. **Normal Window**: Login as HR
   - Go to: http://127.0.0.1:8000
   - Click "HR/Admin Login"
   - Email: `hr@hris.com`
   - Password: `HR@2024`

2. **Incognito Window** (Ctrl+Shift+N in Chrome): Login as Employee
   - Go to: http://127.0.0.1:8000
   - Click "Employee Login"
   - Email: `employee@hris.com`
   - Password: `Employee@2024`

### Method 3: Use Different Browser Profiles
1. Create a new Chrome profile for testing
2. Login as HR in Profile 1
3. Login as Employee in Profile 2

---

## Why This Happens

Laravel uses cookies to manage sessions. When you use the same browser:
- Both tabs share the same cookies
- Logging in as Employee overwrites the HR session
- The CSRF token from the HR session becomes invalid
- Result: 419 Page Expired error

---

## Testing Chat Between HR and Employee

To test the chat system between HR and Employee:

1. **Browser 1**: Login as HR
   - Go to Messages
   - Click on "John Doe" (employee)
   - Send a message: "Hello John!"

2. **Browser 2**: Login as Employee
   - Go to Messages
   - You should see the message from HR
   - Reply: "Hello HR!"

3. **Browser 1**: Refresh the chat
   - You should see the employee's reply

---

## Testing Real-Time Features

### Test Leave Approval Flow
1. **Browser 2 (Employee)**: 
   - Go to Transactions → Leaves
   - Click "Request Leave"
   - Submit a leave request

2. **Browser 1 (HR)**:
   - Check notification badge (should show "1")
   - Go to Leaves
   - See the pending request
   - Click "Approve" or "Reject"

3. **Browser 2 (Employee)**:
   - Refresh the page
   - See the updated status

### Test Online Status
1. **Browser 1 (HR)**:
   - Go to Employees page
   - Look for "John Doe"
   - Should show green dot (Online)

2. **Browser 2 (Employee)**:
   - Close the browser or logout
   - Wait 5 minutes

3. **Browser 1 (HR)**:
   - Refresh Employees page
   - "John Doe" should now show gray dot (Offline)

---

## Quick Reference

### HR Account
- **URL**: http://127.0.0.1:8000 → "HR/Admin Login"
- **Email**: hr@hris.com
- **Password**: HR@2024

### Employee Account
- **URL**: http://127.0.0.1:8000 → "Employee Login"
- **Email**: employee@hris.com
- **Password**: Employee@2024

---

## Troubleshooting

### Still Getting 419 Error?
1. Clear browser cookies:
   - Chrome: Ctrl+Shift+Delete → Clear cookies
   - Edge: Ctrl+Shift+Delete → Clear cookies
2. Close all browser tabs
3. Try again with different browsers

### Session Expired Message?
- This is normal if you've been idle for 2 hours (session lifetime)
- Just login again

### Can't See Messages/Notifications?
- Make sure you're using different browsers
- Refresh the page to see updates
- Check that both accounts are logged in

---

## Pro Tips

1. **Keep both browsers side-by-side** to see real-time updates
2. **Use Chrome DevTools** (F12) to check for errors
3. **Refresh pages** after actions to see updates
4. **Test in this order**:
   - Login both accounts
   - Test chat
   - Test leave request/approval
   - Test overtime request/approval
   - Test online status

---

## Alternative: Test One at a Time

If you don't want to use multiple browsers:

1. **Test as HR**:
   - Login as HR
   - Explore all HR features
   - Logout

2. **Test as Employee**:
   - Login as Employee
   - Explore all Employee features
   - Logout

3. **Test Interactions**:
   - Login as Employee
   - Submit leave request
   - Logout
   - Login as HR
   - Approve the request
   - Logout
   - Login as Employee
   - Check the approved status

---

**Remember**: The 419 error only happens when trying to use both accounts in the same browser session. Use different browsers or incognito mode to test simultaneously! 🎉
