<?php


namespace App\RepositoryFiles;


use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

class FilesRepository implements FileStorageInterface
{
    public function getFilesListCurrentUser(User $user)
    {
        return $user->files;
    }

    public function getFilesCurrentUser(User $user)
    {
        // TODO: Implement getFilesCurrentUser() method.
    }

    public function saveFileInfo(User $user)
    {
        $user->files()->create();
        Storage::files();
    }

    public function deleteFileInfo(User $user)
    {
        // TODO: Implement deleteFileInfo() method.
    }

}
