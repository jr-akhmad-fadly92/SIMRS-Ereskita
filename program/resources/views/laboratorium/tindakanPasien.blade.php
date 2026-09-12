@extends('master')

@section('header')
  <h1>Penata Jasa Laboratorium </h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-body">
			<div class='table-responsive'>
				<div class="col-md-6 pull-left">
					Keterangan:
					<br>
					<b>APS (Atas Permintaan Sendiri)</b>
				</div>
				<table class='table table-striped table-bordered table-hover table-condensed' id='data'>
					<thead>
						<tr>
							<th class="text-center" style="vertical-align: middle;">No</th>
							<th class="text-center" style="vertical-align: middle;">Antrian</th>
							<th class="text-center" style="vertical-align: middle;">Nama Pasien</th>
							<th class="text-center" style="vertical-align: middle;">No. RM</th>
							<th class="text-center" style="vertical-align: middle;">Tgl Reg</th>
							<th class="text-center" style="vertical-align: middle;">Dokter</th>
							<th class="text-center" style="vertical-align: middle;">Klinik Asal</th>
							<th class="text-center" style="vertical-align: middle;">Instalasi</th>
							<th class="text-center" style="vertical-align: middle;">Cara Bayar</th>
							<th class="text-center" style="vertical-align: middle;">Proses</th>
							<th class="text-center" style="vertical-align: middle;">Hasil</th>
							<th class="text-center" style="vertical-align: middle;">Cetak</th>
							<th class="text-center" style="vertical-align: middle;">Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($registrasi as $key => $d)
							<tr>
								<td>{{ $no++ }}</td>
                <td>Order {{ ($d->dokter_id==null || $d->dokter_id==0) ? '- APS - Antrian '.$d->antrian_poli : '' }}</td>
								<td>{{ $d->pasien->nama }}</td>
								<td>{{ $d->pasien->no_rm }}</td>
								<td>{{ $d->created_at->format('d-m-Y') }}</td>
								<td>{{ !(empty($d->dokter_id)) ? baca_dokter($d->dokter_id) : '' }}</td>
								<td>{{ ($d->poli_id!=null) ? $d->poli->nama : '' }}</td>
								<td>{{ instalasi(substr($d->status_reg,0,1)) }}</td>
								<td>{{ baca_carabayar($d->bayar) }}
									@if (!empty($d->tipe_jkn))
										- {{ $d->tipe_jkn }}
									@endif
								</td>
								<td>
									<a href="{{ url('/laboratorium/insert-kunjungan/'. $d->id.'/'.$d->pasien_id) }}" onclick="return confirm('Apakah yakin akan dilakukan tindakan Lab? Karena akan menambah kunjungan Lab.')" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
								</td>
								<td>
									@if($d->status_proses==1)
										<a href="{{ url('pemeriksaanlab/create/'.$d->id) }}" class="btn btn-sm btn-warning btn-flat"><i class="fa fa-credit-card"></i></a>
									@endif
								</td>
								<td>
									@if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'L')->count() > 0 AND $d->status_proses==1)
										<a href="{{ url('laboratorium/cetakRincianLab/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
									@endif
								</td>
								<td>
									@if($d->status_proses==1)
										<i class="fa fa-check"></i> Selesai
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
