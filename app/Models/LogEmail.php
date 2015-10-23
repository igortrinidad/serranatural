<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class LogEmail extends Model
{
    protected $table = 'log_emails';

    public $timestamps = true;

    protected $fillable = array('email', 'assunto', 'mensagem');

}
