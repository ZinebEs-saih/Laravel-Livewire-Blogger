<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;



class AuthoProfilHeader extends Component
{
    public $author;

    protected $listeners = [
        'updateAuthorProfilHeader'=>'$refresh'
    ];
    public function mount(){
        $this->author=User::find(auth('web')->id());
    }
    public function render()
    {
        return view('livewire.autho-profil-header');
    }
}
