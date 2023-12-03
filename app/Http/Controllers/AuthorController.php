<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File; // Ajoutez cette ligne pour inclure la classe File
use App\Models\Setting;

use App\Models\Post;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Storage; 
use Intervention\Image\Facades\Image;




class AuthorController extends Controller
{
    //methode index
    public function index(Request $request){
        return view('back.pages.home');
    }
    //function logout
     public function logout(){
        Auth::guard('web')->logout();
        return redirect()->route('authorLogin');
     }

    //function resetForm
    public function RestForm(Request $request,$token=null){
        $data=[
            'pageTitle'=>'Rest Password'
        ];
        return view('back.pages.auth.rest',$data)->with(['token'=>$token,'email'=>$request->email]);

    }
    //function change picture profil::
    public function ChangeProfilPicture(Request $request){
        $user = User::find(auth('web')->id());
        $path = 'back/dist/img/authors/';
        $file = $request->file('file');
        $old_picture = $user->getAttributes()['picture'];
        $file_path = $path . $old_picture;
        $new_picture_name = '/'.'AIMG' . $user->id . time() . rand(1, 100000) . '.jpg';
    
        if ($old_picture != null && File::exists(public_path($file_path))) { // Utilisez File::exists au lieu de Files::exists
            File::delete(public_path($file_path)); // Utilisez File::delete au lieu de Files::delete
        }
        
        $upload = $file->move(public_path($path), $new_picture_name);
        
       
        
        if ($upload) {
            $user->update([
                'picture' => $new_picture_name
            ]);
          
            return response()->json(['status' => 1, 'Your Profile picture has been successfully updated']);
           
        } else {
            return response()->json(['status' => 0, 'Something went wrong']);
        }
    }
    public function changeBlogLogo(Request $request){
        $settings = Setting::find(1);
        $logo_path = '/back/dist/img/logo-favicon';
        $old_logo = $settings->getAttributes()['blog_logo'];
        $file = $request->file('blog_logo');
        $filename = time(). '_' . rand(1, 1000000) . '_blog_logo.png';
    
        if ($request->hasFile('blog_logo')) {
            if ($old_logo != null && file_exists(public_path($logo_path . $old_logo))) {
                File::delete(public_path($logo_path . $old_logo));
            }
    
            $upload = $file->move(public_path($logo_path), $filename);
    
            if ($upload) {
                $settings->update([
                    'blog_logo' => $filename
                ]);
                return response()->json(['statut' => 1, 'msg' => 'Logo has been  been successfully updated']);
            } else {
                return response()->json(['statut' => 0, 'msg' => 'Something went wrong']);
            }
        }
        
    }
    public function changeFaviconLogo(Request $request)
    {
        $settings = Setting::find(1);
        $faviconPath = '/back/dist/img/logo-favicon';
        $oldFavicon = $settings->blog_favicon;

        // Vous pouvez personnaliser l'extension autorisée pour le favicon, par exemple, '.ico'
        $allowedExtensions = ['ico'];

        $file = $request->file('blog_favicon');

        if ($request->hasFile('blog_favicon') && in_array($file->getClientOriginalExtension(), $allowedExtensions)) {
            // Générez un nom de fichier unique pour le favicon
            $filename = time() . '_' . rand(1, 1000000) . '_blog_favicon.ico';

            if ($oldFavicon != null && file_exists(public_path($faviconPath . $oldFavicon))) {
                File::delete(public_path($faviconPath . $oldFavicon));
            }

            $upload = $file->move(public_path($faviconPath), $filename);

            if ($upload) {
                $settings->update([
                    'blog_favicon' => $filename
                ]);

                return response()->json(['status' => 1, 'msg' => 'Favicon has been successfully updated']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Something went wrong']);
            }
        }

        return response()->json(['status' => 0, 'msg' => 'Invalid file format or no file uploaded']);
    }

    public function createPost(Request $request){
        $request->validate([
            'post_title' => 'required|unique:posts,post_title',
            'post_content' => 'required',
            'post_category' => 'required',
            'featured_image' => 'required|mimes:jpeg,jpg,png|max:1024',
            'post_tags'=>'required'
        ]);
        if($request->hasFile('featured_image')){
            $path = 'images/post_images/';
            $file=$request->file('featured_image');
            $filename=$file->getClientOriginalName();
            $new_filename=time().'_'.$filename;
            
            
            $upload=Storage::disk('public')->put($path.$new_filename,(string) file_get_contents($file));
            $post_thumbnails_path=$path.'thumbnails';
            if(!Storage :: disk('public')->exists($post_thumbnails_path)){
                Storage::disk('public')->makeDirectory($post_thumbnails_path,0755,true,true);
            }
            //create square thumbnail
            Image::make(storage_path('app/public/'.$path.$new_filename))
                ->fit(200,200)
                ->save(storage_path('app/public/'.$path.'thumbnails/'.'thumb_'.$new_filename));
    
            //create resized image
    
            Image ::make (storage_path('app/public/'.$path.$new_filename))
                ->fit(500,350)
                ->save(storage_path('app/public/'.$path.'thumbnails/'.'resized_'.$new_filename));
                

                /**$dom = new \DomDocument();
                $post_content = $request->post_content;
        
                $dom->loadHtml($post_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
                $imageFile = $dom->getElementsByTagName('imageFile');
        
                foreach($imageFile as $item => $image) {
                    $data = $image->getAttribute('src');
                    list($type, $data) = explode(';', $data);
                    list(, $data) = explode(',', $data);
                    $imgeData = base64_decode($data);
                    $image_name = 'storage/images/post_images/Upload_image' . time() . $item . '.png';
                    $path = public_path() . $image_name;
                    file_put_contents($path, $imgeData);
                    $image->removeAttribute('src');
                    $image->setAttribute('src', $image_name);
                }
        
                $post_content = $dom->saveHTML();*/
         
         
            if($upload){
                $post=new Post();
                $post->author_id=auth()->id();
                $post->category_id=$request->post_category;
                $post->post_title=$request->post_title;
                //$post->post_slug=Str::slug($request->post_title);
                $post->post_content=$request->post_content;
                $post->featured_image=$new_filename;
                $post->post_tags=$request->post_tags;
                $saved=$post->save();
                if($saved){
                    return response()->json(['code'=>1,'msg'=>'New post has been successfully created .']);
                }else{
                    return response()->json(['code'=>3,'msg'=>'Something went wrong ins saving post data.']);
                }
            }else{
                return response()->json(['code'=>3 ,'msg'=>'Somthing went wrong for uploading featured image']);
            }
        }
    }

    public function EditPost(Request $request){
        if(!request()->post_id){
            return abort(404);
        }else{
            $post =Post::find(request()->post_id);
            $data=[
                'post'=>$post,
                'pageTitle'=>'Edit Post',
            ];
            return view('back.pages.edit_post',$data);
        }
    }

    public function UpdatePost(Request $request){
        if($request->hasFile('featured_image')){
            $request->validate([
                'post_title'=>'required|unique:posts,post_title,'.$request->post_id,
                'post_content' => 'required',
                'post_category' => 'required',
                'featured_image' => 'required|mimes:jpeg,jpg,png|max:1024',
            ]);
            $path = 'images/post_images/';
            $file=$request->file('featured_image');
            $filename=$file->getClientOriginalName();
            $new_filename=time().'_'.$filename;
            
            
            $upload=Storage::disk('public')->put($path.$new_filename,(string) file_get_contents($file));
            $post_thumbnails_path=$path.'thumbnails';
            if(!Storage :: disk('public')->exists($post_thumbnails_path)){
                Storage::disk('public')->makeDirectory($post_thumbnails_path,0755,true,true);
            }
            //create square thumbnail
            Image::make(storage_path('app/public/'.$path.$new_filename))
                ->fit(200,200)
                ->save(storage_path('app/public/'.$path.'thumbnails/'.'thumb_'.$new_filename));
    
            //create resized image
    
            Image ::make (storage_path('app/public/'.$path.$new_filename))
                ->fit(500,350)
                ->save(storage_path('app/public/'.$path.'thumbnails/'.'resized_'.$new_filename));
                
            if($upload){
                $old_post_image=Post::find($request->post_id)->featured_image;
                if($old_post_image!=null && Storage::disk('public')->exists($path.$old_post_image)){
                    Storage::disk('public')->delete($path.$old_post_image);
                    if(Storage::disk('public')->exists($path.'thumbnails/resized_'.$old_post_image)){
                        Storage::disk('public')->delete($path.'thumbnails/resized_'.$old_post_image);
                    }
                    if(Storage::disk('public')->exists($path.'thumbnails/thumb_'.$old_post_image)){
                        Storage::disk('public')->delete($path.'thumbnails/thumb_'.$old_post_image);
                    }
    
                }
                $post=Post::find($request->post_id);
                $post->category_id=$request->post_category;
                $post->post_slug=null;
                $post->post_title=$request->post_title;
                $post->post_content=$request->post_content;
                $post->featured_image=$new_filename;
                $post->post_tags=$request->post_tags;

                $saved=$post->save();
                if($saved){
                    return response()->json(['code'=>1,'msg'=>'Post has been successfully updated.']);
    
                }else{
                    return response()->json(['code'=>3,'msg'=>'Something went wrong !']);
                }
            }else{
                return response()->json(['code'=>3,'msg'=>'Error in uploading new featured image !']);
            }
        }else{
            $request->validate([
                'post_title'=>'required|unique:posts,post_title,'.$request->post_id,
                'post_content'=>'required',
                'post_category'=>'required|exists:sub_categories,id'
            ]);
            $post=Post::find($request->post_id);
            $post->category_id=$request->post_category;
            $post->post_slug=null;
            $post->post_title=$request->post_title;
            $post->post_content=$request->post_content;
            $post->post_tags=$request->post_tags;

            $saved=$post->save();
            if($saved){
                return response()->json(['code'=>1,'msg'=>'Post has been successfully updated.']);

            }else{
                return response()->json(['code'=>3,'msg'=>'Something went wrong !']);
            }
        }
    }
    

   

    
}
