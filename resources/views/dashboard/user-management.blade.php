@extends('layouts.dashboard')

@section('title', 'User Management')
@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Welcome to user management</h2>
    <div class="mx-auto my-4">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-300">
                    <th class="py-2 px-4 whitespace-nowrap text-left">Name</th>
                    <th class="py-2 px-4 whitespace-nowrap text-left">Email</th>
                    <th class="py-2 px-4 whitespace-nowrap text-left">Role</th>
                    <th class="py-2 px-4 whitespace-nowrap text-left">Action</th>
                    <th class="py-2 px-4 whitespace-nowrap text-left">Status</th>
                    <th class="py-2 px-4 whitespace-nowrap text-left">Created At</th>
                    <th class="py-2 px-4 whitespace-nowrap text-left">Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-b border-gray-200">
                        <td class="whitespace-nowrap px-4">{{ $user->name }}</td>
                        <td class="whitespace-nowrap px-4">{{ $user->email }}</td>
                        <td class="whitespace-nowrap px-4">{{ $user->role->name }}</td>
                        <td class="whitespace-nowrap px-4">
                            <form action="{{ route('dashboard.update-role', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <select name="role_id" class="border-none py-1 px-8 outline-none focus:ring-0" onchange="this.form.submit()">
                                    @foreach (\App\Models\Role::all() as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_name === $role->name ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="whitespace-nowrap px-4">
                            <form action="{{ route('dashboard.update-status', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <select name="user_status" class="border-none py-1 px-2 outline-none focus:ring-0" onchange="this.form.submit()">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" {{ $user->user_status === $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="whitespace-nowrap px-4">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="whitespace-nowrap px-4">{{ $user->updated_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Add pagination links --}}
    <div class="flex items-center justify-center">
        {{ $users->links('pagination::tailwind') }}
    </div>
</div>
@endsection
