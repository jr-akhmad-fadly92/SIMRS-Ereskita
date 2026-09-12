@extends('master')

@section('header')
  <h1>Konfigurasi Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Konfigurasi Rumah Sakit
          <a href="{{ route('config.edit', $config->id) }}" class="btn btn-default"><i class="fa fa-edit"></i> Update Data</a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <tbody>
              <tr>
                <th>Nama</th>
                <td>{{ $config->nama }}</td>
                <th>Antrian Footer</th>
                <td>{{ $config->antrianfooter }}</td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td>{{ $config->alamat }}</td>
                <th>Tahun Tarif</th>
                @foreach (Modules\Config\Entities\Tahuntarif::all() as $d)
                @if ($config->tahuntarif == $d->id )
                <td>{{ $d->tahun }}</td>
                @endif
                @endforeach
              </tr>
              <tr>
                <th>Website</th>
                <td>{{ $config->website }}</td>
                <th>Panjang Kode Pasien</th>
                <td>{{ $config->panjangkodepasien }}</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>{{ $config->email }}</td>
                <th>IP SEP</th>
                <td>{{ $config->ipsep }}</td>
              </tr>
              <tr>
                <th>Bayar Depan</th>
                <td>{{ $config->bayardepan }}</td>
                <th>User SEP</th>
                <td>{{ $config->usersep }}</td>
              </tr>
              <tr>
                <th>Kasir Tindakan</th>
                <td>{{ $config->kasirtindakan }}</td>
                <th>IP INACBG</th>
                <td>{{ $config->ipinacbg }}</td>
              </tr>

              <tr>
                <th>Logo</th>
                <td colspan="3"><img src="{{ asset('public/images/'.$config->logo) }}"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
