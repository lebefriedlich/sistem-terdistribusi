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

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
