@extends('master')

@section('content')
	<div class="col-md-2 no-padding" style="padding-right:10px!important;">	
		<h4 style="margin-top:0;font-size:14px;font-weight:600;">
			@if (substr($jenis->status_reg,0,1) == 'G')
				Entry Tindakan Radiologi - Rawat Darurat
			@elseif (substr($jenis->status_reg,0,1) == 'J')
				Entry Tindakan Radiologi - Rawat Jalan
			@elseif (substr($jenis->status_reg,0,1) == 'I')
				Penata Jasa Radiologi - Rawat Inap
			@else
				Penata Jasa Radiologi - Tindakan Langsung
			@endif
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
						<!--tr>
							<td>Alamat</td><td class="text-right"><b>{{ $pasien->alamat }}</td>
						</tr-->
						<tr>
							<td>Cara Bayar</td><td class="text-right"><b>{{ baca_carabayar($jenis->bayar) }}</td>
						</tr>
						<tr>
							<td>DPJP</td><td class="text-right"><b>{{ baca_dokter($jenis->dokter_id) }}</td>
						</tr>
						<tr>
							<td>Status</td><td class="text-right"><b>{{ ucwords($jenis->posisi_pasien) }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12" style="margin-bottom:10px;">
				<a href="#" class="btn btn-warning btn-block btn-flat"><span id="total_tagihan_text"></span></a>
			</div>
			<div class="col-md-12" style="margin-bottom:10px;">
				<a href="{{ url('radiologi/hasil/'. $jenis->id) }}" class="btn btn-block btn-primary btn-flat"><i class="fa fa-file"></i> INPUT HASIL</a>
			</div>
			<div class="col-md-12" style="margin-bottom:10px;">
				<div class="col-md-12 no-padding">
					<div class="form-group{{ $errors->has('berat_badan') ? ' has-error' : '' }}">
						{!! Form::label('berat_badan', 'Berat Badan', ['class' => 'col-sm-12 no-padding no-margin']) !!}
						<div class="col-md-12 no-padding">
							<div class="input-group">
								{!! Form::text('berat_badan', $jenis->berat_badan, ['class' => 'form-control', 'readonly'=>true, 'autocomplete' => 'off']) !!}
								<small class="text-danger">{{ $errors->first('berat_badan') }}</small>
								<span class="input-group-btn">
									<input type="button" class="btn btn-flat pull-right" value="Kg">
								</span>
							</div>
						</div>
					</div>
				</div>				
				<div class="col-md-12 no-padding">
					<div class="form-group{{ $errors->has('tekanan_darah') ? ' has-error' : '' }}">
						{!! Form::label('tekanan_darah', 'Tekanan Darah', ['class' => 'col-sm-12 no-padding no-margin']) !!}
						<div class="col-md-12 no-padding">
							<div class="input-group">
								{!! Form::text('tekanan_darah', $jenis->tekanan_darah, ['class' => 'form-control', 'readonly'=>true, 'autocomplete' => 'off']) !!}
								<small class="text-danger">{{ $errors->first('tekanan_darah') }}</small>
								<span class="input-group-btn">
									<input type="button" class="btn btn-flat pull-right" value="mmHg">
								</span>
							</div>
						</div>
					</div>
				</div>				
				<div class="col-md-12 no-padding">
					<div class="form-group{{ $errors->has('diagnosa_akhir') ? ' has-error' : '' }}">
						{!! Form::label('diagnosa_akhir', 'Diagnosa Pasien', ['class' => 'col-sm-12 no-padding no-margin']) !!}
						<div class="col-md-12 no-padding">
							{!! Form::textarea('diagnosa_akhir', $jenis->diagnosa_akhir, ['class' => 'form-control', 'readonly'=>true, 'id'=>'diagnosa_akhir', 'style'=>'height:70px;resize:none;']) !!}
							<small class="text-danger">{{ $errors->first('diagnosa_akhir') }}</small>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
	
	<div class="col-md-10 no-padding" id="div-right" style="overflow-y:auto;overflow-x:hidden;">			
		<div class="nav-tabs-custom" style="margin-bottom:0;">
			<ul class="nav nav-tabs">
				<li id="tabtindakan" class="active"><a href="#tab_tindakan" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">TINDAKAN</a></li>
				<li id="tabpakaiobat"><a href="#tab_pakaiobat" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">PEMAKAIAN OBAT</a></li>
				<div class="pull-right" style="width: 40%;">
					<div class="col-md-12 col-sm-12 col-xs-12 no-padding">
						<input type="hidden" value="{{ $reg_id }}" id="reg_id">
						<div class="col-md-8 col-sm-8 col-xs-8" style="margin-top:3px;">
							{!! Form::select('radiografer', $radiografer, session('radiografer'), ['class' => 'form-control select2', 'placeholder'=>'-- pilih pelaksana --', 'style'=>'width:100%;', 'onchange'=>'updatePelaksana(this.value)']) !!}
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4" style="padding-left:0;margin-top:5px;">
							<a href="{{ url('radiologi/selesai/'.$reg_id) }}" onclick="return confirm('{{ ($jenis->dokter_id==0) ? 'Apakah yakin pemeriksaan sudah selesai dan ingin memulangkan pasien?' : 'Apakah yakin pemeriksaan sudah selesai?' }}')" class="btn btn-primary btn-flat btn-block">
								{{ ($jenis->dokter_id==0) ? 'PULANGKAN' : 'SELESAI' }}
							</a>
						</div>
					</div>
				</div>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_tindakan">
					<div class="row">
						<div style="padding:0 5px;">
							<div class="col-md-12 no-padding">
								@role(['supervisor','radiologi','administrator'])
									@if($jenis->posisi_pasien!='selesai')
									<div class="col-md-12">
										<div class="col-md-12" style="background:#f9f9f9;padding:10px;border:solid 1px #eee;">
											{!! Form::open(['method' => 'POST', 'url' => 'radiologi/save-order', 'class' => 'form-horizontal']) !!}
											{!! Form::hidden('registrasi_id', $idreg) !!}
											{!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
											{!! Form::hidden('pasien_id', $pasien->id) !!}
											{!! Form::hidden('dokter_id', $jenis->dokter_id) !!}
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
													<input type="hidden" name="poli_id" value="{{$jenis->poli_id}}">
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
									</div>
									@endif
								@endrole
								<div class="col-md-6">
									<h5><b>#Jenis Order Tindakan</b></h5>
									<div class='table-responsive'>
										<table class='table table-striped table-bordered table-hover table-condensed'>
											<thead>
												<tr>
													<th>No</th>
													<th>Nama</th>
													<th>Status</th>
													@role(['supervisor','radiologi','administrator'])
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
														<td>
															@if($d->status_proses==1)
																<i class="fa fa-check"></i> Sudah diproses
															@else
																<i class="fa fa-remove"></i> Belum diproses
															@endif
														</td>
														@role(['supervisor','radiologi','administrator'])
															<td>
															@if($jenis->posisi_pasien!='selesai')
															<a href="{{ url('radiologi/hapus-jenisorder/'.$d->id.'/'.$d->registrasi_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
															@endif
															</td>
														@endrole
													</tr>
													@endforeach
												@endif
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-md-6">
									<h5>
										<b>#Catatan</b>
									</h5>
									<div class="box box-widget widget-user" style="margin-bottom:10px;">
										<div class="" style="background:#fff;height:auto;padding:5px 20px;">
											<div class="row">
												@php $no=1; @endphp
												@foreach ($order as $key => $d)
													<table class="" style="width:100%;color:black;">
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
							</div>
								
							<div class="col-md-12">
								@if(count($detil_order)>0)
								<div class="col-md-4 no-padding">
									<div class="box-body" style="background:#f9f9f9;border:solid 1px #eee;margin:0 10px 10px 0;">
										@if($jenis->posisi_pasien!='selesai')
											{!! Form::open(['method' => 'POST', 'url' => 'radiologi/save-tindakan', 'class' => 'form-horizontal']) !!}
											{!! Form::hidden('registrasi_id', $reg_id) !!}
											{!! Form::hidden('jenis', $jenis->jenis_pasien) !!}
											{!! Form::hidden('pasien_id', $pasien->id) !!}
											{!! Form::hidden('dokter_id', $jenis->dokter_id) !!}
											
											<div class="row">
												{!! Form::hidden('jumlah', 1, ['class' => 'form-control']) !!}
												<div class="col-md-12">
													<div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
														{!! Form::label('tarif_id', 'Tindakan', ['class' => 'col-md-12']) !!}
														<div class="col-md-12">
															<select class="form-control select2" name="tarif_id">
																@foreach($tindakan as $d)
																<option value="{{ $d->id }}">{{ $d->nama }} | {{ number_format(getTotalTarif($jenis,$d)) }}</option>
																@endforeach
															</select>
															<small class="text-danger">{{ $errors->first('tarif_id') }}</small>
														</div>
													</div>
												</div>
												<input type="hidden" name="poli_id" value="{{$jenis->poli_id}}">
												<div class="col-md-12">
													<div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
														{!! Form::label('tanggal', 'Tanggal', ['class' => 'col-md-12']) !!}
														<div class="col-md-6">
															{!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
														</div>
														<div class="col-md-6">
															{!! Form::submit("Tambah Tindakan", ['class' => 'btn btn-success btn-block btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
														</div>
													</div>
												</div>
											</div>
											{!! Form::close() !!}
										@endif
									</div>
								</div>
								
								<div class="col-md-8 no-padding">
									<h5 class="no-margin"><b>#Detil Tindakan</b></h5>
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
												<th>Status</th>
												@role(['supervisor','radiologi','administrator'])
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
													<td>{{ $d->namatarif }}</td>
													<td class="text-right">{{ number_format($d->total,0,',','.') }}</td>
													<td>{{ baca_dokter($d->radiografer) }}</td>
													<td>{{ $d->user->name }}</td>
													<td>{{ $d->created_at->format('d-m-Y') }}</td>
													<td>{{ ($d->status_proses==1) ? 'Selesai' : '' }}</td>
													@role(['supervisor','radiologi','administrator'])
													<td>
													@if ($d->lunas == 'Y')
														<i class="fa fa-check"></i>
													@else
														<a href="{{ url('radiologi/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
													@endif
													</td>
													@endrole
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane active" id="tab_pakaiobat">
					<div class="row">
						<div style="padding:;">
							<div class="col-md-12">
								<div class="col-md-4 no-padding">
									<div class="boxz" style="border:none;">
										<div style="background:#f8f8f8;border:solid 1px #eee;padding:10px;margin-right:10px;">
											<form id="formAddPakai" method="post" class="form-horizontal">
												{{ csrf_field() }} {{ method_field('POST') }}
												{!! Form::hidden('pasien_id', $pasien->id) !!}
												{!! Form::hidden('idreg', $idreg) !!}
												{!! Form::hidden('tipe_rawat', $jenis->status_reg) !!}
												<div class="rowx">
													<div class="form-group{{ $errors->has('masterobat_id') ? ' has-error' : '' }}">
														{!! Form::label('masterobat_id', 'Pilih Obat', ['class' => 'col-sm-12']) !!}
														<div class="col-sm-12">
															<select name="masterobat_id" id="" class="form-control select2ajaxdepo">
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
@stop

@section('script')
<script type="text/javascript">
$('#div-right').css('height',(window.innerHeight-75));
$('.content').css('padding-right','0px');
$('#total_tagihan_text').html('Menghitung...');

setTimeout(function(){ 
	var element = document.getElementById("tab_pakaiobat");
	element.classList.remove("active");
}, 500);

setTimeout(function(){
	$('#total_tagihan_text').html('Rp. '+ribuan(parseInt(<?php echo $tagihan; ?>) + parseInt(<?php echo session('total_obat'); ?>)));
}, 2000);

// master Obat
$('.select2').select2();

var table = null;
$("#tabpakaiobat").click(function(){
	table = getPemakaian();
});
function getPemakaian(){
	$("#detailPemakaian").DataTable().destroy()
	return $('#detailPemakaian').DataTable({
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
		ajax: '/pemakaian-detail/'+$('input[name="idreg"]').val(),
		columns: [
			{data: 'rownum'},
			{data: 'created_at'},
			{data: 'masterobat_id'},
			{data: 'satuan'},
			{data: 'jumlah'},
			{data: 'hargajual'},
			{data: 'delete'},
		]
	});
}

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
				$("#tabpakaiobat").click();
				$('input[name="masterobat_id"]').val("");
				$('input[name="jumlah"]').val(1);
				$('input[name="informasi1"]').val("");
				$('input[name="informasi2"]').val("");
			}
		}
	});
});

function updatePelaksana(val){
	$.ajax({
		headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    },
		type: 'POST',
		url: '/radiologi/update-pelaksana',
		data: {radiografer: val, registrasi_id: $("#reg_id").val()},
		success: function (data) {
			
		}
	});
}

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
					$("#tabpakaiobat").click();
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

$(document).ready(function() {
	//TINDAKAN entry
	$('select[name="kategoriTarifID"]').on('change', function() {
		var tarif_id = $(this).val();
		if(tarif_id) {
			$.ajax({
				url: '/tindakan/getTarif/'+tarif_id,
				type: "GET",
				dataType: "json",
				success:function(data) {
					//$('select[name="tarif_id"]').append('<option value=""></option>');
					$('select[name="tarif_id"]').empty();
					$.each(data, function(id, nama, total) {
						$('select[name="tarif_id"]').append('<option value="'+ nama.id +'">'+ nama.nama +' | '+ ribuan(nama.total)+'</option>');
					});

				}
			});
		}else{
			$('select[name="tarif_id"]').empty();
		}
	});
});
</script>
@endsection
