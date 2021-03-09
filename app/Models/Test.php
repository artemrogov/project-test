<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $table = 'test_table';

    protected $primaryKey   = 'id';

    public $timestamps = false;

    protected $fillable = [
        'test_value'
    ];
}
