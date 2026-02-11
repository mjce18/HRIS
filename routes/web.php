<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AccountActivationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\Employee\EmployeeAttendanceController;
use App\Http\Controllers\Employee\EmployeeLeaveController;
use App\Http\Controllers\Employee\EmployeeOvertimeController;
use App\Http\Controllers\Employee\EmployeeTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    // HR/Admin Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Employee Login
    Route::get('/employee/login', [LoginController::class, 'showEmployeeLoginForm'])->name('employee.login');
    Route::post('/employee/login', [LoginController::class, 'employeeLogin'])->name('employee.login.submit');
    
    // Account Activation
    Route::get('/activate/{token}', [AccountActivationController::class, 'showActivationForm'])->name('account.activate.form');
    Route::post('/activate/{token}', [AccountActivationController::class, 'activate'])->name('account.activate');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/logout', [LoginController::class, 'logout']); // Fallback for expired sessions
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/picture', [ProfileController::class, 'deleteProfilePicture'])->name('profile.picture.delete');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::get('/api/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
    
    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{user}', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/api/chat/unread-count', [ChatController::class, 'getUnreadCount'])->name('chat.unreadCount');
    
    // Main dashboard - redirects based on role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // HR/Admin Routes - Protected by role middleware
    Route::middleware('role:super-admin|admin|hr')->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::post('employees/{employee}/resend-activation', [EmployeeController::class, 'resendActivation'])->name('employees.resend-activation');
        Route::resource('departments', DepartmentController::class);
        
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/', [AttendanceController::class, 'index'])->name('index');
        });
        
        Route::prefix('leaves')->name('leaves.')->group(function () {
            Route::get('/', [LeaveController::class, 'index'])->name('index');
            Route::post('/{leave}/approve', [LeaveController::class, 'approve'])->name('approve');
            Route::post('/{leave}/reject', [LeaveController::class, 'reject'])->name('reject');
        });
        
        Route::prefix('overtimes')->name('overtimes.')->group(function () {
            Route::get('/', [OvertimeController::class, 'index'])->name('index');
            Route::post('/{overtime}/approve', [OvertimeController::class, 'approve'])->name('approve');
            Route::post('/{overtime}/reject', [OvertimeController::class, 'reject'])->name('reject');
        });
    });
    
    // Employee Portal Routes - No role middleware needed, all authenticated users can access
    Route::prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
        
        Route::prefix('transactions')->name('transactions.')->group(function () {
            Route::get('/time-entries', [EmployeeTransactionController::class, 'timeEntries'])->name('time-entries');
            Route::get('/absences', [EmployeeTransactionController::class, 'absences'])->name('absences');
            Route::get('/days-present', [EmployeeTransactionController::class, 'daysPresent'])->name('days-present');
        });
        
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/', [EmployeeAttendanceController::class, 'index'])->name('index');
            Route::post('/check-in', [EmployeeAttendanceController::class, 'checkIn'])->name('check-in');
            Route::post('/check-out', [EmployeeAttendanceController::class, 'checkOut'])->name('check-out');
        });
        
        Route::prefix('leaves')->name('leaves.')->group(function () {
            Route::get('/', [EmployeeLeaveController::class, 'index'])->name('index');
            Route::get('/create', [EmployeeLeaveController::class, 'create'])->name('create');
            Route::post('/', [EmployeeLeaveController::class, 'store'])->name('store');
            Route::post('/{leave}/cancel', [EmployeeLeaveController::class, 'cancel'])->name('cancel');
        });
        
        Route::prefix('overtimes')->name('overtimes.')->group(function () {
            Route::get('/', [EmployeeOvertimeController::class, 'index'])->name('index');
            Route::get('/create', [EmployeeOvertimeController::class, 'create'])->name('create');
            Route::post('/', [EmployeeOvertimeController::class, 'store'])->name('store');
            Route::post('/{overtime}/cancel', [EmployeeOvertimeController::class, 'cancel'])->name('cancel');
        });
    });
});
