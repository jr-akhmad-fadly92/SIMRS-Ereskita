<?php

namespace Modules\Config\Entities;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = ['nama', 'alamat', 'website', 'email', 'logo', 'bayardepan', 'kasirtindakan', 'antrianfooter',
  'tahuntarif', 'panjangkodepasien', 'ipsep', 'usersep', 'ipinacbg', 'pt', 'kota', 'npwp', 'tlp'];
}
