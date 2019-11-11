<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dado extends Model
{
    public $timestamps = false;
    protected $table = 'reativacao_claro';
    protected $dates = [
        'data_compra',
        'data_cancelamento'
    ];

    public function childrens()
    {
        return $this->hasMany(Dado::class, 'parent_id', 'ch_id');
    }
}
