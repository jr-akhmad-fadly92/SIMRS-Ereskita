@extends('master')
@section('header')
  <h1>Aturan Pakai Obat<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <a href="{{ url('farmasi/etiket/create') }}" class="btn btn-default btn-flat">Tambah</a>
    </div>
    <div class="box-body">
      <div class="col-md-6">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Aturan Pakai</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($etiket as $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td> <a class="btn btn-primary btn-sm btn-flat" href="{{ url('farmasi/etiket/'.$d->id.'/edit') }}" role="button"> <i class="fa fa-edit"></i> </a> </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
