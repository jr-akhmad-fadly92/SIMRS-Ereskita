@extends('master')
@section('header')
  <h1>Inventaris Global</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Inventaris Global&nbsp;
        <a href="{{ url('/backoffice/Inv-global/createinvglobal') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        <a href="{{ url('/backoffice/Inv-global/refresh') }}" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Produsen</th>
                <th>Merk</th>
                <th>Tahun Produksi</th>
                <th>Harga per unit</th>
                <th>Total Harga</th>
                
                <th>Katagori</th>
                <th>Jenis brg</th>
                <th>action</th>
                
              </tr>
            </thead>
            <tbody>
              @foreach($invetraisglobal as $inv)
              <tr>
                <td>{{$inv->kode_barang}}</td>
                <td>{{$inv->nama_barang}}</td>
                <td>{{$inv->jumlah_barang}}</td>
                <td>{{$inv->produsen}}</td>
                <td>{{$inv->merk}}</td>
                <td>{{$inv->tahun_produksi}}</td>
                <th>{{number_format($inv->harga_unit)}}</th>
                <th>{{number_format($inv->total_harga)}}</th>
                <td>{{$inv->kategori_barang}}</td>
                <td>{{$inv->nama_jenis_barang}}</td>
                <td><a href="{{ url('/backoffice/Inv-global/kode/'.$inv->kode_barang.'/edit') }}" onclick="return confirm('apakah anda yakin mengedit data ini? akan berpengaruh dengan data yang lain');"class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    <a href="{{ url('/backoffice/Inv-detail/'.$inv->kode_barang) }}" class="btn btn-warning btn-sm"><i class="fa fa-file"></i></a>
                    <a href="{{ url('/backoffice/Inv-global/kode/'.$inv->kode_barang.'/delete') }}" onclick="return confirm('apakah anda yakin menghapus data ini?  akan berpengaruh dengan data yang lain');"class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                    </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>

  
@endsection
