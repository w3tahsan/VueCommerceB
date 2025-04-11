<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Frontend
Route::get('/', [HomeController::class, 'welcome']);

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Users
Route::get('/edit/profile', [UserController::class, 'edit_profile'])->name('edit.profile');
Route::post('/update/profile', [UserController::class, 'update_profile'])->name('update.profile');
Route::post('/update/password', [UserController::class, 'update_password'])->name('update.password');
Route::post('/update/photo', [UserController::class, 'update_photo'])->name('update.photo');

//Category
Route::get('/add/category', [CategoryController::class, 'add_category'])->name('add.category');
Route::post('/category/store', [CategoryController::class, 'category_store'])->name('category.store');
Route::get('/category/delete/{id}', [CategoryController::class, 'category_delete'])->name('category.delete');
Route::get('/category/edit/{id}', [CategoryController::class, 'category_edit'])->name('category.edit');
Route::post('/category/update/{id}', [CategoryController::class, 'category_update'])->name('category.update');
Route::get('/category/restore/{id}', [CategoryController::class, 'category_restore'])->name('category.restore');
Route::get('/category/pdelete/{id}', [CategoryController::class, 'category_pdelete'])->name('category.pdelete');
Route::get('/category/trash', [CategoryController::class, 'trash'])->name('trash');
Route::post('/delete/checked', [CategoryController::class, 'delete_checked'])->name('delete.checked');
Route::post('/checked/action', [CategoryController::class, 'checked_action'])->name('checked.action');

//subcategory
Route::get('/subcategory', [SubcategoryController::class, 'subcategory'])->name('subcategory');
Route::post('/subcategory/store', [SubcategoryController::class, 'subcategory_store'])->name('subcategory.store');

//Tags
Route::get('/tags', [TagController::class, 'tags'])->name('tags');
Route::post('/tags/store', [TagController::class, 'tags_store'])->name('tags.store');

//Product
Route::get('/add/product', [ProductController::class, 'add_product'])->name('add.product');
Route::post('/store/product', [ProductController::class, 'store_product'])->name('store.product');
Route::get('/list/product', [ProductController::class, 'product_list'])->name('product.list');
Route::get('/add/variation', [ProductController::class, 'add_variation'])->name('add.variation');
Route::post('/add/color', [ProductController::class, 'add_color'])->name('add.color');
Route::post('/add/size', [ProductController::class, 'add_size'])->name('add.size');
Route::get('/inventory/{id}', [ProductController::class, 'inventory'])->name('inventory');
Route::post('/inventory/store/{id}', [ProductController::class, 'inventory_store'])->name('inventory.store');
Route::get('/inventory/del/{id}', [ProductController::class, 'del_inventory'])->name('del.inventory');