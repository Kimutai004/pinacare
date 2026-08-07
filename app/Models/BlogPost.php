<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = ['title','slug','content','author_id','published_at'];

    public function author()
    {
        return $this->belongsTo(Admin::class, 'author_id');
    }
}
