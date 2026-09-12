@extends('master')

@section('content')
	<div class="col-md-2 no-padding" style="padding-right:10px!important;">	
		<h4 style="margin-top:0;font-size:14px;font-weight:600;">
			@if ( substr($reg->status_reg, 0, 1) == 'I' )
				Penjualan Rawat Inap @if(session()->get('retur')=='retur')(Retur)@endif
			@elseif ( substr($reg->status_reg, 0, 1) == 'G' )
				Penjualan Rawat Darurat @if(session()->get('retur')=='retur')(Retur)@endif
			@elseif ( substr($reg->status_reg, 0, 1) == 'J' )
				Penjualan Rawat Jalan @if(session()->get('retur')=='retur')(Retur)@endif
			@else
				Penjualan Bebas
			@endif
		</h4>
		<!-- border-radius:4px 4px 50px 4px!important; -->
		<div class="box box-widget widget-user" style="margin-bottom:10px;">
			<div class="widget-user-header bg-aqua-active" style="height:auto;">
				<div class="row">
					<table class="table-condensed" style="width:100%;color:white;">
						@if($penjualan!=null)
						<tr>
							<td colspan=4 class="text-center">
								No. Faktur <b>{{ $penjualan->no_resep }}</b>
							</td>
						</tr>
						@endif
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
						@if($bebas=='')
						<tr>
							<td>Cara Bayar</td><td class="text-right"><b>{{ baca_carabayar($reg->bayar) }}</td>
						</tr>
						<tr>
							<td>DPJP</td><td class="text-right"><b>{{ baca_dokter($reg->dokter_id) }}</td>
						</tr>
						@endif
						<tr>
							<td>Status</td><td class="text-right"><b>{{ ucwords($reg->posisi_pasien) }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		
		@if($bebas=='')
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
		@endif
	</div>
	<div class="col-md-10 no-padding" id="div-right" style="overflow-y:auto;overflow-x:hidden;">
		<div class="box box-primary">
			<div class="box-header with-border">	
				<div class="col-md-8 no-padding">
					<div class="col-md-2 no-padding">
						Pelaksana<br>Farmasi
					</div>
					@if($penjualan==null)
						{!! Form::open(['method' => 'POST', 'url' => 'penjualan/savepenjualan']) !!}
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
						<div class="col-md-4">
							<b class="text-primary">
								{{ ($penjualan->apoteker==null) ? '' : baca_apoteker($penjualan->apoteker) }}
							</b>
						</div>			
					@endif
				</div>			
				<div class="col-md-4 no-padding">
					@if($penjualan!=null)
						@php
							$antrian = App\AntrianApotek::where('registrasi_id',$reg->id)->first();
						@endphp
						@if($reg->posisi_pasien!='konfirmasi farmasi' AND $reg->posisi_pasien!='selesai' AND $reg->posisi_pasien!='pengembalian uang retur')
							<a href="#" id="click-panggil" data-idreg="{{ $reg->id }}" class="btn btn-success btn-sm btn-flat pull-right"><i class="fa fa-microphone"></i> Panggil Pasien {{ ($antrian!=null) ? $antrian->kelompok.$antrian->nomor : '' }}</a>
						@endif
						<div class="pull-right" style="margin-right:10px;">
							<h5 class="no-margin text-right">Status Pasien</h5>
							<p class="no-margin text-right text-bold">
								{{ ucwords($reg->posisi_pasien) }}
							</p>
						</div>
					@endif
				</div>			
			</div>
			<div class="box-body">			
				@if($penjualan!=null)
					<div class="col-xs-12 no-padding" style="margin-bottom:10px;">
						@if($reg->posisi_pasien=='antrian apotek' OR $reg->posisi_pasien=='konfirmasi farmasi')
						<div style="margin-top:10px;float:left">
							<button type="button" id="btn-formresep" data-registrasiID="{{ $idreg }}" class="btn btn-info btn-sm btn-flat">
								<i class="fa fa-plus"></i> Tambah Obat
							</button>
						</div>
						@endif
						<div style="margin-top:10px;float:right">
							<td class="text-center">
								<button type="button" id="historipenjualan" data-registrasiID="{{ $idreg }}" class="btn btn-info btn-sm btn-flat">
									<i class="fa fa-th-list"></i> Histori
								</button>
							</td>
							@if($bebas=='')
							<td class="text-center">
								<a href="{{ url('farmasi/telaah-resep/resep/'.$reg->id) }}" class="btn btn-warning btn-flat btn-sm"> <i class="fa fa-check-square"></i> Telaah</a>
							</td>
							@endif
							<td class="text-center">
								<a target="_blank" href="{{ url('farmasi/cetak-detail/'.$penjualan->id) }}" class="btn btn-danger btn-flat btn-sm"> <i class="fa fa-file-pdf-o"></i> Rincian</a>
							</td>
							<td class="text-center">
								<a target="_blank" href="{{ url('farmasi/cetak-resep/'.$penjualan->id) }}" class="btn bg-pink btn-flat btn-sm text-google"> <i class="fa fa-print"></i> Resep</a>
							</td>
							<td class="text-center">
								<a target="_blank" href="{{ url('farmasi/laporan/etiket/rj/'.$penjualan->id) }}" class="btn btn-primary btn-flat btn-sm"> <i class="fa fa-print"></i> Etiket</a>
							</td>
						</div>
					</div>
				@endif
				
				@if($penjualan!=null)
					<div class="">
						<table id="detailResep" class='table table-bordered table-hover table-condensed'>
							<thead>
								<tr>
									<th>RACIKAN</th>
									<th>NAMA OBAT</th>
									<th>SATUAN</th>
									<th style="text-align:center">JML</th>
									<th style="width:10%" class="text-center">HARGA @</th>
									<th>ATURAN PAKAI</th>
									<th>ETIKET</th>
									<th>STATUS</th>
									<th>AKSI</th>
									@if($reg->posisi_pasien=='antrian apotek' OR $reg->posisi_pasien=='konfirmasi farmasi')
										<th>EDIT</th>
									@endif
								</tr>
							</thead>
							<tbody>
								@php
									$x = '';
									$racikan = '';
									$aturan_pakai = '';
									$etiket = '';
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
										$retur_bayar = false;
										if($d->retur==1 AND $d->retur_bayar==null){
											$retur_bayar = true;
										}
										$aturan_pakai = $d->aturan_pakai;
										if($d->aturan_pakai==null){
											$etiket = '';
										}else{
											$etiket = $d->konversi_aturan_pakai;
										}
										if($d->status_racikan==1){
											$racikan = $d->obatRacikan->nama;
											if($racikan!=$x){
												$x = $d->obatRacikan->nama;
											}else{
												$aturan_pakai = '';
												$racikan = '';
												$etiket = '';
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
											<td colspan=10><b>{{ strtoupper($racikan) }}</b></td>
										</tr>
									@endif
									<tr>
										<td>
											
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
											@php
												if($d->hapus==1 AND $d->retur==null){
													echo '<i>'.$d->alasan_hapus.'</i>';
												}elseif($d->retur==1){
													echo 'Jumlah retur <b>'.$d->retur_jumlah.'</b> | <i>'.$d->alasan_hapus.'</i>';
												}elseif($penjualan->status=='proses' AND strtolower(Auth::user()->role()->first()->name)=='apotik'){
													echo '<b>Sedang Diproses</b>';
												}elseif($penjualan->status=='selesai'){
													
												}elseif($penjualan->status=='pending'){
													echo '<b>Menunggu Diproses</b>';
												}
											@endphp
										</td>
										<td>
											@if(session()->get('retur')=='retur' AND $d->retur==null)
												<a href="#" data-id="{{$d->id}}" jumlah="{{$d->jumlah}}" class="btn btn-sm btn-warning btn-flat retur-det-res"><i class="fa fa-refresh"></i> Retur</a>
											@elseif($d->hapus==1)
												<i class="fa fa-close"></i>
											@elseif($reg->posisi_pasien=='antrian apotek' OR $reg->posisi_pasien=='konfirmasi farmasi')
												<a href="#" data-id="{{$d->id}}" class="btn btn-sm btn-danger btn-flat hapus-det-res"><i class="fa fa-trash"></i></a>
											@elseif($penjualan->status=='selesai')
												<i class="fa fa-check"></i>
											@endif
										</td>
										<td>
											@if($d->hapus==null AND ($reg->posisi_pasien=='antrian apotek' OR $reg->posisi_pasien=='konfirmasi farmasi'))
												<a href="#" data-id="{{$d->id}}" class="btn btn-sm btn-info btn-flat edit-det-res"><i class="fa fa-pencil"></i></a>
											@else
												<i class="fa fa-close"></i>
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<th colspan="4" class="text-right">Total Harga</th>
									<th class="text-right">{{ number_format($detail->sum('hargajual')) }}</th>
								</tr>
							</tfoot>
						</table>
					</div>
					
					<div class="col-md-12">
						<center>
							<br>
							@if($reg->posisi_pasien=='antrian apotek')
								@if(count($detail)>0)
									<a href="{{ url('penjualan/konfirmasi-resep/'.$reg->id.'/'.$penjualan->id) }}" class="btn btn-flat btn-success" onclick="return confirm('Yakin akan melakukan konfirmasi?')"><i class="fa fa-check-square"></i> KONFIRMASI RESEP</a>
								@endif
							@elseif($reg->posisi_pasien=='selesai pembayaran')
								<div class="text-orange">
									Apabila sudah selesai, silahkan klik SIMPAN dibawah ini.
								</div>
								<div class="text-orange">
									Stok otomatis akan berkurang sesuai jumlah pengeluaran.
								</div>
								<a href="{{ url('penjualan/savetotal/'.$penjualan->id) }}" class="btn btn-flat btn-success" onclick="return confirm('Yakin sudah selesai?')"><i class="fa fa-save"></i> SIMPAN & SELESAI</a>
							@elseif(session()->get('retur')=='retur' AND $retur_bayar)
								<a href="{{ url('farmasi/cetak/pengembalian-uang/'.$reg->id) }}" class="btn btn-flat btn-success" onclick="return confirm('Yakin sudah selesai?')"><i class="fa fa-print"></i> AJUKAN PENGEMBALIAN UANG</a>
							@endif
						</center>
					</div>
				@endif
			</div>
		</div>
  </div>
	
	@if($penjualan!=null)
  <div class="modal fade" id="showFormResep" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <a href="" class="close">&times;</a>
          <h4 class="modal-title" id="">Form Resep</h4>
        </div>
        <div class="modal-body">
					<div class="row">
						<div class="col-md-12 no-padding">
							<div class="boxs">
								<div class="box-body" style="margin-bottom:0;padding:0 25px;">
									<form id="formAddResep" method="post" class="form-horizontal">
										{{ csrf_field() }} {{ method_field('POST') }}
										{!! Form::hidden('pasien_id', $pasien->id) !!}
										{!! Form::hidden('idreg', $idreg) !!}
										{!! Form::hidden('tipe_rawat', $reg->status_reg) !!}
										@include('tindakan::form_resep_obat')
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
$('#div-jenis-racikan-resep').hide();

function ribuan(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function changeRacikan(val) {
	if(val==1){
		$("#div-jenis-racikan-resep").show();
		$("#div-data-obat-resep").hide();
		$('#addRacikanResep').hide();
		$('#status_racikan_resep').show();
	}else{
		$("#div-jenis-racikan-resep").hide();
		$("#div-data-obat-resep").show();		
		$('#status_racikan_resep').hide();
	}	
	$("#aturan-pakai").show();
}
function changeAlergi(val) {
	if(val==1){
		$("#div-ket-alergi-resep").show();
	}else{
		$("#div-ket-alergi-resep").hide();
	}
}
$(document).ready(function() {
	$(document).on('click', '#historipenjualan', function (e) {
		var id = $(this).attr('data-registrasiID');
		$('#showHistoriPenjualan').modal('show');
		$('#dataHistori').load("/penjualan/"+id+"/history");
	});
	$(document).on('click', '#btn-formresep', function (e) {
		$('#showFormResep').modal('show');
		$('#isUpdateResep').val(0);
	});	
	$('#showFormResep').on('hidden.bs.modal', function () {
	 location.reload();
	})
});
$('#saveItemResep').on('click', function () {
	$(this).hide();
	if($('select[name="resep_racikan"]').val()==1){	
		$("#aturan-pakai").hide();
	}
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		type: 'POST',
		url: '/resep-simpan',
		data: $('#formAddResep').serialize(),
		success: function (data) {
			alert(data.message);
			if(data.sukses) {
				//table3.ajax.reload();
			}
			$('#saveItemResep').show();
		}
	});
});
$('#batalEditRes').on('click', function(){
	$(this).hide();
	$("#penjualan_id").val(0);
	$('#isCreateRes').show();
	$('#isUpdateRes').val(0);
	$('input[name="resep_expired"]').val('');
	$('input[name="resep_jumlah"]').val(1);
	$('select[name="resep_masterobat_id"]').html('');
	$('#showFormResep').modal('hide');
});
$('#saveRacikanResep').on('click', function () {
	$.ajax({
		headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    },
		type: 'POST',
		url: '/resep-add-racikan',
		data: {registrasi_id: $('#registrasi_idx').val(), resep_jenis_racikan: $('select[name="resep_jenis_racikan"]').val(), resep_jumlah_racikan: $('input[name="resep_jumlah_racikan"]').val(), resep_satuan_racikan: $('select[name="resep_satuan_racikan"]').val()},
		success: function (data) {
			if(data.sukses == false) {
				alert(data.message);
			}else if(data.sukses == true) {
				$('input[name="resep_jumlah_racikan"]').prop("readonly",true);
				$('#resep_jenis_racikan').hide();
				$('#resep_satuan_racikan').hide();
				$('#resep_satuan_racikan').next(".select2-container").hide();
				$('#text_resep_jenis_racikan').val($('select[name="resep_jenis_racikan"]').val());
				$('#text_resep_satuan_racikan').val($('select[name="resep_satuan_racikan"]').val());
				$('#text_resep_id_racikan').val(data.id_racikan);
				$('#text_resep_jenis_racikan').show();
				$('#text_resep_satuan_racikan').show();
				$('#addRacikanResep').show();
				$('#saveRacikanResep').hide();
				$("#div-data-obat-resep").show();
			}
		}
	});
});
$('#addRacikanResep').on('click', function () {
	$('input[name="resep_jumlah_racikan"]').prop("readonly",false);
	$('select[name="status_racikan_resep"]').val(0);
	$('#status_racikan_resep').hide();
	$('#text_resep_id_racikan').val("");
	$('#resep_jenis_racikan').show();
	$('#resep_satuan_racikan').show();
	$('#resep_satuan_racikan').next(".select2-container").show();
	$('#text_resep_jenis_racikan').hide();
	$('#text_resep_satuan_racikan').hide();
	$("#div-data-obat-resep").hide();
	$("#addRacikanResep").hide();
	$("#saveRacikanResep").show();
});
$(document).on('click', '.hapus-det-res', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	var alasan = prompt("Jika Anda yakin menghapus data ini, silahkan masukan alasan:");
	if(alasan!=null){
		$.ajax({
			url: '/resep-hapus/'+id+'/0/'+encodeURI(alasan),
			type: 'GET',
			success: function (data) {
				if(data.sukses == true) {
					location.reload();
				}else{
					alert("Item gagal dihapus");
				}
			}
		});
	}else{
		alert("Alasan tidak diisi, data tidak dapat dihapus");
	}
})
$(document).on('click', '.edit-det-res', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	$("#penjualan_id").val(id);
	$('#isUpdateResep').val(1);
	$('#isCreateResep').hide();
	$.ajax({
		url: '/penjualan/edit-penjualan/'+id,
		type: 'GET',
		dataType: 'json',
		success: function (data) {
			if(data.status){
				$('#showFormResep').modal('show');
				$('#batalEditRes').show();
				$('select[name="resep_masterobat_id"]').append('<option value="'+data.data.masterobat_id+'">'+data.data.nama+' | '+data.data.satuan+' | '+data.data.stok+'</option>');
				$('select[name="resep_masterobat_id"]').select2('data', {id:data.data.masterobat_id, text:data.data.nama});
				$('input[name="resep_expired"]').val(data.data.expired);
				$('input[name="resep_jumlah"]').val(data.data.jumlah);
				$('select[name="resep_aturan_pakai"]').val(data.data.aturan_pakai);
				$('select[name="resep_aturan_pakai"]').select2().trigger('change');
				$('input[name="resep_jumlah_aturanpakai"]').val(data.data.jumlah_aturanpakai);
				$('select[name="resep_satuan_aturanpakai"]').val(data.data.satuan_aturanpakai);
				$('select[name="resep_satuan_aturanpakai"]').select2().trigger('change');
				$('select[name="resep_informasi1"]').val(data.data.informasi1);
				$('select[name="is_did"]').val(data.data.is_did);
			}else{
				alert('Data tidak ditemukan')
			}
		}
	});
})
$(document).on('click', '.retur-det-res', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	var jumlah_awal = $(this).attr('jumlah');
	var jumlah_retur = prompt("Masukkan jumlah yang akan di retur:");
	if(jumlah_retur!=null){
		if(jumlah_awal<jumlah_retur){
			alert('Jumlah retur tidak boleh melebihi jumlah awal');
		}else if(jumlah_retur==0){
			alert('Jumlah retur tidak boleh 0');
		}else{
			var alasan = prompt("Apakah yakin item ini akan diretur? Silahkan masukan alasan:");
			if(alasan!=null){
				$.ajax({
					url: '/resep-retur/'+id+'/'+jumlah_retur+'/'+encodeURI(alasan),
					type: 'GET',
					success: function (data) {
						if(data.sukses) {
							alert("Item berhasil diretur");
							location.reload();
						}else{
							alert("Item gagal diretur");
						}
					}
				});
			}
		}
	}
})
function ubahEtiket(id,etiket){
	var new_etiket = prompt('Etiket saat ini: '+etiket+'. Apakah Anda ingin mengubahnya?', etiket);
	if(new_etiket!=null){
		$.ajax({
			url: '/resep-ubah-etiket/resep/'+id+'/'+encodeURI(new_etiket),
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