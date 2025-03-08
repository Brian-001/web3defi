@extends('layouts.dashboard')

@section('title', 'Applicant Management')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Applicants management</h2>
    <div class="mx-auto my-4">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-300">
                    <th class="py-2 px-4 text-left">Job Title</th>
                    <th class="py-2 px-4 text-left">Applicant Name</th>
                    <th class="py-2 px-4 text-left">Application Date</th>
                    <th class="py-2 px-4 text-left">Action</th>
                    <th class="py-2 px-4 text-left">Status</th>
                    <th class="py-2 px-4 text-left">Contact</th>
                    <th class="py-2 px-4 text-left">Resume</th>
                </tr>
            </thead>
            <tbody>
                
                <tr class="border-b border-gray-200">
                    <td class="py-2 px-4">Solana Developer</td>
                    <td class="py-2 px-4">John Doe</td>
                    <td class="py-2 px-4">2021-01-01 12:00:00</td>
                    <td class="py-2 px-4">View</td>
                    <td class="py-2 px-4">Active</td>
                    <td class="py-2 px-4">Send Email</td>
                    <td class="py-2 px-4">View Resume</td>
                    
                </tr>
                
            </tbody>
        </table>
    </div>
</div>

@endsection
