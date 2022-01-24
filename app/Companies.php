<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $table = 'companies';
    public static function object_field($field, $id)
    {
        return self::select($field)->where('id', $id)->first()->$field;
    }
    public static function get_field($field)
    {
        return self::select($field)->get();
    }
}
