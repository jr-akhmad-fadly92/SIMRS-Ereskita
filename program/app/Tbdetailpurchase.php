<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbdetailpurchase extends Model
{
    protected $table ='tb_detail_purchase';
    protected $fillable =[
        'dpo_id',
        'dpo_no_purchaseorder',
        'dpo_item_id',
        'dpo_item_name',
        'dpo_pbf',
        'dpo_price',
        'dpo_qty',
        'dpo_item_unit',
        'dpo_qty_item',
        'dpo_qty_unit',
        'dpo_conv_unit',
        'dpo_total_price',
        'dpo_diskon',
        'dpo_total_bayar'
    ];
}
