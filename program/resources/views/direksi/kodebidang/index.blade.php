@extends('master')
@section('header')
  <h1>Tahun Tarif</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Kode Bidang&nbsp;
        <a href="{{ url('/direksi/kodebidang/createbidang') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-6'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Bidang</th>
                <th>Nama Bidang</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($bidang as $e)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $e->kode }}</td>
                <td>{{ $e->nama_bidang }}</td>
                <td><a href="{{ url('/direksi/kodebidang/kode/'.$e->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                <a href="{{ url('/direksi/kodebidang/kode/'.$e->id.'/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>

  
@endsection
