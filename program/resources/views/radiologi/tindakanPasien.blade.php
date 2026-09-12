@extends('master')

@section('header')
  <h1>Billing System Radiologi</h1>
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
							<th>No</th>
							<th>Antrian</th>
							<th>Nama Pasien</th>
							<th>No. RM</th>
              <th class="text-center" style="vertical-align: middle;">Tgl Reg</th>
							<th>Dokter</th>
							<th>Poli Tujuan</th>
							<th>Cara Bayar</th>
							<th>Proses</th>
							<th>Hasil</th>
							<th>Cetak</th>
							<th>Status</th>
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
								<td>{{ baca_dokter($d->dokter_id) }}</td>
								<td>{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
								<td>{{ baca_carabayar($d->bayar) }}
									@if (!empty($d->tipe_jkn))
										- {{ $d->tipe_jkn }}
									@endif
								</td>
								<td>
									<a href="{{ url('radiologi/insert-kunjungan/'. $d->id.'/'.$d->pasien_id) }}" onclick="return confirm('Apakah yakin akan dilakukan tindakan Radiologi? Karena akan menambah kunjungan Radiologi')" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
								</td>
								<td>
									<a href="{{ url('radiologi/hasil/'. $d->id) }}" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-file"></i></a>
								</td>
								<td>
									<a target="_blank" href="{{ url('/radiologi/q/cetak/'.$d->id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-print"></i></a>
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
