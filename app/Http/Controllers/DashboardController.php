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

        //Listings per day line chart
        $listingsPerDay = Listing::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subDays(7)) // Last 7 days
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->pluck('count', 'date');

        //List per week line chart
        $listingsPerWeek = Listing::select(
            DB::raw("strftime('%Y%W', created_at) as week"),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subWeeks(4))// Last 4 weeks
        ->groupBy('week')
        ->orderBy('week', 'asc')
        ->pluck('count', 'week');
        return view('dashboard.index', [
            'userStats' => $userStats,
            'listingsPerDay' => $listingsPerDay,
            'listingsPerWeek' => $listingsPerWeek,
        ]);
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
