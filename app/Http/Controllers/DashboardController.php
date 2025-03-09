<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        //Users Bar chart
        $userStats = User::select('role_id', DB::raw('count(*) as total'))
        ->groupBy('role_id')
        ->get()
        ->mapWithKeys(function ($item){
            $roleName = match($item->role_id){
                1 => 'Admin',
                2 => 'Employer',
                3 => 'Employee',
            };
            return [$roleName => $item->total];
        });
        
        return view('dashboard.index', compact('userStats'));
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
