<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Role::create(['name'=> 'Admin']);
        Role::create(['name' => 'Employer']);
        Role::create(['name' => 'Employee']);

        $admin = Role::where('name', 'Admin')->first();
        $admin->permissions()->sync(Permission::all());

        $employer = Role::where('name', 'Employer')->first();
        $employer->permissions()->sync(Permission::whereIn('name', ['post-listing', 'edit-listing', 'update-listing', 'delete-listing'])->get());


        $employee = Role::where('name', 'Employee')->first();
        $employee->permissions()->sync(Permission::whereIn('name', ['apply-job', 'edit-job-application', 'delete-job-application'])->get());
    }

    
}
