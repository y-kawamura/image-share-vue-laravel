<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class Photo extends Model
{
    protected $keyType = 'string';

    protected $appends = [
        'url', 'likes_count', 'liked_by_user'
    ];

    protected $visible = [
        'id', 'owner', 'url', 'comments', 'likes_count', 'liked_by_user'
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
     * Accessor - likes_count
     * @return string
     */
    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }

    /**
     * Accessor - liked_by_user
     * @return string
     */
    public function getLikedByUserAttribute()
    {
        if (Auth::guest()) {
            return false;
        }

        return $this->likes->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
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

    /**
     * The Relationship for user table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }
}
