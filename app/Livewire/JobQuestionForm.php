<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\JobQuestion;

class JobQuestionForm extends Component
{
    public $listingId;
    public $questions = [];
    public $removedQuestionIds = [];
    public $inputTypes = ['text', 'textarea', 'select', 'radio', 'checkbox'];

    public function rules()
    {
        return [
            'questions.*.question_text' => 'required|string|max:255',
            'questions.*.input_type' => 'required|in:text,textarea,select,radio,checkbox',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*' => 'required_if:questions.*.input_type,select,checkbox,radio|string|max:255',
            'questions.*.is_required' => 'boolean',
        ];
    }

    public function mount($listingId)
    {
        $this->listingId = $listingId;
        $this->loadQuestions();
    }

    public function loadQuestions()
    {
        $this->questions = JobQuestion::where('listing_id', $this->listingId)
            ->get()
            ->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question_text' => $question->question_text,
                    'input_type' => $question->input_type,
                    'options' => $question->options ?? [],
                    'is_required' => $question->is_required,
                ];
            })
            ->toArray();
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'question_text' => '',
            'input_type' => 'text',
            'options' => [],
            'is_required' => false,
        ];
    }

    public function updated($propertyName, $value)
    {
        if (str($propertyName)->endsWith('.input_type')) {
            $parts = explode('.', $propertyName); // e.g., "questions.0.input_type"
            $index = $parts[1]; // 0

            $type = $value ?? 'text'; // Fallback to 'text' if value is null

            if ($type === 'radio') {
                $this->questions[$index]['options'] = ['Yes', 'No'];
            } elseif (in_array($type, ['select', 'checkbox'])) {
                $this->questions[$index]['options'] = [''];
            } else {
                $this->questions[$index]['options'] = [];
            }

            // Re-assign to trigger Livewire reactivity
            $this->questions = array_values($this->questions);
        }
    }

    public function addOption($index)
    {
        $this->questions[$index]['options'][] = '';
    }

    public function removeOption($questionIndex, $optionIndex)
    {
        unset($this->questions[$questionIndex]['options'][$optionIndex]);
        $this->questions[$questionIndex]['options'] = array_values($this->questions[$questionIndex]['options']);
    }

    public function removeQuestion($index)
    {
        $question = $this->questions[$index];

        if (isset($question['id'])) {
            $this->removedQuestionIds[] = $question['id'];
        }

        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function save()
    {
        if (!$this->listingId) {
            throw new \Exception('Listing ID is missing');
        }

        $this->validate();

        // Delete removed questions
        if (!empty($this->removedQuestionIds)) {
            JobQuestion::whereIn('id', $this->removedQuestionIds)->delete();
            $this->removedQuestionIds = [];
        }

        // Save or update current questions
        foreach ($this->questions as $question) {
            JobQuestion::updateOrCreate(
                [
                    'id' => $question['id'] ?? null,
                    'listing_id' => $this->listingId,
                ],
                [
                    'listing_id' => $this->listingId,
                    'question_text' => $question['question_text'],
                    'input_type' => $question['input_type'],
                    'options' => in_array($question['input_type'], ['select', 'checkbox', 'radio'])
                        ? $question['options'] : null,
                    'is_required' => $question['is_required'],
                ]
            );
        }

        // Refresh questions
        $this->loadQuestions();

        session()->flash('message', 'Questions saved successfully.');
    }

    public function render()
    {
        return view('livewire.job-question-form', [
            'inputTypes' => $this->inputTypes,
        ]);
    }
}