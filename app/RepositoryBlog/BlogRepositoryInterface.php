<?php
namespace App\RepositoryBlog;

use App\Models\User;

interface BlogRepositoryInterface
{
    public function allBlogs();
    public function getByUserId(User $user);
}
