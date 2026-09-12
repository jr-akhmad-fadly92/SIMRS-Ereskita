<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Operasi</title>
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

    tr:nth-child(even) 
table tr th{

			font-size: 10pt;

		}

    table.blueTable {

      border: 2px solid #000000;

      border-collapse: collapse;

    }

    table.blueTable td, table.blueTable th {

      border: 2px solid ;

      padding: 4px 4px;

    }

    table.blueTable tbody td {

      font-size: 12px;

    }

    table.blueTable tfoot td {

      font-size: 14px;

    }

    table.blueTable tfoot .links {

      text-align: right;

    }

    table.blueTable tfoot .links a{

      display: inline-block;

      background: #1C6EA4;

      color: #FFFFFF;

      padding: 2px 8px;

      border-radius: 5px;

    }

    th { background-color: #d3d3d3; }

    

    hr.double-garis{

      border:0;

      border-top: 3px double #000;

    }

    hr.1garis{

      border:solid 1px;

   

    }
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

    

    <div>

    <h4>Laporan Operasi Pasien </h4>
    
    Periode : {{$periode}}

    <hr class="1garis">
   
    <table width='100%' border='1' >

    @foreach($list_pasien as $list)

    <tr>

      <th class='abu'>Tgl Operasi</th>

      <th class="abu">No. RM /<br> Nama Pasien</th>

      <th class="abu">Jns Ans</th>

      <th class="abu">Dokter Bedah</th>

      <th class="abu">Diagnosa awal</th>

      <th class="abu">Jaringan eksisi/insisi</th>

      <th class="abu">Laporan Operasi</th>

    </tr>

    <tr>

      <td rowspan="5">{{valid_date($list->rencana_operasi)}}</td>

      <td rowspan="5">{{$list->no_rm}} /<br>

      {{$list->nama_pasien}} </td>

      <td>{{$list->tipe_anastesi}}</td>

      <td>{{baca_dokter($list->operator)}}</td>

      <td>{{$list->diagnosa_awal}}</td>

      <td >{{$list->jaringan_tubuh}}</td>

      <td rowspan="5">{{$list->laporan_operasi}}</td>

    </tr>

    <tr>

      <th>Tipe Operasi</th>

      <th>Biaya Perawatan</th>

      <th>Diagnosa akhir</th>

      <th >Selesai Operasi</th>

    </tr>

    <tr>

      <td>{{$list->tipe_operasi}}</td>

      <td>0</td>

      <td rowspan="3">{{$list->diagnosa_pasca_op}}</td>

      <td rowspan="3" >{{$list->updated_at}}</td>

    </tr>

    <tr>

      <th>Nama Operasi</th>

      <th>Biaya Obat</th>

      

    </tr>

    <tr>

   <td>{{$list->nama_operasi}}</td>

      <td>0</td>

      

    </tr>

    @endforeach

    </table>
    
    </div>
    
</body>

</html>