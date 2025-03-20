@extends('layouts.dashboard')

@section('title', 'User Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">User Management</h2>
            <span class="text-sm text-gray-500">Total Users: {{ $users->total() }}</span>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wide border-b border-gray-200">
                        <th class="py-2 px-2 text-left">Name</th>
                        <th class="py-2 px-2 text-left">Email</th>
                        <th class="py-2 px-2 text-left">Role</th>
                        <th class="py-2 px-2 text-left">Action</th>
                        <th class="py-2 px-2 text-left">Status</th>
                        <th class="py-2 px-2 text-left">Created At</th>
                        <th class="py-2 px-2 text-left">Updated At</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 border-b border-gray-200">
                            <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $user->name }}</td>
                            <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $user->email }}</td>
                            <td class="py-2 px-2 whitespace-nowrap text-sm capitalize">{{ $user->role->name }}</td>
                            <td class="py-2 px-2 whitespace-nowrap">
                                <form action="{{ route('dashboard.update-role', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role_id" 
                                            class="bg-transparent text-gray-700 text-sm py-0 px-8 rounded-lg hover:text-cyan-600" 
                                            onchange="this.form.submit()">
                                        @foreach (\App\Models\Role::all() as $role)
                                            <option value="{{ $role->id }}" {{ $user->role->name === $role->name ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="py-2 px-2 whitespace-nowrap">
                                <form action="{{ route('dashboard.update-status', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="user_status" 
                                            class="bg-transparent text-gray-700 text-sm py-0 px-6 rounded-lg hover:text-cyan-600" 
                                            onchange="this.form.submit()">
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}" {{ $user->user_status === $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="py-2 px-2 whitespace-nowrap text-sm">{{ $user->updated_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-2 px-2 text-center text-gray-500 text-sm">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex items-center justify-center">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection