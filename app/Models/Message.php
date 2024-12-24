<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'read_at',
        // Add other fillable fields if necessary
    ];

    /**
     * Get the sender of the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * The attributes that  should be cast to native types(e.g., dates).
     * 
     * @var array
     */
    protected $casts = [
        'deteled_at' => 'datatime', 
        // Optional: Explicitly cast 'deleted_at
    ];

    /**
     * Get the sender of the message.
     */
    public function sender(){
        return $this->belongsTo(User::class, 'sender_id'); 
    }

    /**
     * Get the receiver of the message.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
