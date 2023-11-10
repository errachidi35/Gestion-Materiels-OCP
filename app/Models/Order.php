<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $table = 'orders';

    public $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'client_name',
        'client_email',
        'created_at',
        'updated_at',
    ];

    public function materials()
    {
        return $this->belongsToMany(Material::class)->withPivot(['quantity']);
    }
}
