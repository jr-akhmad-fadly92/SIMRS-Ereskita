<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masterruangan extends Model
{
    protected $table ="master_ruangan";
    protected $fillable = ['ruangan','role'];
}
