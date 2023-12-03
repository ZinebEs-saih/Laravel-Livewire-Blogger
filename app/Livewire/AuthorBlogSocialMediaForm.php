<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogSocialMedia;
class AuthorBlogSocialMediaForm extends Component
{
    public $blogsocialmedia;
    public $bsm_facebook,$bsm_instagram,$bsm_youtube,$bsm_linkedin;
    public function mount(){
        $this->blogsocialmedia=BlogSocialMedia::find(1);
        $this->bsm_facebook=$this->blogsocialmedia->bsm_facebook;
        $this->bsm_instagram=$this->blogsocialmedia->bsm_instagram;
        $this->bsm_youtube=$this->blogsocialmedia->bsm_youtube;
        $this->bsm_linkedin=$this->blogsocialmedia->bsm_linkedin;


    }
    public function UpdateBlogSocialMedia(){
        $this->validate([
            'bsm_facebook'=>'nullable|url',
            'bsm_instagram'=>'nullable|url',
            'bsm_youtube'=>'nullable|url',
            'bsm_linkedin'=>'nullable|url',
        ]);
        $update=$this->blogsocialmedia->update([
            'bsm_facebook'=>$this->bsm_facebook,
            'bsm_youtube'=>$this->bsm_youtube,
            'bsm_instagram'=>$this->bsm_instagram,
            'bsm_linkedin'=>$this->bsm_linkedin
        ]);
        if($update){
            $message = "Blog Social Media have been Successfully update.";
            $this->dispatch('toastr:success', ['message' => $message]);
        }else{
            $this->dispatch('toastr:error', ['message' => 'Somthing went wrong!!']);
        }
    }
    public function render()
    {
        return view('livewire.author-blog-social-media-form');
    }
}
