<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    // protected $fillable = ['title','company','location','website','email','description','tags'];


    protected $fillable = ['name','rate','quantity', 'used_quantity', 'global_quantity'];

    protected static function booted()
    {
        static::saving(function ($materiel) {
            $materiel->global_quantity = $materiel->quantity + $materiel->used_quantity;
        });
    }

    public function scopeFilter($query,array $filters){
        // if($filters['tag'] ?? false){
        //     $query->where('tags','like','%' . request('tag') . '%');
        // }

        if($filters['search'] ?? false){
            $query->where('name','like','%' . request('search') . '%')
            ->orWhere('code','like','%' . request('search') . '%')
            ->orWhere('description','like','%' . request('search') . '%')
            ->orWhere('location','like','%' . request('search') . '%')
            ->orWhere('rate','like','%' . request('search') . '%')
            ->orWhere('quantity','like','%' . request('search') . '%')
            ->orWhere('used_quantity','like','%' . request('search') . '%');
            
            
            // Filter by brand name
            if ($filters['search'] ?? false) {
                //dd($filters['search']);
                $query->orWhereHas('brand', function ($query) use ($filters) {
                    $query->where('name', 'like', '%' . $filters['search'] . '%');
                });
            }
            // Filter by category name
            if ($filters['search'] ?? false) {
                $query->orWhereHas('category', function ($query) use ($filters) {
                    $query->where('name', 'like', '%' . $filters['search'] . '%');
                });
            }
        }
    }

    // Relationship to Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand');
    }

    // Relationship to Category
    public function category()
    {
        return $this->belongsTo(Category::class,'category');
    }

    // Relationship To Admin
    public function admin(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
