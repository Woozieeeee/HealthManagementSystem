<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'referral_id',
        'user_id',
        'barangay_id',
        'regional_id',
        'appointment_date',
        'status',
        'fee',
        'payment_id',
        // Add other fillable fields as necessary
    ];

    /**
     * Get the referral associated with the appointment.
     */
    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }

    /**
     * Get the user associated with the appointment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the barangay associated with the appointment.
     */
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    /**
     * Get the region associated with the appointment.
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the payment associated with the appointment.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}