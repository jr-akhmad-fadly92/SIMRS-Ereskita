<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Pendapatan Dokter</title>
<style>
    @page {
      sheet-size: A4-L;
      size: auto;
      odd-header-name: html_MyHeader1;
      odd-footer-name: html_MyFooter1;
    }
   
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {background-color: #f2f2f2;}

</style>
</head>
<body>
    <htmlpageheader name="MyHeader1">
        <div style="text-align: right; border-bottom: 1px solid #000000; font-weight: bold; font-size: 10pt;">{{$config->nama}}</div>
    </htmlpageheader>
   <htmlpagefooter name="MyFooter1">
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
            <tr>
                <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
                <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right; ">{{$config->nama}}</td>
            </tr>
        </table>
    </htmlpagefooter>

    

    <div><h3>Laporan Pendapatan Dokter</h3>

    <h5>
    Periode: {{ $periode }}
    </h5>



      <table border="1" style="width:100%;">

        <thead>

          <tr style="background-color: #008080;">

                <th style="vertical-align: middle;">No</th>
                <th style="vertical-align: middle;">Nama Dokter</th>
                <th style="vertical-align: middle;">Tindakan</th>
                <th style="vertical-align: middle;">Konsultasi</th>
                <th style="vertical-align: middle;">Pemeriksaan</th>
                <th style="vertical-align: middle;">Total Pendapatan</th>
           </tr>

        </thead>

        <tbody>

        @foreach($list_dokter as $data)

          <tr>
            <td>{{$no++}}</td>
            <td>{{$data->nama}}</td>
            <td>{{Modules\Registrasi\Entities\Folio::join('tarifs','tarifs.id','=','folios.tarif_id')
                ->whereBetween('folios.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->whereNotIn('folios.tarif_id',[1, 2, 3])
                ->where('folios.jenis','TA')
                ->where('tarifs.mapping_pemeriksaan','TN')
                ->where('folios.dokter_id',$data->id)
                ->count()}}</td>
            <td>{{Modules\Registrasi\Entities\Folio::join('tarifs','tarifs.id','=','folios.tarif_id')
                ->whereBetween('folios.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->whereNotIn('folios.tarif_id',[1, 2, 3])
                ->where('folios.jenis','TA')
                ->where('tarifs.mapping_pemeriksaan','KS')
                ->where('folios.dokter_id',$data->id)
                ->count()}}</td>
            <td>{{Modules\Registrasi\Entities\Folio::join('tarifs','tarifs.id','=','folios.tarif_id')
                ->whereBetween('folios.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->whereNotIn('folios.tarif_id',[1, 2, 3])
                ->where('folios.jenis','TA')
                ->where('tarifs.mapping_pemeriksaan','PM')
                ->where('folios.dokter_id',$data->id)
                ->count()}}</td>
            <td>Rp. {{
                number_format(Modules\Registrasi\Entities\Folio::join('tarifs','tarifs.id','=','folios.tarif_id')
                ->whereBetween('folios.created_at', [ valid_date($tga).' 00:00:00', valid_date($tgb).' 23:59:59' ])
                ->whereNotIn('folios.tarif_id',[1, 2, 3])
                ->where('folios.jenis','TA')
                ->where('folios.dokter_id',$data->id)
                ->sum('total'))}}</td>
          </tr>

        @endforeach
       
        </tbody>

      </table></div>
    
</body>

</html>