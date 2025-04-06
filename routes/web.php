<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Livewire\Counter;
use Livewire\Livewire;

// Update this route to use ListingController's index method
Route::get('/', [ListingController::class, 'index'])->name('home');

Route::prefix('listings')->group(function(){
    // Display all Listing
    Route::get('/', [ListingController::class, 'index'])->name('listings.index');

    // Show form to create new listing
    Route::get('/create', [ListingController::class, 'create'])->name('listings.create');

    // Store new listing in db
    Route::post('/store', [ListingController::class, 'store'])->name('listings.store');

    // Show a specific listing
    Route::get('/{listing}', [ListingController::class, 'show'])->name('listings.show');

    // Show form to edit specific listing
    Route::get('/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');

    // Update specific listing
    Route::put('/{listing}', [ListingController::class, 'update'])->name('listings.update');

    // Delete specific listing
    Route::delete('/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');
});

Route::prefix('tags')->group(function(){
    Route::get('/', [TagController::class, 'index'])->name('tags.index');

    // Show form to create new tag
    Route::get('/create', [TagController::class, 'create'])->name('tags.create');

    // Store new tag in db
    Route::post('/store', [TagController::class, 'store'])->name('tags.store');

    // Show a specific tag
    Route::get('/{tag}', [TagController::class, 'show'])->name('tags.show');

    // Show form to edit specific tag
    Route::get('/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');

    // Update specific tag
    Route::put('/{tag}', [TagController::class, 'update'])->name('tags.update');

    // Delete specific tag
    Route::delete('/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
});

// Job Application
Route::get('/apply/{listing}', [JobApplicationController::class, 'showJobApplicationForm'])->name('apply.form');
Route::post('/apply/{listing}', [JobApplicationController::class, 'submitApplication'])->name('apply.submit');

Route::middleware(['auth'])->group(function()
{
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/profile', [DashboardController::class, 'getProfile'])->name('dashboard.profile');
    Route::put('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
    Route::get('/dashboard/user-management', [DashboardController::class, 'getUsersManagementData'])->name('dashboard.user-management');
    
    Route::get('/dashboard/job-management', [DashboardController::class, 'getJobsManagementData'])->name('dashboard.job-management');
    Route::get('/dashboard/applicant-management', [DashboardController::class, 'getApplicantsManagementData'])->name('dashboard.applicant-management');
    Route::get('/dashboard/reports', [DashboardController::class, 'getReports'])->name('dashboard.reports');

    // Update listing status
    Route::patch('/listings/{id}/status', [DashboardController::class, 'updateListingStatus'])->name('dashboard.update-listing-status');
    
    //Display single listing associated with a specific applicant
    Route::get('/dashboard/single-listing/{applicant}', [DashboardController::class, 'getSingleListing'])->name('dashboard.single-listing');
});

//Livewire
Route::get('/counter', Counter::class);