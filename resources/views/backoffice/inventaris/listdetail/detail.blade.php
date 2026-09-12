@extends('master')

@section('header')
  <h1>Detail History Invetaris</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">@foreach($Inventarisdetail as $inv)
        <h3 class="box-title">
          Detail History Invetaris &nbsp; <a href="{{ url('/backoffice/Inv-detail/'.$inv->kode_barang) }}" class="btn btn-success btn-flat">kembali</a>
        </h3>
      </div>
      <div class="box-body">
      <table class='table table-striped table-bordered table-hover table-condensed'>
        <tbody>
        <tr>
          <th>No Inv</th>
          <td>{{$inv->no_inv}}</td>
          <th>Nama Barang</th>
          <td>{{$inv->nama_barang}}</td>
        </tr>
        <tr>
          <th>Produsen</th>
          <td>{{$inv->nama_produsen}}</td>
          <th>Nama Merk</th>
          <td>{{$inv->merk}}</td>
        </tr>
        <tr>
          <th>Tanggal Pengadaan</th>
          <td>{{$inv->tanggal_pengadaan}}</td>
          <th>Kondisi Barang Saat Ini</th>
          <td>{{$inv->kondisi_barang}}</td>
        </tr>
        <tr>
          <th>Ruangan Saat Ini</th>
          <td>{{App\Masterruangan::find($inv->ruangan)->ruangan}}</td>
          <th>Lokasi Saat Ini</th>
          <td>{{App\Masterlokasi::find($inv->lokasi)->lokasi}}</td>
        </tr>
        </tbody>
      </table>
      <h5><b>History Barang</b></h5>
      <table class='table table-bordered table-hover table-condensed' id="data">
        <thead>
          <tr>
            <th>Tanggal Masuk</th>
            <th>Asal Ruangan</th>
            <th>Ruangan Sekarang</th>
            <th>Kondisi Saat Pindah</th>
            <th>Petugas</th>
          </tr>
        </thead>
        <tbody>
        @foreach($historiinventaris as $h)
          <tr>
            <td>{{tgl_indo($h->tanggal_pindah)}}</td>
            <td>{{App\Masterruangan::find($h->asal_ruangan)->ruangan}}</td>
            <td>{{App\Masterruangan::find($h->update_ruangan)->ruangan}}</td>
            <td>{{$h->kondisi_barang}}</td>
            <td>{{baca_pegawai($h->petugas)}}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
      
      </div>
    </div>@endforeach
@stop
