<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\Exception\FileException;



class ApiFileSwiftTesting extends Controller
{


    const STORAGE_PUBLIC = "public_user";

    /**
     * Приватное хранилище
     */
    const STORAGE_DOCUMENT = "swift";

    /**
     * Хранилище с видеозаписями с собеседования
     */
    const STORAGE_VIDEOMOST = "videomost";

    /**
     * Хранилище для чата
     */
    const STORAGE_CHAT = "chat_storage";



    public function uploadFiles(Request $request)
    {

        try {

            $files = $request->file('files');

            $zone = $this->getZoneStorageFiles($request->has('zone') ? $request->input('zone') : 'swift');

            if (is_null($files)) {
                throw new \Exception("No files to upload");
            }

            $userId = $request->user()->id;

            $dataPath = collect();

            foreach ($files as $file) {

                $fileUploadData = $file->store("users/user-{$userId}", $zone);

                $existsFile = Storage::disk($zone)->exists($fileUploadData);

                if ($existsFile) {
                    $dataPath[] = [
                        'path_hash' => $fileUploadData,
                        'user_id' => $userId,
                        'mime_type' => $file->getMimeType(),
                        'original_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                        'file_extension' => $file->getClientOriginalExtension()
                    ];
                }
            }

            self::saveDataFiles($dataPath->values()->toArray());

            $files = DB::table('s3_storage_files')->select('id', 'path_hash')->whereIn('path_hash', $dataPath->pluck('path_hash'))->get();

            return response()->json([
                'data' => $files,
                'metadata_files' => [
                    'status' => 'upload files',
                    'count_upload_object' => count($dataPath)
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['status_msg' => $e->getMessage()], 400);
        }
    }



    public function getFileDataBase64Encode(Request $request)
    {
        $path_file_cloud = $request->get('path_hash');

        $zone = $this->getZoneStorageFiles($request->has('zone') ? $request->input('zone') : 'swift');

        $existFile = self::existsFile($path_file_cloud);

        if ($existFile) {

            $file = Storage::disk($zone)->get($path_file_cloud);

            $metadata = $this->getMetadataFile($path_file_cloud);

            $fileDecodeBase64 = base64_encode($file);

            return response()->json([
                'data' => [
                    'path_hash' => $metadata->path_hash,
                    'file_extension' => $metadata->file_extension,
                    'size_bytes' => $metadata->file_size,
                    'mime_type' => $metadata->mime_type,
                    'original_name' => $metadata->original_name,
                    'file_encode_base64' => $fileDecodeBase64,
                ]], 200);
        } else {
            return response()->json([
                'status_txt' => 'Запрашиваемый файл не найден',
            ], 404);
        }
    }


    public function getOnlyBase64File(Request $request)
    {
        $path_file_cloud = $request->get('path_hash');
        $zone = $this->getZoneStorageFiles($request->has('zone') ? $request->input('zone') : 'swift');
        $existFile = self::existsFile($path_file_cloud);

        if (!$existFile) {
            return response()->json([
                'status_txt' => 'Запрашиваемый файл не найден',
            ], 404);
        }

        $file = Storage::disk($zone)->get($path_file_cloud);
        $fileDecodeBase64 = base64_encode($file);

        return response($fileDecodeBase64);
    }


    public function deleteFiles(Request $request)
    {
        $data = (array)$request->input('data');

        $zone = $this->getZoneStorageFiles($request->has('zone') ? $request->input('zone') : 'swift');

        $deletedObjects = collect();

        foreach ($data as $file) {

            $result = Storage::disk($zone)->delete($file['path_hash']);

            $deletedObjects[] = [
                'path_hash' => $file['path_hash'],
                'deleted' => $result,
            ];
        }

        $db_row_delete = $deletedObjects->where('deleted', true)->values()->pluck('path_hash')->toArray();

        if (count($db_row_delete) > 0) {
            DB::connection('zhps')->table('s3_storage_files')->whereIn('path_hash', $db_row_delete)->delete();
        }

        return response()->json([
            'data' => $deletedObjects
        ], 200);
    }



    public function getFilesCurrentUser(Request $request)
    {

        try {

            $currentUser = $request->user();

            $limit = empty($request->get('limit')) ? 10 : $request->get('limit');

            if (is_null($currentUser)) {
                throw new \Exception("Error is null user object");
            }

            $dataUserFiles = DB::connection('zhps')->table('s3_storage_files')
                ->where('user_id', '=', $currentUser->id)
                ->paginate($limit);

            return response()->json($dataUserFiles, 200);

        } catch (\Exception $e) {
            return response()->json(['error_msg' => $e->getMessage()], 400);
        }
    }



    public function savePublicStorageFiles(Request $request)
    {

        try {

            $files = $request->file('files');
            $dataPath = collect();

            if (is_null($files)) {
                throw new \Exception("files array null");
            }

            foreach ($files as $file) {

                $fileUploadData = $file->store('/', 'public_user');

                $existsFile = Storage::disk('public_user')->exists($fileUploadData);

                if (empty($existsFile)) {
                    continue;
                }

                $dataPath[] = [
                    'path_hash' => $fileUploadData,
                    'mime_type' => $file->getMimeType(),
                    'original_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'file_extension' => $file->getClientOriginalExtension()
                ];
            }

            return response()->json(['data' => $dataPath], 200);

        } catch (\Exception $fileNullableError) {
            return response()->json([
                'error_message' => $fileNullableError->getMessage()
            ]);
        }

    }



    public function getPublicStorageFiles()
    {
        $dataPath = Storage::disk('public_user')->files();

        $dataFilesInfo = collect();

        foreach ($dataPath as $filePath) {
            $dataFilesInfo[] = $this->getMetadataFileStorage($filePath);
        }

        return response()->json(['data' => $dataFilesInfo], 200);
    }


    /**
     * Получение типа файла
     * @param $path
     * @param string $zone
     * @return mixed
     */
    protected function getMimeTypeStorage($path, $zone = 'public_user')
    {
        $fileExists = Storage::disk($zone)->exists($path);

        if ($fileExists) {
            return Storage::disk($zone)->getMimetype($path);
        }
    }


    /**
     * Размер файла
     * @param $path
     * @param string $zone
     * @return int
     */
    protected function getSizeStorage($path, $zone = 'public_user')
    {
        $fileExists = Storage::disk($zone)->exists($path);

        if ($fileExists) {
            return Storage::disk($zone)->getSize($path);
        } else {
            return 0;
        }

    }

    /**
     * Получение полных методанных по файлам
     * @param $path
     * @param string $zone
     * @return array
     */
    protected function getMetadataFileFullStorage($path, $zone = 'public_user'): array
    {
        try {

            $fileResource = Storage::disk($zone)->get($path);

            return [
                'path_hash' => $path,
                'base64_decode' => base64_encode($fileResource),
                'mime_type' => $this->getMimeTypeStorage($path, $zone),
                'file_size' => $this->getSizeStorage($path, $zone),
            ];

        } catch (FileNotFoundException $fileNotFoundException) {

            return [
                'msg_en' => $fileNotFoundException->getMessage(),
                'msg_ru' => 'Запрошенный файл не найден',
            ];
        }

    }


    protected function getMetadataFileStorage($path, $zone = 'public_user'): array
    {

        $fileExists = Storage::disk($zone)->exists($path);

        if ($fileExists) {
            return [
                'path_hash' => $path,
                'mime_type' => $this->getMimeTypeStorage($path, $zone),
                'file_size' => $this->getSizeStorage($path, $zone),
            ];
        } else {
            throw new \Exception();
        }
    }



    public function getPublicStorageFile(Request $request)
    {
        $filePath = $request->input('path_hash');

        $exists = Storage::disk('public_user')->exists($filePath);

        if (!$exists) {

            return response()->json(['msg' => 'File not found!', 'exists_file' => false], 404);
        }

        return response()->json(['file_name' => $filePath, 'exists_file' => true], 200);

    }



    public function deletePublicFiles(Request $request)
    {

        $data = (array)$request->input('data');

        $deletedObjects = collect();

        foreach ($data as $file) {

            $result = Storage::disk('public_user')->delete($file['path_hash']);

            $deletedObjects[] = [
                'path_hash' => $file['path_hash'],
                'deleted' => $result,
            ];
        }

        return response()->json([
            'data' => $deletedObjects
        ], 200);
    }


    /**
     * Проверка на существования файла в хранилище swift S3
     * @param $file_path
     * @return mixed
     */
    private static function existsFile($file_path)
    {
        return Storage::disk('swift')->exists($file_path);
    }


    /**
     * @param $file_path
     * @param string $zone
     * @return bool
     */
    private static function existsFileStorage($file_path, $zone = 'public_user')
    {
        return Storage::disk($zone)->exists($file_path);
    }

    /**
     * Сохранение методанных о файле в БД
     * @param array $data
     */
    private static function saveDataFiles(array $data): void
    {
        if (!empty($data)) {
            DB::table('s3_storage_files')->insert($data);
        }
    }

    /**
     * Получить методанные по текущему файлу
     * @param string $hash
     * @return mixed
     */
    private function getMetadataFile(string $hash)
    {
        return DB::table('s3_storage_files')->where('path_hash', '=', $hash)->first();
    }


    /**
     * Тип зоны хранения файла
     * @param $zone
     * @return string
     */
    private function getZoneStorageFiles($zone)
    {
        switch ($zone) {
            case 'chat':
                return 'chat_storage';
            case 'videos':
                return 'videomost';
            default:
                return 'swift';
        }
    }


    /**
     * Метод для тестирования работы
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testUploadChatStorage(Request $request)
    {

        $zone = $this->getZoneStorageFiles($request->has('zone') ? $request->input('zone') : 'swift');

        $files = $request->file('files');

        $collData = collect();

        foreach ($files as $file) {
            $collData[] = $file->store('/', $zone);
        }

        return response()->json($collData, 200);

    }
}
