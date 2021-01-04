<?php


namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface DocumentInterface
{
    public function search(string $query = '') : Collection;

    public function getDocumentsList() :Collection;

}
