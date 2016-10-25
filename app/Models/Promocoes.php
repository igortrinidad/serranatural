<?php

namespace serranatural\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Promocoes extends Model
{
	public $timestamps = true;

    protected $table = 'promocoes';

    protected $dates = ['inicio', 'fim'];

    protected $fillable = [
    	'titulo',
    	'inicio',
    	'fim',
    	'descricao',
        'regulamento',
    	'foto',
    	'is_ativo'
    ];

    /*
    * Adiciona o caminho hasheado para o arquivo no registro
    */
    protected $appends = ['foto_url'];

    //url foto
    public function getFotoUrlAttribute()
    {
        if($this->attributes['foto'])
        {
            return $this->getFileUrl($this->attributes['foto']);
        }

    }

    //get file url
    private function getFileUrl($key) {
        $s3 = \Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $bucket = \Config::get('filesystems.disks.s3.bucket');

        $command = $client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $key
        ]);

        $request = $client->createPresignedRequest($command, '+1440 minutes');

        return (string) $request->getUri();
    }

    public function setInicioAttribute($value)
    {
        return $this->attributes['inicio'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function setFimAttribute($value)
    {
        return $this->attributes['fim'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getInicioAttribute($value)
    {
        return $this->attributes['inicio'] = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    }

    public function getFimAttribute($value)
    {
        return $this->attributes['fim'] = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    }
}
