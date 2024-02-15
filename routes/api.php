<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Category Routes
Route::get('/categories', [CategoryController::class, 'index']); // Retrieve all categories with dynamic search by name and description
Route::get('/categories/{id}', [CategoryController::class, 'show']); // Retrieve a single category by ID
Route::post('/categories', [CategoryController::class, 'store']); // Create a new category
Route::put('/categories/{id}', [CategoryController::class, 'update']); // Update an existing category by ID
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']); // Delete a category by ID

// Item Routes
Route::get('/items', [ItemController::class, 'index']); // Retrieve all items with dynamic search by name and description
Route::get('/items/categories', [ItemController::class, 'getItemsWithCategories']); // Retrieve all items with category details
Route::get('/items/{id}', [ItemController::class, 'show']); // Retrieve a single item by ID
Route::post('/items', [ItemController::class, 'store']); // Create a new item
Route::put('/items/{id}', [ItemController::class, 'update']); // Update an existing item by ID
Route::delete('/items/{id}', [ItemController::class, 'destroy']); // Delete an item by ID

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
