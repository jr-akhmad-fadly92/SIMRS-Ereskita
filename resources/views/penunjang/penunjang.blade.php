@extends('master')

@section('content')
	<div class="col-md-2 no-padding" style="padding-right:10px!important;">	
		<h4 style="margin-top:0;font-size:14px;font-weight:600;">
			Rawat {{$layanan}} - Order {{ $header }}
		</h4>
		<!-- border-radius:4px 4px 50px 4px!important; -->
		<div class="box box-widget widget-user" style="margin-bottom:10px;">
			<div class="widget-user-header bg-aqua-active" style="height:auto;">
				<div class="row">
					<table class="table-condensed" style="width:100%;color:white;">
						<tr>
							<td style="width:35%;">Nama</td><td class="text-right"><b>{{ $pasien->nama }}</td>
						</tr>
						<tr>
							<td>No. RM</td><td class="text-right"><b>{{ $pasien->no_rm }}</td>
						</tr>
						<tr>
							<td>Tgl. Lahir</td><td class="text-right"><b>{{ tgl_indo($pasien->tgllahir) }}</td>
						</tr>
						<tr>
							<td>Alamat</td><td class="text-right"><b>{{ $pasien->alamat }}</td>
						</tr>
						<tr>
							<td>Cara Bayar</td><td class="text-right"><b>{{ baca_carabayar($reg->bayar) }}</td>
						</tr>
						<tr>
							<td>DPJP</td><td class="text-right"><b>{{ baca_dokter($reg->dokter_id) }}</td>
						</tr>
						<tr>
							<td>Status</td><td class="text-right"><b>{{ ucwords($reg->posisi_pasien) }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<h4 style="margin-top:0;font-size:14px;font-weight:600;">
			#Order Sebelumnya
		</h4>
		<div class="box box-widget widget-user" style="margin-bottom:10px;">
			<div class="widget-user-header bg-aqua-active" style="height:auto;">
				<div class="row">
					@foreach ($order as $key => $d)
						<table class="" style="width:100%;color:white;">
							<tr>
								<td>{{ $no++ }}. <b>{{ $d->created_at->format('d - m - Y / H:i:s') }}</b></td>
							</tr>
							<tr>
								<td>{!! $d->pemeriksaan !!}</td>
							</tr>
						</table>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-10 no-padding" id="div-right" style="overflow-y:auto;overflow-x:hidden;">
		<div class="nav-tabs-custom" style="margin-bottom:0;">
			<ul class="nav nav-tabs">
				<li id="tabtindakan" class="active"><a href="#tab_tindakan" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">TINDAKAN</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_tindakan">
					<div class="row">
						<div style="padding:0 10px;">
							<div class="col-md-12">
								<div class="box-info" style="margin-bottom:10px;">
									{!! Form::open(['method' => 'POST', 'url' => 'penunjang/save-tindakan', 'class' => 'form-horizontal']) !!}
									{!! Form::hidden('registrasi_id', $idreg) !!}
									{!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
									{!! Form::hidden('pasien_id', $pasien->id) !!}
									{!! Form::hidden('dokter_id', $jenis->dokter_id) !!}
									{!! Form::hidden('penunjang', $header) !!}
									@php
										$link_tipe = '';
										$layanan_tipe = '';
										if($layanan=='Jalan'){
											$link_tipe = 'rawat-jalan';
											$layanan_tipe = 'rajal_penunjang';
										}elseif($layanan=='Darurat'){
											$link_tipe = 'darurat';
											$layanan_tipe = 'darurat_penunjang';
										}elseif($layanan=='Inap'){
											$link_tipe = 'rawat-inap';
											$layanan_tipe = 'ranap_penunjang';
										}
									@endphp
									{!! Form::hidden($layanan_tipe, true) !!}
									<div class="row">
										<div class="col-md-12">
											{!! Form::hidden('jumlah', 1, ['class' => 'form-control']) !!}
											<div class="col-md-3 no-padding">
												<div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
													{!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-md-12']) !!}
													<div class="col-md-12">
														<select class="form-control chosen-select" name="tarif_id">
															@foreach(Modules\Tarif\Entities\Tarif::where('kategoritarif_id', $kat_tarif)->get() as $d)
															<option value="{{ $d->id }}">{{ $d->nama }} | {{ number_format(getTotalTarif($jenis,$d)) }}</option>
															@endforeach
														</select>
														<small class="text-danger">{{ $errors->first('tarif_id') }}</small>
													</div>
												</div>
											</div>
											<select class="hidden" name="poli_id">
												@foreach ($opt_poli as $key => $d)
													<option value="{{ $d->id }}">{{ $d->nama }}</option>
												@endforeach
											</select>
											<div class="col-md-3 no-padding">
												<div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
													{!! Form::label('tanggal', 'Tanggal', ['class' => 'col-md-12']) !!}
													<div class="col-md-12">
														{!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
														<small class="text-danger">{{ $errors->first('tanggal') }}</small>
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label class="col-md-12">
														Aksi
													</label>
													<div class="col-md-12">
														{!! Form::submit("Tambah Tindakan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									{!! Form::close() !!}
								</div>
									
								<div>
									<table class='table table-striped table-bordered table-hover table-condensed'>
										<thead>
											<tr>
											<th>No</th>
											<th>Tindakan</th>
											<th>Biaya</th>
											<th>Total</th>
											<th>Pelaksana</th>
											<th>Admin</th>
											<th>Waktu</th>
											<th>Bayar</th>
											@role(['supervisor','kamarbersalin','fisioterapi','administrator','rawatjalan','rawatdarurat','rawatinap'])
											<th>Hapus</th>
											@endrole
											</tr>
										</thead>
										<tbody>
											@php
												$no=1;
											@endphp
											@foreach ($folio as $key => $d)
											<tr>
												<td>{{ $no++ }}</td>
												<td>{{ ($d->tarif_id <> 0 ) ? $d->tarif->nama : 'Penjualan Obat' }}</td>
												<td>{{ ($d->tarif_id <> 0 ) ? ($d->tarif->total==0) ? 0 : number_format($d->tarif->total,0,',','.') : '' }}</td>
												<td>{{ number_format($d->total,0,',','.') }}</td>
												<td> </td>
												<td>{{ $d->user->name }}</td>
												<td>{{ $d->created_at->format('d-m-Y') }}</td>
												<td>
													@if ($d->lunas == 'Y')
														<i class="fa fa-check"></i>
													@else
														<i class="fa fa-remove"></i>
													@endif
												</td>												  @role(['supervisor','kamarbersalin','fisioterapi','administrator','rawatjalan','rawatdarurat','rawatinap'])
													<td>
													@if ($d->lunas == 'Y')
														<i class="fa fa-check"></i>
													@else
														<a href="{{ url('penunjang/hapus-tindakan/'.$penunjang.'/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id.'/'.$link_tipe) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
													@endif
													</td>
												@endrole
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								
								@if(count($folio)>0)
									{!! Form::open(['method' => 'POST', 'url' => 'tindakan/simpan-penunjang', 'class' => 'form-horizontal']) !!}
										{!! Form::hidden('registrasi_id', $idreg) !!}
										{!! Form::hidden('dokter', $reg->dokter_id) !!}
										{!! Form::hidden('instalasi', $layanan) !!}
										{!! Form::hidden('penunjang', $header) !!}
										<div class="form-group{{ $errors->has('pemeriksaan') ? ' has-error' : '' }}">
												<div class="col-md-12">
														{!! Form::textarea('pemeriksaan', null, ['class' => 'form-control', 'placeholder'=>'Catatan', 'style'=>'height:60px;']) !!}
														<small class="text-danger">{{ $errors->first('pemeriksaan') }}</small>
												</div>
										</div>
										<div class="btn-group pull-right">
												{!! Form::submit("ORDER ".strtoupper($header), ['class' => 'btn btn-success btn-flat']) !!}
										</div>
									{!! Form::close() !!}
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
$('#div-right').css('height',(window.innerHeight-75));
$('.content').css('padding-right','0px');
setTimeout(function(){ 
	var element = document.getElementById("tab_pakaiobat");
	element.classList.remove("active");
}, 500);
function ribuan(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>
@endsection