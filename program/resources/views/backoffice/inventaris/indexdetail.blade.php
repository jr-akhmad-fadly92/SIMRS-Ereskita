@extends('master')
@section('header')
  <h1>Inventaris Global</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      
        @foreach($jumlah_inventaris as $inv)
        @if($inv->jumlah_barang==$jumlah)
      <h3 class="box-title">
        Inventaris Global&nbsp;
        <a href="{{ url('/backoffice/Inv-detail/refresh/'.$id) }}" class="btn btn-success btn-flat"><i class="fa fa-refresh"></i>refresh</a>
       
        <a href="{{ url('/backoffice/Inv-global/') }}" class="btn btn-success btn-flat">kembali</a>
      </h3>
      <h5><b>Inventaris Sudah Terdata Semua </b></h5>
      <h5><b>Jumlah Nilai Inventaris  = Rp.{{number_format($total_harga)}}</b></h5>
        @else
      <h3 class="box-title">
        Inventaris Global&nbsp;
       
        <a href="{{ url('/backoffice/Inv-detail/createinv/'.$id) }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        <a href="{{ url('/backoffice/Inv-detail/refresh/'.$id) }}" class="btn btn-success btn-flat"><i class="fa fa-refresh"></i>refresh</a>
       
        <a href="{{ url('/backoffice/Inv-global/') }}" class="btn btn-success btn-flat">kembali</a>
      </h3>
      <h5><b>Jumlah Inventaris yang belum di input = {{$inv->jumlah_barang-$jumlah}}</b></h5>
      <h5><b>Jumlah Nilai Inventaris  = Rp. {{number_format($total_harga)}}</b></h5>
        @endif
        @endforeach
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>Nomor Inv</th>
                <th>Kode Barang</th>
                <th>Ruangan</th>
                <th>Lokasi</th>
                <th>Tanggal Pengadaan</th>
                <th>Kondisi Barang</th>
                
                <th>Asal Barang</th>
                <th>action</th>
                
              </tr>
            </thead>
            <tbody>
              @foreach($Inventarisdetail as $inv)
                <tr>
                  <td>{{$inv->no_inv}}</td>
                  <td>{{$inv->kode_barang}}</td>
                  <td>{{$inv->ruangan}}</td>
                  <td>{{$inv->lokasi}}</td>
                  <td>{{tgl_indo($inv->tanggal_pengadaan)}}</td>
                  <td>{{$inv->kondisi_barang}}</td>
                  
                  <td>{{$inv->asal_barang}}</td>
                  <td>
                    <a href="{{ url('/backoffice/Inv-detail/kode/'.$inv->no_inv.'/edit') }}" onclick="return confirm('apakah anda yakin mengedit data ini? akan berpengaruh dengan data yang lain');"class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    <a href="{{ url('/backoffice/Inv-detail/history/'.$inv->no_inv) }}" class="btn btn-warning btn-sm"><i class="fa fa-file"></i></a>
                    <a href="{{ url('/backoffice/Inv-detail/kode/'.$inv->no_inv.'/'.$inv->kode_barang.'/delete') }}" onclick="return confirm('apakah anda yakin menghapus data ini?');"class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                  </td>
                  
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>

  
@endsection
