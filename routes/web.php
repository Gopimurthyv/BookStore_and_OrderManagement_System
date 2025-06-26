<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('book')->group(function(){
    Route::get('/',[BookController::class, 'index'])->name('book.index');
    Route::get('/create',[BookController::class, 'create'])->name('book.create');
    Route::post('/store',[BookController::class, 'store'])->name('book.store');
    Route::get('/edit/{id}',[BookController::class, 'edit'])->name('book.edit');
    Route::put('/update/{id}',[BookController::class, 'update'])->name('book.update');
    Route::get('/delete/{id}',[BookController::class, 'destroy'])->name('book.destroy');
    Route::get('/details/{id}',[BookController::class, 'show'])->name('book.details');

    Route::get('/stocks/{id}',[BookController::class, 'stockDetails'])->name('book.stock.detail');
    Route::get('/supplier/{id}',[BookController::class, 'supplier'])->name('book.supplier');
    Route::get('/supplier-filter',[BookController::class, 'supplierFilter'])->name('book.supplier.filter');

    Route::get('/trash',[BookController::class, 'trash'])->name('book.trash');
    Route::get('/restore/{id}',[BookController::class, 'restore'])->name('book.restore');
    Route::get('/permanent-delete/{id}',[BookController::class, 'forceDelete'])->name('book.forceDelete');

    Route::get('/list',[BookController::class, 'bookCategory'])->name('book.category');
    Route::get('/search',[BookController::class, 'bookSearch'])->name('book.search');
});

Route::get('/orders/create', [OrderController::class, 'create'])->name('order.create');
Route::post('/orders/store', [OrderController::class, 'store'])->name('order.store');
Route::get('/orders/list', [OrderController::class, 'index'])->name('order.index');

Route::get('/get-states/{countryId}',[BookController::class, 'getStates']);
