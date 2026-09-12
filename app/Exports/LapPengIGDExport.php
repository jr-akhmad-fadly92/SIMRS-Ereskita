<?php

namespace App\Exports;
use Modules\Poli\Entities\Poli;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Rujukan\Entities\Rujukan;
use Modules\Pasien\Entities\Regency;
use Modules\Registrasi\Entities\Registrasi;
use Maatwebsite\Excel\Concerns\FromCollection;

class LapPengIGDExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function collection()
    {
    //    return view('igd.excel_laporan_pengunjung',Registrasi::all())->;

      return Registrasi::all();
    }
}
