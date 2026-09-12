@extends('master')
@section('header')
  <h1>Tahun Tarif</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Master Jabatan&nbsp;
        <a href="{{ url('/direksi/masterjabatan/createmasterjabatan') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-10'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Jabatan</th>
                <th>Nama Jabatan</th>
                <th>Tunjangan Jabatan</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($masterjabatan as $e)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $e->kode_jabatan }}</td>
                <td>{{ $e->nama_jabatan}}</td>
                <td>Rp. {{ number_format($e->tunjangan_jabatan)}}</td>
                <td><a href="{{ url('/direksi/masterjabatan/kode/'.$e->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                <a href="{{ url('/direksi/masterjabatan/kode/'.$e->id.'/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>

  
@endsection
