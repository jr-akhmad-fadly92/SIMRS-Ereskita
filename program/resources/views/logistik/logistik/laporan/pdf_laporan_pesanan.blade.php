<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Pemesanan</title>
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
      font-size:12;
    }
    th{
      background-color: #008080;
    }

    tr:nth-child(even) {background-color: #f2f2f2;}

</style>
</head>
<body>
    <htmlpageheader name="MyHeader1">
        <div style="text-align: right; border-bottom: 1px solid #000000; font-weight: bold; font-size: 10pt;">Laporan Pemesanan</div>
    </htmlpageheader>
   <htmlpagefooter name="MyFooter1">
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
            <tr>
                <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
                <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right; ">My document</td>
            </tr>
        </table>
    </htmlpagefooter>

    

    <div>

    <div><b>LAPORAN PENERIMAAN </b><br>

    Periode : {{$periode}}</div>
    
    <table border=1>

    <thead>

      <tr >

        <th style="vertical-align: middle;">#</th>

        <th style="vertical-align: middle;">PO</th>

        <th style="vertical-align: middle;">Faktur</th>

        <th style="vertical-align: middle;">Kode</th>

        <th style="vertical-align: middle;">Nama</th>

        <th style="vertical-align: middle;">Satuan</th>

        <th style="vertical-align: middle;">Jumlah</th>

        <th style="vertical-align: middle;">Jumlah Diterima</th>

        <th style="vertical-align: middle;">Harga Satuan</th>

        <th style="vertical-align: middle;">Harga Total</th>

        <th style="vertical-align: middle;">Status</th>

        

      </tr>

    </thead>

    <tbody>



    @foreach($Laporan_pemesanan as $data)

    <tr>

      <td>{{$no++}}</td>

      <td>{{$data->no_po}}</td>

      <td>{{$data->no_faktur}}</td>

      <td>{{$data->kode}}</td>

      <td>{{$data->nama_obj}}</td>

      <td>{{$data->dpo_item_unit}}</td>

      <td>{{$data->jumlah}}</td>

      <td>{{$data->jumlah_diterima}}</td>

      <td>Rp. {{number_format($data->dpo_price)}}</td>

      <td>Rp. {{number_format($data->total_biaya)}}</td>

      <td>{{$data->po_status}}</td>

    </tr>  

    @endforeach

    </tbody>



    </table>

    Total Item : {{$item_pemesanan}} item<br>

    Total Jumlah Barang Di terima : {{$jumlah_pemesanan}} barang<br>

    Total Nilai Pemesanan : Rp. {{number_format($biaya_pemesanan->total_biaya)}}</div>
        
</body>

</html>