<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentsDocumentTransformJson extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id_document'=>$this->id,
          'name_document'=>$this->title,
          'description'=>$this->description,
          'text_document'=>$this->content
        ];
    }
}
