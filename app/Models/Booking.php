<?php
// app/Models/Booking.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'room_id',
        'rent_type',   // or rent_type, depending on your schema
        'length_stay',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'notes',
    ];

    /**
     * A booking belongs to a tenant.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * A booking belongs to a room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    
}
