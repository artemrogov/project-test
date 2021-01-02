<?php

namespace App\Http\Controllers;

use App\MyClass\HelloWorld;
use App\MyClass\Mathematic;
use App\MyFacades\Math;
use App\MyFacades\MyStrFacade;
use App\RepositoryFiles\FileStorageInterface;
use Illuminate\Http\Request;

class FilesUsersController extends Controller
{

    private $files_repository;

    /**
     * FilesUsersController constructor.
     * @param $files_repository
     */
    public function __construct(FileStorageInterface $files_repository)
    {
        $this->files_repository = $files_repository;
    }


    public function getListFilesUser(Request $request){
        $current_user = $request->user();
        $data = $this->files_repository->getFilesListCurrentUser($current_user);
        return response()->json($data,200);
    }

    public function testPage()
    {
        return HelloWorld::hello_world();
    }

    public function getTest02()
    {
        return Mathematic::sum(56,23);
    }

}
