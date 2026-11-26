@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">My Tasks</h1>
            <p class="text-sm text-slate-500">Manage your daily tasks and mark items complete.</p>
        </div>

        <a href="{{ route('tasks.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            + New Task
        </a>
    </div>

    <div class="space-y-3">
        @forelse ($tasks as $task)
            <div id="task-row-{{ $task->id }}"
                 class="bg-white border border-slate-200 rounded-xl p-4 flex items-start justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <h2 id="task-title-{{ $task->id }}"
                            class="text-base font-semibold {{ $task->is_completed ? 'line-through text-slate-400' : 'text-slate-900' }}">
                            {{ $task->title }}
                        </h2>

                        <span id="task-badge-{{ $task->id }}"
                              class="text-xs font-medium px-2.5 py-0.5 rounded-full {{ $task->is_completed ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $task->is_completed ? 'Completed' : 'Pending' }}
                        </span>
                    </div>

                    @if ($task->description)
                        <p class="text-sm text-slate-600">{{ $task->description }}</p>
                    @endif

                    @if ($task->due_date)
                        <p class="text-xs text-slate-400">
                            Due: {{ $task->due_date->format('M d, Y') }}
                        </p>
                    @endif
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <button type="button"
                            onclick="toggleTask({{ $task->id }}, this)"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                        {{ $task->is_completed ? 'Undo' : 'Complete' }}
                    </button>

                    <a href="{{ route('tasks.edit', $task) }}"
                       class="text-sm font-medium text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg transition">
                        Edit
                    </a>

                    <form action="{{ route('tasks.destroy', $task) }}"
                          method="POST"
                          onsubmit="return confirm('Delete this task?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-sm font-medium text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200 rounded-xl p-8 text-center">
                <p class="text-slate-600 font-medium">No tasks yet.</p>
                <p class="text-sm text-slate-400 mt-1">Click "+ New Task" to create your first task.</p>
            </div>
        @endforelse
    </div>

    <script>
        function toggleTask(id, btn) {
            axios.patch(`/api/tasks/${id}/toggle`, {}, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                const completed = Boolean(res.data.task.is_completed);
                const titleEl = document.getElementById(`task-title-${id}`);
                const badgeEl = document.getElementById(`task-badge-${id}`);

                btn.textContent = completed ? 'Undo' : 'Complete';

                if (titleEl) {
                    titleEl.classList.toggle('line-through', completed);
                    titleEl.classList.toggle('text-slate-400', completed);
                    titleEl.classList.toggle('text-slate-900', !completed);
                }

                if (badgeEl) {
                    badgeEl.textContent = completed ? 'Completed' : 'Pending';
                    badgeEl.className = completed
                        ? 'text-xs font-medium px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700'
                        : 'text-xs font-medium px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-700';
                }
            })
            .catch(() => {
                alert('Failed to update task status.');
            });
        }
    </script>
@endsection