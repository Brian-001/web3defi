<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class ApplicantManagement extends Component
{
    use WithPagination;

    public $search = '';

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
        $query = JobApplication::with(['listing' => function($query){
            $query->select('id', 'listing_title', 'user_id', 'listing_status');
        }])
        ->select('id', 'listing_id', 'name', 'created_at', 'resume_path', 'status')
        ->when($this->search, function ($query) {
            $searchTerm = '%' . $this->search . '%';
            $query->where('name', 'like', $searchTerm)
            ->orWhere('email', 'like', $searchTerm)
            ->orWhereHas('listing', function ($query) use ($searchTerm){
                $query->where('listing_title', 'like', $searchTerm);
            });
        });

        $applicants = $query->paginate(10);

        return view('livewire.applicant-management', compact('applicants'));
    }
}
