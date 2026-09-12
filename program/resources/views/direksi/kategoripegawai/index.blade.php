@extends('master')
@section('header')
  <h1>Tahun Tarif</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Kategori Pegawai&nbsp;
        <a href="{{ url('/direksi/kategoripegawai/createkategoripegawai') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-6'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Kategori Pegawai</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($kategoripegawai as $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->kategori }}</td>
                <td><a href="{{ url('/direksi/kategoripegawai/kode/'.$d->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                <a href="{{ url('/direksi/kategoripegawai/kode/'.$d->id.'/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>

  
@endsection
