<?php

namespace App\Livewire;

use App\Models\Listing;
use Livewire\Component;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class JobReferralForm extends Component
{
    public $listingId;
    public $answers = [];
    public $questions = [];

    protected $rules = [];

    public function mount($listingId)
    {
        $this->listingId = $listingId;
        $this->questions = Listing::findOrFail($listingId)->questions;
        $this->setRules();
    }

    public function setRules()
    {
        foreach ($this->questions as $question){
            $this->rules["answers.{$question->id}"] = $question->is_required ? 'required' : 'nullable';
            if (in_array($question->input_type, ['select', 'checkbox', 'radio'])) {
                $this->rules["answers.{$question->id}"] .= '|in:' .implode(',', $question->options);
            }
        }
    }

    public function submit()
    {
        $this->validate();

        JobApplication::create([
            'listing_id' => $this->listingId,
            'user_id' => Auth::id(),
            'answers' => $this->answers,
        ]);

        session()->flash('message', 'Referral submitted successfully!');
    }

    public function render()
    {
        return view('livewire.job-referral-form');
    }
}
