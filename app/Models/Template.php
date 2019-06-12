<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{


    protected $table = 'templatesEmail';

    protected $fillable = [
    						'id',
                            'nome',
    						'code',
    						'assunto',
    					];
}
