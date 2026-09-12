@extends('master')

@section('content')
	<div class="col-md-2 no-padding" style="padding-right:10px!important;">	
		<h4 style="margin-top:0;font-size:14px;font-weight:600;">
			Rawat {{$layanan}} - Order Radiologi
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
				@if(strtolower(Auth::user()->role()->first()->name)=='radiologi')
					<li id="tabpakaiobat"><a href="#tab_pakaiobat" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">PEMAKAIAN OBAT</a></li>
				@endif
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_tindakan">
					<div class="row">
						<div style="padding:0 10px;">
							<div class="col-md-12">
								<div class="box-info" style="margin-bottom:10px;">
									{!! Form::open(['method' => 'POST', 'url' => 'radiologi/save-order', 'class' => 'form-horizontal']) !!}
									{!! Form::hidden('registrasi_id', $idreg) !!}
									{!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
									{!! Form::hidden('pasien_id', $pasien->id) !!}
									{!! Form::hidden('dokter_id', $jenis->dokter_id) !!}
									@php
										$link_tipe = '';
										$layanan_tipe = '';
										if($layanan=='Jalan'){
											$link_tipe = 'rawat-jalan';
											$layanan_tipe = 'rajal_rad';
										}elseif($layanan=='Darurat'){
											$link_tipe = 'darurat';
											$layanan_tipe = 'darurat_rad';
										}elseif($layanan=='Inap'){
											$link_tipe = 'rawat-inap';
											$layanan_tipe = 'ranap_rad';
										}
									@endphp
									{!! Form::hidden($layanan_tipe, true) !!}
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-3 no-padding">
												<div class="form-group{{ $errors->has('tindakan_radiologi') ? ' has-error' : '' }}">
													{!! Form::label('tindakan_radiologi', 'Tindakan', ['class' => 'col-md-12']) !!}
													<div class="col-md-12">
														<select class="form-control select2" name="tindakan_radiologi">
															@foreach($tindakanradiologi as $d)
																<option value="{{ $d->id }}">{{ $d->kelompok }}</option>
															@endforeach
														</select>
														<small class="text-danger">{{ $errors->first('tindakan_radiologi') }}</small>
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
											<div class="col-md-3 no-padding">
												<div class="form-group">
													<label class="col-md-12">
														Aksi
													</label>
													<div class="col-md-12">
														{!! Form::submit("Tambah Jenis Tindakan", ['style'=>'margin-left:10px;margin-top:2px;', 'class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
													</div>
												</div>
											</div>
										</div>
									</div>
									{!! Form::close() !!}
								</div>
								
								<h5><b>#Jenis Tindakan</b></h5>
								<div class='table-responsive'>
									<table class='table table-striped table-bordered table-hover table-condensed'>
										<thead>
											<tr>
												<th>No</th>
												<th>Nama</th>
												@role(['supervisor', 'radiologi','administrator','rawatjalan','rawatdarurat','rawatinap'])
												<th>Hapus</th>
												@endrole
											</tr>
										</thead>
										<tbody>
											@php
												$no=1;
											@endphp
											@if($detil_order!=null)
											@foreach($detil_order as $key => $d)
											<tr>
												<td>{{ $no++ }}</td>
												<td>{{ $d->tindakanRadiologiSub->kelompok }}</td>
												@role(['supervisor', 'radiologi','administrator','rawatjalan','rawatdarurat','rawatinap'])
													<td>
														<a href="{{ url('radiologi/hapus-jenisorder/'.$d->id.'/'.$d->registrasi_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
													</td>
												@endrole
											</tr>
											@endforeach
											@endif
										</tbody>
									</table>
								</div>
								
								@if(count($folio)>0)
								<h5><b>#Detil Tindakan</b></h5>
								<div class='table-responsive'>
									<table class='table table-striped table-bordered table-hover table-condensed'>
										<thead>
											<tr>
											<th>No</th>
											<th>Tindakan</th>
											<th>Biaya</th>
											<th>Pelaksana</th>
											<th>Admin</th>
											<th>Waktu</th>
											<th>Bayar</th>
											@role(['supervisor', 'radiologi','administrator'])
											<th>Hapus</th>
											@endrole
											</tr>
										</thead>
										<tbody>
											@php
												$no=1;
											@endphp
											@foreach($folio as $key => $d)
											<tr>
												<td>{{ $no++ }}</td>
												<td>{{ $d->namatarif }}</td>
												<td class="text-right">{{ number_format($d->total,0,',','.') }}</td>
												<td>{{ baca_dokter($d->radiografer) }}</td>
												<td>{{ $d->user->name }}</td>
												<td>{{ $d->created_at->format('d-m-Y') }}</td>
												<td>
												@if ($d->lunas == 'Y')
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-remove"></i>
												@endif
												</td>
												@role(['supervisor', 'radiologi','administrator'])
													<td>
													@if ($d->lunas == 'Y')
														<i class="fa fa-check"></i>
													@else
														<a href="{{ url('radiologi/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id.'/'.$link_tipe) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
													@endif
													</td>
												@endrole
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								@endif
								@if(count($detil_order)>0)
								{!! Form::open(['method' => 'POST', 'url' => 'tindakan/simpan-radiologi', 'class' => 'form-horizontal']) !!}
									{!! Form::hidden('registrasi_id', $reg->id) !!}
									{!! Form::hidden('dokter', $reg->dokter_id) !!}
									{!! Form::hidden('instalasi', $layanan) !!}
									<div class="form-group{{ $errors->has('pemeriksaan') ? ' has-error' : '' }}">
										<div class="col-sm-12">
											{!! Form::textarea('pemeriksaan', null, ['class' => 'form-control', 'placeholder'=>'Catatan', 'style'=>'height:60px;']) !!}
											<small class="text-danger">{{ $errors->first('pemeriksaan') }}</small>
										</div>
									</div>

									<div class="btn-group pull-right">
											{!! Form::submit("ORDER RADIOLOGI", ['class' => 'btn btn-success btn-flat']) !!}
									</div>
								{!! Form::close() !!}
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane active" id="tab_pakaiobat">
					<div class="row">
						<div style="padding:0 10px;">
							<div class="col-md-12">
								<div class="col-md-4 no-padding">
									<div class="boxz" style="border:none;">
										<div style="background:#f8f8f8;padding:10px;margin-right:10px;">
											<form id="formAddPakai" method="post" class="form-horizontal">
												{{ csrf_field() }} {{ method_field('POST') }}
												{!! Form::hidden('pasien_id', $pasien->id) !!}
												{!! Form::hidden('idreg', $idreg) !!}
												{!! Form::hidden('tipe_rawat', $jenis->status_reg) !!}
												<div class="rowx">
													<div class="form-group{{ $errors->has('masterobat_id') ? ' has-error' : '' }}">
														{!! Form::label('masterobat_id', 'Pilih Obat', ['class' => 'col-sm-12']) !!}
														<div class="col-sm-12">
															<select name="masterobat_id" id="" class="form-control select2">
															</select>
															<small class="text-danger">{{ $errors->first('masterobat_id') }}</small>
														</div>
													</div>
													<div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
														{!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-12']) !!}
														<div class="col-sm-6">
															<input type="number" name="jumlah" value="1" class="form-control">
														</div>
													</div>
													<div class="form-group{{ $errors->has('informasi1') ? ' has-error' : '' }}">
														{!! Form::label('informasi1', 'Informasi 1', ['class' => 'col-sm-12']) !!}
														<div class="col-sm-12">
															{!! Form::text('informasi1', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
														</div>
													</div>
													<div class="form-group{{ $errors->has('informasi2') ? ' has-error' : '' }}">
														{!! Form::label('informasi2', 'Informasi 2', ['class' => 'col-sm-12', 'autocomplete' => 'off']) !!}
														<div class="col-sm-12">
															{!! Form::text('informasi2', null, ['class' => 'form-control']) !!}
														</div>
													</div>
													<div class="form-group{{ $errors->has('cetak') ? ' has-error' : '' }}">
														<div class="col-sm-12">
															<button type="button" id="saveItemPem" class="btn btn-primary btn-block btn-flat">Tambahkan</button>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
									
								<div class="col-md-8 no-padding">
									<div>
										<table id="detailPemakaian" class='table table-striped table-bordered table-hover table-condensed' style="margin:0!important;">
											<thead>
												<tr>
												<th class="text-center">No</th>
												<th>Waktu</th>
												<th>Nama Obat</th>
												<th>Satuan</th>
												<th style="text-align:center">Jml</th>
												<th style="width:10%" class="text-center">Harga</th>
												<th>Hapus</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
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

// master Obat
$('.select2').select2();
$('select[name="masterobat_id"]').html('<option value=""></option>');
$.ajax({
	url: '/penjualan/master-obat/<?php echo $depo;?>',
	type: 'GET',
	dataType: 'json',
	success: function(data){
		$.each(data, function(index, val) {
			$('select[name="masterobat_id"]').append('<option value="'+val.id+'">'+val.nama+' | '+val.satuan+' | Rp '+ribuan(mojs('{{substr($reg->status_reg,0,1)}}',val.hargajual))+' | '+val.stok+'</option>');
		});       
	}
});

// view Detail
var id = $('input[name="registrasi_id"]').val();
var table = $('#detailPemakaian').DataTable({
	'language': {
		'url': '/json/pasien.datatable-language.json',
	},
	lengthChange: false,
	paging      : false,
	searching   : false,
	ordering    : false,
	autoWidth   : false,
	processing  : false,
	info        : false,
	serverSide  : true,
	ajax: '/pemakaian-detail/'+id,
	columns: [
		{data: 'rownum'},
		{data: 'masterobat_id'},
		{data: 'satuan'},
		{data: 'jumlah'},
		{data: 'hargajual'},
		{data: 'delete'},
	]
});

// save Detail
$('#saveItemPem').on('click', function () {
	$.ajax({
		type: 'POST',
		url: '/pemakaian-simpan',
		data: $('#formAddPakai').serialize(),
		success: function (data) {
			if(data.sukses == false) {
				alert(data.message);
			}else if(data.sukses == true) {
				table.ajax.reload();
				$('input[name="masterobat_id"]').val("");
				$('input[name="jumlah"]').val(1);
				$('input[name="informasi1"]').val("");
				$('input[name="informasi2"]').val("");
			}
		}
	});
});

// hapus Detail
$(document).on('click', '.hapus', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	if (confirm('Apakah yakin item ini akan dihapus?')) {
		$.ajax({
			url: '/pemakaian-hapus/' + id,
			type: 'GET',
			success: function (data) {
				if(data.sukses == true) {
					table.ajax.reload();
				}else{
					alert("Item gagal dihapus");
				}
			}
		});
	}
})

function ribuan(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>
@endsection