<div>

    <div class="mb-4">
        <input 
        type="text"
        wire:model.live.debounce.300ms="search"
        placeholder="Search by name or email"
        class="w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent"
         >
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
                            <select
                                wire:model="selectedRole.{{ $user->id }}"
                                wire:change="updateRole({{ $user->id }})"
                                class="bg-transparent text-gray-700 text-sm py-0 px-8 rounded-lg hover:text-cyan-600" 
                            >
                                @foreach ($roles as $role)
                                    <option value=" {{ $role->name }}" {{ $user->role->name === $role->name ? 'selected' : '' }}>
                                         {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="py-2 px-2 whitespace-nowrap">
                            <select
                                wire:model="selectedStatus.{{ $user->id }}"
                                wire:change="updateStatus({{ $user->id }})"
                                class="bg-transparent text-gray-700 text-sm py-0 px-6 rounded-lg hover:text-cyan-600"
                            >
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" {{ $user->user_status === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
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
        {{-- {{ $users->links('pagination::tailwind') }} --}}
        {{ $users->links() }}
    </div>
</div>