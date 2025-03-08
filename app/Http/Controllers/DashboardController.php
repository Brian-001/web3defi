<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return view('dashboard.index', compact('users'));
    }

    public function getUsersManagementData()
    {
        $users = User::all();
        return view('dashboard.user-management', compact('users'));
    }

    public function getJobsManagementData()
    {
        $listings =Listing::all();
        return view('dashboard.job-management', compact('listings'));
    }

    public function getApplicantsManagementData()
    {
        
        return view('dashboard.applicant-management');
    }

    public function getSetting()
    {
        return view('dashboard.settings');
    }

    public function getProfile()
    {
        return view('dashboard.profile');
    }

    public function getReport()
    {
        return view('dashboard.reports');
    }
}
