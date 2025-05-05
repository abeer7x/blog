<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=['title' 
    ,'is_published',
    'body',
    'slug' 
    ,'publish_date' ,'meta_description','tags'];
}
