@extends('master')
@section('header')
  <h1>Pegawai Rumah Sakit</h1>
@endsection
@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Pegawai<br> &nbsp;
         
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed table-pegawai' id='data'>
          <i class="fa fa-pen"></i> : input gaji , <i class="fa fa-edit"></i> : edit gaji 
          <thead>
              <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Kategori Pegawai</th>
                <th>Jabatan</th>
                <th>Departemen</th>
                <th>Gaji Pokok</th>
                <th>Tunj. Jabatan</th>
                <th>Tunj. Lain-lain</th>
                <th>Total Gaji</th>
                <th style="width:50px;">Aksi</th>
              </tr>
            </thead>
           <tbody>
              @foreach ($pegawai as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->kode }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->kategori }}/{{ $d->status_peg }} </td>
                  <td>{{ $d->nama_jabatan }}</td>
                  <td>{{ $d->departemen }}</td>
                  <td>
                  @foreach($gaji as $e)
                  @if($d->id==$e->kode)
                  Rp. {{number_format($e->gaji_pokok)}}
                  @else
                  
                  @endif
                  @endforeach
                  </td>
                  <td>Rp. {{ number_format($d->tunjangan_jabatan) }}</td>
                  <td>@if($d->status_ktp_pegawai==2 or $d->status_ktp_pegawai==3  )
                      Tunjangan anak : Rp. {{number_format($d->tunjangan_ktp)}}<br>
                      @elseif($d->status_ktp_pegawai==5 or $d->status_ktp_pegawai==6)
                      Tunjangan keluarga : Rp. {{number_format($d->tunjangan_ktp)}}
                      <br>
                      @elseif($d->status_ktp_pegawai==1)
                      Tunjangan keluarga : Rp. {{number_format($d->tunjangan_ktp)}}
                      <br>
                      @endif</td>
                  <td>
                      @if($d->status_gaji==1)
                      @foreach($gaji as $e)
                      
                      @if($e->kode===$d->id)
                      {{ number_format($e->total_gaji) }}
                      @endif
                      @endforeach
                      @else
                      {{ number_format($d->tunjangan_jabatan + $d->tunjangan_ktp) }}
                      @endif
                  </td>
                      
                    <td>
                    
                    @if($d->status_gaji==1)
                      <a href="{{ url('/direksi/penggajian/kode/'.$d->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                      @else
                      <a href="{{ url('/direksi/penggajian/kode/'.$d->id.'/input') }}" class="btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
                      @endif
                    
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
