<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    protected $keyType = 'string';

    protected $appends = [
        'url'
    ];

    protected $visible = [
        'id', 'owner', 'url', 'comments',
    ];

    protected $perPage = 8;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!Arr::get($attributes, 'id')) {
            $this->setId();
        }
    }

    private function setId()
    {
        $this->attributes['id'] = $this->getRandomId();
    }

    /**
     * create random string (32 characters)
     * @return string 
     */
    private function getRandomId()
    {
        return md5(uniqid(mt_rand(), true));
    }

    /**
     * Accessor - url
     * @return string
     */
    public function getUrlAttribute()
    {
        return Storage::cloud()->url($this->attributes['filename']);
    }

    /**
     * The Relationship for users table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }

    /**
     * The Relationship for comment table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }
}
