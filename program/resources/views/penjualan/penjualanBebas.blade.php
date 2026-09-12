@extends('master')
@section('header')
  <h1>Penjualan Bebas</h1>
@endsection

@section('content')
  <div class="box box-primary">
		<div class="box-header with-border">
			<div class="col-md-5">
				<h4 style="margin:5px 0;font-size:16px;font-weight:600;">INPUT DATA PASIEN</h4>
			</div>
			@php
				$antrian = App\AntrianApotek::where('registrasi_id',$reg->id)->first();
			@endphp
			@if($reg->posisi_pasien=='antrian apotek')
				<a href="#" id="click-panggil" data-idreg="{{ $reg->id }}" class="btn btn-success btn-sm btn-flat pull-right"><i class="fa fa-microphone"></i> Panggil Pasien {{ ($antrian!=null) ? $antrian->kelompok.$antrian->nomor : '' }}</a>
			@endif
		</div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/savepenjualanbebas']) !!}
        {!! Form::hidden('registrasi_id', $registrasi_id) !!}
        <div class=''>
          <table class='table table-bordered no-border'>
            <tbody>
              <tr>
                <th>Nama Pasien</th>
                <td class="{{ $errors->has('nama') ? ' has-error' : '' }}">
                    {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('nama') }}</small>
                </td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td class="{{ $errors->has('alamat') ? ' has-error' : '' }}">
                  <input type="text" name="alamat" value="" class="form-control">
                  <small class="text-danger">{{ $errors->first('alamat') }}</small>
                </td>
              </tr>
              <tr>
                <th>Tgl. Lahir</th>
                <td class="{{ $errors->has('tgl_lahir') ? ' has-error' : '' }}">
                  <input type="text" name="tgl_lahir" value="" class="form-control datepicker">
                  <small class="text-danger">{{ $errors->first('tgl_lahir') }}</small>
                </td>
              </tr>
              <tr>
                <th>Dokter</th>
                <td>
                  <input type="text" name="dokter" value="" class="form-control">
                </td>
              </tr>
              <tr>
                <th>
                  Penulis Resep
                </th>
                <td>
                  @if (! session('idpenjualan'))
                    <div class="form-group{{ $errors->has('pembuat_resep') ? ' has-error' : '' }} col-md-6 no-padding">
											{!! Form::select('pembuat_resep', $apoteker, (($pegawai_id!=null) ? $pegawai_id->id : null), ['class' => 'form-control select2']) !!}
											<small class="text-danger">{{ $errors->first('pembuat_resep') }}</small>
                    </div>
										<div class="col-md-6">
											{!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Yakin Apoteker sdh benar?")']) !!}
										</div>
                  @else
                    <b class="text-primary">{{ baca_apoteker($penjualan->pembuat_resep) }}</b>
                  @endif
                </td>
              </tr>
              @if (session('idpenjualan'))
                <tr>
                  <td>No. Faktur</td>
                  <td>{{ $penjualan->no_resep }}</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
			{!! Form::close() !!}     
    </div>
  </div>

  {{-- Modal History Penjualan ======================================================================== --}}
  <div class="modal fade" id="showHistoriPenjualan" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">History Penjualan Obat Sebelumnya</h4>
        </div>
        <div class="modal-body">
          <div id="dataHistori"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@endsection
