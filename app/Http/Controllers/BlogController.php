<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\RepositoryBlog\BlogRepositoryInterface;
use App\Services\ArchiveInterface;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private $blog_repository;
    private $user;

    private $archive;

    /**
     * BlogController constructor.
     * @param $blog_repository
     */
    public function __construct(User $user,
                                BlogRepositoryInterface $blog_repository,
                                ArchiveInterface $archive
    )
    {
        $this->blog_repository = $blog_repository;
        $this->user = $user;
        $this->archive = $archive;
    }

    public function index()
    {
        $blogsDataAll = $this->blog_repository->allBlogs();
        return response()->json($blogsDataAll,200);
    }

    public function showBlogVersionV1($user_id)
    {
        $current_user = $this->user->find($user_id);
        $blogData = $this->blog_repository->getByUserId($current_user);
        return response()->json($blogData,200);
    }

    public function showBlog(Request $request)
    {
        $user = $request->user();
        $blog = $this->blog_repository->getByUserId($user);
        return response()->json($blog,200);
    }
}
