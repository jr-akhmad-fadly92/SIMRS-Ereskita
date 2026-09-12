<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depoinv extends Model
{
    protected $table ="depo_po_inv";
    
    public function depo()
	{
			return $this->belongsTo(Depo::class, 'id_depo');
	}
}
