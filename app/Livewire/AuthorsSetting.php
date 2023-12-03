<?php

namespace App\Livewire;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;
use Illuminate\Support\Facades\Mail;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;



use Livewire\Component;

class AuthorsSetting extends Component
{
    use WithPagination;
    public $name,$email,$username,$auhor_type,$direct_publisher;
    public $search;
    public $perPage=4;
    public $selected_author_id;
    public $blocked=0;
    public $listeners=[
        'deleteAuthorAction',
        'resetForm'
    ];
    public function mount(){
        $this->resetPage();
    }
    public function updatingSearch(){
        $this->resetPage();
    }
    public function resetForm(){
        $this->name= $this->email= $this->username= $this->auhor_type= $this->direct_publisher=null;
        $this->resetErrorBlog();
    }
    public function addAuthor(){
        $this->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'username'=>'required|unique:users,username|min:8|max:20',
            'auhor_type'=>'required',
            'direct_publisher'=>'required'
        ],[
            'auhor_type.required'=>'choose author type',
            'direct_publisher.required'=>'specify author publication access',
        ]
        );
        $default_password = Random::generate(8);

        if($this->isOnline()){
            $author=new User();
            $author->name=$this->name;
            $author->email=$this->email;
            $author->username=$this->username;
            $author->type=$this->auhor_type;
            $author->direct_publish=$this->direct_publisher;
            $saved=$author->save();

            $data= array(
                'name'=>$this->name,
                'username'=>$this->username,
                'email'=>$this->email,
                'password'=>$default_password,
                'url'=>route('authorprofile'),
            );

            $author_email=$this->email;
            $author_name=$this->name;

            if($saved){
               // Mail::send('new-author-mail-template',$data,function($message)use ($author_email,$author_name){
                //    $message->from('ziness.dh@gmail.com', 'larablog');
                 //   $message->to($author_email,$author_name)
                   //         ->subject('Account Creation');
                //});
                $mail_body = view('new-author-mail-template',$data)->render();
                $mailConfig=array(
                    'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
                    'mail_from_name'=>env('MAIL_FROM_NAME'),
                    'mail_recipient_email'=>$author_email,
                    'mail_recipient_name'=>$author_name,
                    'mail_subject'=>"Account Creation",
                    'mail_body'=>$mail_body,
                );
                try{
                senMail($mailConfig);
                
                $this->dispatch('toastr:success', ['message' => 'New author has been added to blog']);
                $this->name= $this->email= $this->username= $this->auhor_type= $this->direct_publisher=null;
                $this->dispatch('hide_add_author_modal');
                }catch(\Exception $e){
                    $this->dispatch('toastr:error', ['message' => 'you are offline , check your connection and submit again later!!']);
                }
            }

        }else{
            $this->dispatch('toastr:error', ['message' => 'you are offline , check your connection and submit again later!!']);

        }

    }
    //editAuthor
    public function editAuthor($author){
       // dd(['Open edit author',$author]);
       $this->selected_author_id=$author['id'];
       $this->name=$author['name'];
       $this->email=$author['email'];
       $this->username=$author['username'];
       $this->auhor_type=$author['type'];
       $this->direct_publisher=$author['direct_publish'];
       $this->blocked=$author['blocked'];



       $this->dispatch('showEditAuthorModal');
    }
    public function updateAuthor(){
        $this->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$this->selected_author_id,
            'username'=>'required|unique:users,username,'.$this->selected_author_id,
            
        ]);
        if($this->selected_author_id){
            $author=User::find($this->selected_author_id);
            $author->update([
                'name'=>$this->name,
                'email'=>$this->email,
                'username'=>$this->username,
                'type'=>$this->auhor_type,
                'blocked'=>$this->blocked,
                'direct_publish'=>$this->direct_publisher,
            ]);
            $this->dispatch('toastr:success', ['message' => 'Author details has been successfully updated ']);
            $this->dispatch('hide_edit_author_modal');

        }
    }
    
    //delete Author
    
    public function deleteAuthor($author){
        $this->dispatch('deleteAuthor',[
            'title'=>'Are you sure?',
            'html'=>'You want to delete this author : <br><b>'.$author['name'].'</b>',
            'id'=>$author['id'],

        ]);
    }
    public function deleteAuthorAction($id){
        $author=User::find($id);
        $path='back/dist/img/authors/';
        $author_picture=$author->getAttributes()['picture'];
        $picture_full_path=$path.$author_picture;
        if($author_picture!=null || file_exists($picture_full_path)){
            File::delete(public_path($picture_full_path));
        }
        $author->delete();
        $this->dispatch('toastr:info', ['message' => 'Author has been successfully deleted ']);

        
    }
    
    public function isOnline($site='https://youtube.com'){
        if(@fopen($site,'r')){
            return true;
        }else{
            return false;
        }

    }
    public function render()
    {
        return view('livewire.authors-setting',[
            'authors'=>User::search(trim($this->search))
                ->where('id','!=',auth()->id())->paginate($this->perPage),
        ]);
    }
}
