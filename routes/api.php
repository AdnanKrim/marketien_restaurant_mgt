<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Menu\CategoryController;
use App\Http\Controllers\Menu\SubcategoryController;
use App\Http\Controllers\Menu\FoodItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EmployeeController;
use App\Models\FoodItem;
use Whoops\RunInterface;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     // return $request->user();
//     //Category Api
    
// });
Route::group(['middleware' => 'auth:sanctum'], function(){
    //Category Api
    Route::get('/category-list',[CategoryController::class,'getCategoryApi'])->name('category-list');
    Route::post('/add-category',[CategoryController::class,'addCategoryApi'])->name('add-category');
    Route::delete('/category-delete/{id}',[CategoryController::class,'categoryDeleteApi'])->name('category-delete-api');
    Route::get('/category-edit/{id}',[CategoryController::class,'editCategoryFormApi'])->name('category-edit-information');
    Route::post('/category-update',[CategoryController::class,'updateCategoryApi'])->name('category-update-api');
    
    //Sub Category Api
    Route::get('/sub-category-list',[SubcategoryController::class,'getSubCategoryApi'])->name('sub-category-list');
    Route::post('/add-sub-category',[SubcategoryController::class,'addSubCategoryApi'])->name('add-sub-category');
    Route::delete('/sub-category-delete/{id}',[SubcategoryController::class,'subCategoryDeleteApi'])->name('sub-category-delete-api');
    Route::get('/sub-category-edit/{id}',[SubcategoryController::class,'editSubCategoryFormApi'])->name('sub-category-edit-information');
    Route::post('/sub-category-update',[SubcategoryController::class,'updateSubCategoryApi'])->name('sub-category-update-api');
    // FoodItem api
    Route::get('/get-sub-category/{id}',[FoodItemController::class,'getSubcategoryId'])->name('get-sub-category');
    Route::post('/add-food-item',[FoodItemController::class,'addFoodItemApi'])->name('add-food-item');
    Route::get('/food-item-list',[FoodItemController::class,'getFoodItemApi'])->name('food-item-list');
    Route::post('/food-item-update',[FoodItemController::class,'updateFoodItemApi'])->name('food-item-update');
    Route::get('/food-item-edit/{id}',[FoodItemController::class,'editFoodItemFormApi'])->name('food-item-edit-information');
    Route::delete('/food-item-delete/{id}',[FoodItemController::class,'foodItemDeleteApi'])->name('food-item-delete-api');

    // Employee api
    Route::post('/add-employee',[EmployeeController::class,'addEmployeeApi'])->name('add-employee');
    Route::get('/employee-list',[EmployeeController::class,'employeeListApi'])->name('employee-list');
    Route::post('/employee-update',[EmployeeController::class,'updateEmployeeApi'])->name('employee-update');
    Route::get('/employee-detail/{id}',[EmployeeController::class,'adminEmployeeDetailApi'])->name('employee-detail-information');
    Route::get('/employee-edit/{id}',[EmployeeController::class,'editEmployeeFormApi'])->name('employee-edit-information');
    Route::delete('/employee-delete/{id}',[EmployeeController::class,'employeeDeleteApi'])->name('employee-delete-api');

});

Route::post("login",[UserController::class,'adminLogin']);
Route::get('/get-ip',[EmployeeController::class,'getIp']);
Route::get('/get-dropdown',[FoodItemController::class,'getDropdownApi']);
Route::post('/add-to-cart',[CartController::class,'addToCart']);
Route::get('/cart-item',[CartController::class,'getCartApi']);