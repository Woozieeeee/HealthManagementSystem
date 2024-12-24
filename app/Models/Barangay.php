<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'location'];

    /**
     * Get the users associated with the barangay.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the referrals associated with the barangay.
     */
    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }

    /**
     * Get the appointments associated with the barangay.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}