<?php

// app/Models/Tenant.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'tenant_type',
        'address',
    ];

    /**
     * A tenant can have many bookings.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
