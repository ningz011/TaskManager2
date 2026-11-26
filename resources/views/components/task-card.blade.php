@extends('layouts.app')

@section('title', 'New Task')

@section('content')
    <div class="max-w-xl mx-auto bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <h1 class="text-xl font-bold text-slate-900 mb-4">Create Task</h1>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                <input id="title"
                       type="text"
                       name="title"
                       value="{{ old('title') }}"
                       required
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                <textarea id="description"
                          name="description"
                          rows="3"
                          class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="due_date" class="block text-sm font-medium text-slate-700 mb-1">Due Date</label>
                <input id="due_date"
                       type="date"
                       name="due_date"
                       value="{{ old('due_date') }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <a href="{{ route('tasks.index') }}"
                   class="text-sm font-medium text-slate-600 hover:text-slate-900 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    Save Task
                </button>
            </div>
        </form>
    </div>
@endsection