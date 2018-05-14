<?php

namespace Signifly\Configurable\Test\Models;

use Signifly\Configurable\Config;
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
        'name', 'email', 'config', 'extras',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'config' => 'array',
        'extras' => 'array',
    ];

    /**
     * Add custom config using extras attribute.
     *
     * @return \Signifly\Configurable\Config
     */
    public function getExtrasAttribute()
    {
        return new Config($this, 'extras');
    }
}
