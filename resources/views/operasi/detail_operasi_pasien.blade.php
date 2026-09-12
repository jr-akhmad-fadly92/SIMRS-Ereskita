@extends('master')
@section('header')
  <h1>Master Gizi <small><button class="btn btn-default" id="tambahGizi"> <i class="fa fa-plus"></i> </button></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    <h3><b>Laporan Operasi</b></h3>
    </div>
    <div class="box-body">
    <div class="table-responsive">
    <table width='100%' class="table table-condensed  table-hover" align='center' >
    <!-- 7 colom-->
    <tr>
      <td width="15%">Nama Pasien</td>
      <td width="5%">:</td>
      <td width="15%">{{$reg->nama_pasien}}</td>
      <td width="30%"></td>
      <td width="15%">No. Rekam Medis</td>
      <td width="5%">:</td>
      <td width="15%">{{$reg->no_rm}}</td>
    </tr>
    <tr>
      <td width="15%">Umur</td>
      <td width="5%">:</td>
      <td width="15%">{{ hitung_umur($reg->tgllahir,'Y') }} </td>
      <td width="30%"></td>
      <td width="15%">Ruangan</td>
      <td width="5%">:</td>
      <td width="15%">{{$kamar->nama}} </td>
    </tr>
    <tr>
      <td width="15%">Tgl Lahir</td>
      <td width="5%">:</td>
      <td width="15%">{{ tgl_indo($reg->tgllahir) }}</td>
      <td width="30%"></td>
      <td width="15%">Jenis Kelamin</td>
      <td width="5%">:</td>
      @if($reg->kelamin=="P")
      <td width="15%">Perempuan </td>
      @else
      <td width="15%">Laki-Laki </td>
      @endif
    </tr>
    <tr >
      <th colspan="7" class="bg-success " ><h4><b>PENILAIAN SEBELUM OPERASI</b></h4></th>
      
    </tr>
    <tr>
      <td width="15%">Tanggal</td>
      <td width="5%">:</td>
      <td width="15%">{{ $op->rencana_operasi }}</td>
      <td width="30%"></td>
      <td width="15%">Dokter Bedah</td>
      <td width="5%">:</td>
      <td width="15%">{{baca_dokter($op->operator)}} </td>
    </tr>
    </table>
    <table width='100%' class="table table-border">
    <tr>
      <td width="15%">keluhan</td>
      <td width="5%">:</td>
      <td width="15%">{{$op->keluhan}}</td>
      <td width="30%"></td>
      <td rowspan="3" width="35%">Penilaian : {{$op->penilaian}}</td>
    </tr>
    <tr>
      <td width="15%">Pemeriksaan</td>
      <td width="5%">:</td>
      <td width="15%">{{ $op->pemerikasaan_fisik }}</td>
      <td width="30%"></td>
      
    </tr>
    <tr>
      <td width="15%">Suhu Tubuh (C)</td>
      <td width="5%">:</td>
      <td width="15%">{{$op->suhu_tubuh}}</td>
      <td width="15%">Nadi(/Mnt) : {{$op->nadi}}</td>
      
    </tr>
    <tr>
      <td width="15%">Tensi</td>
      <td width="5%">:</td>
      <td width="15%">{{$op->tensi}}</td>
      <td width="30%">GCS : {{$op->GCS}}</td>
      <td rowspan="3" width="35%">Tindak lanjut : {{$op->tindak_lanjut}}</td>
    </tr>
    <tr>
      <td width="15%">Tinggi(Cm)</td>
      <td width="5%">:</td>
      <td width="15%">{{$op->tinggi}}</td>
      <td width="15%">Respirasi(/Mnt) : {{$op->respirasi}}</td>
      
    </tr>
    <tr>
      <td width="15%">Berat(Kg)</td>
      <td width="5%">:</td>
      <td width="15%">{{$op->berat}}</td>
      <td width="15%"></td>
      
    </tr>
    </table>
    <hr>
    <table width='100%' class="table table-border">
    <tr class="bg-success" >
    <th colspan="7"><h4><b>LAPORAN PASCA OPERASI</b></h4>
    </th>
    </tr>
    <tr>
      <td width="20%">Tanggal </td>
      <td width="20%">: {{$op->updated_at}}</td>
      <td width="20%"></td>
      <td width="20%"></td>
      <td width="20%" rowspan="13">Penilaian : {{$op->penilaian}}</td>
    </tr>
    <tr>
      <td width="20%">Dokter Bedah </td>
      <td width="20%">: {{baca_dokter($op->operator)}}</td>
      <td width="20%">Asisten Perawat / Bidan</td>
      <td width="20%">: {{baca_dokter($op->perawat_1)}}</td>
     
    </tr>
    <tr>
      <td width="20%">Dokter Bedah 2</td>
      <td width="20%">: {{baca_dokter($op->operator1)}}</td>
      <td width="20%">Asisten Perawat / Bidan 2</td>
      <td width="20%">: {{baca_dokter($op->perawat_2)}}</td>
     
    </tr>
    <tr>
      <td width="20%">Dokter Anestesi </td>
      <td width="20%">: {{baca_dokter($op->dokter_anastesi)}}</td>
      <td width="20%">Asisten Perawar / Bidan 3</td>
      <td width="20%">: {{baca_dokter($op->perawat_3)}}</td>
    
    </tr>
    <tr>
      <td width="20%">Dokter anak </td>
      <td width="20%">: {{baca_dokter($op->dokter_anak)}}</td>
      <td width="20%"></td>
      <td width="20%"></td>
    
    </tr>
    <tr class="bg-success ">
      <td colspan="5"width="80%"><b>Diagnosa sebelum operasi </b></td>
     
    </tr>
    <tr>
      <td colspan="5"width="80%">{{$op->diagnosa_awal}} </td>
     
    </tr>
    <tr class="bg-success ">
      <td colspan="5"width="80%"><b>Jaringan Yang Di Eksisi / Insisi </b></td>
     
    </tr>
    <tr>
      <td colspan="5"width="80%">{{$op->jaringan_tubuh}}  </td>
     
    </tr>
    <tr class="bg-success ">
      <td colspan="5"width="80%"><b>Diagnosa Setelah operasi</b> </td>
    
    </tr>
    <tr>
      <td colspan="5"width="80%">{{$op->diagnosa_pasca_op}}</td>
    
    </tr>
    </table>
    <hr>
    <table width="100%" class="table ">
      <tr class="bg-success">
      <th > <h4><b>REPORT ( PROCEDURES,SPECIFIC FINDINGS AND COMPLICATIONS)</b></h4></th>
      </tr>
      <tr>
      <td>
      {{$op->laporan_operasi}}
      </td>
      <tr>
    </table>
    <br><br>
    <table width="100%" >
      <tr>
      <td width="80%"> </td>
      <td>{{$op->rencana_operasi}}</td>
      </tr>
      <tr>
      <td width="80%"> </td>
      <td>Dokter Bedah</td>
      <tr>
      <tr>
      <td width="80%" height="80px"> </td>
      <td>&nbsp</td>
      <tr>
      <tr>
      <td width="80%"> </td>
      <td>{{baca_dokter($op->operator)}}</td>
      <tr>
    </table>
    </div>
    </div>
    <div class="box-footer">
    </div>
  </div>

@endsection
