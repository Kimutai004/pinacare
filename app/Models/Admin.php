<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name','email','password','role'];

    protected $hidden = ['password'];

    // Example: an admin can author blog posts
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }
}
