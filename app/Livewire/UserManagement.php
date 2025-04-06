<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;

use function PHPSTORM_META\type;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $statuses = ['active', 'suspended', 'pending'];
    public $roles;
    public $selectedRole = [];
    public $selectedStatus = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1] 
    ];

    public function mount()
    {
        $this->roles = Cache::remember('role_list', 1440, function() {
            return Role::all();
        });
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateRole($userId)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'role_id' => Role::where('name', $this->selectedRole[$userId])->first()->id
        ]);

        $this->dispatch('notify',
            type: 'success',
            message: 'User role updated successfully!' 
        );
    }

    public function updateStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'user_status' => $this->selectedStatus[$userId]
        ]);

        $this->dispatch('notify',
            type: 'success',
            message: 'User status updated successfully!'
        );
    }

    public function render()
    {
        $users = User::with('role')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhereHas('role', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(10);

        //Initialize selected values
        foreach($users as $user){
            if(!isset($this->selectedRole[$user->id])) {
                $this->selectedRole[$user->id] = $user->role->name;
            }
            if (!isset($this->selectedStatus[$user->id])) {
                $this->selectedStatus[$user->id] = $user->user_status;
            }
        }
        
        return view('livewire.user-management', [
            'users' => $users,
        ]);
    }
}
