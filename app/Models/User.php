<?php

namespace App\Models;

use App\Models\File\FilesModule\Models\FileCloud;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'param1'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getRouteKeyName()
    {
        return 'email';
    }

    /**
     * акссесор имя и почта пользователя
     * вызов User::first()->email_name
     * @return string
     */
    public function getEmailNameAttribute()
    {
        return "Name: {$this->name} Email: {$this->email}";
    }

}
