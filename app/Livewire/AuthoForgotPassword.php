<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthoForgotPassword extends Component
{
    public $email;

    public function ForgotHandler()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'The :attribute is required',
            'email.email' => 'Invalid email address',
            'email.exists' => 'The :attribute is not registered',
        ]);
    
        $user = User::where('email', $this->email)->first();
        
        // Check if a token already exists for this email
        $existingToken = DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->first();
    
        // Generate a new token
        $token = base64_encode(Str::random(64));
    
        if ($existingToken) {
            // Update the existing token
            DB::table('password_reset_tokens')
                ->where('email', $this->email)
                ->update(['token' => $token, 'created_at' => now()]);
        } else {
            // Insert a new record
            DB::table('password_reset_tokens')->insert([
                'email' => $this->email,
                'token' => $token,
                'created_at' => now(),
            ]);
        }
    
        $link = route('authorreset-form', ['token' => $token, 'email' => $this->email]);
    
        $body_message = "We have received a request to reset the password for <b>Lara_blog</b> account associated with " . $this->email . ".<br> You can reset your password by clicking the button below:";
        $body_message .= '<a href="' . $link . '" target="_blank" style="color:#FFF; border-color:#22bc66; border-style:solid; border-width:10px 180px; background-color:#22bc66; display:inline-block; text-decoration:none; border-radius:3px; box-shadow:0 2px 3px rgba(0,0,0,0.16); webkit-text-size-adjust:none; box-sizing:border-box">Reset Password</a>';
        $body_message .= "If you did not request a password reset, please ignore this email";
    
        $data = [
            'name' => $user->name,
            'body_message' => $body_message,
        ];
    
        //Mail::send('forgot-email-template', $data, function ($message) use ($user) {
        //    $message->to($user->email, $user->name);
        //    $message->subject("Reset Password");
        //    $message->from('ziness.dh@gmail.com', 'larablog'); // Replace with your Gmail email and name
        //});
        
        $mail_body=view('forgot-email-template',$data)->render();
        $mailConfig=array(
            'mail_from_email'=>env('EMAIL_USERNAME'),
            'mail_from_name'=>env('MAIL_FROM_NAME'),
            'mail_recipient_email'=>$user->email,
            'mail_recipient_name'=>$user->name,
            'mail_subject'=>"Reset Password",
            'mail_body'=>$mail_body,
        );
        
        try {
            senMail($mailConfig);
            session()->flash('success', 'We have emailed you a password reset link');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to send the password reset email');
        }
    }
    

    public function render()
    {
        return view('livewire.autho-forgot-password');
    }
    
}
