<?php


namespace App\Services;


interface ArchiveInterface
{
    public function createArchive($fileStream,$outputResult);
    public function createDirectoryArchive($dir,$outputResult);
}
