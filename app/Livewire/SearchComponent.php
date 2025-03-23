<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class SearchComponent extends Component
{
    use WithPagination;

    public $query = '';
    //Determines view's search logic is users, jobs etc
    public $searchType;
    protected $paginationTheme ='tailwind'; //eg. 'users, 'jobs', 'applicants

    public function mount($searchType)
    {
        $this->searchType = $searchType;
    }

    public function render()
    {
        $results = $this->performanceSearch();
        return view('livewire.search-component', [
            'results' => $results,
        ]);

        return view('livewire.search-component');
    }

    //Dynamiccaly calls method like searchUsers, searchJobs based on $searchType
    public function performSearch()
    {
        //Delegate the specific search logic based on $searchType
        $method = 'search' . ucfirst($this->searchType);
        if (method_exists($this, $method)){
            return $this->method();
        }
        throw new \Exception("Search method for '{$this->searchType}' not implemented.");
    }

    public function updatingQuery()
    {
        $this->resetPage();
    }
    
}
