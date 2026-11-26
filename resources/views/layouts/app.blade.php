<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Task Manager')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">
    <nav class="bg-white border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('tasks.index') }}" class="text-lg font-semibold text-slate-900">
                Task Manager
            </a>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('tasks.create') }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                        + New Task
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="text-sm font-medium text-slate-600 hover:text-slate-900 px-3 py-2">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-slate-700 hover:text-slate-900 px-3 py-2">
                        Login
                    </a>
                    <a href="{{ route