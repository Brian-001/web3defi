<div class="max-w-2xl mx-auto p-4 sm:p-6 bg-white rounded-xl shadow-lg">
    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6 sm:mb-8">Refer an Employee</h2>

    <!-- Employee Applications -->
    <div class="mb-8 sm:mb-10 bg-gray-50 rounded-lg p-4 sm:p-6">
        <h3 class="text-lg sm:text-xl font-semibold text-gray-700 mb-4 sm:mb-5">Employee Applications</h3>
        @if ($employeeApplications->isEmpty())
            <p class="text-gray-500 text-sm sm:text-base italic">No employee applications for this job listing.</p>
        @else
            <div class="space-y-4">
                @foreach ($employeeApplications as $application)
                    <div class="p-4 sm:p-5 border border-gray-200 rounded-lg bg-white hover:shadow-md transition-shadow duration-200">
                        <p class="text-sm sm:text-base text-gray-700"><strong class="font-medium">Name:</strong> {{ $application->name }}</p>
                        <p class="text-sm sm:text-base text-gray-700"><strong class="font-medium">Email:</strong> {{ $application->email }}</p>
                        <p class="text-sm sm:text-base text-gray-700"><strong class="font-medium">GitHub:</strong> 
                            @if ($application->github)
                                <a href="{{ $application->github }}" target="_blank" class="text-cyan-500 hover:text-cyan-600 hover:underline transition-colors duration-200" aria-label="View GitHub profile for {{ $application->name }}">View Profile</a>
                            @else
                                <span class="text-gray-400">Not provided</span>
                            @endif
                        </p>
                        <p class="text-sm sm:text-base text-gray-700"><strong class="font-medium">LinkedIn:</strong> 
                            @if ($application->linkedin)
                                <a href="{{ $application->linkedin }}" target="_blank" class="text-cyan-500 hover:text-cyan-600 hover:underline transition-colors duration-200" aria-label="View LinkedIn profile for {{ $application->name }}">View Profile</a>
                            @else
                                <span class="text-gray-400">Not provided</span>
                            @endif
                        </p>
                        <p class="text-sm sm:text-base text-gray-700"><strong class="font-medium">Resume:</strong> 
                            @if ($application->resume_path)
                                <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank" class="text-cyan-500 hover:text-cyan-600 hover:underline transition-colors duration-200" aria-label="View resume for {{ $application->name }}">View Resume</a>
                            @else
                                <span class="text-gray-400">Not provided</span>
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Referral Form -->
    <form wire:submit.prevent="submit" class="space-y-6 sm:space-y-8">
        <!-- Applicant Details -->
        <div class="bg-gray-50 rounded-lg p-4 sm:p-6">
            <h3 class="text-base sm:text-lg font-semibold text-gray-700 mb-4 sm:mb-5">Candidate Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div class="flex flex-col">
                    <label for="name" class="text-gray-700 font-medium mb-2 text-sm sm:text-base">Candidate Name <span class="text-red-500">*</span></label>
                    <input type="text" id="name" wire:model.defer="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 text-sm sm:text-base transition-colors duration-200" aria-required="true">
                    @error('name') <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col">
                    <label for="email" class="text-gray-700 font-medium mb-2 text-sm sm:text-base">Candidate Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" wire:model.defer="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 text-sm sm:text-base transition-colors duration-200" aria-required="true">
                    @error('email') <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mt-4 sm:mt-6">
                <div class="flex flex-col">
                    <label for="github" class="text-gray-700 font-medium mb-2 text-sm sm:text-base">GitHub URL</label>
                    <input type="text" id="github" wire:model.defer="github" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 text-sm sm:text-base transition-colors duration-200">
                    @error('github') <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col">
                    <label for="linkedin" class="text-gray-700 font-medium mb-2 text-sm sm:text-base">LinkedIn URL</label>
                    <input type="text" id="linkedin" wire:model.defer="linkedin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 text-sm sm:text-base transition-colors duration-200">
                    @error('linkedin') <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="flex flex-col mt-4 sm:mt-6">
                <label for="resume_path" class="text-gray-700 font-medium mb-2 text-sm sm:text-base">Upload Resume (PDF)</label>
                <input type="file" id="resume_path" wire:model="resume_path" accept=".pdf" class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-cyan-50 file:text-cyan-700 file:cursor-pointer hover:file:bg-cyan-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-colors duration-200">
                @error('resume_path') <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Dynamic Questions -->
        <div class="bg-gray-50 rounded-lg p-4 sm:p-6 max-h-[600px] overflow-y-auto">
            <h3 class="text-base sm:text-lg font-semibold text-gray-700 mb-4 sm:mb-5">Additional Questions</h3>
            @foreach ($questions as $index => $question)
                <div wire:key="question-{{ $question->id }}" class="mb-4 sm:mb-5 p-3 sm:p-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                    <label for="question-{{ $question->id }}" class="block text-sm sm:text-base font-medium text-gray-700 mb-2">
                        {!! $question->question_text . ($question->is_required ? ' <span class="text-red-500">*</span>' : '') !!}
                    </label>

                    @if ($question->input_type == 'text')
                        <input type="text" id="question-{{ $question->id }}" wire:model.defer="answers.{{ $question->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 text-sm sm:text-base transition-colors duration-200" aria-required="{{ $question->is_required ? 'true' : 'false' }}">
                    @elseif ($question->input_type == 'textarea')
                        <textarea id="question-{{ $question->id }}" wire:model.defer="answers.{{ $question->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 text-sm sm:text-base transition-colors duration-200 resize-y" rows="4" aria-required="{{ $question->is_required ? 'true' : 'false' }}"></textarea>
                    @elseif ($question->input_type == 'select')
                        <select id="question-{{ $question->id }}" wire:model.defer="answers.{{ $question->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 text-sm sm:text-base transition-colors duration-200" aria-required="{{ $question->is_required ? 'true' : 'false' }}">
                            <option value="">Select an option</option>
                            @if (!empty($question->options))
                                @foreach ($question->options as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            @endif
                        </select>
                    @elseif ($question->input_type == 'checkbox')
                        @if (!empty($question->options))
                            @foreach ($question->options as $optionIndex => $option)
                                <label class="inline-flex items-center mt-2">
                                    <input type="checkbox" wire:model.defer="answers.{{ $question->id }}.{{ $optionIndex }}" value="{{ $option }}" class="rounded border-gray-300 text-cyan-500 focus:ring-cyan-600 transition-colors duration-200" aria-required="{{ $question->is_required ? 'true' : 'false' }}">
                                    <span class="ml-2 text-sm sm:text-base text-gray-700">{{ $option }}</span>
                                </label>
                            @endforeach
                        @endif
                    @elseif ($question->input_type == 'radio')
                        @if (!empty($question->options))
                            @foreach ($question->options as $option)
                                <label class="inline-flex items-center mt-2">
                                    <input type="radio" name="question-{{ $question->id }}" wire:model.defer="answers.{{ $question->id }}" value="{{ $option }}" class="rounded border-gray-300 text-cyan-500 focus:ring-cyan-600 transition-colors duration-200" aria-required="{{ $question->is_required ? 'true' : 'false' }}">
                                    <span class="ml-2 text-sm sm:text-base text-gray-700">{{ $option }}</span>
                                </label>
                            @endforeach
                        @endif
                    @endif

                    @error('answers.' . $question->id) <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                    @error('answers.' . $question->id . '.*') <span class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</span> @enderror
                </div>
            @endforeach
        </div>

        <!-- Submit Button and Flash Message -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
            <button type="submit" class="bg-cyan-500 text-white px-4 sm:px-6 py-2 rounded-lg hover:bg-cyan-600 focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition-colors duration-200">
                Submit Referral
            </button>
            @if (session()->has('message'))
                <div class="bg-green-100 text-green-700 px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm animate-fade-out shadow-sm">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </form>

    @push('styles')
        <style>
            @keyframes fadeOut {
                0% { opacity: 1; }
                100% { opacity: 0; display: none; }
            }
            .animate-fade-out {
                animation: fadeOut 0.5s ease-out 3s forwards;
            }
        </style>
    @endpush
</div>