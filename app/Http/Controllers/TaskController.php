<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        try {

            //Obtener las tareas del usuario logueado
            $tasks = Task::where('user_id', auth()->user()->id)->get();

            if ($tasks->isEmpty()) {
                return response()->json(['message' => 'No data'], 404);
            }

            return response()->json(['data' => $tasks]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Fatal error', 'error' => $th->getMessage()], 500);
        }
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $taskCreated = Task::create($request->validated());

        return response()->json(['data' => $taskCreated], 201);
    }

    public function show(Task $task): JsonResponse
    {
        $task->load('user');

        return response()->json($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        try {
            $task->update($request->validated());

            return response()->json(['message' => 'Task updated satisfully', "data" => $task]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Fatal error', 'error' => $th->getMessage()], 500);
        }
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted satisfully'], 204);
    }
}
