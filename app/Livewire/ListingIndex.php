<?php

namespace App\Livewire;

use App\Models\Listing;
use Livewire\Component;
use Livewire\WithPagination;

class ListingIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $page = 1;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function updatingSearch()
    {
        \Log::info('Search updated: ' . $this->search . ', Page: ' . $this->getPage());
        $this->resetPage();
    }

    public function updatingPage($page)
    {
        \Log::info('Page updated: ' . $page);
    }

    public function render()
    {
        try {
            $query = Listing::query()
                ->select('id', 'listing_title', 'job_description', 'salary', 'location', 'job_type', 'listing_logo', 'tags', 'created_at')
                ->when($this->search, function ($query) {
                    $searchTerm = '%' . $this->search . '%';
                    $query->where('listing_title', 'like', $searchTerm)
                          ->orWhere('job_type', 'like', $searchTerm)
                          ->orWhere('location', 'like', $searchTerm);
                })
                ->orderBy('created_at', 'desc');

            $listings = $query->paginate(6);
            \Log::info('Rendering ListingIndex with layout: components.layouts.app, Listings count: ' . $listings->count() . ', Page: ' . $this->getPage());

            return view('livewire.listing-index', compact('listings'))
                ->layout('components.layouts.app');
        } catch (\Exception $e) {
            \Log::error('Error rendering ListingIndex: ' . $e->getMessage());
            throw $e;
        }
    }
}