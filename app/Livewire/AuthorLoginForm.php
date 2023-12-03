<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthorLoginForm extends Component
{
    public $email, $password ;
    public $returnUrl;
    public function mount(){
        $this->returnUrl=request()->returnUrl;
    }
    public function LoginHandler(){
        $this->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required|min:5'
        ],[
            'email.required'=>'Enter your email address',
            'email.email'=>'Invalid email address',
            'email.exists'=>'This is not registered in database',
            'password.required'=>'Password is required'
        ]);
        $creds=array('email'=>$this->email,'password'=>$this->password);        
        
        if(Auth::guard('web')->attempt($creds)){
            
            $checkUser = User::where('email', $this->email)->first();
            //            dd($checkUser['role']);
            if($checkUser->blocked ==1){
                Auth::guard('web')->logout();
                return redirect()->route('authorLogin ')->with('fail','Your account has been blocked');
            }else{
                if($this->returnUrl!=null){
                    return redirect()->to($this->returnUrl);
                }else{
                    redirect()->route('authorhome');

                }
            }
        }else{
            session()->flash('fail','Incorrects email or password');
        }
    }

    public function render()
    {
        return view('livewire.author-login-form');
    }
}
