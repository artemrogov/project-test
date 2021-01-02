<?php

namespace App\Http\Controllers;

use App\Contracts\ExportContractInterface;
use App\Models\Document;
use Carbon\Carbon;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentsController extends Controller
{

    public function getParseDocument(ExportContractInterface $export)
    {
        $nameDocument = Carbon::now()->format('d_m_Y_h_i_s');
        $format = '.json';

        $path_docs = 'exports/documents/';

        $fullNameResultFile = $path_docs.$nameDocument.$format;

        Storage::disk('public')
            ->put("{$fullNameResultFile}",
            json_encode($export->getListDocumentTable())
        );

        return Storage::disk('public')->download($fullNameResultFile);
    }


    /**
     * Список документов
     * @param Document $document
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getDocuments(Document $document)
    {
        $documents = $document->documentsPublishDeferred();
        $data = $documents->get();
        return view('documents',compact('data'));
    }

}
