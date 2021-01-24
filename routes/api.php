<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use OpenStack\ObjectStore\v1\Models\StorageObject;

use GuzzleHttp\Psr7\Stream;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('/docs',Api\Documents::class);


/**
 * Список объектов текущего бакета(контейнера)
 */
Route::get('/list-object-test',function(){

    $openstack = new OpenStack\OpenStack([
        'authUrl' => 'http://172.29.11.152:5000/v3',
        'region'  => 'RegionOne',
        'user'    => [
            'name'     => 'admin',
            'password' => 'xE777succ89-0',
            'domain'   => ['id' => 'default']
        ],
        'scope' => [
            'project' => ['id' => '47ee094a26b8437fab3f738fce82e2b4']
        ]
    ]);


    $container = $openstack->objectStoreV1()
        ->getContainer('test_documents');

    $dataObject = collect();

    foreach ($container->listObjects() as $object) {
        $dataObject[] = [
            'hash_s3'=>$object->hash,
            'name'=>$object->name,
            'size_object'=>$object->contentLength,
            'last_modified'=>$object->lastModified,
            'backet_name'=>$object->containerName
        ];
    }

    $resultDataListFiles = $dataObject->toArray();

    return response()->json($resultDataListFiles,200);

});

/**
 * Загрузка файла
 */
Route::post('/upload-file',function(Request $request){

    $file = $request->file('current_file');

    $fileNameOriginal = $file->getClientOriginalName();

    $openstack = new OpenStack\OpenStack([
        'authUrl' => 'http://172.29.11.152:5000/v3',
        'region'  => 'RegionOne',
        'user'    => [
            'name'     => 'admin',
            'password' => 'xE777succ89-0',
            'domain'   => ['id' => 'default']
        ],
        'scope' => [
            'project' => ['id' => '47ee094a26b8437fab3f738fce82e2b4']
        ]
    ]);

    $contentFileStream = new Stream(fopen($file->getRealPath(), 'r'));

    $options = [
        'name'    => $fileNameOriginal,
        'stream' =>$contentFileStream
    ];

    $object = $openstack->objectStoreV1()
        ->getContainer('test_documents')
        ->createObject($options);

    $createdObject = $object->getPublicUri();

    return response()->json(['data'=>['metadata'=>$createdObject]],201);

});

/***
 * metadata
 */


Route::get('/get-metadata-file',function(Request $request){

    $file_name = $request->input('file_name');

    $openstack = new OpenStack\OpenStack([
        'authUrl' => 'http://172.29.11.152:5000/v3',
        'region'  => 'RegionOne',
        'user'    => [
            'name'     => 'admin',
            'password' => 'xE777succ89-0',
            'domain'   => ['id' => 'default']
        ],
        'scope' => [
            'project' => ['id' => '47ee094a26b8437fab3f738fce82e2b4']
        ]
    ]);

    $metadata = $openstack->objectStoreV1()
        ->getContainer('test_documents')
        ->getObject($file_name)
        ->getMetadataV3();

    return response()->json($metadata,200);

});


Route::delete('/delete-object',function (Request $request){

    $file_name = $request->input('file_name');

    $openstack = new OpenStack\OpenStack([
        'authUrl' => 'http://172.29.11.152:5000/v3',
        'region'  => 'RegionOne',
        'user'    => [
            'name'     => 'admin',
            'password' => 'xE777succ89-0',
            'domain'   => ['id' => 'default']
        ],
        'scope' => [
            'project' => ['id' => '47ee094a26b8437fab3f738fce82e2b4']
        ]
    ]);

    $openstack->objectStoreV1()
        ->getContainer('test_documents')
        ->getObject($file_name)
        ->delete();

    return response()->json('delete object',204);

});



/**
 * GET OBJECT
 */

Route::get('/get-object',function (Request $request){

    $file_name = $request->input('file_name');

    $openstack = new OpenStack\OpenStack([
        'authUrl' => 'http://172.29.11.152:5000/v3',
        'region'  => 'RegionOne',
        'user'    => [
            'name'     => 'admin',
            'password' => 'xE777succ89-0',
            'domain'   => ['id' => 'default']
        ],
        'scope' => [
            'project' => ['id' => '47ee094a26b8437fab3f738fce82e2b4']
        ]
    ]);

    $object = $openstack->objectStoreV1()
        ->getContainer('test_documents')
        ->getObject($file_name)
        ->download(['requestOptions' => ['stream' => true]]);

    $data = base64_encode($object);

    return response()->json(['data'=>$data],200);

});

