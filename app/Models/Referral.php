<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'barangay_id',
        'regional_id',
        'status',
        'details',
        // Add other fillable fields as necessary
    ];

    /**
     * Get the user who made the referral.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the barangay associated with the referral.
     */
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    /**
     * Get the region associated with the referral.
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the appointment associated with the referral.
     */
    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}