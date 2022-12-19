<?php

namespace App\Traits;

trait HasAuthor
{


    public static function bootHasAuthor()
    {
        static::creating(function ($model) {
            if($model->author_id == null){
                $model->author_id = auth()->id();

            }
        });
    }
}
