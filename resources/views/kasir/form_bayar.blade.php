@extends('master')

@php
	$tarif_kamar = 0;
@endphp
@section('content')
	<div class="col-md-2 no-padding" style="padding-right:10px!important;">
		@if($reg->posisi_pasien=='konfirmasi farmasi')
			<h3 style="margin-top:0;">
				@php
					$antrian = App\AntrianApotek::where('registrasi_id',$reg->id)->first();
				@endphp
				<a href="#" id="click-panggil" data-idreg="{{ $reg->id }}" class="btn btn-success btn-block btn-sm btn-flat"><i class="fa fa-microphone"></i> Panggil Pasien {{ ($antrian!=null) ? $antrian->kelompok.$antrian->nomor : '' }}</a>
			</h3>
		@endif
		<div class="box-group" id="accordion">
			<div class="panel box box-success no-margin" style="background:transparent!important;box-shadow:none;">
				<div class="box-header with-border" style="background:white!important;">
					<h4 class="box-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
							Kasir
							@if($status_reg=='I')
								Rawat Inap
							@elseif($status_reg=='J')
								Rawat Jalan
							@elseif($status_reg=='G')
								Rawat Darurat
							@elseif($status_reg=='A')
								Penjualan Bebas
							@endif
						</a>
					</h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse in" style="background:transparent!important;">
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
										<td>Kondisi</td><td class="text-right"><b>{{ ($reg->kondisi_akhir_pasien!=null) ? $reg->kondisi->namakondisi : '' }}</td>
									</tr>
									@if(substr($reg->status_reg,0,1)=='I')
									<tr>
										<td>Naik Kelas</td><td class="text-right"><b>{{ ($reg->is_naik_kelas) ? 'Ya' : 'Tidak' }}</td>
									</tr>
									@endif
									<tr>
										<td>Surat Kontrol</td><td class="text-right"><b>{{ $reg->no_surat_kontrol }}</td>
									</tr>
									<tr>
										<td>Status</td><td class="text-right"><b>{{ ucwords($reg->posisi_pasien) }}</td>
									</tr>
								</table>
							</div>
						</div>
					</div>				
					@if($reg->posisi_pasien=='konfirmasi farmasi')
					<div class="row">
						<div class="col-md-12" style="margin-bottom:10px;">
							<button class="btn btn-warning btn-block btn-flat">Rp. <span id="header_total_tagihan">{{ number_format(total_tagihan($reg->id)) }}</span></button>
						</div>
					</div>
					@endif
				</div>
				
				@if($reg->bayar==1)
					<div class="box-header with-border" style="background:white!important;">
						<h4 class="box-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
								Data Bridging E-Klaim
							</a>
						</h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse" style="background:transparent!important;">
						<div class="box box-widget widget-user" style="margin-bottom:10px;">
							<div class="widget-user-header bg-aqua-active" style="height:auto;">
								<div class="row">
									<table class="table-condensed" style="width:100%;color:white;">
										<tr>
											<td style="width:35%;">No. Kartu</td><td class="text-right"><b>{{ (!empty($eklaim->no_kartu)) ? $eklaim->no_kartu : '' }}</td>
										</tr>
										<tr>
											<td>No. SEP</td><td class="text-right"><b>{{ (!empty($eklaim->no_sep)) ? $eklaim->no_sep : '' }}</td>
										</tr>
										<tr>
											<td>Kode Grouper</td><td class="text-right"><b>{{ (!empty($eklaim->kode)) ? $eklaim->kode : '' }}</td>
										</tr>
										<tr>
											<td>Dijamin</td><td class="text-right"><b>{{ (!empty($eklaim->dijamin)) ? 'Rp. '.number_format($eklaim->dijamin) : '' }}</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
	<div class="col-md-10 no-padding" id="div-right" style="overflow-y:auto;overflow-x:hidden;">
		<div class="box box-primary">
			<div class="box-body">
				<div class="row">
					<div class="col-md-12 no-padding">
						@php $total_uangmuka=0; @endphp
						@if(count($uang_muka)>0)
						<div class="col-md-12">
							<h4 class="text-green" style="margin-top:0px;font-size:14px;font-weight:600;">#Uang Titipan</h4>
							<div class='table-responsive'>
								<table class='table table-striped table-bordered table-hover table-condensed'>
									<thead>
										<tr>
											<th style="text-align:center;">Tanggal</th>
											<th style="text-align:center;">Nama Penitip</th>
											<th style="text-align:center;">Nomor HP</th>
											<th style="text-align:center;">Total</th>
											<th style="text-align:center;">Catatan</th>
										</tr>
									</thead>
									<tbody>
										@foreach($uang_muka as $key => $data)
										<tr>
											<td style="text-align:center;">{{ date_format(date_create($data->created_at), 'd-m-Y H:i:s') }}</td>
											<td style="text-align:left;">{{ $data->nama }}</td>
											<td style="text-align:left;">{{ $data->no_hp }}</td>
											<td style="text-align:right;">{{ 'Rp. '.number_format($data->total) }}</td>
											<td style="text-align:left;">{{ $data->keterangan }}</td>
										</tr>
										@php $total_uangmuka = $total_uangmuka + $data->total; @endphp
										@endforeach
										<tr>
											<th colspan="3" style="text-align:center;">Total Titipan</th>
											<th style="text-align:right;">{{ 'Rp. '.number_format($total_uangmuka) }}</th>
											<th style="text-align:center;"></th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						@endif
							
						@if($status_reg=='I')
							<!-- Tagihan -->
							<div class="col-md-12">
								<h4 class="text-green" style="margin-top:0px;font-size:14px;font-weight:600;">#Riwayat Kamar</h4>
								<div class='table-responsive'>
									<table class='table table-striped table-bordered table-hover table-condensed'>
										<thead>
											<tr>
												<th style="text-align:center;">Kelas</th>
												<th style="text-align:center;">Kamar</th>
												<th style="text-align:center;">Bed</th>
												<th style="text-align:center;">Tgl Masuk</th>
												<th style="text-align:center;">Tgl Keluar</th>
												<th style="text-align:center;">Tarif</th>
												<th style="text-align:center;">Durasi</th>
												<th style="text-align:center;">Total</th>
											</tr>
										</thead>
										<tbody>
											@if($hist_kamar!=null)
												@php $total_biaya_kamar=0; @endphp
												@foreach($hist_kamar as $key => $data)
												<tr>
													<td style="text-align:center;">{{ $data->kelas->nama }}</td>
													<td style="text-align:left;">{{ $data->kamar->nama }}</td>
													<td style="text-align:left;">{{ $data->bed->nama }}</td>
													<td style="text-align:center;">{{ date_format(date_create($data->tgl_masuk), 'd-m-Y H:i:s') }}</td>
													<td style="text-align:center;">{{ date_format(date_create($data->tgl_keluar), 'd-m-Y H:i:s') }}</td>
													@php
														$date1=strtotime($data->tgl_masuk);
														if($data->tgl_keluar==""){
															$date2=time();
														}else{
															$date2=strtotime($data->tgl_keluar);
														}
														$diff	= $date2-$date1;
														$hari	= floor($diff / (60 * 60 * 24));
														$jam	= floor($diff / (60 * 60)) - ($hari * 24);
														$menit= floor($diff / (60)) - (((($hari * 24) + $jam) * 60));
													@endphp
													<td style="text-align:right;">
														{{ 'Rp. '.number_format($data->tarif) }}
													</td>
													<td style="text-align:left;">
														{{ $hari.' hari '.$jam.' jam '.$menit.' menit' }}
													</td>
													@php
														$tarif_kamar = $data->tarif;
														if($hari == 0 AND $data->tarif!=0){
															$tarif_kamar = $data->tarif;
														}elseif($hari >= 1 AND $data->tarif!=0){
															$tarif_kamar = $data->tarif * ($hari+1);
															if($jam < 2 AND $menit <= 59){
																$tarif_kamar = $tarif_kamar - $data->tarif;
															}
														}
														$total_biaya_kamar += $tarif_kamar;
														$total_tagihan = 'Rp. '.number_format($tagihan + $tarif_kamar);
													@endphp
													<td style="text-align:right;">{{ 'Rp. '.number_format($tarif_kamar) }}</td>
												</tr>
												@endforeach
											@endif
											<tr>
												<th colspan="7" style="text-align:center;">Total Biaya Kamar</th>
												<th style="text-align:right;">{{ 'Rp. '.number_format($total_biaya_kamar) }}</th>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						@endif
						
						<div class="col-md-12">
							<h4 class="text-green" style="margin-top:0px;font-size:14px;font-weight:600;">
								#Data Biaya
							</h4>
							<div class="col-md-12 no-padding">
								<table class="table table-bordered" style="width:100%;">
									<thead>
										@php
											$pendaftaran = 0;
											$obatalkes = 0;
											$tindakanmedis = 0;
											$penunjangmedis = 0;
											$biaya_pendaftaran = DB::table('biayaregistrasis')->get();
										@endphp
										@foreach ($fol as $d)
											@php
												$isdftr = false;
												if($biaya_pendaftaran!=null){
													foreach($biaya_pendaftaran as $keytrf => $trf){
														if($trf->tarif_id==$d->tarif_id){
															$isdftr = true;
														}
													}
												}
												if($isdftr){
													$pendaftaran += $d->total;
												}elseif(substr($d->jenis,0,2)=='OR' OR substr($d->jenis,0,3)=='EPO' OR substr($d->jenis,0,3)=='PEM'){
													$obatalkes += $d->total;
												}elseif($d->poli_tipe=='L' OR $d->poli_tipe=='R' OR $d->poli_tipe=='F'){
													$penunjangmedis += $d->total;
												}else{
													$tindakanmedis += $d->total;
												}
											@endphp
										@endforeach
										<tr>
											<th class="text-center">PENDAFTARAN</th>
											<th class="text-center">OBAT & ALKES</th>
											<th class="text-center">TINDAKAN MEDIS</th>
											<th class="text-center">PENJUNANG MEDIS</th>
										</tr>
										<tr>
											<th class="text-center">{{ number_format($pendaftaran) }}</th>
											<th class="text-center">{{ number_format($obatalkes) }}</th>
											<th class="text-center">{{ number_format($tindakanmedis) }}</th>
											<th class="text-center">{{ number_format($penunjangmedis) }}</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
						
						@php $is_iur=false; @endphp
						@if($reg->posisi_pasien=='konfirmasi farmasi')
							<div class="col-md-12">
								<h4 class="text-green" style="margin-top:0px;font-size:14px;font-weight:600;">#Pembayaran</h4>
								{!! Form::open(['method' => 'POST', 'url' => 'kasir/save-bayar', 'class' => 'form-horizontal']) !!}
								<div class='table-responsive'>
									<table class='table table-striped table-bordered table-hover table-condensed'>
										{!! Form::hidden('registrasi_id', $reg->id) !!}
										{!! Form::hidden('status_reg', $status_reg) !!}
										<input type="hidden" name="total_uangmuka" id="total_uangmuka" value="{{ $total_uangmuka }}">
										<input type="hidden" name="total" id="total" value="{{ total_tagihan($reg->id) }}">
										<tfoot>
											<tr>
												<th colspan="4" class="text-right">Total Tagihan</th>
												<th style="width: 25%"> {!! Form::text('total_tagihan', number_format(total_tagihan($reg->id)), ['readonly'=>true, 'class' => 'form-control input-sm uang']) !!}</th>
											</tr>
											@if($reg->bayar==3)
												<tr>
													<th colspan="4" class="text-right">
														@php
															$asuransi = Modules\Asuransi\Entities\Asuransi::find($reg->asuransi_id);
															$nama_asuransi = "";
															$diskon_asuransi = 0;
															$total_diskon_asuransi = 0;
															if($asuransi!=null){
																$diskon_asuransi = $asuransi->diskon;
																$nama_asuransi = $asuransi->nama.' ('.$asuransi->diskon.'%)';
																$total_diskon_asuransi = ($asuransi->diskon/100);
															}
														@endphp
														Ditanggung <span class="text-green">{{ $nama_asuransi }}</span>
														<input type="hidden" value="{{$diskon_asuransi}}" name="diskon_asuransi">
													</th>
													<th style="width: 25%"> {!! Form::text('jaminan_asuransi', number_format(total_tagihan($reg->id)*$total_diskon_asuransi), ['class' => 'form-control input-sm uang']) !!}</th>
												</tr>
											@endif
											
											@php $jml_iur = 0; @endphp												
											@if(($reg->bayar==1 AND $reg->is_naik_kelas==1) OR $reg->bayar==3)
												@php
													$is_iur=true;
													if($reg->bayar==1){
														if(!empty($eklaim->dijamin)){
															$jml_iur = $eklaim->dijamin;
														}
													}else{
														$jml_iur = total_tagihan($reg->id) - (total_tagihan($reg->id)*$total_diskon_asuransi);
													}
												@endphp
												<tr>
													<th colspan="4" class="text-right">IUR Bayar</th>
													<th style="width: 25%"> {!! Form::text('iur', number_format($jml_iur), ['class' => 'form-control input-sm uang', 'onkeyup'=>'totalHarusBayar()']) !!}</th>
												</tr>
											@endif
											
											@if(count($uang_muka)>0)
												<tr>
													<th colspan="4" class="text-right">Total Uang Titipan</th>
													<th style="width: 25%"> {!! Form::text('total_uangmuka', number_format($total_uangmuka), ['readonly'=>true, 'class' => 'form-control input-sm uang']) !!}</th>
												</tr>
												@php $x_kembali = 0; $x_kurang = 0; @endphp
												@if($is_iur)
													@if($jml_iur<$total_uangmuka)
														@php $x_kembali = number_format($total_uangmuka-$jml_iur); @endphp
													@else
														@php $x_kurang = number_format($jml_iur-$total_uangmuka); @endphp
													@endif
												@else
													@if($reg->bayar==1 && !$is_iur && $total_uangmuka>0)
														@php $x_kembali = number_format($total_uangmuka); $x_kurang = 0; @endphp
													@elseif(total_tagihan($reg->id)<$total_uangmuka)
														@php $x_kembali = number_format($total_uangmuka-total_tagihan($reg->id)); @endphp
													@else
														@php $x_kurang = number_format(total_tagihan($reg->id)-$total_uangmuka); @endphp
													@endif
												@endif
												
												<tr>
													<th colspan="4" class="text-right text-red">Harus Dikembalikan</th>
													<th style="width: 25%">
													@if ( total_tagihan($reg->id) < $total_uangmuka )
														{!! Form::text('total_dikembalikan', $x_kembali, ['readonly'=>true, 'id'=>'total_dikembalikan', 'class' => 'form-control input-sm uang']) !!}
													@else
														{!! Form::text('total_dikembalikan', '0', ['readonly'=>true, 'id'=>'total_dikembalikan', 'class' => 'form-control input-sm uang']) !!}
													@endif
													</th>
												</tr>
												<tr>
													<th colspan="4" class="text-right text-red">Kekurangan</th>
													<th style="width: 25%"> 
													@if ( total_tagihan($reg->id) < $total_uangmuka )
														{!! Form::text('total_kekurangan', '0', ['readonly'=>true, 'id'=>'total_kekurangan', 'class' => 'form-control input-sm uang']) !!}
													@else
													{!! Form::text('total_kekurangan', number_format(total_tagihan($reg->id)-$total_uangmuka), ['readonly'=>true, 'id'=>'total_kekurangan', 'class' => 'form-control input-sm uang']) !!}
													@endif
													</th>
												</tr>
											@endif
											
											@if($reg->bayar==2)
												<tr>
													<th colspan="4" class="text-right">Diskon (%)</th>
													<th style="width: 25%"> {!! Form::text('diskon_persen', 0, ['class' => 'form-control input-sm uang', 'onkeyup'=>'totalHarusBayar()']) !!}</th>
												</tr>
												<tr>
													<th colspan="4" class="text-right">Diskon (Rp)</th>
													<th style="width: 25%"> {!! Form::text('diskon_rupiah', 0, ['class' => 'form-control input-sm uang', 'onkeyup'=>'totalHarusBayar()']) !!}</th>
												</tr>
												<tr>
													<th colspan="4" class="text-right">Total Bayar</th>
													<th style="width: 25%">
														@if(total_tagihan($reg->id)<$total_uangmuka)
															{!! Form::text('totalBayar', 0, ['class' => 'form-control input-sm uang']) !!}
														@else
															{!! Form::text('totalBayar', number_format(total_tagihan($reg->id)-$total_uangmuka), ['class' => 'form-control input-sm uang']) !!}
														@endif
													</th>
												</tr>
											@endif		
											
											@if(($reg->bayar==1 AND $reg->is_naik_kelas==1) OR $reg->bayar==2 OR $reg->bayar==3)
											<tr>
												<th colspan="4" class="text-right">Metode Bayar</th>
												<th style="width: 25%">
													<select class="form-control" name="metode_bayar">
														<option value="tunai">Tunai</option>
														<!--option value="edc">EDC</option>
														<option value="transfer">Transfer</option-->
													</select>
												</th>
											</tr>
											<tr>
												<th colspan="4" class="text-right">Keterangan</th>
												<th style="width: 25%">
												 {!! Form::text('keterangan', '', ['class' => 'form-control', 'placeholder'=>'']) !!}
												</th>
											</tr>
											@endif
											
											@php
												if ($reg->bayar == '2') {
													$def = 'tunai';
												}else {
													$def = 'piutang';
												}
											@endphp
											<input type="hidden" name="jenis" value="{{ $def }}">
										</tfoot>
									</table>
								</div>
								<div class="btn-group pull-right">
									@if($reg->bayar == 1)
										{!! Form::submit("TUTUP TRANSAKSI", ['class' => 'btn btn-flat btn-success', 'onclick'=>'javascript:return confirm("Yakin data sudah benar? Cek Sekali Lagi!")']) !!}
									@else
										{!! Form::submit("BAYAR", ['class' => 'btn btn-flat btn-success', 'onclick'=>'javascript:return confirm("Yakin data sudah benar? Cek Sekali Lagi!")']) !!}
									@endif
								</div>
								{!! Form::close() !!}
								<div class="pull-left">
									<a href="{{ URL::previous() }}" class="btn btn-flat btn-info"><i class="fa fa-step-backward"></i> Halaman Sebelumnya</a>
								</div>
							</div>
						@endif
						
						@if($reg->posisi_pasien=='pengembalian uang retur')
							<div class="col-md-12 text-center">
								<a href="{{ url('kasir/cetak/cetakkuitansi/'.$pembayaran->id) }}" class="btn btn-flat btn-info"><i class="fa fa-print"></i> Cetak Kwitansi Baru</a>
							</div>
						@endif
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
$('.uang').maskNumber({
	thousands: '.',
	integer: true,
});

function ribuan(x){
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function totalHarusBayar(){
	var total 				= $('input[name="total"]').val();
	var total_uangmuka= $('input[name="total_uangmuka"]').val();
	var is_iur 				= "{{$is_iur}}";
	var iur 					= 0;
	if($('input[name="iur"]').val()!=undefined){
		iur 					= parseInt($('input[name="iur"]').val().split('.').join(""));
	}
	var diskon_persen = 0;
	if($('input[name="diskon_persen"]').val()!=undefined){
		diskon_persen = parseInt($('input[name="diskon_persen"]').val().split('.').join(""));
	}
	var diskon_rupiah = 0;
	if($('input[name="diskon_rupiah"]').val()!=undefined){
		diskon_rupiah = parseInt($('input[name="diskon_rupiah"]').val().split('.').join(""));
	}
	if(Number.isNaN(iur)){
		iur = 0;
	}
	if(Number.isNaN(diskon_persen)){
		diskon_persen = 0;
	}
	if(Number.isNaN(diskon_rupiah)){
		diskon_rupiah = 0;
	}
	if(diskon_persen>100){
		alert('Maksimal diskon 100%');
		$('input[name="diskon_persen"]').val("");
	}else{
		var totalBayar = total - (total*diskon_persen/100) - diskon_rupiah;
		$('#header_total_tagihan').html(ribuan(parseInt(totalBayar)));
		if(is_iur){
			if(iur<total_uangmuka){
				$('#total_dikembalikan').val(ribuan(total_uangmuka-iur));
				$('#total_kekurangan').val(0);
			}else{
				$('#total_dikembalikan').val(0);
				$('#total_kekurangan').val(ribuan(iur-total_uangmuka));
			}
		}else{
			if(total<total_uangmuka){
				$('#total_dikembalikan').val(ribuan(total_uangmuka-parseInt(totalBayar)));
				$('#total_kekurangan').val(0);
				$('input[name="totalBayar"]').val(0);
			}else{
				if(parseInt(totalBayar)<total_uangmuka){
					alert();
					$('#total_dikembalikan').val(ribuan(total_uangmuka-parseInt(totalBayar)));
					$('#total_kekurangan').val(0);
					$('input[name="totalBayar"]').val(0);
				}else{
					$('#total_dikembalikan').val(0);
					$('#total_kekurangan').val(ribuan(parseInt(totalBayar)-total_uangmuka));
					$('input[name="totalBayar"]').val(ribuan(parseInt(totalBayar-total_uangmuka)));
				}
			}
		}
	}
}
</script>
@endsection
