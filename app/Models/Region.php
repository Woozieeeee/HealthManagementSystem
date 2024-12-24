<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'location'];

    /**
     * Get the users associated with the region.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the referrals associated with the region.
     */
    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }

    /**
     * Get the appointments associated with the region.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
