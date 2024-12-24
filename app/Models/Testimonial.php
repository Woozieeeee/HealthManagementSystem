<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * (Optional if the table name follows Laravel's naming conventions)
     *
     * @var string
     */
    protected $table = 'testimonials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'message',
        'rating',
        'approved', // Boolean to indicate if the testimonial is approved for display
        // Add other fillable fields if necessary
    ];

    /**
     * Get the user who submitted the testimonial.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}