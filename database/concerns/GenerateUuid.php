<?php

namespace App\database\concerns;

use Illuminate\Support\Str;

trait GenerateUuid
{
    protected static function bootUsesUuid()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->{$model->primaryKey}) {
                $model->{$model->primaryKey} = (string) Str::uuid();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}