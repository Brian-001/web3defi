@extends('layouts.dashboard')

@section('title', 'Job Management')
@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Welcome to Job management</h2>
    <div class="mx-auto my-4">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-300">
                    <th class="py-2 px-4 text-left">Job Title</th>
                    <th class="py-2 px-4 text-left">Employer</th>
                    <th class="py-2 px-4 text-left">Category</th>
                    <th class="py-2 px-4 text-left">Posted Date</th>
                    <th class="py-2 px-4 text-left">Status</th>
                    <th class="py-2 px-4 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                
                <tr class="border-b border-gray-200">
                    <td class="py-2 px-4">Solana Developer</td>
                    <td class="py-2 px-4">Acme Inc.</td>
                    <td class="py-2 px-4">web3</td>
                    <td class="py-2 px-4">2021-01-01 12:00:00</td>
                    <td class="py-2 px-4">Active</td>
                    <td class="py-2 px-4">Edit</td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>
@endsection
