<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            'post-listing',
            'edit-listing',
            'update-listing',
            'delete-listing',
            'apply-job',
            'edit-job-application',
            'delete-job-application',
            'view-job-applications',
            'view-users',
            'delete-users',
            'notify-users',
            'alert-employees',
        ];

        foreach($permissions as $permission)
        {
            Permission::create(['name' => $permission]);
        }
    }
}
