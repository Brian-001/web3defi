<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Refer an Employee</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Employee Applications -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-4">Employee Applications</h3>
        @if ($employeeApplications->isEmpty())
            <p class="text-gray-500">No employee applications for this job listing.</p>
        @else
            <div class="space-y-4">
                @foreach ($employeeApplications as $application)
                    <div class="p-4 border rounded-lg">
                        <p><strong>Name:</strong> {{ $application->name }}</p>
                        <p><strong>Email:</strong> {{ $application->email }}</p>
                        <p><strong>GitHub:</strong> <a href="{{ $application->github }}" target="_blank" class="text-blue-500 hover:underline">{{ $application->github }}</a></p>
                        <p><strong>LinkedIn:</strong> <a href="{{ $application->linkedin }}" target="_blank" class="text-blue-500 hover:underline">{{ $application->linkedin }}</a></p>
                        <p><strong>Resume:</strong> 
                            @if ($application->resume_path)
                                <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank" class="text-blue-500 hover:underline">View Resume</a>
                            @else
                                Not provided
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Referral Form -->
    <form wire:submit.prevent="submit">
        <!-- Applicant Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="flex flex-col">
                <label for="name" class="text-gray-700 font-medium mb-2">Candidate Name <span class="text-red-500">*</span></label>
                <input type="text" id="name" wire:model="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="flex flex-col">
                <label for="email" class="text-gray-700 font-medium mb-2">Candidate Email <span class="text-red-500">*</span></label>
                <input type="email" id="email" wire:model="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="flex flex-col">
                <label for="github" class="text-gray-700 font-medium mb-2">GitHub URL</label>
                <input type="text" id="github" wire:model="github" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('github') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="flex flex-col">
                <label for="linkedin" class="text-gray-700 font-medium mb-2">LinkedIn URL</label>
                <input type="text" id="linkedin" wire:model="linkedin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('linkedin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex flex-col mb-6">
            <label for="resume_path" class="text-gray-700 font-medium mb-2">Upload Resume (PDF)</label>
            <input type="file" id="resume_path" wire:model="resume_path" accept=".pdf" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('resume_path') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Dynamic Questions -->
        @foreach ($questions as $question)
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">
                    {{ $question->question_text }} {{ $question->is_required ? '*' : '' }}
                </label>

                @if ($question->input_type == 'text')
                    <input type="text" wire:model="answers.{{ $question->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @elseif ($question->input_type == 'textarea')
                    <textarea wire:model="answers.{{ $question->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                @elseif ($question->input_type == 'select')
                    <select wire:model="answers.{{ $question->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Select an option</option>
                        @foreach ($question->options as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                @elseif ($question->input_type == 'checkbox')
                    @foreach ($question->options as $option)
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox" wire:model="answers.{{ $question->id }}" value="{{ $option }}" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                            <span class="ml-2 text-sm text-gray-700">{{ $option }}</span>
                        </label>
                    @endforeach
                @elseif ($question->input_type == 'radio')
                    @foreach ($question->options as $option)
                        <label class="inline-flex items-center mt-2">
                            <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $option }}" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                            <span class="ml-2 text-sm text-gray-700">{{ $option }}</span>
                        </label>
                    @endforeach
                @endif

                @error('answers.' . $question->id) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @endforeach

        <!-- Submit Button -->
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Submit Referral
        </button>
    </form>
</div>