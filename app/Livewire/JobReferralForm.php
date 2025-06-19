<?php

namespace App\Livewire;

use App\Models\Listing;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class JobReferralForm extends Component
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
        'github' => 'nullable|url',
        'linkedin' => 'nullable|url',
        'resume_path' => 'nullable|file|mimes:pdf|max:2048',
        'answers.*' => 'nullable',
    ];

    public function mount($listingId)
    {
        try {
            $this->listingId = $listingId;
            $this->questions = Listing::findOrFail($listingId)->questions;
            $this->employeeApplications = JobApplication::where('listing_id', $listingId)
                ->where('application_type', 'employee')
                ->get();
            $this->initializeAnswers();
            $this->setRules();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            session()->flash('error', 'Job listing not found.');
            return redirect()->route('listings.index');
        }
    }

    public function initializeAnswers()
    {
        foreach ($this->questions as $question) {
            $this->answers[$question->id] = $question->input_type === 'checkbox' ? [] : null;
        }
    }

    public function setRules()
    {
        foreach ($this->questions as $question) {
            if ($question->input_type === 'checkbox') {
                $this->rules["answers.{$question->id}"] = $question->is_required ? 'required|array|min:1' : 'nullable|array';
                $this->rules["answers.{$question->id}.*"] = 'string|in:' . implode(',', array_map('strval', $question->options ?? []));
            } else {
                $this->rules["answers.{$question->id}"] = $question->is_required ? 'required|string' : 'nullable|string';
                if (in_array($question->input_type, ['select', 'radio'])) {
                    $this->rules["answers.{$question->id}"] .= '|in:' . implode(',', array_map('strval', $question->options ?? []));
                }
            }
        }
    }

    public function submit()
    {
        $this->validate();

        try {
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
                'application_status' => 'submitted',
            ]);

            \Log::info('Referral submitted', ['answers' => $this->answers]);

            session()->flash('message', 'Referral submitted successfully!');
            $this->reset(['name', 'email', 'github', 'linkedin', 'resume_path', 'answers']);
            $this->initializeAnswers();
            $this->employeeApplications = JobApplication::where('listing_id', $this->listingId)
                ->where('application_type', 'employee')
                ->get();
        } catch (\Exception $e) {
            \Log::error('Referral submission failed', ['error' => $e->getMessage()]);
            session()->flash('error', 'Failed to submit referral. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.job-referral-form');
    }
}