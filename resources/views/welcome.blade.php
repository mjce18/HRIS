<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - HRIS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold text-white mb-4">HRIS System</h1>
                <p class="text-xl text-gray-300">Human Resource Information System</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- HR/Admin Login Card -->
                <a href="{{ route('login') }}" class="group">
                    <div class="bg-white rounded-2xl shadow-2xl p-8 transform transition-all duration-300 hover:scale-105 hover:shadow-3xl">
                        <div class="text-center">
                            <div class="mx-auto h-20 w-20 bg-gray-800 rounded-full flex items-center justify-center mb-6 group-hover:bg-gray-900 transition-colors">
                                <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">HR / Admin</h2>
                            <p class="text-gray-600 mb-6">Manage employees, attendance, and leave requests</p>
                            <div class="inline-flex items-center text-gray-800 font-semibold group-hover:text-gray-900">
                                Login as HR/Admin
                                <svg class="ml-2 w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Employee Login Card -->
                <a href="{{ route('employee.login') }}" class="group">
                    <div class="bg-white rounded-2xl shadow-2xl p-8 transform transition-all duration-300 hover:scale-105 hover:shadow-3xl">
                        <div class="text-center">
                            <div class="mx-auto h-20 w-20 bg-blue-500 rounded-full flex items-center justify-center mb-6 group-hover:bg-blue-600 transition-colors">
                                <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">Employee</h2>
                            <p class="text-gray-600 mb-6">Check in/out, view attendance, and request leaves</p>
                            <div class="inline-flex items-center text-blue-600 font-semibold group-hover:text-blue-700">
                                Login as Employee
                                <svg class="ml-2 w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="mt-12 text-center text-gray-300 text-sm">
                <p>&copy; 2026 HRIS System. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
