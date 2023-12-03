<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setting;

class AuthorGeneralSettings extends Component
{
    public $settings;
    public $blog_name,$blog_email,$blog_description,$blog_phone;
    public function mount(){
        $this->settings=Setting::find(1);
        $this->blog_name=$this->settings->blog_name;
        $this->blog_email=$this->settings->blog_email;
        $this->blog_phone=$this->settings->blog_phone;
        $this->blog_description=$this->settings->blog_description;


    }
    public function UpdateGeneralSettings(){
        $this->validate([
            'blog_name'=>'required',
            'blog_email'=>'required|email',
            'blog_phone' => 'required|regex:/^\+?[0-9]{8,}$/',

            ]);
            $update=$this->settings->update([
                'blog_name'=>$this->blog_name,
                'blog_email'=>$this->blog_email,
                'blog_phone'=>$this->blog_phone,
                'blog_description'=>$this->blog_description
            ]);
            if($update){
                $message = "General Setting have been Successfully update.";
                $this->dispatch('toastr:success', ['message' => $message]);
                $this->dispatch('UpdateAuthorFooter');
            }else{
                $this->dispatch('toastr:error', ['message' => 'Somthing went wrong!!']);
            }
    }
    public function render()
    {
        return view('livewire.author-general-settings');
    }
}
