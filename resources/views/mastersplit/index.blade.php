@extends('master')
@section('header')
  <h1>Master Split </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Daftar Master Split &nbsp;
          <a href="{{ route('mastersplit.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Master Split</th>
                <th>Kategori Header</th>
                <th>Tahun Tarif</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($master as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->kategoriheader->nama }}</td>
                  <td>{{ $d->tahuntarif->tahun }}</td>
                  <td>
                    <a href="{{ route('mastersplit.edit', $d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
