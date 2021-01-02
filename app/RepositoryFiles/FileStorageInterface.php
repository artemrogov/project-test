<?php


namespace App\RepositoryFiles;


use App\Models\User;

interface FileStorageInterface
{
    public function getFilesListCurrentUser(User $user);
    public function getFilesCurrentUser(User $user);
    public function saveFileInfo(User $user);
    public function deleteFileInfo(User $user);
}
