<?php

namespace App\Livewire;

use Livewire\Component;

class SubmittingButton extends Component
{
    public $label;
    public $target;
    public $additionalClass = '';

    public function mount($label = 'Submit', $target = '')
    {
        $this->label = $label;
        $this->target = $target;
    }

    public function render()
    {
        return view('livewire.submitting-button');
    }
}