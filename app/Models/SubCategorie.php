<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategorie extends Model
{
    
    use HasFactory;
    protected $fillable = [
        'subcategorie_name',
        'slug',
        'parent_categorie',
        'ordering'
    ];

    public function parentcategory(){
        return $this->belongsTo(Category ::class,'parent_categorie','id');
    }
    public function posts(){
        return $this->hasMany(Post::class,'category_id','id');
    }
}
