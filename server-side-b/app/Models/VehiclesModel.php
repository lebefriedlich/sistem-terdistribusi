<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class VehiclesModel extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $guarded = ['id'];

    protected $fillable = [
        'category_id',
        'plate_number',
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->belongsTo(CategoriesModel::class, 'category_id', 'id');
    }
    
    public function rentals()
    {
        return $this->hasMany(RentalsModel::class, 'vehicle_id', 'id');
    }
}
