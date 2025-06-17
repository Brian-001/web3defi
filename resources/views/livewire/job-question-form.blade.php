<div class="max-w-2xl mx-auto p-4 sm:p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6">Job Listing Questions</h2>

    <form wire:submit.prevent="save">
        <div class="max-h-[600px] overflow-y-auto mb-4 sm:mb-6">
            @foreach ($questions as $index => $question)
                <div wire:key="question-{{ $index }}" class="mb-4 sm:mb-6 p-3 sm:p-4 border rounded">
                    <div class="flex justify-between items-center mb-3 sm:mb-4">
                        <h3 class="font-semibold text-sm sm:text-base">Question {{ $index + 1 }}</h3>
                        <button type="button" wire:click="removeQuestion({{ $index }})" class="text-red-600 text-xs sm:text-sm">Remove</button>
                    </div>

                    <label class="block mb-2 text-xs sm:text-sm font-medium">Question</label>
                    <input type="text" wire:model.defer="questions.{{ $index }}.question_text"
                           class="w-full border rounded px-2 py-1 mb-1 text-sm sm:text-base" />
                    @error("questions.$index.question_text") <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror

                    <label class="block mt-2 sm:mt-3 mb-2 text-xs sm:text-sm font-medium">Input Type</label>
                    <select wire:model.lazy="questions.{{ $index }}.input_type"
                            class="w-full border rounded px-2 py-1 mb-1 text-sm sm:text-base">
                        @foreach ($inputTypes as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                    @error("questions.$index.input_type") <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span> @enderror

                    @if (isset($question['input_type']) && in_array($question['input_type'], ['select', 'checkbox', 'radio']) && isset($question['options']))
                        <label class="block mt-2 sm:mt-3 mb-2 text-xs sm:text-sm font-medium">Options</label>

                        @foreach ($question['options'] as $optionIndex => $option)
                            <div class="flex items-center gap-2 mb-1">
                                <input type="text" wire:model.defer="questions.{{ $index }}.options.{{ $optionIndex }}"
                                       class="flex-grow border rounded px-2 py-1 text-sm sm:text-base" />
                                <button type="button" wire:click="removeOption({{ $index }}, {{ $optionIndex }})"
                                        class="text-red-500 text-xs">Remove</button>
                            </div>
                        @endforeach

                        @if ($question['input_type'] !== 'radio')
                            <button type="button" wire:click="addOption({{ $index }})"
                                    class="text-blue-500 text-xs sm:text-sm mt-2">+ Add Option</button>
                        @endif
                    @endif

                    <label class="flex items-center gap-2 mt-3 sm:mt-4 text-xs sm:text-sm">
                        <input type="checkbox" wire:model.defer="questions.{{ $index }}.is_required" class="rounded">
                        Required
                    </label>
                </div>
            @endforeach
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
            <button type="button" wire:click="addQuestion"
                    class="bg-blue-500 text-white px-3 sm:px-4 py-2 rounded hover:bg-blue-600 w-full sm:w-auto">
                + Add Question
            </button>

            <div class="flex items-center gap-2 sm:gap-4 w-full sm:w-auto">
                <button type="submit" class="bg-green-600 text-white px-3 sm:px-4 py-2 rounded hover:bg-green-700">
                    Save Questions
                </button>
                @if (session()->has('message'))
                    <div id="flash-message" class="bg-green-100 text-green-700 px-3 sm:px-4 py-2 rounded text-xs sm:text-sm">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function () {
                Livewire.on('component-updated', () => {
                    const flashMessage = document.getElementById('flash-message');
                    if (flashMessage) {
                        setTimeout(() => {
                            flashMessage.style.display = 'none';
                        }, 3000);
                    }
                });
            });
        </script>
    @endpush
</div>