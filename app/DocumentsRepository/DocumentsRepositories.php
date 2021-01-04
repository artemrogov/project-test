<?php


namespace App\DocumentsRepository;


use App\Contracts\DocumentInterface;
use App\Models\Document;
use Illuminate\Database\Eloquent\Collection;


class DocumentsRepositories implements DocumentInterface
{

    public function search(string $query = ''): Collection
    {
        return Document::documentsPublishDeferred()
            ->where('content','LIKE',"{$query}")
            ->orWhere('title','like',"{$query}")
            ->get();
    }

    public function getDocumentsList(): Collection
    {
        return Document::documentsPublishDeferred()->get();
    }


}
