<?php

namespace App\Models;

use App\Casts\CustomeCastAttributes;
use App\Casts\DateCasting;
use App\Casts\TestValueAttr;
use App\Contracts\Searchable;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory,Searchable;

    protected $primaryKey ='id';

    protected $table = 'documents';


    protected $casts = [
        'start_publish'=>'datetime:Y-m-d H:i:s',
        'end_publish'=>'datetime:Y-m-d H:i:s',
        'active'=>'boolean',
        'test_cast'=>CustomeCastAttributes::class,
        'value_test'=>TestValueAttr::class
    ];

    protected $attributes = [
        'value_test'
    ];

    protected $appends = [
        'value_test'
    ];

    protected $fillable = [
        'title',
        'description',
        'start_publish',
        'content',
        'active',
        'author',
        'value_test',
        'test_cast',
        'end_publish',
        'updated_at',
        'created_at'
    ];






    public function testM(){
        return $this->hasOne(Test::class,'document_id');
    }

    public function getValueTestAttribute()
    {
        return $this->testM->test_value;
    }

    public function setValueTestAttribute($value)
    {
        $this->attributes['value_test'] = $this->testM()
            ->updateOrCreate(['document_id' => $this->id],['test_value'=>$value]);
    }

    public function getTitleAuthorAttribute()
    {
        return "Author document: {$this->author} Name document: {$this->title}";
    }


    public function setAuthorTitleAttribute($author)
    {
        $author = Str::slug(Str::lower($author));
        $this->attributes['author'] = "{$author}@email_author.com";
    }


    /**
     * Отложеная публикация документов
     * @param $query
     * @return mixed
     */
    public function scopeDocumentsPublishDeferred($query)
    {
        return $query
            ->where([
                ['start_publish', '<=', Carbon::now()->format('Y-m-d H:i:s')],
                ['end_publish', '>', Carbon::now()->format('Y-m-d H:i:s')],
                ['active','=',true]
            ])
            ->orWhere([
                ['active','=',true],
                ['end_publish','=',null],
                ['start_publish','<=',Carbon::now()->format('Y-m-d H:i:s')]
            ])
            ->orWhere([
                ['active','=',true],
                ['end_publish', '>', Carbon::now()->format('Y-m-d H:i:s')],
                ['start_publish','=',null]
            ])
            ->orWhere([
                ['active','=',true],
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
