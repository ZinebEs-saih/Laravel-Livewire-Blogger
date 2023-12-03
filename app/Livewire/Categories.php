<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategorie;
use Illuminate\Support\Str;
use App\Models\Post;


class Categories extends Component
{
    public $category_name;
    public $selected_category_id;
    public $updateCategoryMode=false;
    public $subcategorie_name;
    public $parent_categorie =0 ;
    public $selected_subcategory_id;
    public $updateSubCategoryMode=false;

    protected $listeners=[
        'resetModalForm',
        'deleteCategoryAction',
        'deleteSubCategoryAction',
        'updateCategoryOrdering',
        'updateSubCategoryOrdering'
    ];
    
    public function resetModalForm(){
        $this->resetErrorBag();
        $this->category_name=null;
        $this->subcategorie_name=null;
        $this->parent_categorie=null;

    }

    public function addCategory(){
        $this->validate([
            'category_name'=>'required|unique:categories,category_name',
        ]);
        $category  = new Category();
        $category->category_name=$this->category_name;
        $saved=$category->save();
        if($saved){
            $this->dispatch('hideCategoriesModal');
            $this->dispatch('toastr:success', ['message' => 'New Category has been Successfully added']);
        }else{
            $this->dispatch('toastr:error', ['message' => 'Somthing went wrong!!']);
        }
    }
    public function editCategory($id) {
        $category = Category::findOrFail($id);
        $this->selected_category_id=$category->id;
        $this->category_name=$category->category_name;
        $this->updateCategoryMode=true;
        $this->resetErrorBag();
        $this->dispatch('showCatgoriesModal');
    }
    public function updateCategory(){
        $this->validate([
            'category_name'=>'required|unique:categories,category_name',
        ]);
        $category= Category::findOrFail($this->selected_category_id);
        $category->category_name=$this->category_name;
        $update=$category->save();
        if($update){
            $this->dispatch('hideCategoriesModal');
            $this->updateCategoryMode=false;
            $this->dispatch('toastr:success', ['message' => 'Category has been successfullt updated ']);
        }else{
            $this->dispatch('toastr:error', ['message' => 'Somthing went wrong!!']);
        }
    }
    //delete Category
    public function deleteCategory($id){
        $category = Category::find($id);
        $this->dispatch('deleteCategorie',[
            'title'=>'Are you sure?',
            'html'=>'You want to delete <b>'.$category->category_name.'</b> category .',
            'id'=>$id,

        ]);
    }
     //Action
    public function deleteCategoryAction($id){
        $category=Category::where('id',$id)->first();
        $subcategory = SubCategorie::where('parent_categorie', $category->id)
        ->whereHas('posts')
        ->with('posts')
        ->get();
        if(!empty($subcategory) && count($subcategory)>0){
            $totalPost=0;
            foreach($subcategory as $subcat){
                $totalPost += Post::where('category_id',$subcat->id)->get()->count();
            }
            $this->dispatch('toastr:error', ['message' => 'This category has ( '.$totalPost.' posts related to it , cannot be deleted .']);
        }else{
            SubCategorie::where('parent_categorie',$category->id)->delete();
            $category->delete();
            $this->dispatch('toastr:success', ['message' => 'Category has been successfullt deleted .']);

        }
    }
    public function addSubCategory(){
        $this->validate([
            'parent_categorie'=>'required',
            'subcategorie_name'=>'required|unique:sub_categories,subcategorie_name',
        ]);
        $subcategory=new SubCategorie();
        $subcategory->subcategorie_name=$this->subcategorie_name;
        $subcategory->slug=Str::slug($this->subcategorie_name);
        $subcategory->parent_categorie=$this->parent_categorie;
        $saved =$subcategory->save();
        if($saved){
            $this->dispatch('hideSubCategoriesModal');
            $this->parent_categorie=null;
            $this->subcategorie_name=null;
            $this->dispatch('toastr:success', ['message' => 'New subcategory has been Successfully added']);
        }else{
            $this->dispatch('toastr:error', ['message' => 'Somthing went wrong!!']);
        }


    }
    public function editSubCategory($id){
        $Subcategory = SubCategorie::findOrFail($id);
        $this->selected_subcategory_id=$Subcategory->id;
        $this->subcategorie_name=$Subcategory->subcategorie_name;
        $this->parent_categorie=$Subcategory->parent_categorie;

        $this->updateSubCategoryMode=true;
        $this->resetErrorBag();
        $this->dispatch('showSubCatgoriesModal');
    }

    public function updateSubCategory(){
        if($this->selected_subcategory_id){
            $this->validate([
                'parent_categorie' => 'required',
                'subcategorie_name' => 'required|unique:sub_categories,subcategorie_name,'.$this->selected_subcategory_id
            ]);
            $Subcategory= SubCategorie::findOrFail($this->selected_subcategory_id);
            $Subcategory->subcategorie_name=$this->subcategorie_name;
            $Subcategory->slug=Str::slug($this->subcategorie_name);
            $Subcategory->parent_categorie==$this->parent_categorie;

            $update=$Subcategory->save();
            if($update){
                $this->dispatch('hideSubCategoriesModal');
                $this->updateSubCategoryMode=false;
                $this->dispatch('toastr:success', ['message' => 'SubCategory has been successfullt updated ']);
            }else{
                $this->dispatch('toastr:error', ['message' => 'Somthing went wrong!!']);
            }
        }
    }

    public function deleteSubCategory($id){
        $subcategory = SubCategorie::find($id);
        $this->dispatch('deleteSubCategorie',[
            'title'=>'Are you sure?',
            'html'=>'You want to delete <b>'.$subcategory->subcategorie_name.'</b> category .',
            'id'=>$id,

        ]);
    }
    //Action 
    public function deleteSubCategoryAction($id){
        $subcategory = SubCategorie::where('id',$id)->first();
        $posts=Post::where('category_id',$subcategory->id)->get()->toArray();

        if(!empty($posts) && count($posts)>0){
            $this->dispatch('toastr:error', ['message' => 'This category has ( '.count($posts).' posts related to it , cannot be deleted .']);

        }else{
            $subcategory->delete();
            $this->dispatch('toastr:success',['message'=>'Subcategory has been  Successfully']);
        }

    }

    public function updateCategoryOrdering($positions){
        foreach($positions as $position){
            $index=$position[0];
            $newPosition = $position[1];
            Category::where('id',$index)->update([
                'ordering'=>$newPosition
            ]);

        }
        $this->dispatch('toastr:success',['message'=>'Categories ordering have have been  Successfully updated']);


    }

    public function updateSubCategoryOrdering($positions){
        foreach($positions as $position){
            $index=$position[0];
            $newPosition = $position[1];
            SubCategorie::where('id',$index)->update([
                'ordering'=>$newPosition
            ]);

        }
        $this->dispatch('toastr:success',['message'=>'Subcategories ordering have have been  Successfully updated']);

    }
    public function render()
    {
        return view('livewire.categories',[
            'categories'=>Category::orderBy('ordering','asc')->get(),
            'subCategories'=>SubCategorie::orderBy('ordering','asc')->get()
        ]);
    }
   
}
