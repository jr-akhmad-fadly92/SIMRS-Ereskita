<html lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Penerimaan Barang</title>

	<style>
  
  @page {
      margin-top: 1cm;
      margin-bottom: 2cm;
      margin-left: 1cm;
      margin-right: 1cm;
      odd-footer-name: html_MyFooter1;
    }
  #header{
    width:100%;
    margin:0px 0px;
   }
  #content{
    position:relative;
    
   
  }

  #footer{
    position:relative;
    height:40px;
    line-height:40px;
    color:#fff;
    text-align:center;
  }

  th{
    background-color: #008080;
  }
  th, td{
    padding:10px;
  }
  /*CONTENT SECTION*/
  
  </style>
</head>
<body>
<div id="header">
  <table width="100%" >
  <tr>
    <td width="10%"><img height="60px" src="/public/images/{{$config->logo}}" style="width:18mm;" /></td>
    <td align="center" vlign="top">
    <b>{{$config->nama}}</b><br>
    {{$config->alamat}}<br>
    No Telepon : {{$config->tlp}}<br>
    Email : {{$config->email}}<br>
    </td>
    <td width="10%"></td>
  </tr>
  </table><hr class="double-garis"><br>
</div>
<div id="content">
  <div style="text-align:center;"><b><u>Purchase Order</u></b><br>

  </div>

   <p>Kami yang bertanda tangan dibawah ini :</p>

   <table width="50%">

      <tr>

        <td width="25%">Kepada</td>

        <td width="5%">:</td>

        <td width="70%">{{$tbpurchase->nama_produsen}}</td>

      </tr>

      <tr>

        <td width="25%">No PO</td>

        <td width="5%">:</td>

        <td width="70%">{{$tbpurchase->po_no_purchaseorder}}</td>

      </tr>

      <tr>

        <td colspan="3">Harap dikirim barang - barang tersebut di bawah ini :</td>

      </tr>

    </table>

    <table style="width:100%;" border=1 >

      <tr >

        <th>No</th>

        <th>Nama Barang</th>

        <th>Satuan</th>

        <th>Jml</th>

        <th>Harga</th>

        <th>Diskon</th>

        <th colspan="2">Sub Total</th>

      </tr>

      @foreach($Tbdetailpurchase as $data)

        <tr >

          <td class="add">{{$no++}}</td>

          <td class="add">{{$data->dpo_item_name}}</td>

          <td class="add">{{$data->dpo_item_unit}}</td>

          <td class="add">{{$data->dpo_qty}}</td>

          <td class="add">Rp. {{number_format($data->dpo_price)}}</td>

          <td class="add"></td>

          

          <td class="add" colspan="2">Rp. {{number_format($data->dpo_total_price)}}</td>

        </tr>

      @endforeach

        <tr >

          <td class="border-bottom-t" height="40px" width="80%" colspan="6" valign="middle">Total</td>

          <td valign="middle" class="border-bottom-t" align="left">

          Rp.

          </td>

          <td class="border-bottom-t" align="right" valign="middle">

          {{number_format($total)}}

          </td>

        </tr>

        <tr>

          <td colspan="6">Netto</td>

          <td align="left">

          Rp.

          </td>

          <td align="right">

          {{number_format($total)}}

          </td>

        </tr>

        <tr>

          <td colspan="6">PPn</td>

          <td align="left">

          Rp.

          </td>

          <td align="right">

          {{number_format($ppn)}}

          </td>

        </tr>

        <tr>

          <td colspan="6" class="border-bottom-t">Materai</td>

          <td align="left" class="border-bottom-t">

          Rp.

          </td>

          <td align="right" class="border-bottom-t">

          {{number_format($materai)}}

          </td>

        </tr>

        <tr>

          <td colspan="6">Total Keseluruhan</td>

          <td align="left">

          Rp.

          </td>

          <td align="right">

          {{number_format($totalkeseluruhan)}}

          </td>

        </tr>

    </table>

    <br>

    <font size="12px">

    Catatan :

    <ol>

      <li>Barang yang dikirim jika tidak sesuai pesanan akan dikembalikan</li>

      <li>Jika terjadi retur barang, Nota retur Faktur Pajak dibuat supplier sesuai dengan bulan penerbitan faktur pajak awal (saat menerima PO / pesanan barang)</li>

      <li>Pada saat menukarkan faktur, harap melampirkan surat pemesanan barang / PO Lembar penerimaan barang / LPB yang asli, dan lembar faktur pajak yang asli</li>

      <li>Nomor PO harap dicantumkan pada setiap lembar penerimaan barang</li>

      <li>Tukar faktur di Tim pembelian setiap hari kamis jam 08:00 - 12:00</li>

      <li>Pembayaran tagihan di Bag. Keuangan setiap hari Rabu (09:00 - 11:00)</li>

      <li>Kecuali dinyatakan lain, PO berlaku paling lama 7 (tujuh hari) dari tanggal PO (untuk nomor 8 disesuaikan dengan perjanjian dengan supplier)</li>

      <li>pembayaran ............ hari setelah barang diterima</li>

      

    </ol>

    </font>

    

    <table width="100%">

      <tr>

        <td width="33%"></td>

        <td width="33%"></td>

        <td width="33%">Semarang, {{ tanggalkuitansi(date('d-m-Y')) }}</td>

      </tr>

      <tr>

        <td width="33%">Logistik</td>

        <td width="33%">Kepala Keuangan</td>

        <td width="33%">Direktur</td>

      </tr>

      <tr>

        <td width="33%"></td>

        <td width="33%"></td>

        <td width="33%" height="50px"></td>

      </tr>

      <tr>

        <td width="33%">{{baca_pegawai($tbpurchase->po_nama_pemohon)}}</td>

        <td width="33%">( . . . . . . . . . . . . . . . . . . . . . . )</td>

        <td width="33%">Akhmad Fadly Fachriza,S.Kom</td>

      </tr>

    </table>
</div>
<htmlpagefooter name="MyFooter1">
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
            <tr>
                <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
                <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right; ">{{$config->nama}}</td>
            </tr>
        </table>
</htmlpagefooter>

</body>
</html>