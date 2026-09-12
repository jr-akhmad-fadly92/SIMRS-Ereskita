@extends('master')
@section('content')
  <div class="box box-primary">		
    <div class="box-header with-border">
			<a href="{{ url('frontoffice/e-claim/rawat-inap') }}" class="btn btn-primary pull-right">Ke Halaman Bridging RI</a>
      <h4 style="margin:5px 0;">Bridging E-Klaim Rawat Jalan dan Rawat Darurat</h4>
    </div>
    <div class="box-body">
      <div class='table-responsive'>
				<div class="col-sm-6 pull-left">
					{!! Form::open(['method' => 'POST', 'url' => 'frontoffice/e-claim/rawat-jalan', 'class'=>'form-hosizontal']) !!}
					<div class="row">
						<div class="col-md-6">
							<div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
									<span class="input-group-btn">
										<button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
									</span>
									{!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
									<small class="text-danger">{{ $errors->first('tga') }}</small>
							</div>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No. RM</th>
              <th>Nama Pasien</th>
              <th>Klinik</th>
              <th>Dokter Penanggung Jawab</th>
              <th>Cara Bayar</th>
              <th>No. SEP</th>
              <th>Tgl Reg</th>
              <th>Status</th>
              <th class="text-center">Proses</th>
              <th>Final Klaim</th>
              <th>Kirim DC</th>
              <th>Kirim LPK</th>
              <th class="text-center">Cetak</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
              <tr>
                <td>{{ !empty($d->pasien_id) ? $d->pasien->no_rm : '' }}</td>
                <td>{{ !empty($d->pasien_id) ? strtoupper($d->pasien->nama) : '' }}</td>
                <td>{{ !empty($d->poli_id) ? strtoupper($d->poli->nama) : '' }}</td>
                <td>{{ baca_dokter($d->dokter_id) }}</td>
                <td>{{ baca_carabayar($d->bayar).' - '.$d->tipe_jkn }}</td>
                <td>{{ $d->no_sep }}</td>
                <td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                <td>{{ ucwords($d->posisi_pasien) }}</td>
                <td class="text-center">
                  <a href="{{ url('frontoffice/e-claim/bridging/'.$d->id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-database"></i></a>        
                </td>
                <td>@if($d->final_klaim=='Y') <i class="fa fa-check"></i> @endif</td>
                <td>@if($d->kirim_dc=='Y') <i class="fa fa-check"></i> @endif</td>
                <td>@if($d->kirim_lpk=='Y') <i class="fa fa-check"></i> @endif</td>
                <td class="text-center">
                  @if (App\Inacbg::where('registrasi_id', $d->id)->count() == 1)
                    <a href="{{ url('/eklaim-detail-bridging/'.$d->id) }}" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                  @endif
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
