<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message',
        'is_user',
    ];

    /**
     * Get the user that sent the chat message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}