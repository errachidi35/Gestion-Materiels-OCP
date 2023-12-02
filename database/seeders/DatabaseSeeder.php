<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Brand;
use App\Models\Listing;
use App\Models\Category;
use App\Models\Material;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(5)->create();

        $admin = User::factory()->create([
            'name' => 'admin',
            'email' =>'adminOCP@gmail.com',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);

        $brand = Brand::factory()->create([
            'user_id' => $admin->id,
            'name' => 'Dell',
            'state' => 1,
            'active' => 1
        ]);

        $category = Category::factory()->create([
            'user_id' => $admin->id,
            'name' => 'laptop',
            'state' => 1,
            'active' => 1
        ]);

        Material::create([
            'user_id' => $admin->id,
            'name' => 'Latitude', 
            'code' => 'A123DFTU',
            'brand' => $brand->id,
            'category' => $category->id,
            'quantity' => '100',
            'rate' => '1',
            'location' => 'Safi, MAR',
            'email' => 'email1@email.com',
            'website' => 'https://www.acme.com',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam minima et illo reprehenderit quas possimus voluptas repudiandae cum expedita, eveniet aliquid, quam illum quaerat consequatur! Expedita ab consectetur tenetur delensiti?'
        ]);


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
