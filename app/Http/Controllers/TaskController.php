<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {

            $title = $request->query('title');
            $description = $request->query('description');
            //Obtener las tareas del usuario logueado, buscando por titulo
            

            $tasks = Task::where('user_id', auth()->user()->id)->where(function ($query) use ($title, $description) {
                if ($title) {
                    $query->where('title', 'like', '%' . $title . '%');
                }
                if ($description) {
                    $query->where('description', 'like', '%' . $description . '%');
                }

            })->get();

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
        $newTask = new Task;

        $newTask->fill($request->validated());

        $newTask->user_id = auth()->user()->id;
        $newTask->save();

        return response()->json(['data' => $newTask], 201);
    }

    public function show($id): JsonResponse
    {

        $task = Task::where('id', $id)->where('user_id', auth()->user()->id)->first();

        if (!$task) {
            return response()->json(['message' => 'Task Not Found'], 404);
        }

        $task->load('user');
        return response()->json($task);
    }

    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {
        try {

            $task = Task::where('id', $id)->where('user_id', auth()->user()->id)->first();

            if (!$task) {
                return response()->json(['message' => 'Task Not Found'], 404);
            }

            $task->fill($request->validated());
            $task->save();

            return response()->json(['message' => 'Task updated satisfully', "data" => $task]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Fatal error', 'error' => $th->getMessage()], 500);
        }
    }

    public function destroy($id): JsonResponse
    {

        $task = Task::where('id', $id)->where('user_id', auth()->user()->id)->first();

        if (!$task) {
            return response()->json(['message' => 'Task Not Found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted satisfully'], 204);
    }
}
