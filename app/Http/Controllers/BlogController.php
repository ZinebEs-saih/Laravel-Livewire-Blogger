<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Setting;
use App\Models\SubCategorie;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Route;
use App\Mail\ContactFormMail; 
use Mail; 





class BlogController extends Controller
{
    public function CategoryPost(Request $request, $slug){
        if (!$slug) {
            return abort(404);
        } else {
            $subcategory = SubCategorie::where('slug', $slug)->first();
            if (!$subcategory) {
                return abort(404);
            } else {
                $posts = Post::where('category_id', $subcategory->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(6);
    
                $data = [
                    'pageTitle' => 'Category - ' . $subcategory->subcategorie_name,
                    'category' => $subcategory,
                    'posts' => $posts,
                ];
    
                return view('front.pages.category_post', $data);
            }
        }
    }

    public function searchPost(Request $request){
        $query = request()->query('query');
        
        if (isset($query) && strlen($query) >= 2) {
            $searchValues = preg_split('/\s+/', $query, -1, PREG_SPLIT_NO_EMPTY);
            $posts = Post::query();
    
            $posts->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->orWhere('post_title', 'LIKE', "%{$value}%");
                    $q->orWhere('post_tags', 'LIKE', "%{$value}%");
                }
            });
    
            $posts = $posts->with('subcategory')
                           ->with('author')
                           ->orderBy('created_at', 'desc')
                           ->paginate(6);
    
            $data = [
                'pageTitle' => 'Search For: ' . request()->query('query'),
                'posts' => $posts
            ];
    
            return view('front.pages.search_posts', $data);
        } else {
            return abort(404);
        }
    }

    public function readPost($slug){
        if (!$slug) {
            return abort(404);
        } else {
            $post = Post::where('post_slug', $slug)
                ->with("subcategory")
                ->with('author')
                ->first();
    
            $post_tags = explode(',', $post->post_tags);
    
            $related_posts = Post::where('id', '!=', $post->id)
                ->where(function ($query) use ($post_tags, $post) {
                    foreach ($post_tags as $item) {
                        $query->orWhere('post_tags', 'like', "%$item%")
                            ->orWhere('post_title', 'like', $post->post_title);
                    }
                })
                ->inRandomOrder()
                ->take(3)
                ->get();
    
            $data = [
                'pageTitle' => Str::ucfirst($post->post_title),
                'post' => $post,
                'related_posts' => $related_posts
            ];
    
            return view('front.pages.single_posts', $data);
        }
    }
    public function tagPost(Request $request ,$tag ){
        $posts=Post::where('post_tags','like','%'.$tag.'%')
                    ->with('subcategory')
                    ->with('author')
                    ->orderBy('created_at', 'DESC')->paginate(6);

        if(!$posts){return abort(404);}
        $data=[
            'pageTitle'=>'#'.$tag,
            'posts'=>$posts
        ];
        return view('front.pages.tag_posts',$data);
    }
    public function contact(){

        $info = Setting::find(1);
        $data = [
            'pageTitle' => 'Contact',
            'info' => $info, // Pass the retrieved information to the view
        ];
    
        return view('front.pages.contact', $data);
    }
    //contact me 
    
    public function sendMail(Request $request){
        $details=[
            'name'=>$request->name,
            'email'=>$request->email,
            'subject'=>$request->subject,
            'message'=>$request->message
        ];
        Mail::to('devprogramme09@gmail.com')->send(new ContactFormMail($details) );
        return back()->with('message_sent','Your Message has been sent successefully');
    }
    
    
    
    
}
