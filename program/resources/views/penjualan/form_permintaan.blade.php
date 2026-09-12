@extends('master')
@section('header')
	<h1></h1>
@endsection
@section('content')
	<div class="col-md-2 no-padding" style="padding-right:10px!important;">	
		<h4 style="margin-top:0;font-size:14px;font-weight:600;">
			Permintaan Rawat Inap
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
							<td>Kamar</td><td class="text-right"><b>{{ $irna->kamar->nama }}</td>
						</tr>
						<tr>
							<td>Status</td><td class="text-right"><b>{{ ucwords($reg->posisi_pasien) }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group{{ $errors->has('berat_badan') ? ' has-error' : '' }}">
					{!! Form::label('berat_badan', 'Berat Badan', ['class' => 'col-sm-12 no-padding no-margin']) !!}
					<div class="col-md-12 no-padding">
						<div class="input-group">
							{!! Form::text('berat_badan', $reg->berat_badan, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
							<small class="text-danger">{{ $errors->first('berat_badan') }}</small>
							<span class="input-group-btn">
								<input type="button" class="btn btn-flat pull-right" value="Kg">
							</span>
						</div>
					</div>
				</div>
			</div>				
			<div class="col-md-12">
				<div class="form-group{{ $errors->has('tekanan_darah') ? ' has-error' : '' }}">
					{!! Form::label('tekanan_darah', 'Tekanan Darah', ['class' => 'col-sm-12 no-padding no-margin']) !!}
					<div class="col-md-12 no-padding">
						<div class="input-group">
							{!! Form::text('tekanan_darah', $reg->tekanan_darah, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
							<small class="text-danger">{{ $errors->first('tekanan_darah') }}</small>
							<span class="input-group-btn">
								<input type="button" class="btn btn-flat pull-right" value="mmHg">
							</span>
						</div>
					</div>
				</div>
			</div>				
			<div class="col-md-12">
				<div class="form-group{{ $errors->has('diagnosa_akhir') ? ' has-error' : '' }}">
					{!! Form::label('diagnosa_akhir', 'Diagnosa Pasien', ['class' => 'col-sm-12 no-padding no-margin']) !!}
					<div class="col-md-12 no-padding">
						{!! Form::textarea('diagnosa_akhir', $reg->diagnosa_akhir, ['class' => 'form-control', 'id'=>'diagnosa_akhir', 'style'=>'height:70px;resize:none;']) !!}
						<small class="text-danger">{{ $errors->first('diagnosa_akhir') }}</small>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-10 no-padding" id="div-right" style="overflow-y:auto;overflow-x:hidden;">
		<div class="box box-primary">
			<div class="box-body">	
				<div class="col-md-4 no-padding">
					<div class="col-md-2 no-padding">
						Pelaksana<br>Farmasi
					</div>
					@if($permintaan==null)
						{!! Form::open(['method' => 'POST', 'url' => 'penjualan/savepermintaan']) !!}
						{!! Form::hidden('pasien_id', $pasien->id) !!}
						{!! Form::hidden('idreg', $idreg) !!}
							<div class="col-md-4 no-padding">
								{!! Form::select('apoteker', $apoteker, null, ['class' => 'form-control select2', 'placeholder'=>'-- Pilih Petugas --']) !!}
							</div>
							<div class="col-md-4">
								{!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Yakin Apoteker sdh benar?")']) !!}
							</div>
						{!! Form::close() !!}
					@else
						<div class="col-md-10">
							<b class="text-primary">
								{{ ($permintaan->apoteker==null) ? '' : baca_apoteker($permintaan->apoteker) }}
							</b>
						</div>			
					@endif
				</div>
			
				@if($permintaan!=null)
					<div class="col-md-4 no-padding">
						<a href="{{ url('penjualan/epo') }}" class="btn btn-warning btn-sm btn-flat pull-right"><i class="fa fa-step-backward"></i> SELESAI</a>
						<a href="{{ url('farmasi/telaah-resep/epo/'.$reg->id) }}" class="btn btn-primary btn-sm btn-flat pull-right"><i class="fa fa-check-square"></i> TELAAH</a> 
						<a target="_blank" href="{{ url('farmasi/laporan/etiket/epo/'.$permintaan->id) }}" class="btn btn-primary btn-sm btn-flat pull-right"><i class="fa fa-file"></i> ETIKET</a> 
						<a target="_blank" href="{{ url('farmasi/cetak-epo/'.$reg->id) }}" class="btn btn-primary btn-sm btn-flat pull-right"><i class="fa fa-print"></i> CETAK KPO</a> 
					</div>
					<div class="col-md-2 no-padding pull-right">
						<center>No. KPO<br><b>{{ $permintaan->no_resep }}</b></center>
					</div>
					<div class="col-md-12 no-padding"><hr style="margin:8px 0;"></div>
					@isset($detail)
						@if(count($detail)>0)
							<div class="col-md-12 no-padding">						
								<div class="col-md-3 no-padding" style="margin-bottom:10px;">
									<button type="button" id="btn-formepo" data-registrasiID="{{ $idreg }}" class="btn btn-info btn-sm btn-flat">
										<i class="fa fa-plus"></i> Tambah Obat
									</button>
								</div>
								<table class='table table-bordered table-hover table-condensed'>
									<thead>
										<tr>
											<th>RACIKAN</th>
											<th>HARI, TANGGAL</th>
											<th>NAMA OBAT</th>
											<th>SATUAN</th>
											<th class="text-center">JML</th>
											<th class="text-center">HARGA @</th>
											<th>ATURAN PAKAI</th>
											<th>ETIKET</th>
											<th>UPDATE STATUS</th>
											<th>HAPUS</th>
											<th>EDIT</th>
											<th>RETUR</th>
										</tr>
									</thead>
									<tbody>
										@php
											$x = '';
											$racikan = '';
											$aturan_pakai = '';
											$etiket = '';
											$waktu = '';
											$enter = false;
											$hari = array ( 1 => 
												'Senin',
												'Selasa',
												'Rabu',
												'Kamis',
												'Jumat',
												'Sabtu',
												'Minggu'
											);
										@endphp
										@foreach ($detail as $key => $d)
											@php
												$aturan_pakai = $d->aturan_pakai;
												if($d->aturan_pakai==null){
													$etiket = '';
												}else{
													$etiket = $d->konversi_aturan_pakai;
												}
												$waktu = $hari[ date_format($d->created_at, 'N') ].', '.date_format($d->created_at, 'd-m-Y');
												if($d->status_racikan==1){
													$racikan = $d->obatRacikan->nama;
													if($racikan!=$x){
														$x = $d->obatRacikan->nama;
													}else{
														$aturan_pakai = '';
														$racikan = '';
														$etiket = '';
														$waktu = '';
													}
													if($racikan!=''){
														$enter = true;
													}else{
														$enter = false;
													}
												}else{
													$enter = true;
													$racikan = '-';
												}
											@endphp
											@if($enter)
												<tr style="background:#f9f9f9;">
													<td colspan=11><b>{{ strtoupper($racikan) }}</b></td>
												</tr>
											@endif
											<tr>
												<td>
													
												</td>
												<td>
													{{ $waktu }}
												</td>
												<td>{{ $d->masterobat->nama }}</td>
												<td>{{ $d->masterobat->satuan }}</td>
												<td class="text-center">{{ $d->jumlah }}</td>
												<td class="text-right">{{ number_format($d->hargajual) }}</td>
												<td>{{ $aturan_pakai }}</td>
												@if($d->hapus==1)
													<td>-</td>
												@else
													<td style="cursor:pointer;" onclick="return ubahEtiket('{{$d->id}}','{{ $etiket }}');">{{ $etiket }} <i class="fa fa-pencil"></i></td>
												@endif
												<td style="width:12%;">
													<div id="show-status{{$d->id}}">
														@if($d->delete_by!=null)
															<span class="text-red">Dihapus oleh {{ App\User::where('id', $d->delete_by)->first()->name }}</span>
														@elseif($d->status=='Terima Retur')
															<span class="text-orange">Diretur oleh {{ App\User::where('id', $d->retur_by)->first()->name }}</span>
														@elseif($d->status=='Sudah Diminum Pasien')
															<span class="text-aqua">{{ $d->status }}</span>
														@else
															<select name="" onchange="updateStatus(this.value, {{$d->id}})" class="form-control">
																@if($d->status=='Pending')
																	<option value="">Pending</option>
																	<option value="Diproses" {{ ($d->status=='Diproses') ? 'selected' : '' }}>Diproses</option>
																@elseif($d->status=='Retur ke Apotek')
																	<option value="">Retur</option>
																	<option value="Terima Retur" {{ ($d->status=='Terima Retur') ? 'selected' : '' }}>Terima Retur</option>
																@elseif($d->status=='Diproses')
																	<option value="">Diproses</option>
																	<option value="Diserahkan">Diserahkan</option>
																@elseif($d->status=='Diserahkan')
																	<option value="">Diserahkan</option>
																	<!--option value="Sudah Diminum Pasien" {{ ($d->status=='Sudah Diminum Pasien') ? 'selected' : '' }}>Sudah Diminum Pasien</option-->
																@endif
															</select>
														@endif
													</div>
													
													<div id="show-alasan{{$d->id}}" style="display:none;">
														<input placeholder="Alasan dihapus" name="alasan{{$d->id}}" id="alasan{{$d->id}}" value="" class="form-control" autofocus>
													</div>
												</td>
												<td>
													{{-- $d->status!='Diserahkan' &&  --}}
													@if($d->status!='Terima Retur' && $d->status!='Sudah Diminum Pasien' && $d->delete_by==null)
														<a id="btn-hapus{{$d->id}}" onclick="confirmHapus({{$d->id}})" href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
														<a style="display:none;" id="btn-simpan-alasan{{$d->id}}" onclick="simpanAlasan({{$d->id}})" href="#" class="btn btn-sm btn-info"><i class="fa fa-save"></i></a>
													@else
														{{ $d->alasan_hapus }}
													@endif
												</td>
												<td>
													{{-- $d->status!='Diserahkan' &&  --}}
													@if($d->status!='Terima Retur' && $d->status!='Sudah Diminum Pasien' && $d->delete_by==null)
														<a id="btn-edit{{$d->id}}" onclick="editObat({{$d->id}})" href="#" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>
													@endif
												</td>
												<td>
													@if($d->status=='Diserahkan')
														<a id="btn-retur{{$d->id}}" onclick="returObat({{$d->id}},{{$d->jumlah}})" href="#" class="btn btn-sm btn-warning"><i class="fa fa-refresh"></i></a>
													@endif
												</td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											<th colspan="5" class="text-right">Total Harga</th>
											<th class="text-right">{{ number_format($detail->sum('hargajual')) }}</th>
											<th></th>
											<th></th>
											<th>
												<a href="" class="btn btn-primary btn-block btn-sm btn-flat"><i class="fa fa-refresh"></i> Update</a>
											</th>
											<th></th>
											<th></th>
										</tr>
									</tfoot>
								</table>
							</div>
						@else
							<center><h4>Belum ada resep dari Dokter</h4></center>
						@endif
					@endisset
				@endif
			</div>
		</div>
	</div>
	
	@if($permintaan!=null)
  <div class="modal fade" id="showFormEpo" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <a href="" type="button" class="close">&times;</a>
          <h4 class="modal-title" id="">Form Resep</h4>
        </div>
        <div class="modal-body">
					<div class="row">
						<div class="col-md-12 no-padding">
							<div class="boxs">
								<div class="box-body" style="margin-bottom:0;padding:0 25px;">
									<form id="formAddEpo" method="post" class="form-horizontal">
										{{ csrf_field() }} {{ method_field('POST') }}
										{!! Form::hidden('pasien_id', $pasien->id) !!}
										{!! Form::hidden('idreg', $idreg) !!}
										{!! Form::hidden('tipe_rawat', $reg->status_reg) !!}
										@include('tindakan::form_permintaan_obat')
									</form>
								</div>
							</div>
						</div>
					</div>
        </div>
      </div>
    </div>
  </div>
	@endif
	
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
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
$('#div-right').css('height',(window.innerHeight-75));
$('.content').css('padding-right','0px');
$('#div-jenis-racikan-epo').hide();
function changeRacikan(val) {
	if(val==1){
		$("#div-jenis-racikan-epo").show();
		$("#div-data-obat-epo").hide();
		$('#addRacikanEpo').hide();
		$('#status_racikan_epo').show();
	}else{
		$("#div-jenis-racikan-epo").hide();
		$("#div-data-obat-epo").show();
		$('#status_racikan_epo').hide();
	}
	$("#aturan-pakai").show();
}
function changeAlergi(val) {
	if(val==1){
		$("#div-ket-alergi-epo").show();
	}else{
		$("#div-ket-alergi-epo").hide();
	}
}

function ribuan(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function editObat(val){
	$("#permintaan_id").val(val);
	$('#isCreateEpo').hide();
	$('#isUpdateEpo').val(1);
	$.ajax({
		url: '/penjualan/edit-permintaan/'+val,
		type: 'GET',
		dataType: 'json',
		success: function (data) {
			if(data.status){
				$('#showFormEpo').modal('show');
				$('#batalEditEpo').show();
				$('select[name="epo_masterobat_id"]').append('<option value="'+data.data.masterobat_id+'">'+data.data.nama+' | '+data.data.satuan+' | '+data.data.stok+'</option>');
				$('select[name="epo_masterobat_id"]').select2('data', {id:data.data.masterobat_id, text:data.data.nama});
				$('input[name="epo_expired"]').val(data.data.expired);
				$('input[name="epo_jumlah"]').val(data.data.jumlah);
				$('select[name="epo_aturan_pakai"]').val(data.data.aturan_pakai);
				$('select[name="epo_aturan_pakai"]').select2().trigger('change');
				$('input[name="epo_jumlah_aturanpakai"]').val(data.data.jumlah_aturanpakai);
				$('select[name="epo_satuan_aturanpakai"]').val(data.data.satuan_aturanpakai);
				$('select[name="epo_satuan_aturanpakai"]').select2().trigger('change');
				$('select[name="epo_informasi1"]').val(data.data.informasi1);
			}else{
				alert('Data tidak ditemukan')
			}
		}
	});
}
$('#batalEditEpo').on('click', function(){
	$(this).hide();
	$("#permintaan_id").val(0);
	$('#isCreateEpo').show();
	$('#isUpdateEpo').val(0);
	$('input[name="epo_expired"]').val('');
	$('input[name="epo_jumlah"]').val(1);
	$('select[name="epo_masterobat_id"]').html('');
	$('#showFormEpo').modal('hide');
});
function returObat(id,jumlah_sekarang){
	var jumlah_retur = prompt('Berapa jumlah yang akan diretur?');
	if(jumlah_retur==null){
		alert('Anda tidak memasukkan jumlah retur');
	}else if(jumlah_sekarang<jumlah_retur){
		alert('Masukkan jumlah retur kurang dari '+jumlah_sekarang);
	}else{
		$.ajax({
			url: '/penjualan/retur-permintaan/'+id+'/'+parseInt(jumlah_retur),
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				if(data.sukses){
					window.location.reload();
				}else{
					alert('Data gagal diretur')
				}
			}
		});
	}
}
function confirmHapus(val){
	if(confirm('Data yakin dihapus?')){
		$("#show-alasan"+val).show();
		$("#btn-simpan-alasan"+val).show();
		$("#alasan"+val).focus();
		$("#show-status"+val).hide();
		$("#btn-hapus"+val).hide();
	}
}
function simpanAlasan(val){
	if($("#alasan"+val).val()==""){
		alert("Alasan wajib diisi");
		$("#alasan"+val).focus();
	}else{
		$.ajax({
			headers:{
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			url: '/penjualan/deletedetailpermintaan/'+val+'/'+{{$reg->pasien_id}}+'/'+{{$idreg}}+'/'+{{$permintaan_id}}+'/'+encodeURI($("#alasan"+val).val()),
			type: 'GET',
			dataType: 'json',
			data: null,
			success: function(data){
				if(data.sukses){
					window.location.reload();
				}else{
					alert('Data gagal dihapus');
				}
			}
		}); 
	}
}
function updateStatus(val, id){
	$.ajax({
		headers:{
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		url: '/penjualan/update-status-permintaan',
		type: 'POST',
		dataType: 'json',
		data: {value: val, id: id},
		success: function(data){
			if(data.sukses){
				//window.location.reload();
			}else{
				alert(data.message);
			}
		},
		error: function(data){
			alert('Gagal update status');
		}
	});   
}

$('#saveItemEpo').on('click', function () {
	$(this).hide();
	if($('select[name="epo_racikan"]').val()==1){	
		$("#aturan-pakai").hide();
	}
	var url = '/epo-simpan';
	$.ajax({
		type: 'POST',
		url: url,
		data: $('#formAddEpo').serialize(),
		success: function (data) {
			alert(data.message);
			$('#saveItemEpo').show();
		}
	});
});
$('#saveRacikanEpo').on('click', function () {
	$.ajax({
		headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    },
		type: 'POST',
		url: '/epo-add-racikan',
		data: {registrasi_id: $('#registrasi_idx').val(), epo_jenis_racikan: $('select[name="epo_jenis_racikan"]').val(), epo_jumlah_racikan: $('input[name="epo_jumlah_racikan"]').val(), epo_satuan_racikan: $('select[name="epo_satuan_racikan"]').val()},
		success: function (data) {
			if(data.sukses == false) {
				alert(data.message);
			}else if(data.sukses == true) {
				$('input[name="epo_jumlah_racikan"]').prop("readonly",true);
				$('#epo_jenis_racikan').hide();
				$('#epo_satuan_racikan').hide();
				$('#epo_satuan_racikan').next(".select2-container").hide();
				$('#text_epo_jenis_racikan').val($('select[name="epo_jenis_racikan"]').val());
				$('#text_epo_satuan_racikan').val($('select[name="epo_satuan_racikan"]').val());
				$('#text_epo_id_racikan').val(data.id_racikan);
				$('#text_epo_jenis_racikan').show();
				$('#text_epo_satuan_racikan').show();
				$('#addRacikanEpo').show();
				$('#saveRacikanEpo').hide();
				$("#div-data-obat-epo").show();
			}
		}
	});
});
$('#addRacikanEpo').on('click', function () {
	$('input[name="epo_jumlah_racikan"]').prop("readonly",false);
	$('select[name="status_racikan_epo"]').val(0);
	$('#status_racikan_epo').hide();
	$('#text_resep_id_racikan').val("");
	$('#epo_jenis_racikan').show();
	$('#epo_satuan_racikan').show();
	$('#epo_satuan_racikan').next(".select2-container").show();
	$('#text_epo_jenis_racikan').hide();
	$('#text_epo_satuan_racikan').hide();
	$("#div-data-obat-epo").hide();
	$("#addRacikanEpo").hide();
	$("#saveRacikanEpo").show();
});

$(document).ready(function() {
	$(document).on('click', '#btn-formepo', function (e) {
		$('#showFormEpo').modal('show');
		$('#isUpdateEpo').val(0);
	});
	$('#showFormEpo').on('hidden.bs.modal', function () {
	 location.reload();
	})
});
function ubahEtiket(id,etiket){
	var new_etiket = prompt('Etiket saat ini: '+etiket+'. Apakah Anda ingin mengubahnya?', etiket);
	if(new_etiket!=null){
		$.ajax({
			url: '/resep-ubah-etiket/epo/'+id+'/'+encodeURI(new_etiket),
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				if(data.sukses) {
					location.reload();
				}else{
					alert("Etiket gagal diubah");
				}
			}
		});
	}
}
</script>
@endsection
