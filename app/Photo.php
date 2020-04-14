<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Photo extends Model
{
    protected $keyType = 'string';

    public function __construct(array $attribute = [])
    {
        parent::__construct();

        if (!Arr::get($attribute, 'id')) {
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
}
