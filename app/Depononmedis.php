<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depononmedis extends Model
{
    protected $table ="depo_po_nonmedis";
    
    public function depo()
	{
			return $this->belongsTo(Depo::class, 'id_depo');
	}
}
