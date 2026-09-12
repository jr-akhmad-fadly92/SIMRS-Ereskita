@extends('master')

@section('content')
	<div class="box box-primary">
		<div class="box-body">
			<div class="boxs">
				@php
					$ri = App\Rawatinap::where('registrasi_id', $reg->id)->first();
					$inacbg = \App\Inacbg::where('registrasi_id', $reg->id)->first();
					$hi = App\HistoriRawatInap::where('registrasi_id', $reg->id)->get();
					$no_kamar = 1;
				@endphp

				<div class='table-responsive'>
					<table class='table table-striped table-bordered table-hover table-condensed'>
						<tbody>
							<tr>
								<th>Nama Pasien</th> <td>{{ strtoupper($reg->pasien->nama) }}</td>
								@if ($hi->count() == 1)
									@foreach ($hi as $r)
										<th>Kelas / Kamar</th> <td>{{ baca_kelompok($r->kelompokkelas_id) }} / {{ baca_kamar($r->kamar_id) }}</td>
									@endforeach
								@else
									<th></th><td></td>
								@endif
							</tr>
							<tr>
								<th>No. RM</th> <td>{{ strtoupper($reg->pasien->no_rm) }}</td>
								<th>Kelas Perawatan </th> <td>{{ !empty($reg->kelas_id) ? baca_kelas($reg->kelas_id) : '' }}</td>
							</tr>
							<tr>
								<th>Alamat</th> <td>{{ strtoupper($reg->pasien->alamat) }}</td>
								<th>No. SEP</th> <td>{{ $reg->no_sep }}</td>
							</tr>
							<tr>
									<th>DPJP </th> <td>{{ baca_dokter($ri->dokter_id) }}</td>
									<th>Hak Kelas JKN </th> <td>{{ $reg->hak_kelas_inap }}</td>
							</tr>
							<tr>
								<th>Cara Bayar</th> <td>{{ baca_carabayar($reg->bayar) }}
									@if (!empty($reg->tipe_jkn))
										- {{ $reg->tipe_jkn }}
									@endif
									@if (!empty($reg->perusahaan_id))
										- {{ $reg->perusahaan->nama }}
									@endif
								</td>
								<th>Kode Grouper </th> <td>{{ !empty($inacbg) ? $inacbg->kode : '' }}</td>
							</tr>								
							@php
								session( ['kelas_id'=>$reg->kelas_id]);
							@endphp
							@if ($reg->bayar == '1')
								<tr>
									<th>Ubah Tipe JKN</th> 
									<td>
										<form action="{{ url('kasir/ubah-tipe-jkn') }}" method="post">
											{{ csrf_field() }}
											{!! Form::hidden('registrasi_id', $reg->id) !!}
											{!! Form::select('tipe_jkn', ['PBI'=>'PBI', 'NON PBI'=>'NON PBI'], $reg->tipe_jkn, ['class' => 'form-control', 'style'=>'width: 50%', 'onchange'=>'this.form.submit()']) !!}
										</form>
									</td>
									<th>Dijamin INACBG</th> <td>{{ !empty($inacbg) ? number_format($inacbg->dijamin) : '' }}</td>
								</tr>
							@endif
							<tr>
								<th>Tanggal Masuk</th><td>{{ tanggal($ri->tgl_masuk) }}</td>
								<th>Tanggal Keluar</th><td>{{ tanggal($ri->tgl_keluar) }}</td> 
							</tr>							
						</tbody>
					</table>
				</div>

				@if ($hi->count() > 1)
					<div class="table-responsive">
						<table class="table table-hover table-bordered table-condensed">
							<thead>
								<tr>
									<th>No.</th>
									<th>Kelas</th>
									<th>Kamar</th>
									<th>Bed</th>
									<th>Tanggal</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($hi as $d)
								<tr>
									<td>{{ $no_kamar++ }}</td>
									<td>{{ baca_kelompok($d->kelompokkelas_id) }}</td>
									<td>{{ baca_kamar($d->kamar_id) }} </td>
									<td>{{ baca_bed($d->bed_id) }}</td>
									<td>{{ $d->created_at->format('d-m-Y') }}</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				@endif
			</div>
			
			<div class='table-responsive'>
				<table class='table table-striped table-bordered table-hover table-condensed' >
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th>Tindakan</th>
							<th class="text-center">Biaya</th>
							<th class="text-center">Qty</th>
							<th class="text-center">Total</th>
							<th class="text-center">Verifikasi</th>
							<th>Hapus</th>
						</tr>
					</thead>
					<tbody>
						{!! Form::open(['method' => 'POST', 'url' => 'kasir/verifikasi-detail-kasir-irna', 'class' => 'form-horizontal']) !!}
							{{ csrf_field() }} {{ method_field('POST') }}
							{!! Form::hidden('registrasi_id', $reg->id) !!}
							@foreach ($folio as $key => $d)
								<tr>
									<td class="text-center">{{ $no++ }}</td>
									<td>{{ $d->namatarif }}</a></td>
									<td class="text-right">{{ number_format($d->total) }}</td>
									<td class="text-center">
									@php
										$tarifx = 0;
										if($d->tarif_id==10000 || $d->tarif_id==20000 || $d->tarif_id==30000){
											$tarifx = 1;
										}elseif($d->total > 0){
											$settarif = getTotalTarif($reg,$d);
											if($settarif>0){
												$tarifx = ceil($d->total/$settarif);
											}else{
												$tarifx = 1;
											}
										}else{
											$tarifx = 1;
										}
									@endphp
									{{ $tarifx }}
									</td>
									<td class="text-right">{{ number_format($d->total) }}</td>
									<td class="text-center">
										@if ($d->verif_kasa == cekVerif($reg->id, $d->tarif_id))
											<i class="fa fa-check text-success"></i>
										@else
											<input type="checkbox" style="cursor:pointer;" name="verif_kasa{{ $i_verif++ }}" id="verif_kasa{{ $i_verif++ }}" value="{{ $d->id_folio }}">
										@endif
									</td>
									<td class="text-center">
										<input type="checkbox" style="cursor:pointer;" name="hapus{{ $i_hapus++ }}" id="hapus{{ $i_hapus++ }}" value="{{ $d->id_folio }}">
									</td>                  
								</tr>
							@endforeach
							<tr>
								<td colspan="9">
									<input type="hidden" name="jmlbaris" value="{{ $i_verif }}">
									<div class="text-center">
										<input type="submit" name="submit" onclick="return confirm('Yakin data yang di Verifikasi sudah benar?')" class="btn btn-success btn-flat" value="SIMPAN">
									</div>
								</td>
							</tr>
						{!! Form::close() !!}
					</tbody>
				</table>
			</div>
			{{-- CETAK RINCIAN --}}
			@if ( Modules\Registrasi\Entities\Folio::where('registrasi_id', $reg->id)->where('verif_kasa', 'Y')->sum('total') > 0)
				<a href="{{ url('kasir/cetak-verifikasi/'.$reg->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat pull-right"><i class="fa fa-print"></i> CETAK</a>
			@endif
			<div class="">
				<a href="{{ url('kasir/verifikasi') }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-step-backward"></i> SELESAI </a>
			</div>
		</div>
	</div>
@endsection


@section('script')
<script type="text/javascript">
	
</script>
@endsection
