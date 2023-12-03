<?php

namespace App\Livewire;

use Livewire\Component;

class Toastr extends Component
{
    public $message;

    protected $listeners = ['showToastr' => 'show'];

public function show($message)
{
    $this->message = $message;
}

    public function render()
    {
        return view('livewire.toastr');
    }
}
