<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ParserData extends Model
{
    use HasFactory;

    protected $primaryKey = 'uid';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'test_value'
    ];

    protected $attributes = [
        'name',
        'description',
        'test_value'
    ];

    protected $appends = [
        'name',
        'description',
        'test_value'
    ];

    public $options = [
        'name',
        'description',
        'test_value'
    ];

    public function getNameAttribute()
    {
        return $this->attributes['name'];
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
    }

    public function getTestValueAttribute()
    {
        return $this->attributes['test_value'];
    }

    public function setTestValueAttribute($value)
    {
        $this->attributes['test_value'] = $value;
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description'];
    }

    public function setDescriptionAttribute($value)
    {
        return $this->attributes['description'] = $value;
    }


    public function save(array $options = [])
    {

        $options['title'] = $this->name;
        $options['description'] = $this->description;
        $options['test_value'] = $this->test_value;
        return $options;
    }

}
