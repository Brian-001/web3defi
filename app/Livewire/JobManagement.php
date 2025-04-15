<?php

namespace App\Livewire;

use App\Models\Listing;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class JobManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $statuses = ['active', 'closed'];
    public $selectedStatus = 'active';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateStatus($listingId)
    {
        $listing = Listing::findOrFail($listingId);
        $listing->update(['listing_status' =>$this->selectedStatus[$listingId]]);

        $this->dispatch('notify', 
        type: 'success',
        message: 'Job status updated successfully.'
    );
    }

    public function render()
    {
        $user = Auth::user();
        $query = Listing::with('user')
            ->select('id', 'listing_title', 'job_type', 'listing_status', 'user_id', 'created_at')
            ->when($this->search, function ($query) {
                $query->where('listing_title', 'like', '%' . $this->search . '%')
                    ->orWhere('job_type', 'like', '%' . $this->search . '%');
        });
        $listings = $query->paginate(10);

        // Initialize selected status values
        foreach ($listings as $listing) {
            if (!isset($this->selectedStatus[$listing->id])) {
                $this->selectedStatus[$listing->id] = $listing->listing_status;
            }
        }

        return view('livewire.job-management', compact('listings'));
    }
}
