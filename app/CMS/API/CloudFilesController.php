<?php

namespace App\CMS\API;

use App\CMS\Http\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class CloudFilesController extends BaseAdminController
{

    /**
     * CloudFilesController constructor.
     */
    public function __construct()
    {
        $this->middleware('api');
    }


    public function uploadFiles(Request $request)
    {
           try {
               $uploadedFileNames = [];
               if ($request->hasFile('files')) {
                   $files[] = $request->file('files');
                   foreach ($files as $file) {

                       $fileUploadData = $file->store('tests', 'test_user');

                       $existsFile = Storage::disk('test_user')
                           ->exists($fileUploadData);

                       if ($existsFile) {
                           $uploadedFileNames[] = [
                               'path_hash' => $fileUploadData,
                               'mime_type' => $file->getMimeType(),
                               'original_name' => $file->getClientOriginalName(),
                               'file_size' => $file->getSize(),
                               'file_extension' => $file->getClientOriginalExtension()
                           ];
                       }
                   }
                   if (0 < count($uploadedFileNames)) {
                       return response()->json($uploadedFileNames, 201);
                   } else {
                       return response()->json(['status' => 'Файлы не были загружены!'], 500);
                   }
               }
           }catch (\Exception $e){
               Log::alert('Фалы не были загружены!');
               return response()->json(['error'=>$e->getMessage()]);
           } finally {
               return 0;
           }
    }

}
