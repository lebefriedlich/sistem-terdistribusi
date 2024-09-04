<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CategoriesModel extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'type',
        'image',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function vehicles()
    {
        return $this->hasMany(VehiclesModel::class, 'category_id', 'id');
    }
}
