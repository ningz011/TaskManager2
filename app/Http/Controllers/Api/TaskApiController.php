<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;

class TaskApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'tasks' => auth()->user()->tasks()->latest()->get(),
        ]);
    }

    public function toggle(Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);

        $task->update([
            'is_completed' => ! $task->is_completed,
        ]);

        return response()->json([
            'task' => $task->fresh(),
        ]);
    }
}