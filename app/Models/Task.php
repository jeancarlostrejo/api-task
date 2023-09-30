<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class Task extends Model
{
    public const PRIORITY = ['high', 'medium', 'low'];
    public const STATUS = ['pending', 'in_progress', 'completed', 'cancelled'];

    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'priority',
        'status',
    ];

    protected $cast = [
        'deadline' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function searchByTitleOrDescription(Request $request)
    {
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

        })->orderBy('deadline', 'asc')->get();

        return $tasks;
    }
}
