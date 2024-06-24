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
use App\Http\Controllers\PressController;
use App\Http\Controllers\Menu\PackageController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\Menu\ReviewController;
use App\Models\FoodItem;
use App\Models\Package;
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
    Route::group(['middleware' => 'adminPanel'], function(){
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
    Route::get('/priority/{id}',[FoodItemController::class,'priority'])->name('priority');
    Route::get('/status/{id}',[FoodItemController::class,'status'])->name('status');

    // Employee api
    Route::post('/add-employee', [EmployeeController::class, 'addEmployeeApi'])->name('add-employee');
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
    Route::get('/approved-reservation-list', [ReserveController::class, 'getApprovedReserveListApi'])->name('approved-reservation-list');
    Route::get('/reservation-approve/{id}', [ReserveController::class, 'reservationApproved'])->name('reservation-approve');
    Route::get('/reservation-decline/{id}', [ReserveController::class, 'reservationDeclined'])->name('reservation-decline');
    Route::delete('/reservation-delete/{id}', [ReserveController::class, 'reservationDeleteApi'])->name('reservation-delete');
    //Press
    Route::post('/add-press', [PressController::class, 'addPressApi'])->name('add-press');

    Route::post('/press-update', [PressController::class, 'updatePressApi'])->name('press-update');
    Route::get('/press-edit/{id}', [PressController::class, 'editPressFormApi'])->name('press-edit-information');
    Route::delete('/press-delete/{id}', [PressController::class, 'pressDeleteApi'])->name('press-delete-api');
    //packages
    Route::get('/get-dropdown-food-item', [PackageController::class, 'getFoodItemDropdown'])->name('get-dropdown-food-item');
    Route::post('/add-package', [PackageController::class, 'addPackageApi'])->name('add-package');

    Route::delete('/package-delete/{id}', [PackageController::class, 'packageDeleteApi'])->name('package-delete-api');
    Route::get('/package-edit/{id}', [PackageController::class, 'editPackageFormApi'])->name('package-edit-information');
    Route::post('/package-update', [PackageController::class, 'updatePackageApi'])->name('package-update');
    //deliveryman
    Route::post('/add-delivery-man', [DeliveryController::class, 'addDeliveryManApi'])->name('add-delivery-man');
    Route::post('/create-delivery-panel', [DeliveryController::class, 'createDeliveryPanel'])->name('create-delivery-panel');
    Route::post('/assign-order', [DeliveryController::class, 'assignOrderApi'])->name('assign-order');
    Route::post('/delivery-man-update', [DeliveryController::class, 'updateDeliveryManApi'])->name('delivery-man-update');
    Route::get('/delivery-man-edit/{id}', [DeliveryController::class, 'editDeliveryManFormApi'])->name('delivery-man-edit-information');
    Route::get('/close-delivery-panel/{id}', [DeliveryController::class, 'closeDeliveryPanel'])->name('close-delivery-panel');
    Route::get('/delivery-man-info/{id}', [DeliveryController::class, 'getDeliveryManInfo'])->name('delivery-man-information');
    Route::delete('/delivery-man-delete/{id}', [DeliveryController::class, 'deliveryManDeleteApi'])->name('delivery-man-delete-api');
    Route::get('/delivery-man-list', [DeliveryController::class, 'deliveryManListApi'])->name('delivery-man-list');
    Route::get('/delivery-panel-list', [DeliveryController::class, 'allDeliveryPanelList'])->name('delivery-panel-list');
    Route::get('/order-delivery-list', [DeliveryController::class, 'getOrderDeliveryListApi'])->name('order-delivery-list');

    //logout

    Route::get('/admin-graph-first',[UserController::class,'getAdminGraphInfo'])->name('admin-graph-first');
    Route::get('/admin-order-graph',[UserController::class,'orderGraphInfo'])->name('order-graph');
});

Route::post('admin-logout',[UserController::class,'adminLogoutApi']);
    Route::group(['middleware' => 'deliveryPanel'], function(){
 //for delivery panel
 Route::get('/order-assign-list', [DeliveryController::class, 'deliveryAssignList'])->name('order-assign-list');
 Route::get('/order-stage-delivered/{id}', [OrderController::class, 'orderStageDelivered'])->name('order-stage-delivered');
    });
});

Route::post("login", [UserController::class, 'adminLogin']);

// Route::get('/get-ip',[EmployeeController::class,'getIp']);
//Add to Cart
Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('/cart-item', [CartController::class, 'getCartApi'])->name('cart-item');
Route::delete('/food-cart-delete/{id}', [CartController::class, 'foodCartDeleteApi'])->name('food-cart-delete-api');
Route::post('/add-review',[ReviewController::class,'getReview'])->name('add-review');
//Menu
Route::get('/food-item-list', [FoodItemController::class, 'getFoodItemApi'])->name('food-item-list');
//Order
Route::post('/add-order', [OrderController::class, 'addOrderApi'])->name('add-order');
Route::get('/user-order-list', [OrderController::class, 'userOrderTracking'])->name('user-order-list');
Route::get('/user-order-detail/{id}', [OrderController::class, 'userOrderDetail'])->name('user-order-detail');
//Reservation
Route::post('/add-reservation', [ReserveController::class, 'addReservationApi'])->name('add-reservation');
Route::get('user-reservation-info',[ReserveController::class,'userReserveInfoApi'])->name('user-reservation-info');
//employee
Route::get('/employee-list', [EmployeeController::class, 'employeeListApi'])->name('employee-list');
Route::get('/delivery-man-info/{id}', [DeliveryController::class, 'deliveryManInfo'])->name('delivery-man-info');
Route::get('/press-list', [PressController::class, 'pressListApi'])->name('press-list');
Route::get('/package-list', [PackageController::class, 'packageListApi'])->name('package-list');
Route::get('/package-item/{id}', [PackageController::class, 'getPackageItemApi'])->name('package-item');



