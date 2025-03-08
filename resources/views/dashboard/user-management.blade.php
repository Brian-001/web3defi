@extends('layouts.dashboard')

@section('title', 'User Management')
@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Welcome to user management</h2>
    <div class="mx-auto my-4">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-300">
                    <th class="py-2 px-4 text-left">Name</th>
                    <th class="py-2 px-4 text-left">Email</th>
                    <th class="py-2 px-4 text-left">Role</th>
                    <th class="py-2 px-4 text-left">Action</th>
                    <th class="py-2 px-4 text-left">Status</th>
                    <th class="py-2 px-4 text-left">Created At</th>
                    <th class="py-2 px-4 text-left">Updated At</th>
                </tr>
            </thead>
            <tbody>
                
                <tr class="border-b border-gray-200">
                    <td class="py-2 px-4">John Doe</td>
                    <td class="py-2 px-4">john.doe@example.com</td>
                    <td class="py-2 px-4">Admin</td>
                    <td class="py-2 px-4">Edit</td>
                    <td class="py-2 px-4">Active</td>
                    <td class="py-2 px-4">2021-01-01 12:00:00</td>
                    <td class="py-2 px-4">2021-01-01 12:00:00</td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>
@endsection
