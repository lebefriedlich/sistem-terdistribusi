<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RentalsModel extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'rentals';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $guarded = ['id'];

    protected $fillable = [
        'customer_id',
        'vehicle_id',
        'start_date',
        'end_date',
        'total_price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function customer()
    {
        return $this->belongsTo(CustomersModel::class, 'customer_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(VehiclesModel::class, 'vehicle_id', 'id');
    }
}
