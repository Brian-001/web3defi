<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;

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
    Route::get('/{id}', [TagController::class, 'show'])->name('tags.show');

    // Show form to edit specific tag
    Route::get('/{id}/edit', [TagController::class, 'edit'])->name('tags.edit');

    // Update specific tag
    Route::put('/{id}', [TagController::class, 'update'])->name('tags.update');

    // Delete specific tag
    Route::delete('/{id}', [TagController::class, 'destroy'])->name('tags.destroy');
});

// Job Application
Route::get('/apply/{listing}', [JobApplicationController::class, 'showJobApplicationForm'])->name('apply.form');
Route::post('/apply/{listing}', [JobApplicationController::class, 'submitApplication'])->name('apply.submit');

// Route::get('/dashboard', function () {
//     return view('dashboard.index');
// })->name('dashboard.index');

// Route::get('/dashboard/profile', function () {
//     return view('dashboard.profile');
// })->name('dashboard.profile');

// Route::get('/dashboard/settings', function () {
//     return view('dashboard.settings');
// })->name('dashboard.settings');

// Route::get('/dashboard/user-management', function () {
//     return view('dashboard.user-management');
// })->name('dashboard.user-management');

// Route::get('/dashboard/job-management', function () {
//     return view('dashboard.job-management');
// })->name('dashboard.job-management');

// Route::get('/dashboard/applicant-management', function () {
//     return view('dashboard.applicant-management');
// })->name('dashboard.applicant-management');

// Route::get('/dashboard/reports', function () {
//     return view('dashboard.reports');
// })->name('dashboard.reports');

Route::prefix('dashboard')->group(function()
{
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/profile', [DashboardController::class, 'getProfile'])->name('dashboard.profile');
    Route::get('/settings', [DashboardController::class, 'getSetting'])->name('dashboard.settings');
    Route::get('/user-management', [DashboardController::class, 'getUsersManagementData'])->name('dashboard.user-management');
    Route::get('/job-management', [DashboardController::class, 'getJobsManagementData'])->name('dashboard.job-management');
    Route::get('/applicant-management', [DashboardController::class, 'getApplicantsManagementData'])->name('dashboard.applicant-management');
    Route::get('/reports', [DashboardController::class, 'getReports'])->name('dashboard.reports');

});