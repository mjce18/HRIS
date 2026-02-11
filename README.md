# HRIS - Human Resource Information System

A comprehensive Human Resource Information System built with Laravel 11, featuring separate portals for HR/Admin and Employees with modern UI and complete attendance, leave, and overtime management.

## 🚀 Features

### 🔐 Authentication & Authorization
- **Separate Login Pages** for HR/Admin and Employees
- **Email-Based Account Activation** with secure token system
- **Role-Based Access Control** using Spatie Laravel Permission
- **Password Management** with secure hashing
- **Session Management** with automatic redirects

### 👥 Employee Management
- **Complete CRUD Operations** (Create, Read, Update, Delete)
- **Employee Registration** with automatic account creation
- **Email Activation System** (48-hour token expiry)
- **Resend Activation Email** functionality
- **Employee Profile Management**
  - Profile picture upload (JPG, PNG, GIF up to 2MB)
  - Personal information editing
  - Password change
- **Employee Information**
  - Employee ID, Name, Email
  - Department & Position assignment
  - Employment Type (Full-time, Part-time, Contract, Intern)
  - Hire Date, Salary
  - Phone Number, Address
  - Account Status (Active/Inactive/Terminated)
- **Activation Status Tracking** (Activated/Pending)
- **Delete Confirmation Modal** with cascade deletion

### 🏢 Department Management
- **Department CRUD Operations**
- **Department Information**
  - Department Code & Name
  - Description
  - Manager Assignment
  - Employee Count
  - Status (Active/Inactive)
- **Department Details View** with employee list
- **Validation** prevents deleting departments with employees

### 📋 Position Management
- Position titles and descriptions
- Department association
- Status management

### ⏰ Attendance Management

#### For HR/Admin:
- **View All Employee Attendance**
- **Attendance Records** with date, check-in/out times
- **Status Tracking** (Present, Late, Absent)
- **Hours Worked Calculation**
- **Required Hours Display** (8 hours standard)
- **Read-Only View** (HR cannot check-in/out)

#### For Employees:
- **Check-In/Check-Out System**
  - One-click check-in/out buttons
  - Automatic late detection (after 9:00 AM)
  - Real-time status updates
- **Today's Attendance Card**
  - Check-in time
  - Check-out time
  - Hours worked vs Required hours
  - Current status
- **Personal Attendance History**
- **Time Entries View** with complete history
- **Days Present Summary**
  - Working days count
  - Days present count
  - On-time count
  - Late count
  - Attendance rate percentage
- **Absences Tracking**
  - Automatic absence calculation
  - Excludes weekends
  - Current month view

### 🌴 Leave Management

#### For HR/Admin:
- **Leave Approvals Dashboard**
- **Approve/Reject Leaves** with reasons
- **Leave Status Tracking** (Pending, Approved, Rejected, Cancelled)
- **Leave Type Management** (Sick, Vacation, Personal, etc.)

#### For Employees:
- **Request Leave**
  - Select leave type
  - Date range selection
  - Reason for leave
- **View Leave History**
- **Cancel Pending Leaves**
- **Leave Status Tracking**

### ⏱️ Overtime Management

#### For HR/Admin:
- **Overtime Approvals Dashboard**
- **Approve/Reject Overtime** with reasons
- **Overtime Status Tracking**

#### For Employees:
- **Request Overtime**
  - Date selection
  - Time range (start/end)
  - Automatic hours calculation
  - Reason for overtime
- **View Overtime History**
- **Cancel Pending Requests**
- **Status Tracking** (Pending, Approved, Rejected, Cancelled)

### 📊 Transactions Menu (Employee Portal)
Collapsible dropdown menu with:
- **Time Entries** - Complete attendance history with pagination
- **Request Overtime** - Submit overtime requests
- **Leaves** - Manage leave requests
- **Absences** - View absent days with statistics
- **Days Present** - Attendance summary with rate calculation

### 👤 Profile Management
- **Profile Picture Upload/Remove**
  - Circular display in sidebar
  - Fallback to initial letter
  - 2MB max file size
- **Edit Profile Information**
  - Name, Email, Phone
  - View Employee ID
- **Change Password**
  - Current password verification
  - Secure password update

### 🎨 User Interface

#### Design Features:
- **Modern Tailwind CSS** styling
- **Dark Mode Support** with localStorage persistence
- **Collapsible Sidebar**
  - Collapses to icons only
  - Hover to expand
  - Smooth animations
- **Responsive Design** for all screen sizes
- **Alpine.js** for interactive components
- **Beautiful Gradients** and color schemes
- **Status Badges** with color coding
- **Confirmation Modals** for destructive actions

#### HR/Admin Dashboard:
- System statistics overview
- Quick actions
- Recent activity
- Navigation: Dashboard, Employees, Departments, Attendance, Leave Approvals, Overtime Approvals

#### Employee Portal:
- Personal dashboard
- Today's attendance card
- Quick check-in/out
- Transactions dropdown menu
- Navigation: Dashboard, Transactions, My Attendance

### 📧 Email Notifications
- **Account Activation Emails**
  - Secure activation link
  - Employee ID included
  - 48-hour expiry
- **Resend Activation** option for HR

### 🔒 Security Features
- **CSRF Protection** on all forms
- **SQL Injection Prevention** (Eloquent ORM)
- **XSS Protection** (Blade escaping)
- **Password Hashing** (bcrypt)
- **File Upload Validation**
- **Role-Based Middleware**
- **Session Security**

## 🛠️ Technology Stack

- **Framework:** Laravel 11
- **Frontend:** Tailwind CSS, Alpine.js
- **Database:** SQLite (configurable to MySQL/PostgreSQL)
- **Authentication:** Laravel Sanctum
- **Authorization:** Spatie Laravel Permission
- **File Storage:** Laravel Storage (local/public disk)

## 📦 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM (optional, for asset compilation)

### Setup Steps

1. **Clone the repository**
```bash
git clone <repository-url>
cd hris-system
```

2. **Install dependencies**
```bash
composer install
```

3. **Environment setup**
```bash
copy .env.example .env
php artisan key:generate
```

4. **Configure database** (in `.env`)
```env
DB_CONNECTION=sqlite
# Or for MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=hris
# DB_USERNAME=root
# DB_PASSWORD=
```

5. **Run migrations and seeders**
```bash
php artisan migrate --seed
```

6. **Create storage link**
```bash
php artisan storage:link
```

7. **Start development server**
```bash
php artisan serve
```

8. **Access the application**
- Main page: http://localhost:8000
- HR Login: http://localhost:8000/login
- Employee Login: http://localhost:8000/employee/login

## 👤 Default Credentials

### HR/Admin Account
- **Email:** hr@hris.com
- **Password:** password

### Admin Account
- **Email:** admin@hris.com
- **Password:** password

### Employee Account
- **Email:** employee@hris.com
- **Password:** password

## 📁 Project Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── Auth/
│       │   ├── LoginController.php
│       │   └── AccountActivationController.php
│       ├── Employee/
│       │   ├── EmployeeDashboardController.php
│       │   ├── EmployeeAttendanceController.php
│       │   ├── EmployeeLeaveController.php
│       │   ├── EmployeeOvertimeController.php
│       │   └── EmployeeTransactionController.php
│       ├── DashboardController.php
│       ├── EmployeeController.php
│       ├── DepartmentController.php
│       ├── AttendanceController.php
│       ├── LeaveController.php
│       ├── OvertimeController.php
│       └── ProfileController.php
├── Models/
│   ├── User.php
│   ├── Employee.php
│   ├── Department.php
│   ├── Position.php
│   ├── Attendance.php
│   ├── Leave.php
│   ├── LeaveType.php
│   └── Overtime.php
└── Notifications/
    └── EmployeeAccountActivation.php

database/
├── migrations/
│   ├── create_users_table.php
│   ├── create_departments_table.php
│   ├── create_positions_table.php
│   ├── create_employees_table.php
│   ├── create_attendances_table.php
│   ├── create_leave_types_table.php
│   ├── create_leaves_table.php
│   ├── create_overtimes_table.php
│   ├── create_permission_tables.php
│   └── add_activation_fields_to_users_table.php
└── seeders/
    ├── DatabaseSeeder.php
    ├── RolePermissionSeeder.php
    ├── UserSeeder.php
    ├── DepartmentSeeder.php
    ├── PositionSeeder.php
    └── LeaveTypeSeeder.php

resources/
└── views/
    ├── layouts/
    │   ├── app.blade.php (HR Layout)
    │   └── employee.blade.php (Employee Layout)
    ├── auth/
    │   ├── login.blade.php
    │   ├── employee-login.blade.php
    │   └── activate.blade.php
    ├── profile/
    │   └── edit.blade.php
    ├── employees/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   ├── edit.blade.php
    │   └── show.blade.php
    ├── departments/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   ├── edit.blade.php
    │   └── show.blade.php
    ├── attendances/
    │   └── index.blade.php
    ├── leaves/
    │   └── index.blade.php
    ├── overtimes/
    │   └── index.blade.php
    └── employee/
        ├── dashboard.blade.php
        ├── attendance/
        │   └── index.blade.php
        ├── leaves/
        │   ├── index.blade.php
        │   └── create.blade.php
        ├── overtimes/
        │   ├── index.blade.php
        │   └── create.blade.php
        └── transactions/
            ├── time-entries.blade.php
            ├── absences.blade.php
            └── days-present.blade.php
```

## 🎯 Key Features Breakdown

### Employee Registration Flow
1. HR registers employee with email and employee ID
2. System generates activation token (48-hour expiry)
3. Activation email sent to employee
4. Employee clicks link and sets password
5. Employee can login to employee portal

### Attendance Flow
1. Employee logs in to employee portal
2. Clicks "Check In" button (before/after 9:00 AM)
3. System records time and marks as Present/Late
4. Employee works throughout the day
5. Clicks "Check Out" button
6. System calculates hours worked
7. HR can view all attendance records

### Leave Request Flow
1. Employee submits leave request with dates and reason
2. Request appears in HR's Leave Approvals dashboard
3. HR reviews and approves/rejects with reason
4. Employee sees updated status in their leaves page
5. Employee can cancel pending requests

### Overtime Request Flow
1. Employee submits overtime request with date, time range, and reason
2. System automatically calculates hours
3. Request appears in HR's Overtime Approvals dashboard
4. HR reviews and approves/rejects with reason
5. Employee sees updated status

## 📊 Database Schema

### Users Table
- id, name, email, password
- employee_id, phone, status
- account_activated, activation_token, activation_token_expires_at
- profile_picture
- timestamps

### Employees Table
- id, user_id, employee_code
- first_name, last_name
- department_id, position_id
- hire_date, employment_type, salary
- address, phone, status
- timestamps, soft_deletes

### Departments Table
- id, name, code, description
- manager_id, status
- timestamps

### Positions Table
- id, title, description
- department_id, status
- timestamps

### Attendances Table
- id, employee_id, date
- check_in, check_out
- status (present, late, absent, half-day)
- notes, timestamps

### Leaves Table
- id, employee_id, leave_type_id
- start_date, end_date, days
- reason, status
- approved_by, approved_at, rejection_reason
- timestamps

### Overtimes Table
- id, employee_id, date
- start_time, end_time, hours
- reason, status
- approved_by, approved_at, rejection_reason
- timestamps

## 🔧 Configuration

### Email Configuration (Optional)
For activation emails to work, configure SMTP in `.env`:
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

### File Storage
Profile pictures are stored in `storage/app/public/profile_pictures/`

## 🧪 Testing

### Manual Testing Checklist

#### Authentication
- [ ] HR login
- [ ] Employee login
- [ ] Account activation
- [ ] Password change
- [ ] Logout

#### Employee Management
- [ ] Create employee
- [ ] Edit employee
- [ ] Delete employee
- [ ] View employee details
- [ ] Resend activation email

#### Attendance
- [ ] Employee check-in
- [ ] Employee check-out
- [ ] Late detection (after 9 AM)
- [ ] View attendance history
- [ ] HR view all attendance

#### Leave Management
- [ ] Request leave
- [ ] Approve leave
- [ ] Reject leave
- [ ] Cancel leave
- [ ] View leave history

#### Overtime Management
- [ ] Request overtime
- [ ] Approve overtime
- [ ] Reject overtime
- [ ] Cancel overtime
- [ ] View overtime history

#### Profile Management
- [ ] Upload profile picture
- [ ] Remove profile picture
- [ ] Update profile information
- [ ] Change password

## 🐛 Troubleshooting

### Common Issues

**Issue:** Activation email not sending
**Solution:** Configure SMTP settings in `.env` or manually activate accounts in database

**Issue:** Profile pictures not displaying
**Solution:** Run `php artisan storage:link`

**Issue:** Permission denied errors
**Solution:** Check file permissions on `storage/` and `bootstrap/cache/`

**Issue:** Database connection error
**Solution:** Verify database configuration in `.env`

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Development

### Adding New Features
1. Create migration: `php artisan make:migration create_table_name`
2. Create model: `php artisan make:model ModelName`
3. Create controller: `php artisan make:controller ControllerName`
4. Add routes in `routes/web.php`
5. Create views in `resources/views/`

### Code Style
- Follow PSR-12 coding standards
- Use Laravel best practices
- Write descriptive commit messages

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📞 Support

For support, email support@hris.com or open an issue in the repository.

---

**Built with ❤️ using Laravel 11**
