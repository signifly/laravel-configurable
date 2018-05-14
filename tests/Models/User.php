<?php

namespace Signifly\Configurable\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Signifly\Configurable\Configurable;

class User extends Model
{
    use Configurable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'config',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'config' => 'array',
    ];
}
