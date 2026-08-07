<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = ['name','email','password','role'];

    protected $hidden = ['password'];

    // Example: an admin can author blog posts
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }
}
