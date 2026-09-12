@extends('master')
@section('header')
  <h1>Akun keuangan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      Akun Keuangan&nbsp;
        <a href="{{ url('keuangan/createakunkeuangan') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        <a href="{{ url('kasir/keuangan') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-6'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          N ( Neraca ) / R ( Laba / Rugi ) / P ( Perubahan Modal)
            <thead>
              <tr>
                <th>No</th>
                <th>Kode_Kuangan</th>
                <th>Nama Akun</th>
                <th>Tipe</th>
                <th>Balance</th>
                <th>action</th>
              </tr>
            </thead>
            <tbody>
             @foreach ($akunkeuangan as $e)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $e->kode_keuangan }}</td>
                <td>{{ $e->nama_akun }}</td>
                <td>{{ $e->tipe }}</td>
                <td>{{ $e->balance }}</td>
                <td><a href="{{ url('keuangan/kode/'.$e->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                <a href="{{ url('keuangan/kode/'.$e->id.'/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>

  
@endsection
