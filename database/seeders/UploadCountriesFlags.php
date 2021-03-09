<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadCountriesFlags extends Seeder
{

    CONST FILE_FULL_SWIFT_DEV='https://dev.education-in-russia.com/static/flags_test';

    CONST FILE_FULL_SWIFT_PROD='https://education-in-russia.com/static/flags_test';

    CONST CHUNK_SIZE = 50;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flagsAll = Storage::disk('countries_flag_local')->files();
            Country::chunk(static::CHUNK_SIZE,function ($countries) use($flagsAll){
                foreach ($flagsAll as $flag){
                  foreach ($countries as $country){
                      $country->where('alpha_code','=',static::replaceFlagCountry($flag))
                          ->update(['country_logo'=>static::FILE_FULL_SWIFT_DEV.
                              $this->saveDiskFile($flag,'public_user_test')]);
                  }
              }
            });
    }

    public function saveDiskFile($fileName,$driver = 'local')
    {
        $file = Storage::disk('countries_flag_local')->url($fileName);
        $resultName = explode('/',$file)[7];
        return Storage::disk($driver)->putFileAs(
            '/',$file,
            static::generatePathVersion($resultName));
    }

    public static function replaceFlagCountry(string $flag,$ext='.png'):String
    {
        return Str::replaceLast($ext,'',$flag);
    }

    public static function generatePathVersion(string $fileName,string $baseName = 'countries/') : String
    {
        $hash = md5(rand(1, 999999));
        return $baseName.$hash[0] .'/'.$hash[1].'/'.$hash[2].'/'.$fileName;
    }
}
