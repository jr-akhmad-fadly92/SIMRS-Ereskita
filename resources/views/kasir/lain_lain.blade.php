@extends('master')
@section('header')
  <h1>Transaksi Lain Lain <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4></h4>
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Alamat</th>
              {{-- <th>Jenis Transaksi</th>
              <th>Total</th> --}}
              <th>Bayar</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $key => $d)
              <tr>
                <td>{{ $d['no'] }}</td>
                <td>{{ $d['nama'] }}</td>
                <td>{{ $d['alamat'] }}</td>
                {{-- <td>

                </td>
                <td>{{ number_format($d['total']) }}</td> --}}
                <td>
                  <a href="{{ url('kasir/lain-lain/bayar/'.$d['registrasi_id']) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-dollar"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>



    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
