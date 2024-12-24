<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * (Optional if the table name follows Laravel's naming conventions)
     *
     * @var string
     */
    protected $table = 'user_settings';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'setting_key',
        'setting_value',
        'dark_mode', // Corrected to use underscores instead of hyphens
        'receive_email_notification',
        'language',
        // Add other fillable fields if necessary
    ];

    /**
     * Get the user associated with the setting.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
