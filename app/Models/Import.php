<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model

{
    protected $table = 'imports';

    protected $fillable = array('data');

}
