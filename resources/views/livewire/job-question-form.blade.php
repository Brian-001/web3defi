<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Add Questions for Job Listing</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        @foreach ($questions as $index => $question)
            <div class="mb-6 p-4 border rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Question {{ $index + 1 }}</h3>
                    <button type="button" wire:click="removeQuestion({{ $index }})" class="text-red-500 hover:text-red-700">
                        Remove
                    </button>
                </div>

                <!-- Question Text -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Question</label>
                    <input type="text" wire:model="questions.{{ $index }}.question_text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('questions.' . $index . '.question_text') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Input Type -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Input Type</label>
                    <select wire:model="questions.{{ $index }}.input_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @foreach ($inputTypes as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                    @error('questions.' . $index . '.input_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Options for Select/Checkbox/Radio -->
                @if (in_array($question['input_type'], ['select', 'checkbox', 'radio']))
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Options</label>
                        @foreach ($question['options'] as $optionIndex => $option)
                            <div class="flex items-center mb-2">
                                <input type="text" wire:model="questions.{{ $index }}.options.{{ $optionIndex }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <button type="button" wire:click="removeOption({{ $index }}, {{ $optionIndex }})" class="ml-2 text-red-500 hover:text-red-700">
                                    Remove
                                </button>
                            </div>
                            @error('questions.' . $index . '.options.' . $optionIndex) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        @endforeach
                        <button type="button" wire:click="addOption({{ $index }})" class="text-blue-500 hover:text-blue-700">
                            Add Option
                        </button>
                    </div>
                @endif

                <!-- Required Checkbox -->
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model="questions.{{ $index }}.is_required" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                        <span class="ml-2 text-sm text-gray-700">Required</span>
                    </label>
                </div>
            </div>
        @endforeach

        <!-- Add Question Button -->
        <button type="button" wire:click="addQuestion" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Add Question
        </button>

        <!-- Save Button -->
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Save Questions
        </button>
    </form>
</div>