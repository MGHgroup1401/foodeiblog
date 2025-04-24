<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('/',[HomeController::class,'index'])->name('dashbord');
    
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/show/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/update/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/destroy/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });
});