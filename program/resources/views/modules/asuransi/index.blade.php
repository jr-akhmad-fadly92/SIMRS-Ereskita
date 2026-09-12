@extends('master')

@section('header')
  <h1>Perusahaan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Ubah Perusahaan &nbsp;
        <a href="{{ url('asuransi/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Id PRK</th>
              <th>Diskon</th>
              <th>Plafon</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($asuransi as $e)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $e->nama }}</td>
                <td>{{ $e->alamat }}</td>
                <td>{{ $e->id_prk }}</td>
                <td>{{ $e->diskon }}</td>
                <td>{{ $e->plafon }}</td>
                <td><a href="{{ url('asuransi/'.$e->id.'/edit') }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-edit"></i></a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@stop
