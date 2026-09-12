@extends('master')
@section('header')
  <h1>Master Status KTP Pegawai
</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      Master Status KTP Pegawai
&nbsp;
        <a href="{{ url('/direksi/statusktppegawai/createstatusktppegawai') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-10'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>tunjangan</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($statusktppegawai as $e)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $e->status }}</td>
                <td>{{ $e->keterangan}}</td>
                <td>Rp. {{ number_format($e->tunjangan)}}</td>
                <td><a href="{{ url('/direksi/statusktppegawai/kode/'.$e->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                <a href="{{ url('/direksi/statusktppegawai/kode/'.$e->id.'/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>

  
@endsection
