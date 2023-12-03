<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthorChangePassword extends Component
{
    public $current_password, $new_password, $confirm_new_password;

public function ChangePassword()
{
    $this->validate([
        'current_password' => [
            'required',
            function ($attribute, $value, $fail) {
                if (!Hash::check($value, User::find(auth('web')->id())->password)) {
                    $fail(__("The current password is incorrect"));
                }
            },
        ],
        'new_password' => 'required|min:5|max:25',
        'confirm_new_password' => 'same:new_password',
    ], [
        'current_password.required' => 'Enter your current password',
        'new_password.required' => 'Enter a new password',
        'confirm_new_password.same' => 'The confirm password must be equal to the new password',
    ]);
    $query =User::find(auth('web')->id())->update([
        'password'=>Hash::make($this->new_password)
    ]);
    if($query){
        $this->dispatch('toastr:success', ['message' => 
        'Your Password has been successfully Update']);
        $this->current_password =$this->new_password=$this->confirm_new_password=null;

    }else{
        $this->dispatch('toastr:Error', ['message' => 'Somethis went wrong']);
    }
}

    public function render()
    {
        return view('livewire.author-change-password');
    }
}
