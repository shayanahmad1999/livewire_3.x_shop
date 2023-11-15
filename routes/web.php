<?php

use App\Livewire\Customer;
use App\Livewire\Order;
use App\Livewire\OrderItem;
use App\Livewire\Payment;
use App\Livewire\PaymentEdit;
use App\Livewire\PaymentForm;
use App\Livewire\Product;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
   Route::get('/customer', Customer::class)->name('customer');
   Route::get('/product', Product::class)->name('product');
   Route::get('/order', Order::class)->name('order');
   Route::get('/order-item', OrderItem::class)->name('orderItem');
   Route::get('/payment', Payment::class)->name('payment');
   Route::get('/payment-create', PaymentForm::class)->name('paymentForm');
   Route::get('/payment-edit/{id}', PaymentEdit::class)->name('paymentEdit');
}); 
