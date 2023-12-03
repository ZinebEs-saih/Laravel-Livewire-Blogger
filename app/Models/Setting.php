<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'blog_name',
        'blog_email',
        'blog_phone',
        'blog_description',
        'blog_logo',
        'blog_favicon'
    ];
}
