<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\JobQuestion;

class JobQuestionForm extends Component
{
    public $listingId;
    public $questions = [];
    public $inputTypes = ['text', 'textarea', 'select', 'radio', 'checkbox'];

    protected $rules = [
        'questions.*.question_text' => 'required|string|max:255',
        'questions.*.input_type' => 'required|in:text,textarea,select,radio,checkbox',
        'questions.*.options' => 'nullable|array',
        'questions.*.options.*' => 'required_if:questions.*.input_type,select,checkbox,radio|string|max:255',
        'questions.*.is_required' => 'boolean',
    ];

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
                'question_text' =>$question->question_text,
                'input_type' => $question->input_type,
                'options' => $question->options ?? [],
                'is_required' => $question->is_required,
            ];
        })
        ->toArray();
    }

    public function addQuestion()
    {
        $this->questions[] =[
            'question_text'=> '',
            'input_type' => 'text',
            'options' => [],
            'is_required' => false,
        ];
    }

    public function addOption($index)
    {
        $this->questions[$index]['options'][] = '';
    }

    public function removeOption($questionIndex, $optionIndex)
    {
        unset($this->questions[$questionIndex]['options'][$optionIndex]);
        $this->questions[$questionIndex]['options'] = array_values($this->questions[$quetionIndex]['options']);
    }

    public function removeQuestion($index)
    {
        unset($this->question[$index]);
        $this->questions = array_values($this->questions);
    }

    public function save()
    {
        if (!$this->listingId){
            throw new \Exception('Listing ID is missing');
        }
        
        $this->validate();

        foreach($this->questions as $question) {
            JobQuestion::updateOrCreate( 

                [
                    'id' => $question['id'] ?? null, 
                    'listing_id' => $this->listingId
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
        session()->flash('message', 'Questions saved successfully.');
    }

    public function render()
    {
        return view('livewire.job-question-form', [
            'inputTypes' => $this->inputTypes,
        ]);
    }
}
