<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CustomersModel extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function rentals()
    {
        return $this->hasMany(RentalsModel::class, 'customer_id', 'id');
    }
}
