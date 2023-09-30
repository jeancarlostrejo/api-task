<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    public const PRIORITY = ['high', 'medium', 'low'];
    public const STATUS = ['pending', 'in_progress', 'completed'];

    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'priority',
        'status',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
