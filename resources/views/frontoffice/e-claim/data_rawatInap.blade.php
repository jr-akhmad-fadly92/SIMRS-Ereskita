@extends('master')

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
			<a href="{{ url('frontoffice/e-claim/rawat-jalan') }}" class="btn btn-primary pull-right">Ke Halaman Bridging RJ</a>
      <h4 style="margin:5px 0;">Bridging INACBG Rawat Inap</h4>
    </div>
    <div class="box-body">
      <div class='table-responsive'>
				<div class="col-sm-6 pull-left">
					{!! Form::open(['method' => 'POST', 'url' => 'frontoffice/e-claim/rawat-inap', 'class'=>'form-hosizontal']) !!}
					<div class="row">
						<div class="col-md-6 no-padding">
							<div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
								<span class="input-group-btn">
									<button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Dari Tanggal</button>
								</span>
								{!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
								<small class="text-danger">{{ $errors->first('tga') }}</small>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button">Sampai Tanggal</button>
								</span>
								 {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
							</div>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
        <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>No. RM Baru</th>
              <th>Nama </th>
              <th>Alamat</th>
              <th>Bangsal</th>
              <th>Kelas</th>
              <th>DPJP Rawat Inap</th>
              <th>Cara Bayar</th>
              <th>Proses</th>
              <th>Final Klaim</th>
              <th>Kirim DC</th>
              <th>Kirim LPK</th>
              <th>Cetak</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($irna as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->pasien->no_rm }}</td>
                <td>{{ strtoupper($d->pasien->nama) }}</td>
                <td>{{ strtoupper($d->pasien->alamat) }}</td>
                <td>{{ baca_kamar($d->kamar_id) }}</td>
                <td>{{ strtoupper(baca_kelas($d->kelas_id)) }}</td>
                <td>{{ baca_dokter($d->dokter_id) }}</td>
                <td>{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : NULL }}</td>
                <td>
                  <a href="{{ url('frontoffice/e-claim/bridging-irna/'.$d->reg_id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-database"></i></a>
                </td>
                <td>@if($d->final_klaim=='Y') <i class="fa fa-check"></i> @endif</td>
                <td>@if($d->kirim_dc=='Y') <i class="fa fa-check"></i> @endif</td>
                <td>@if($d->kirim_lpk=='Y') <i class="fa fa-check"></i> @endif</td>
                <td class="text-center">
                  @if (App\Inacbg::where('registrasi_id', $d->reg_id)->count() == 1)
                    <a href="{{ url('/eklaim-detail-bridging/'.$d->reg_id) }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print"></i></a>
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
