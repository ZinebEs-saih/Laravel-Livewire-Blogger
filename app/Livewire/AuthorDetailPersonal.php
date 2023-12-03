<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class AuthorDetailPersonal extends Component
{
    public $author;
    public $name,$email,$username,$biography;
    public function mount(){
        $this->author=User::find(auth('web')->id());
        $this->name=$this->author->name;
        $this->username=$this->author->username;
        $this->email=$this->author->email;
        $this->biography=$this->author->biography;
    }
    public function UpdateDatails(){
        $this->validate([
        'name'=>'required|String',
        'username'=>'required|unique:users,username,'.auth('web')->id()
        
        ]);
    
        $this->dispatch('updateAuthorProfilHeader');
        $this->dispatch('updateTopHeader');


        User::where('id',auth('web')->id())->update([
            'name'=>$this->name,
            'username'=>$this->username,
            'biography'=>$this->biography
        ]);
        $message = "Your details have been updated.";
    $this->dispatch('toastr:success', ['message' => $message]);
        
        
        
        

        

        
    }
         
    
   
    public function render()
    {
        return view('livewire.author-detail-personal');
    }
}
