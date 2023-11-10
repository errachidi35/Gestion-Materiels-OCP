<?php

use App\Models\Category;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Common Resource Routes:
// index - Show all materials
// show - Show single material
// create - Show form to create new material
// store - Store new materials 
// edit - show form to edit material
// update - Update material
// destroy - Delete material

// All Materials
Route::get('/', [MaterialController::class, 'index']);


// Show Create Form Material
Route::get('/materials/create',[MaterialController::class, 'create'])->middleware('admin');

// Show Create Form Brand
Route::get('/brands/create',[BrandController::class, 'create'])->middleware('admin');

// Show Create Form Category
Route::get('/categories/create',[CategoryController::class, 'create'])->middleware('admin');

// Store Material Data
Route::post('/materials',[MaterialController::class, 'store'])->middleware('admin');

// Store Brand Data
Route::post('/brands',[BrandController::class, 'store'])->middleware('admin');

// Store Category Data
Route::post('/categories',[CategoryController::class, 'store'])->middleware('admin');

// Show Edit Form Material
Route::get('/materials/{material}/edit',[MaterialController::class, 'edit'])->middleware('admin');

// Show Edit Form Brand
Route::get('/brands/{brand}/edit',[BrandController::class, 'edit'])->middleware('admin');

// Show Edit Form Category
Route::get('/categories/{category}/edit',[CategoryController::class, 'edit'])->middleware('admin');

// Edit Submit to Update Brand
Route::put('/brands/{brand}',[BrandController::class, 'update'])->middleware('admin');

// Edit Submit to Update Category
Route::put('/categories/{category}',[CategoryController::class, 'update'])->middleware('admin');

// Edit Submit to Update Material
Route::put('/materials/{material}',[MaterialController::class, 'update'])->middleware('admin');

// Delete Brand
Route::delete('/brands/{brand}',[BrandController::class, 'destroy'])->middleware('admin');

// Delete Category
Route::delete('/categories/{category}',[CategoryController::class, 'destroy'])->middleware('admin');

// Delete Material
Route::delete('/materials/{material}',[MaterialController::class, 'destroy'])->middleware('admin');

// Manage Materials
Route::get('/manage/material',[MaterialController::class,'manage'])->middleware('admin');

// Manage Brands
Route::get('/manage/brand',[BrandController::class,'manage'])->middleware('admin');

// Manage Categories
Route::get('/manage/category',[CategoryController::class,'manage'])->middleware('admin');

// Show Create Form Order
Route::get('/manage/orders/add',[OrderController::class,'create'])->middleware('admin');

// Store Order Data
Route::post('/manage/orders',[OrderController::class,'store'])->middleware('admin');

// Manage Orders
Route::get('/manage/orders/manage',[OrderController::class,'manage'])->middleware('admin');

// Show Edit Form Order
Route::get('/manage/orders/{order}/edit',[OrderController::class, 'edit'])->middleware('admin');

// Edit Submit to Update Order
Route::put('/manage/orders/{order}',[OrderController::class, 'update'])->middleware('admin');

// Delete Order
Route::delete('/manage/orders/{order}',[OrderController::class, 'destroy'])->middleware('admin');

// Single Material
Route::get('/materials/{material}', 
[MaterialController::class,'show']
);

// Show Register/Create Form
Route::get('/register',[UserController::class, 'create'])->middleware('guest');

// Create new user
Route::post('/users',[UserController::class, 'store']);

// Log User Out
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');

// Show Login Form 
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

// Login User
Route::post('/users/authenticate',[UserController::class,'authenticate']);


