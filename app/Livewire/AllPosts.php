<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage; 
use Intervention\Image\Facades\Image;

class AllPosts extends Component
{
    use WithPagination;
    
    public $parpage= 10;
    public $search=null;
    public $author=null;
    public $category=null;
    public $orderby='desc';
    public $listeners=[
        'deletePostAction',
        'resetForm'
    ];
    public function mount(){
        $this->resetPage();
    }
    public function updatingSearch(){
        $this->resetPage();
    }

    public function updatingCategory(){
        $this->resetPage();
    }

    public function updatingAuthor(){
        $this->resetPage();
    }

    public function deletePost($id)
    {
        $this->dispatch('deletePost',[
            'title'=>'Are you sure?',
            'html'=>'You want to delete this Post',
            'id'=>$id,

        ]);
    }

    public function deletePostAction($id){
        $post=Post::find($id);
        $path="/images/post_images/";
        $featured_image=$post->featured_image;
        if($featured_image!=null && Storage::disk('public')->exists($path.$featured_image)){
            if(Storage::disk('public')->exists($path.'thumbnails/resized_'.$featured_image)){
                Storage::disk('public')->delete($path.'thumbnails/resized_'.$featured_image);
            }
            if(Storage::disk('public')->exists($path.'thumbnails/thumb_'.$featured_image)){
                Storage::disk('public')->delete($path.'thumbnails/thumb_'.$featured_image);
            }
            Storage::disk('public')->delete($path.$featured_image);
        }
        $deletePost=$post->delete();
        if($deletePost){
            $this->dispatch('toastr:info', ['message' => 'Post has been successfully deleted ']);
        }else{
            $this->dispatch('toastr:error', ['message' => 'Somthing went wrong! ']);

        }
    }
    public function render()
    {
        return view('livewire.all-posts', [
            'posts' => auth()->user()->type == 1 ?
                            Post::search(trim($this->search))
                                ->when($this->category,function($query){
                                    $query->where('category_id',$this->category);
                                })
                                ->when($this->author,function($query){
                                    $query->where('author_id',auth()->id());
                                })
                                ->when($this->orderby,function($query){
                                    $query->orderBy('id',$this->orderby);
                                })
                                ->paginate($this->parpage) : 
                            Post::search(trim($this->search))
                                ->when($this->category,function($query){
                                    $query->where('category_id',$this->category);
                                })
                                ->where('author_id',auth()->id())
                                ->when($this->orderby,function($query){
                                    $query->orderBy('id',$this->orderby);
                                })
                                ->where('author_id', auth()->id())->paginate($this->parpage)
        ]);
        
    }
}
