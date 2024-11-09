<?php

use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::prefix('listings')->group(function(){
    // Display all Listing
    Route::get('/', [ListingController::class, 'index'])->name('listings.index');

    //Show form to create new listing
    Route::get('/create', [ListingController::class, 'create'])->name('listings.create');

    //Store new listing in db
    Route::post('/store', [ListingController::class, 'store'])->name('listings.store');

    //Show a specific listing
    Route::get('/{id}', [ListingController::class, 'show'])->name('listings.show');

    //Show form to edit specific listing
    Route::get('/{id}/edit', [ListingController::class, 'edit'])->name('listings.edit');

    //update specific listing
    Route::put('/{id}', [ListingController::class, 'update'])->name('listing.update');

    //Delete specific listing
    Route::delete('/{id}', [ListingController::class, 'destroy'])->name('listings.destroy');
});