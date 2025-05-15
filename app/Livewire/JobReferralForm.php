<?php

namespace App\Livewire;

use App\Models\Listing;
use Livewire\Component;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class JobReferralForm extends Component
{
    {
    use WithFileUploads;

    public $listingId;
    public $questions = [];
    public $name;
    public $email;
    public $github;
    public $linkedin;
    public $resume_path;
    public $answers = [];
    public $employeeApplications = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'github' => 'required|url',
        'linkedin' => 'required|url',
        'resume_path' => 'nullable|file|mimes:pdf|max:2048',
        'answers.*' => 'nullable',
    ];

    public function mount($listingId)
    {
        $this->listingId = $listingId;
        $this->questions = Listing::findOrFail($listingId)->questions;
        $this->employeeApplications = JobApplication::where('listing_id', $listingId)
            ->where('application_type', 'employee')
            ->get();
        $this->setRules();
    }

    public function setRules()
    {
        foreach ($this->questions as $question) {
            $this->rules["answers.{$question->id}"] = $question->is_required ? 'required' : 'nullable';
            if (in_array($question->input_type, ['select', 'checkbox', 'radio'])) {
                $this->rules["answers.{$question->id}"] .= '|in:' . implode(',', $question->options);
            }
        }
    }

    public function submit()
    {
        $this->validate();

        $resumePath = $this->resume_path ? $this->resume_path->store('resumes', 'public') : null;

        JobApplication::create([
            'listing_id' => $this->listingId,
            'user_id' => Auth::user()->id, // Recruiter
            'name' => $this->name,
            'email' => $this->email,
            'github' => $this->github,
            'linkedin' => $this->linkedin,
            'resume_path' => $resumePath,
            'answers' => $this->answers,
            'application_type' => 'recruiter',
            'referred_by' => Auth::user()->id, // Referrer
        ]);

        session()->flash('message', 'Referral submitted successfully!');
        $this->reset(['name', 'email', 'github', 'linkedin', 'resume_path', 'answers']);
    }

    public function render()
    {
        return view('livewire.job-referral-form');
    }

}
