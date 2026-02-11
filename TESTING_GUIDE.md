# HRIS System Testing Guide

## 🚀 Server is Running!

**URL**: http://127.0.0.1:8000

The development server is now active and ready for testing!

---

## 👥 Test Accounts

### HR Account
- **Email**: `hr@hris.com`
- **Password**: `HR@2024`
- **Access**: Full HR dashboard with all management features

### Employee Account
- **Email**: `employee@hris.com`
- **Password**: `Employee@2024`
- **Access**: Employee portal with attendance, leaves, overtime

### Admin Account (Super Admin)
- **Email**: `admin@hris.com`
- **Password**: `Admin@2024`
- **Access**: Full system access

---

## 🧪 Testing Scenarios

### 1. Test HR Dashboard
1. Go to: http://127.0.0.1:8000
2. Click "HR/Admin Login"
3. Login with: `hr@hris.com` / `HR@2024`
4. You should see:
   - ✅ Modern gradient welcome banner
   - ✅ 4 stat cards (Employees, Departments, Pending Leaves, Attendance)
   - ✅ Quick Actions section
   - ✅ System Overview with attendance rate

**Features to Test:**
- Click on stat cards to navigate
- Try Quick Actions buttons
- Check dark mode toggle (bottom left)
- View sidebar navigation

---

### 2. Test Employee Management
**While logged in as HR:**

1. Click "Employees" in sidebar
2. You should see:
   - ✅ Filter section (Search, Department, Status)
   - ✅ Employee list with online status indicators
   - ✅ Profile pictures with green/yellow/gray dots

**Test Filters:**
- Search by name or employee ID
- Filter by department
- Filter by employment status
- Click "Clear" button to reset

**Test Actions:**
- Click "View" to see employee details
- Click "Edit" to modify employee info
- Try "Delete" to see confirmation modal

---

### 3. Test Employee Portal
1. Logout from HR account
2. Go to: http://127.0.0.1:8000
3. Click "Employee Login"
4. Login with: `employee@hris.com` / `Employee@2024`
5. You should see:
   - ✅ Employee dashboard
   - ✅ Check-in/Check-out buttons
   - ✅ Today's attendance card

**Features to Test:**
- Click "Check In" button
- View "My Attendance" page
- Click "Transactions" menu to see submenu:
  - Time Entries
  - Request Overtime
  - Leaves
  - Absences
  - Days Present

---

### 4. Test Attendance System
**As Employee:**
1. Click "My Attendance"
2. Click "Check In" button
3. Note the time (late if after 9:00 AM)
4. Click "Check Out" button
5. View attendance history

**As HR:**
1. Go to "Attendance" in sidebar
2. View all employee attendance
3. See real-time check-ins

---

### 5. Test Leave Management
**As Employee:**
1. Go to Transactions → Leaves
2. Click "Request Leave"
3. Fill in the form:
   - Leave type
   - Start date
   - End date
   - Reason
4. Submit request

**As HR:**
1. Go to "Leaves" in sidebar
2. See pending leave requests
3. Click "Approve" or "Reject"
4. Add approval/rejection reason

---

### 6. Test Overtime System
**As Employee:**
1. Go to Transactions → Request Overtime
2. Click "Request Overtime"
3. Fill in:
   - Date
   - Start time
   - End time
   - Reason
4. Submit request

**As HR:**
1. Go to "Overtime" in sidebar
2. Review pending overtime requests
3. Approve or reject with reason

---

### 7. Test Department Management
**As HR:**
1. Click "Departments" in sidebar
2. Click "Add Department"
3. Create new department
4. View department details
5. Edit department
6. Try to delete (will warn if employees assigned)

---

### 8. Test Chat System
**As HR:**
1. Click "Messages" in sidebar
2. See list of employees
3. Notice online status indicators (green/yellow/gray dots)
4. Click on an employee to chat
5. Send a message

**As Employee:**
1. Click "Messages" in sidebar
2. See HR team members
3. Click to open chat
4. Reply to message
5. Check unread badge updates

---

### 9. Test Notifications
**As Employee:**
1. Submit a leave or overtime request

**As HR:**
1. Check notification badge (red circle with count)
2. Click "Notifications"
3. See new request notification
4. Click notification to go to request
5. Badge should update after marking as read

---

### 10. Test Online Status
**As HR:**
1. Go to "Employees" page
2. Look for green dots = Online employees
3. Yellow dots = Away (inactive 5-30 min)
4. Gray dots = Offline (inactive >30 min)
5. See "Online now" or "Last seen X ago" text

**Test in Chat:**
1. Open Messages
2. See online status in conversation list
3. Open a chat - see status in header

---

### 11. Test Profile Management
**Both HR and Employee:**
1. Click "My Profile" at bottom of sidebar
2. Upload profile picture (JPG, PNG, GIF - max 2MB)
3. Update name, email, phone
4. Change password
5. Remove profile picture
6. Check if picture appears in:
   - Sidebar
   - Chat
   - Employee list (for employees)

---

### 12. Test Dark Mode
1. Click moon/sun icon in sidebar (bottom left)
2. Toggle between light and dark mode
3. Check all pages maintain dark mode
4. Refresh page - mode should persist

---

### 13. Test Filtering System
**As HR on Employees page:**
1. Type employee name in search
2. Select a department from dropdown
3. Select employment status
4. Click "Filter" button
5. See filtered results
6. Check "Active filters" badges appear
7. Click "X" button to clear all filters
8. See results count update

---

### 14. Test Responsive Design
1. Resize browser window
2. Check mobile view (narrow width)
3. Verify:
   - Sidebar collapses to icons
   - Tables scroll horizontally
   - Cards stack vertically
   - Filters stack on mobile

---

## 🎨 Visual Features to Check

### Modern UI Elements
- ✅ Gradient backgrounds on cards
- ✅ Hover effects with scale animation
- ✅ Shadow effects on hover
- ✅ Smooth transitions
- ✅ Rounded corners (rounded-2xl)
- ✅ Icon badges with colors
- ✅ Profile pictures with status dots
- ✅ Badge indicators for notifications/messages

### Color Scheme
- Blue: Employees, Primary actions
- Green: Departments, Success states
- Yellow/Orange: Pending items, Warnings
- Purple/Pink: Attendance, Special features
- Red: Notifications, Delete actions

---

## 🐛 Common Issues & Solutions

### Issue: "View [chat.index] not found"
**Solution**: Already fixed! Caches were cleared.

### Issue: Can't login
**Solution**: Make sure database is seeded:
```bash
php artisan migrate:fresh --seed
```

### Issue: Profile pictures not showing
**Solution**: Create storage link:
```bash
php artisan storage:link
```

### Issue: Online status not updating
**Solution**: Refresh the page. Status updates on each request.

### Issue: Filters not working
**Solution**: Check that departments exist in database.

---

## 📊 Expected Data

After seeding, you should have:
- 3 users (admin, hr, employee)
- Multiple departments (IT, HR, Sales, etc.)
- Multiple positions
- Sample leave types
- Default roles and permissions

---

## 🔄 Reset Database (If Needed)

If you need to start fresh:

```bash
php artisan migrate:fresh --seed
```

This will:
- Drop all tables
- Recreate tables
- Seed default data
- Create test accounts

---

## 📝 Test Checklist

Use this checklist to track your testing:

- [ ] HR Dashboard loads with modern UI
- [ ] Employee Dashboard loads correctly
- [ ] Login/Logout works for both portals
- [ ] Employee filtering works (search, department, status)
- [ ] Online status indicators show correctly
- [ ] Attendance check-in/check-out works
- [ ] Leave request and approval flow works
- [ ] Overtime request and approval flow works
- [ ] Department CRUD operations work
- [ ] Chat system sends/receives messages
- [ ] Notifications appear and update badges
- [ ] Profile picture upload works
- [ ] Dark mode toggles and persists
- [ ] All navigation links work
- [ ] Responsive design works on mobile
- [ ] Delete confirmation modal works

---

## 🎯 Key Features to Showcase

1. **Modern Dashboard**: Gradient cards with hover effects
2. **Online Status**: Real-time employee availability
3. **Smart Filtering**: Multi-criteria employee search
4. **Chat System**: Internal messaging with status
5. **Notifications**: Real-time alerts with badges
6. **Profile Management**: Picture upload and editing
7. **Dark Mode**: Persistent theme switching
8. **Responsive Design**: Works on all devices

---

## 🚪 Logout & Switch Accounts

To test different roles:
1. Click "Logout" button in sidebar
2. Return to home page
3. Choose different login portal
4. Login with different credentials

---

## 💡 Pro Tips

- Keep both HR and Employee accounts open in different browsers to test real-time features
- Test chat by sending messages between accounts
- Submit leave/overtime as employee, then approve as HR
- Check notification badges update in real-time
- Try all filters in combination
- Test dark mode on all pages

---

## 📞 Need Help?

If you encounter any issues:
1. Check browser console for errors (F12)
2. Check Laravel logs: `storage/logs/laravel.log`
3. Verify database connection in `.env`
4. Make sure all migrations ran successfully

---

**Happy Testing! 🎉**

Your HRIS system is ready to use at: **http://127.0.0.1:8000**
