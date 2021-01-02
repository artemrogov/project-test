<?php


namespace App\Services;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use \PhpZip\ZipFile;


class Archive implements ArchiveInterface
{

    private $zip_archivator;

    /**
     * Archive constructor.
     * @param $zip_archivator
     */
    public function __construct(ZipFile $zip_archivator)
    {
        $this->zip_archivator = $zip_archivator;
    }


    public function createArchive($fileStream,$outputResult)
    {
        try {

            $currentFile = Storage::disk('public')->readStream($fileStream);

            return  $this->zip_archivator
                ->addFromStream($currentFile,'test.jpg')
                ->saveAsFile($outputResult);
        }catch (\PhpZip\Exception\ZipException $e){
            return $e->getMessage();
        }catch (FileNotFoundException $e) {
            return $e->getMessage();
        } finally {
            $this->zip_archivator->close();
        }
    }

    public function createDirectoryArchive($dir,$outputResult)
    {
        // TODO: Implement createDirectoryArchive() method.
    }

}
