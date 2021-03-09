<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $connection = 'global';

    protected $table = 'countries';

    protected $fillable = [
      'alpha_code',
      'quota',
      'start_campaign',
      'end_campaign',
      'rs_code',
      'country_logo',
      'created_at',
      'updated_at'
    ];
}
