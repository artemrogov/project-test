<?php


namespace App\RepositoryBlog;


use App\Models\Blog;
use App\Models\User;

class BlogRepository implements BlogRepositoryInterface
{

    public function allBlogs()
    {
        return Blog::all();
    }

    public function getByUserId(User $user)
    {
        return Blog::where('user_id',$user->id)->get();
    }

}
