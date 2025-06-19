<?php

namespace App\Livewire;

use App\Models\Listing;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ApplicantManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $expandedListings = [];

    protected $paginationTheme = 'tailwind';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];

    public function updatingSearch()
    {
        $this->resetPage();
        $this->expandedListings = []; // Reset expanded listings when search is updated
    }

    //Toggle the expansion of a listing
    public function toggleListing($listingId)
    {
        if (in_array($listingId, $this->expandedListings)) {
            $this->expandedListings = array_diff($this->expandedListings, [$listingId]);
        } else {
            $this->expandedListings[] = $listingId;
        }
    }

    // Update application status
    public function updateStatus($applicationId, $newStatus)
    {
        $application = JobApplication::findOrFail($applicationId);
        $application->application_status = $newStatus;
        $application->save();

        \Log::info('Application ID ' . $applicationId . ' status updated to ' . $newStatus . ' by user ' . Auth::id());
        $this->dispatch('status-updated', ['message' => 'Status updated successfully']);
    }

    public function render()
    {
        // Fetch listings with application counts
        $listingsQuery = Listing::query()
            ->select('id', 'listing_title', 'listing_status')
            ->where('listing_status', 'active')
            ->withCount('jobApplications as applications_count')
            ->when($this->search, function ($query) {
                $searchTerm = '%' . $this->search . '%';
                $query->where('listing_title', 'like', $searchTerm);
            })
            ->orderBy('created_at', 'desc');

        $listings = $listingsQuery->paginate(10);

        // Fetch applications only for expanded listings
        $applications = [];
        if (!empty($this->expandedListings)) {
            $applications = JobApplication::query()
                ->with([
                    'listing' => fn($query) => $query->select('id', 'listing_title', 'listing_status'),
                    'referrer' => fn($query) => $query->select('id', 'name')
                ])
                ->select([
                    'id', 'listing_id', 'name', 'email', 'github', 'linkedin',
                    'resume_path', 'application_status', 'referred_by', 'created_at'
                ])
                ->whereIn('listing_id', $this->expandedListings)
                ->when($this->search, function ($query) {
                    $searchTerm = '%' . $this->search . '%';
                    $query->where('name', 'like', $searchTerm)
                          ->orWhere('email', 'like', $searchTerm);
                })
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('listing_id');
        }

        \Log::info('Rendering ApplicantManagement, Listings count: ' . $listings->count(), [
            'expanded_listings' => $this->expandedListings,
            'applications_count' => array_sum($listings->pluck('applications_count')->toArray())
        ]);

        return view('livewire.applicant-management', compact('listings', 'applications'));
    }

}
