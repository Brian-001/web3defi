<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    //
    public function index()
    {
        //Cache user stats for 10 minutes to reduce DB queries
        //Users Bar chart
        $userStats = Cache::remember('user_stats', 600, function() {
            return User::select('role_id', DB::raw('count(*) as total'))
            ->groupBy('role_id')
            ->pluck('total', 'role_id')
            ->mapWithKeys(function ($total, $roleId){
                return [match($roleId) {
                    1 => 'Admin',
                    2 => 'Employer',
                    3 => 'Employee',
                } => $total];
            });
        });

        //Cache listings per Day for 10 minutes
        $listingsPerDay = Cache::remember('listings_per_day', 600, function() {
            return Listing::select(
                DB::raw("DATE(created_at) as date"), 
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date') 
            ->orderBy('date', 'asc')
            ->pluck('count', 'date');
        });
        
        //Cache listings per week for 10 minutes
        $listingsPerWeek = Cache::remember('listings_per_week', 600, function() {
            return Listing::select(
                DB::raw("strftime('%Y-%W', created_at) as week"), // SQLite-compatible week format
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subWeeks(4))
            ->groupBy(DB::raw("strftime('%Y-%W', created_at)")) // Group by the same expression
            ->orderBy('week', 'asc')
            ->pluck('count', 'week');
        });


        //Job type pie chart
        //Cache job type stats for 10 minutes
        $listingsByJobType = Cache::remember('listings_by_job_type', 600, function() {
            return Listing::select('job_type', DB::raw('COUNT(*) as count'))
            ->groupBy('job_type')
            ->pluck('count', 'job_type');
        });


        return view('dashboard.index', compact('userStats', 'listingsPerDay', 'listingsPerWeek', 'listingsByJobType'));  
    }

    public function getUsersManagementData()
    {
        //Use Eloquent with relationship instead of join for cleaner code and eager loading
        $users = User::with('role')
        ->select('id', 'name', 'email', 'user_status', 'created_at', 'updated_at', 'role_id') // Specify columns explicitly
        ->paginate(10);

        //Available status for the dropdown
        $statuses = ['Active', 'Suspended', 'Pending'];

        //Fetch available roles from roles table
        $roles = Cache::remember('roles_list', 1440, function() { //Cache roles for 24 hours
            return Role::pluck('name')->all();
        });

        return view('dashboard.user-management', compact('users', 'statuses', 'roles'));
    }

    public function updateUserStatus(Request $request, $id)
    {
        //Use route model binding to fetch the user
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
        //Use route model binding
        $user = User::findOrFail($id);
        $request->validate([
            'role_name' => 'required|exists:roles,name', // validate by name intead of id
        ]);
        $role = Role::where('name', $request->role_name)->firstOrFail();
        $user->update(['role_id' => $role->id]);

        notify()->success('User role updated successfully');

        return redirect()->route('dashboard.user-management');
    }

    public function getJobsManagementData()
    {
        $user = Auth::user();
        $query = Listing::with('user') //Eager load user relationship
        ->select('id', 'listing_title', 'job_type', 'created_at', 'listing_status', 'user_id'); // Only needed columns
        
        if(!$user->hasRole('Admin')){
            $query->where('user_id', $user->id);
        }
        $listings = $query->paginate(10);
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

    public function getSingleListing(JobApplication $applicant, Listing $listing){

        $user = Auth::user();

        $listing = Listing::with(['jobApplications', 'user'])
        ->select('id', 'listing_title', 'user_id', 'job_type', 'listing_status', 'created_at') //Limit Columns
        ->findOrFail($applicant->listing_id);

        //Restrict Employers to their own listings and allow Admin to view all listings
        if (!$user->hasRole('Admin') && $listing->user_id  !==$user->id){
            abort(403, 'You can only view your own listings');
        }

        //Pass bot the listing and specific applicant to the view
        
        return view('dashboard.single-listing', compact('listing', 'applicant'));
    }
    public function getApplicantsManagementData()
    {
        $user = Auth::user();
        $query = JobApplication::with(['listing' => function($q){
            //Nested eager loading
            $q->select('id', 'listing_title', 'user_id', 'listing_status');
        }])
        ->select('id', 'listing_id', 'name', 'email', 'created_at'); //Limit job application columns
        
        if(!$user->hasRole('Admin')) {
            $query->whereHas('listing', function($subQuery) use ($user){
                $subQuery->where('user_id', $user->id);
            });
        }
        $applicants = $query->paginate(10);
        
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
