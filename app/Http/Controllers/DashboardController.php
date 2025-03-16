<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\User;
use App\Models\Listing;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        //Job type pie chart
        $listingsByJobType = Listing::select(
            'job_type',
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('job_type')
        ->pluck('count', 'job_type');

        return view('dashboard.index', [
            'userStats' => $userStats,
            'listingsPerDay' => $listingsPerDay,
            'listingsPerWeek' => $listingsPerWeek,
            'listingsByJobType' => $listingsByJobType,
        ]);  
    }

    public function getUsersManagementData()
    {
        // $users = User::all();
        //Fetch users with role name
        $users = User::select('users.id', 'users.name', 'users.email', 'users.user_status', 'roles.name as role_name', 'users.created_at', 'users.updated_at')
        ->join('roles', 'users.role_id', '=', 'roles.id')
        ->get();

        //Available status for the dropdown
        $statuses = ['Active', 'Suspended', 'Pending'];

        //Fetch available roles from roles table
        $roles = Role::pluck('name')->all();

        return view('dashboard.user-management', compact('users', 'statuses', 'roles'));
    }

    public function updateUserStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'user_status' => 'required|in:Active,Suspended,Pending',
        ]);
        $user->update(['user_status' =>$request->user_status]);

        notify()->success('User status updated successfully');

        return redirect()->route('dashboard.user-management');
    }

    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);
        $user->update(['role_id' => $request->role_id]);

        notify()->success('User role updated successfully');

        return redirect()->route('dashboard.user-management');
    }

    public function getJobsManagementData()
    {
        $listings = Listing::select(
            'listings.id',
            'listings.listing_title',
            'users.name as posted_by',
            'listings.job_type as listing_type',
            'listings.created_at',
            'listings.listing_status'
        )

        ->join('users', 'listings.user_id', '=', 'users.id')
        ->where('listings.user_id', Auth::user()->id)
        ->get();


        $statuses = ['active', 'closed']; //for the dropdown
        return view('dashboard.job-management', compact('listings', 'statuses'));
    }

    //Add method to update listing status
    public function updateListingStatus(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);
        $request->validate([
            'listing_status' => 'required|in:active,closed',
        ]);
        $listing->update(['listing_status' => $request->listing_status]);

        notify()->success('Listing status updated successfully');

        return redirect()->route('dashboard.job-management');
    }

    public function getSingleListing(Listing $listing){

        //Load the listing with its associated job applications
        $listing = Listing::with('jobApplications')->findOrFail($listing->id);

        //Restrict access to the listing if it's not associated with the current user and remove if user is admin
        if (Auth::user()->role_id === 2 && $listing->user_id !== Auth::user()->id) { 
            abort(403, 'You can only view your own listings.');
        }
        return view('dashboard.single-listing', compact('listing'));
    }
    public function getApplicantsManagementData()
    {
        
        // $applicants = JobApplication::select(
        //     'job_applications.id',
        //     'job_applications.name',
        //     'job_applications.email',
        //     'job_applications.resume_path',
        //     'job_applications.created_at',
        //     'listings.listing_title'
        // )
        // ->join('listings', 'job_applications.listing_id', '=', 'listings.id')
        // ->get();
        $applicants = JobApplication::with('listing')
        ->whereHas('listing', function ($query){
            $query->where('user_id', Auth::user()->id);
        })
        ->get();
        
        return view('dashboard.applicant-management', compact('applicants'));
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
