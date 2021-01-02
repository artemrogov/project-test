<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $primaryKey ='id';
    protected $table = 'documents';

    protected $fillable = [
        'title',
        'description',
        'start_publish',
        'end_publish',
        'updated_at',
        'created_at'
    ];


    /**
     * Отложеная публикация документов
     * @param $query
     * @return mixed
     */
    public function scopeDocumentsPublishDeferred($query)
    {
        return $query
            ->where('start_publish', '<=', Carbon::now()->format('Y-m-d H:i:s'))
            ->where('end_publish', '>', Carbon::now()->format('Y-m-d H:i:s'))
            ->orWhere([
                ['end_publish','=',null],
                ['start_publish','<=',Carbon::now()->format('Y-m-d H:i:s')]
            ])
            ->orWhere([
                ['end_publish', '>', Carbon::now()->format('Y-m-d H:i:s')],
                ['start_publish','=',null]
            ])
            ->orWhere([
                ['end_publish', '=', null],
                ['start_publish','=',null]
            ]);
    }


    /**
     * Тп документа - обратное отношение один ко одному типу
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(TypeDocument::class,
            'type_document_id','id'
        );
    }
}
