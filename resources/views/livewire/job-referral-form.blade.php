<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Refer an Employee</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
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

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Submit Referral
        </button>
    </form>
</div>