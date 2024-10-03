<?php

use App\Livewire\Test;
use App\Livewire\Course;
use App\Livewire\CreatePost;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\SendRequestController;
use App\Http\Controllers\Front\ExpenseController;
use App\Http\Controllers\Admin\AdminExpenseController;


//front
Route::controller(ExpenseController::class)->group(function (){
    Route::get('/expenses-create','create')->name('expenses.index');
    Route::post('/expenses', 'store')->name('expenses.store');
    Route::get('/my-expenses', 'myExpenses')->name('expenses.myExpenses');
    Route::post('pay-expense/{expense}','processPayment')->name('expenses.processPayment');
    Route::get('/schedule-payments/{expense}','schedulePayments')->name('expenses.schedule-payments');
});


//admin
Route::prefix('admin')->group(function (){

    Route::get('/',[\App\Http\Controllers\Admin\HomeController::class,'index'])->name('admin.home');

    Route::prefix('expense')->controller(AdminExpenseController::class)->group(function (){
        Route::get('/','index')->name('admin.expenses.index');

        Route::get('/expense/show/{expense}','create')->name('admin.expenses.show');

        Route::get('/expense/{expense}','show')->name('admin.expenses.show');

        Route::post('/expense/status/{expense}','status')->name('admin.expenses.status');

        Route::delete('expense/{expense}','destroy')->name('admin.expenses.destroy');

        Route::post('expense/reason_for_not_approved/{expense}','rejectReason')->name('admin.expenses.reject-reason');

        Route::delete('expense-delete/{expense}','destroy')->name('admin.expense.destroy');


//        Route::post('/expense/{expense}/process-payment','processPayment')->name('admin.expenses.processPayment');
    });

    Route::prefix('category')->controller(\App\Http\Controllers\Admin\CategoryController::class)->group(function (){
        Route::get('/','index')->name('admin.category.index');

        Route::get('/category/create','create')->name('admin.category.create');

        Route::post('/category','store')->name('admin.category.store');

        Route::get('/category-edit/{category}','edit')->name('admin.category.edit');

        Route::put('/category-update/{category}','update')->name('admin.category.update');

        Route::get('/status/{category}','status')->name('admin.category.status');

        Route::delete('category-delete/{category}','destroy')->name('admin.category.destroy');

    });
});
