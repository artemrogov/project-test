<?php

namespace Tests\Feature;

use Database\Seeders\UploadCountriesFlags;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountryImageReplace extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testReplaceFlagFilter()
    {
        $seeder = new UploadCountriesFlags();
        $image = 'TEST.png';
        $result = $seeder->replaceFlagCountry($image);
        $type = (gettype($result) === 'string') ? true : false;
        $this->assertEquals($result,'TEST') && $this->assertTrue($type);
    }

}
