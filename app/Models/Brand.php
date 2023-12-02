<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    public function scopeFilter($query,array $filters){
        // if($filters['tag'] ?? false){
        //     $query->where('tags','like','%' . request('tag') . '%');
        // }

        if($filters['search'] ?? false){
            $query->where('name','like','%' . request('search') . '%');
        }
    }

    // Relationship With Materials
    public function materials(){
        return $this->hasMany(Material::class,'brand');
    }

}
