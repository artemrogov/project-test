<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'type_documents';

    protected $fillable =[
        'type_document',
        'created_at',
        'updated_at'
    ];

    public function document()
    {
        return $this->hasOne(Document::class,'type_id','id');
    }
}
