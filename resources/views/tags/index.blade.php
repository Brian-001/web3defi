@extends('layouts.dashboard')

@section('title', 'Tags')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Tags</h1>
            <a wire:navigate href="{{ route('tags.create') }}" 
               class="bg-cyan-500 text-white text-sm font-semibold px-4 py-2 rounded-md hover:bg-cyan-600 transition-colors duration-200">
                Add New Tag
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wide border-b border-gray-200">
                        <th class="py-2 px-2 text-left">Tag ID</th>
                        <th class="py-2 px-2 text-left">Tag Name</th>
                        <th class="py-2 px-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @forelse ($tags as $tag)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 border-b border-gray-200">
                            <td class="py-2 px-2 text-sm">{{ $tag->id }}</td>
                            <td class="py-2 px-2 text-sm">{{ $tag->tag_name }}</td>
                            <td class="py-2 px-2 text-sm flex items-center gap-4">
                                <a wire:navigate href="{{ route('tags.edit', $tag->id) }}" 
                                   class="text-cyan-600 hover:text-cyan-800 hover:underline transition-colors duration-200">
                                    Edit
                                </a>
                                <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this tag?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 hover:underline transition-colors duration-200">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-2 px-2 text-center text-gray-500 text-sm">No tags found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($tags->hasPages())
            <div class="mt-4 flex items-center justify-center">
                {{ $tags->links('vendor.livewire.tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection