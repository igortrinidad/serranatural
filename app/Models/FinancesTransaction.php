<?php

namespace serranatural\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancesTransaction extends Model
{
    use SoftDeletes;

    /*
        Database
    */
    protected $connection= 'financeiro';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'company_id',
        'category_id',
        'account_id',
        'employee_id',
        'created_by',
        'confirmed_by',
        'confirmed_at',
        'expire_at',
        'name',
        'date',
        'value',
        'tax',
        'total',
        'observation',
        'boleto',
        'nota',
        'comprovante'
    ];

    /**
     * The accessors to append to the model's array.
     *
     * @var array
     */
    protected $appends = [
        'formatted_value', 
        'formatted_tax', 
        'formatted_total', 
        'created_at_formatted', 
        'nota_url',
        'boleto_url',
        'comprovante_url',
        'is_paid',
        'is_expired'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault([
        'name' => 'Não informado',
    ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class)->withDefault([
        'name' => 'Não informado',
    ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source()
    {
        return $this->hasOne(Source::class)->withDefault([
        'name' => 'Não informado',
    ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
        'name' => 'Não informado',
    ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function confirmed_by_user()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank_transaction()
    {
        return $this->hasOne(BankTransaction::class)->withDefault(['desc' => '', 'formatted_value' => '', 'value' => '']);
    }

    /**
     * @return string
     */
    public function getNotaUrlAttribute()
    {
        if (count($this->attributes) &&  $this->attributes['nota']) {
            return $this->getFileUrl($this->attributes['nota']);
        }

    }

    /**
     * @return string
     */
    public function getComprovanteUrlAttribute()
    {
        if (count($this->attributes) && $this->attributes['comprovante']) {
            return $this->getFileUrl($this->attributes['comprovante']);
        }

    }

    /**
     * @return string
     */
    public function getBoletoUrlAttribute()
    {
        if (count($this->attributes) && $this->attributes['boleto']) {
            return $this->getFileUrl($this->attributes['boleto']);
        }

    }

    /**
     * @return string
     */
    public function getFormattedValueAttribute()
    {
        if (count($this->attributes) && $this->attributes['value']) {
            return  'R$ ' . number_format($this->attributes['value'], 2, ",", ".");
        }
    }

    /**
     * @return string
     */
    public function getFormattedTaxAttribute()
    {
        if (count($this->attributes) && $this->attributes['tax']) {
            return  'R$ ' . number_format($this->attributes['tax'], 2, ",", ".");
        }
    }

    /**
     * @return string
     */
    public function getFormattedTotalAttribute()
    {
        if (count($this->attributes) && $this->attributes['total']) {
            return  'R$ ' . number_format($this->attributes['total'], 2, ",", ".");
        }
    }

    /**
     * @return string
     */
    public function getIsPaidAttribute()
    {
        if (count($this->attributes)) {
            
            if(!is_null($this->attributes['confirmed_at'])){
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @return string
     */
    public function getIsExpiredAttribute()
    {
        if (count($this->attributes)) {
            
            if(!is_null($this->attributes['confirmed_at'])){
                return false;
            } else {

                $today = new Carbon();

                $date = new Carbon($this->attributes['expire_at']);

                //Se a data de hoje for maior que a data de vencimento
                if ($today->gt($date) ){
                    return true;
                } else {
                    return false;
                }

            }
        }
    }

    /**
     * @return string
     */
    public function getCreatedAtFormattedAttribute()
    {
        if (count($this->attributes)){
            return date('d/m/Y H:i:s', strtotime($this->attributes['created_at'])); 
        }
    }


    /**
     * @return string
     */
    public function getDateAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }


    /**
     * @return string
     */
    public function getExpireAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));

    }

    /**
     * @return string
     */
    public function getConfirmedAtAttribute($value)
    {

        if (count($this->attributes) && $this->attributes['confirmed_at']) {
            return date('d/m/Y', strtotime($value));
        } else {
            return 'Pendente';
        }

    }

    /**
     * @param $key
     * @return string
     */
    private function getFileUrl($key)
    {
       	return (string)Storage::disk('media')->url($key);

    }


}
