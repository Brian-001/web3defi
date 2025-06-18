<?php

namespace App\Livewire;

use App\Models\Listing;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class ApplicantManagement extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'tailwind';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        
        $query = JobApplication::with([
            'listing' => function ($query) {
                $query->select('id', 'listing_title', 'user_id', 'listing_status');
            },
            'referrer' => function ($query) {
                $query->select('id', 'name'); // Load only necessary fields for referrer
            }
        ])
        ->select([
            'id',
            'listing_id',
            'name',
            'email',
            'github',
            'linkedin',
            'resume_path',
            'listing_status',
            'referred_by',
            'created_at'
        ])
        ->when($this->search, function ($query) {
            $searchTerm = '%' . $this->search . '%';
            $query->where('name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm)
                  ->orWhereHas('listing', function ($query) use ($searchTerm) {
                      $query->where('listing_title', 'like', $searchTerm);
                  });
        })
        ->whereHas('listing') // Ensure only applications with valid listings
        ->orderBy('created_at', 'desc');

        $applicants = $query->paginate(10);

        return view('livewire.applicant-management', compact('applicants'));
    }

}
