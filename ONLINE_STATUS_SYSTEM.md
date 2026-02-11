# Employee Online Status System

## Overview
Implemented a real-time online status tracking system that allows HR to see which employees are currently online, away, or offline.

## Features Implemented

### 1. Database Changes
- Added `last_seen` timestamp column to `users` table
- Tracks the last activity time for each user

### 2. Middleware - UpdateLastSeen
**File**: `app/Http/Middleware/UpdateLastSeen.php`
- Automatically updates `last_seen` timestamp on every request
- Registered in web middleware group
- Runs for all authenticated users

### 3. User Model Methods
**File**: `app/Models/User.php`

Added three helper methods:

#### `isOnline()`
- Returns `true` if user was active within last 5 minutes
- Returns `false` otherwise

#### `getOnlineStatus()`
- Returns `'online'` if active within 5 minutes
- Returns `'away'` if active within 30 minutes
- Returns `'offline'` otherwise

#### `getLastSeenFormatted()`
- Returns `'Online'` if currently online
- Returns human-readable time (e.g., "5 minutes ago") if offline
- Returns `'Never'` if user has never logged in

## Status Indicators

### Visual Indicators
- **Green dot** (●) - Online (active within 5 minutes)
- **Yellow dot** (●) - Away (active within 30 minutes)
- **Gray dot** (●) - Offline (inactive for more than 30 minutes)

### Where Status is Displayed

#### 1. Employees List (HR Dashboard)
**File**: `resources/views/employees/index.blade.php`
- Shows profile picture with status indicator
- Displays "Online now", "Away", or last seen time
- Real-time status for all employees in one view

#### 2. Chat Index Page
**File**: `resources/views/chat/index.blade.php`
- Status indicator on profile pictures
- "Online" or "Away" label next to names
- Shows in both "Recent Conversations" and "Available Users" sections

#### 3. Chat Conversation Page
**File**: `resources/views/chat/show.blade.php`
- Status indicator in chat header
- Shows "● Online", "● Away", or "Last seen X ago"
- Status indicator in conversation list sidebar

## How It Works

### Automatic Tracking
1. User logs in and navigates the system
2. Every page request updates their `last_seen` timestamp
3. System checks timestamp to determine online status
4. Status indicators update automatically on page refresh

### Status Calculation
```
Online:  last_seen <= 5 minutes ago
Away:    last_seen > 5 minutes AND <= 30 minutes ago
Offline: last_seen > 30 minutes ago OR never logged in
```

## Files Modified

### New Files
1. `database/migrations/2026_02_11_061335_add_last_seen_to_users_table.php`
2. `app/Http/Middleware/UpdateLastSeen.php`

### Modified Files
1. `bootstrap/app.php` - Registered middleware
2. `app/Models/User.php` - Added status methods and fillable field
3. `resources/views/employees/index.blade.php` - Added status indicators
4. `resources/views/chat/index.blade.php` - Added status indicators
5. `resources/views/chat/show.blade.php` - Added status indicators

## Usage Examples

### For HR Users
1. Go to Employees page to see all employee statuses at once
2. Green dot = Employee is currently active
3. Yellow dot = Employee was recently active (within 30 min)
4. Gray dot = Employee is offline
5. Hover over status dot to see tooltip

### In Chat
1. Open Messages to see who's available to chat
2. Online employees show green indicator
3. Click to start chatting with online employees
4. See real-time status in chat header

## Benefits

### For HR
- Quickly identify available employees
- Know when employees are active
- Better timing for urgent communications
- Monitor employee activity patterns

### For Employees
- See when HR is available
- Know if message will be seen immediately
- Better communication timing

## Technical Details

### Performance
- Minimal database impact (single column update per request)
- No additional queries for status calculation
- Efficient timestamp comparison using Carbon

### Privacy
- Only tracks activity, not specific actions
- Shows relative time, not exact timestamps
- Respects user privacy while providing useful information

## Future Enhancements (Optional)
- Real-time updates using WebSockets (no page refresh needed)
- Custom status messages (e.g., "In a meeting", "On break")
- Activity history reports
- Notification when specific employee comes online
- Idle detection (mouse/keyboard activity)
