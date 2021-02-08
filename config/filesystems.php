<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],


        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],


        'swift' => [
            'driver' => 'swift',
            'authUrl'   => env('OS_AUTH_URL', 'http://172.29.11.152:5000/v3'),
            'region'    => env('OS_REGION_NAME', 'RegionOne'),
            'user'      => env('OS_USERNAME', 'admin'),
            'domain'    => env('OS_USER_DOMAIN_NAME', 'default'),
            'password'  => env('OS_PASSWORD', 'xE777succ89-0'),
            'container' => env('OS_CONTAINER_NAME', 'test_upload_files'),
            'projectId'=>env('PROJECT_ID','47ee094a26b8437fab3f738fce82e2b4')
        ],

        'videomost' => [
            'driver' => 'swift',
            'authUrl'   => env('VOS_AUTH_URL', 'http://172.29.11.152:5000/v3'),
            'region'    => env('VOS_REGION_NAME', 'RegionOne'),
            'user'      => env('VOS_USERNAME', 'video'),
            'domain'    => env('VOS_USER_DOMAIN_NAME', 'default'),
            'password'  => env('VOS_PASSWORD', 'x43oP19m77gY'),
            'container' => env('VOS_CONTAINER_NAME', 'videos'),
            'projectId' => env('VOS_PROJECT_ID','5ef61f52cc2c48b2b1f0948de0c8773b')
        ],

        'chat_storage' => [
            'driver' => 'swift',
            'authUrl'   => env('CS_AUTH_URL', 'http://172.29.11.152:5000/v3'),
            'region'    => env('CS_REGION_NAME', 'RegionOne'),
            'user'      => env('CS_USERNAME', 'video'),
            'domain'    => env('CS_USER_DOMAIN_NAME', 'default'),
            'password'  => env('CS_PASSWORD', 'x43oP19m77gY'),
            'container' => env('CS_CONTAINER_NAME', 'chat'),
            'projectId' => env('CS_PROJECT_ID','5ef61f52cc2c48b2b1f0948de0c8773b')
        ],

        'public_user' => [
            'driver' => 'swift',
            'authUrl'   => env('PUB_AUTH_URL', 'http://172.29.11.152:5000/v3'),
            'region'    => env('PUB_REGION_NAME', 'RegionOne'),
            'user'      => env('PUB_USERNAME', 'video'),
            'domain'    => env('PUB_USER_DOMAIN_NAME', 'default'),
            'password'  => env('PUB_PASSWORD', 'x43oP19m77gY'),
            'container' => env('PUB_CONTAINER_NAME', 'public_user'),
            'projectId' => env('PUB_PROJECT_ID','5ef61f52cc2c48b2b1f0948de0c8773b'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
