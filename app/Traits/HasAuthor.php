<?php

namespace App\Traits;

trait HasAuthor
{


    public static function bootHasAuthor()
    {
        static::creating(function ($model) {
            $model->author_id = auth()->id();
        });
    }
}
