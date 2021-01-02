<?php


namespace App\Services;


use App\Contracts\ExportContractInterface;
use App\Http\Resources\DocumentsDocumentTransformJson;
use App\Models\Document;

class JsonDocument implements ExportContractInterface
{

    private $document;

    /**
     * JsonDocument constructor.
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function getListDocumentTable()
    {
        return $this->documentCollectJson();
    }

    protected function documentCollectJson()
    {
        $data_documents = $this->document->orderBy('id')->get();
        return DocumentsDocumentTransformJson::collection($data_documents);
    }
}
