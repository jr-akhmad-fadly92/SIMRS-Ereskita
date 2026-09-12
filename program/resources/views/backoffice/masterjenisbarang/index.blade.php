@extends('master')
@section('header')
  <h1>Master Jenis Barang</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Master Jenis Barang&nbsp;
        <a href="{{ url('/backoffice/master_jenis_barang/createjenisbarang') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Jenis Barang</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
            @foreach($jenis_barang as $jenis)
              <tr>
                <td>{{$no++}}</td>
                <td>{{$jenis->jenis_barang}}</td>
                <td><a href="{{ url('/backoffice/master_jenis_barang/kode/'.$jenis->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                <a href="{{ url('/backoffice/master_jenis_barang/kode/'.$jenis->id.'/delete') }}" onclick="return confirm('apakah anda yakin menghapus data ini?');"class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                </td>
              <tr>
            @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>
  
  
@endsection
