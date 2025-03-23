<div class="bg-white p-6 rounded-xl shadow-lg">
    <!-- Search Input -->
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ ucfirst($searchType) }} Search</h2>
        <div class="flex items-center space-x-4">
            <input type="text" wire:model.debounce.500ms="query" 
                   placeholder="Search {{ $searchType }}..." 
                   class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent">
            <span class="text-sm text-gray-500">Total: {{ $results->total() }}</span>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="text-center text-gray-500">Loading...</div>

    <!-- Results Placeholder (to be overridden) -->
    <div class="overflow-x-auto">
        @yield('search-results')
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex items-center justify-center">
        {{ $results->links() }}
    </div>
</div>