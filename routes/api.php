<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Menu\CategoryController;
use App\Http\Controllers\Menu\SubcategoryController;
use App\Http\Controllers\Menu\FoodItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReserveController;
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
Route::group(['middleware' => 'auth:sanctum'], function () {
    //Category Api
    Route::get('/category-list', [CategoryController::class, 'getCategoryApi'])->name('category-list');
    Route::post('/add-category', [CategoryController::class, 'addCategoryApi'])->name('add-category');
    Route::delete('/category-delete/{id}', [CategoryController::class, 'categoryDeleteApi'])->name('category-delete-api');
    Route::get('/category-edit/{id}', [CategoryController::class, 'editCategoryFormApi'])->name('category-edit-information');
    Route::post('/category-update', [CategoryController::class, 'updateCategoryApi'])->name('category-update-api');

    //Sub Category Api
    Route::get('/sub-category-list', [SubcategoryController::class, 'getSubCategoryApi'])->name('sub-category-list');
    Route::post('/add-sub-category', [SubcategoryController::class, 'addSubCategoryApi'])->name('add-sub-category');
    Route::delete('/sub-category-delete/{id}', [SubcategoryController::class, 'subCategoryDeleteApi'])->name('sub-category-delete-api');
    Route::get('/sub-category-edit/{id}', [SubcategoryController::class, 'editSubCategoryFormApi'])->name('sub-category-edit-information');
    Route::post('/sub-category-update', [SubcategoryController::class, 'updateSubCategoryApi'])->name('sub-category-update-api');
    // FoodItem api
    Route::get('/get-sub-category/{id}', [FoodItemController::class, 'getSubcategoryId'])->name('get-sub-category');
    Route::get('/get-dropdown', [FoodItemController::class, 'getDropdownApi']);
    Route::post('/add-food-item', [FoodItemController::class, 'addFoodItemApi'])->name('add-food-item');

    Route::post('/food-item-update', [FoodItemController::class, 'updateFoodItemApi'])->name('food-item-update');
    Route::get('/food-item-edit/{id}', [FoodItemController::class, 'editFoodItemFormApi'])->name('food-item-edit-information');
    Route::delete('/food-item-delete/{id}', [FoodItemController::class, 'foodItemDeleteApi'])->name('food-item-delete-api');

    // Employee api
    Route::post('/add-employee', [EmployeeController::class, 'addEmployeeApi'])->name('add-employee');
    Route::get('/employee-list', [EmployeeController::class, 'employeeListApi'])->name('employee-list');
    Route::post('/employee-update', [EmployeeController::class, 'updateEmployeeApi'])->name('employee-update');
    Route::get('/employee-detail/{id}', [EmployeeController::class, 'adminEmployeeDetailApi'])->name('employee-detail-information');
    Route::get('/employee-edit/{id}', [EmployeeController::class, 'editEmployeeFormApi'])->name('employee-edit-information');
    Route::delete('/employee-delete/{id}', [EmployeeController::class, 'employeeDeleteApi'])->name('employee-delete-api');
    //order
    Route::get('/order-list', [OrderController::class, 'getOrderListApi'])->name('order-list');
    Route::get('/order-detail/{id}', [OrderController::class, 'orderDetails'])->name('order-detail');
    Route::get('/order-stage-approve/{id}', [OrderController::class, 'orderStageApproved'])->name('order-stage-approve');
    Route::get('/order-stage-way/{id}', [OrderController::class, 'orderStageOnTheWay'])->name('order-stage-way');
    //Reservation

    Route::get('/reservation-list', [ReserveController::class, 'getReserveListApi'])->name('reservation-list');
    Route::get('/reservation-approve/{id}', [ReserveController::class, 'reservationApproved'])->name('reservation-approve');
    Route::delete('/reservation-delete/{id}', [ReserveController::class, 'reservationDeleteApi'])->name('reservation-delete');

});

Route::post("login", [UserController::class, 'adminLogin']);
// Route::get('/get-ip',[EmployeeController::class,'getIp']);
//Add to Cart
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('/cart-item', [CartController::class, 'getCartApi'])->name('cart-item');
Route::delete('/food-cart-delete/{id}', [CartController::class, 'foodCartDeleteApi'])->name('food-cart-delete-api');
//Menu
Route::get('/food-item-list', [FoodItemController::class, 'getFoodItemApi'])->name('food-item-list');
//Order
Route::post('/add-order', [OrderController::class, 'addOrderApi'])->name('add-order');
Route::get('/user-order-list', [OrderController::class, 'userOrderTracking'])->name('user-order-list');
Route::get('/user-order-detail/{id}', [OrderController::class, 'userOrderDetail'])->name('user-order-detail');
//Reservation
Route::post('/add-reservation', [ReserveController::class, 'addReservationApi'])->name('add-reservation');




