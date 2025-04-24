<?php

namespace App\Livewire;

use App\Models\Tag;
use App\Models\Listing;
use Livewire\Component;
use Livewire\WithPagination;

class ListingIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Listing::with('tags')
            ->select('id', 'listing_title', 'job_description', 'salary', 'location', 'job_type', 'listing_logo', 'tags', 'created_at')
            ->when($this->search, function ($query) {
                $searchTerm = '%' . $this->search . '%';
                $query->where('listing_title', 'like', $searchTerm)
                      ->orWhere('job_type', 'like', $searchTerm)
                      ->orWhere('location', 'like', $searchTerm);
            });

        $listings = $query->paginate(9); // 9 for 3x3 grid
        $tags = Tag::all();

        return view('livewire.listing-index', compact('listings', 'tags'));
    }
}
