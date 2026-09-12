<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Rincian Biaya Perawatan</title>
<link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
<style type="text/css">
	h2{
		font-weight: bold;
		text-align: center;
		margin-bottom: -10px;
	}
	body{
		font-size: 8pt;
		margin:0;
	}
	.bg-gradient, .table > thead > tr > th{
		background:rgba(29, 233, 182, 0.8)!important;
		color:white;
	}
	.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
		padding:2px 4px;
	}
	@page {
		margin: 5mm;
	}
</style>
<META HTTP-EQUIV="REFRESH" CONTENT="0; URL={{ url('kasir/cetak') }}">
</head>

<body onload="window.print()">
	@if(count($folio_rj)>0)
	<div style="PAGE-BREAK-BEFORE: always;">
		<table style="width:100%;">
			<tbody>
				<tr>
					<td style="margin-bottom:0;width:10%;"><img src="{{ asset('/laravel/images/'.configrs()->logo) }}" style="width:40px; margin-right: -20px;"></td>
					<td style="margin-bottom:0;">
						<h4 style="margin-bottom:5px;font-size: 135%; font-weight: bold;">{{ configrs()->nama }}</h4>
						<h4 style="margin:0;font-size: 100%;">{{ configrs()->alamat }}</h4>
					</td>
				</tr>
				<tr style="margin:0;">
					<td colspan=2 style="margin:0;"><hr style="margin:15px 0 10px 0;padding:0;"></td>
				</tr>
			</tbody>
		</table>
		
		<table>
			<tbody>
				<div class="page">
					<table style="width:100%">
						<tbody>
							<tr>
								<td colspan="2"><h5 style="text-align:center;font-weight:bold;margin:0;">RINCIAN BIAYA PELAYANAN RAWAT JALAN</h5></td>
							</tr>
							<tr>
								<td style="width:25%">NOMOR RM</td> <td>: {{ $reg->pasien->no_rm }}</td>
							</tr>
							<tr>
								<td style="width:25%">NAMA</td> <td>: {{ strtoupper($reg->pasien->nama) }}</td>
							</tr>
							<tr>
								<td>TGL LAHIR / KELAMIN</td> <td>: {{ date_format(date_create($reg->pasien->tgllahir), 'd-m-Y') }} / {{ ($reg->pasien->kelamin=='P') ? 'PEREMPUAN' : 'LAKI-LAKI' }}</td>
							</tr>
							@if($reg->bayar==1)
							<tr>
								<td>NO. SEP</td><td>: {{ $reg->no_sep }}</td>
							</tr>
							@endif
							<tr>
								<td>KLINIK TUJUAN</td><td>: {{ strtoupper( baca_poli($reg->poli_id)) }}</td>
							</tr>
							<tr>
								<td>DPJP</td> <td>: {{ baca_dokter($reg->dokter_id) }}</td>
							</tr>

						</tbody>
					</table>
					
					<h5 style="text-align:left;font-weight:bold;">PENDAFTARAN</h5>			
					<table class="table table-bordered" >
						<thead>
							<tr class="bg-gradient">
								<th class="text-left">TANGGAL</th>
								<th class="text-left">NAMA</th>
								<th class="text-right">TARIF</th>
							</tr>
						</thead>
						<tbody>
							@php $total_pendaftaran=0; @endphp
							@foreach ($folio_rj as $key => $d)
								@if(in_array($d->kategoritarif,[7,8,9]))
									@php $total_pendaftaran = $total_pendaftaran + $d->total_all; @endphp
									<tr>
										<td class="text-left">{{ date_format(date_create($d->created_at), 'd-m-Y H:i:s') }}</td>
										<td class="text-left">{{ $d->namatarif }}</td>
										<td class="text-right">{{ number_format($d->total_all) }}</td>
									</tr>
								@endif
							@endforeach
							<tr>
								<th class="text-right" colspan="3">{{ number_format($total_pendaftaran) }}</th>
							</tr>
						</tbody>					
					</table>
					
					@php $hidden=true; @endphp
					@foreach ($folio_rj as $key => $dd)
						@if(substr($dd->jenis,0,2)=='OR')
							@php $hidden=false; @endphp
						@endif
					@endforeach
					<div id="peresepan-obat-alkes" class="{{ ($hidden) ? 'hidden' : '' }}">
						<h5 style="text-align:left;font-weight:bold;">PERESEPAN OBAT DAN ALKES</h5>			
						<table class="table table-bordered" >
							<thead>
								<tr class="bg-gradient">
									<th class="text-left">JENIS</th>
									<th class="text-left">NAMA</th>
									<th class="text-center">JUMLAH</th>
									<th class="text-right">HARGA TOTAL</th>
								</tr>
							</thead>
							<tbody>
								@php $total_obat=0; @endphp
								@foreach ($folio_rj as $key => $dd)
									@if(substr($dd->jenis,0,2)=='OR')
										@php 
											$total_obat = $total_obat + $dd->total_all;
											$get_obat_res = App\Penjualandetail::where('hapus',null)->where('no_resep',$dd->namatarif)->get();
										@endphp
										@if(count($get_obat_res)>0)
											@foreach ($get_obat_res as $key => $obat)
												<input type="hidden" name="peresepan-obat-alkes" value="true">
												<tr>
													<td class="text-left">{{ $obat->masterobat->jenis }}</td>
													<td class="text-left">{{ $obat->masterobat->nama }}</td>
													<td class="text-center">{{ $obat->jumlah }}</td>
													<td class="text-right">{{ number_format($obat->hargajual) }}</td>
												</tr>
											@endforeach
										@endif
									@endif
								@endforeach
								<tr>
									<th class="text-right" colspan="4">{{ number_format($total_obat) }}</th>
								</tr>
							</tbody>					
						</table>
					</div>
					
					@php $hidden=true; @endphp
					@foreach ($folio_rj as $key => $dd)
						@if(in_array($dd->jenis,['PEM','EPO']))
							@php $hidden=false; @endphp
						@endif
					@endforeach
					<div id="penggunaan-obat-alkes" class="{{ ($hidden) ? 'hidden' : '' }}">
						<h5 style="text-align:left;font-weight:bold;">PENGGUNAAN OBAT DAN ALKES</h5>			
						<table class="table table-bordered" >
							<thead>
								<tr class="bg-gradient">
									<th class="text-left">JENIS</th>
									<th class="text-left">NAMA</th>
									<th class="text-center">JUMLAH</th>
									<th class="text-right">HARGA TOTAL</th>
								</tr>
							</thead>
							<tbody>
								@php $total_obat=0; @endphp
								@foreach ($folio_rj as $key => $dd)
									@if(in_array($dd->jenis,['PEM','EPO']))
										@php 
											$total_obat = $total_obat + $dd->total_all;
											$get_obat_pem = App\Pemakaiandetail::where('no_resep',$dd->namatarif)->get();
											$get_obat_kpo = App\Permintaanobatdetail::where('retur_by',null)->where('delete_by',null)->where('no_resep',$dd->namatarif)->get();
										@endphp
										@if(count($get_obat_pem)>0)
											@foreach ($get_obat_pem as $key => $obat1)
												<tr>
													<input type="hidden" name="penggunaan-obat-alkes" value="true">
													<td class="text-left">{{ $obat1->masterobat->jenis }}</td>
													<td class="text-left">{{ $obat1->masterobat->nama }}</td>
													<td class="text-center">{{ $obat1->jumlah }}</td>
													<td class="text-right">{{ ($obat1->jumlah*$obat1->hargajual) }}</td>
												</tr>
											@endforeach
										@endif
										@if(count($get_obat_kpo)>0)
											@foreach ($get_obat_kpo as $key => $obat2)
												<tr>
													<input type="hidden" name="penggunaan-obat-alkes" value="true">
													<td class="text-left">{{ $obat2->masterobat->jenis }}</td>
													<td class="text-left">{{ $obat2->masterobat->nama }}</td>
													<td class="text-center">{{ $obat2->jumlah }}</td>
													<td class="text-right">{{ ($obat2->jumlah*$obat2->hargajual) }}</td>
												</tr>
											@endforeach
										@endif
									@endif
								@endforeach
								<tr>
									<th class="text-right" colspan="4">{{ number_format($total_obat) }}</th>
								</tr>
							</tbody>					
						</table>
					</div>
					
					@php $hidden=true; @endphp
					@foreach ($folio_rj as $key => $ddd)
						@if(in_array($ddd->kategoritarif,[1,4,5,6]))
							@php $hidden=false; @endphp
						@endif
					@endforeach
					<div id="tindakan-umum" class="{{ ($hidden) ? 'hidden' : '' }}">
						<h5 style="text-align:left;font-weight:bold;">TINDAKAN UMUM</h5>			
						<table class="table table-bordered" >
							<thead>
								<tr class="bg-gradient">
									<th class="text-left">TANGGAL</th>
									<th class="text-left">NAMA</th>
									<th class="text-center">JUMLAH</th>
									<th class="text-right">TARIF</th>
								</tr>
							</thead>
							<tbody>
								@php $total_tindakan=0; @endphp
								@foreach ($folio_rj as $key => $ddd)
									@if(in_array($ddd->kategoritarif,[1,4,5,6]))
										@php 
											$total_tindakan = $total_tindakan + $ddd->total_all;
										@endphp
										<tr>
											<input type="hidden" name="tindakan-umum" value="true">
											<td class="text-left">{{ date_format(date_create($ddd->created_at), 'd-m-Y H:i:s') }}</td>
											<td class="text-left">{{ $ddd->namatarif }}</td>
											<td class="text-center">{{ $ddd->jumlah }}</td>
											<td class="text-right">{{ number_format($ddd->total_all) }}</td>
										</tr>
									@endif
								@endforeach
								<tr>
									<th class="text-right" colspan="4">{{ number_format($total_tindakan) }}</th>
								</tr>
							</tbody>					
						</table>
					</div>
					
					@php $hidden=true; @endphp
					@foreach ($folio_rj as $key => $dddd)
						@if($dddd->kategoritarif==2 && $dddd->total!=0)
							@php $hidden=false; @endphp
						@endif
					@endforeach
					<div id="laboratorium" class="{{ ($hidden) ? 'hidden' : '' }}">
						<h5 style="text-align:left;font-weight:bold;">LABORATORIUM</h5>
						<table class="table table-bordered" >
							<thead>
								<tr class="bg-gradient">
									<th class="text-left">TANGGAL</th>
									<th class="text-left">NAMA</th>
									<th class="text-center">JUMLAH</th>
									<th class="text-right">TARIF</th>
								</tr>
							</thead>
							<tbody>
								@php $total_tindakan=0; @endphp
								@foreach ($folio_rj as $key => $dddd)
									@if($dddd->kategoritarif==2 && $dddd->total!=0)
										@php 
											$total_tindakan = $total_tindakan + $dddd->total_all;
										@endphp
										<tr>
											<input type="hidden" name="laboratorium" value="true">
											<td class="text-left">{{ date_format(date_create($dddd->created_at), 'd-m-Y H:i:s') }}</td>
											<td class="text-left">{{ $dddd->namatarif }}</td>
											<td class="text-center">{{ $dddd->jumlah }}</td>
											<td class="text-right">{{ number_format($dddd->total_all) }}</td>
										</tr>
									@endif
								@endforeach
								<tr>
									<th class="text-right" colspan="4">{{ number_format($total_tindakan) }}</th>
								</tr>
							</tbody>					
						</table>
					</div>
					
					@php $hidden=true; @endphp
					@foreach ($folio_rj as $key => $dddd)
						@if($dddd->kategoritarif==3)
							@php $hidden=false; @endphp
						@endif
					@endforeach
					<div id="radiologi" class="{{ ($hidden) ? 'hidden' : '' }}">
						<h5 style="text-align:left;font-weight:bold;">RADIOLOGI</h5>
						<table class="table table-bordered" >
							<thead>
								<tr class="bg-gradient">
									<th class="text-left">TANGGAL</th>
									<th class="text-left">NAMA</th>
									<th class="text-center">JUMLAH</th>
									<th class="text-right">TARIF</th>
								</tr>
							</thead>
							<tbody>
								@php $total_tindakan=0; @endphp
								@foreach ($folio_rj as $key => $dddd)
									@if($dddd->kategoritarif==3)
										@php 
											$total_tindakan = $total_tindakan + $dddd->total_all;
										@endphp
										<tr>
											<input type="hidden" name="radiologi" value="true">
											<td class="text-left">{{ date_format(date_create($dddd->created_at), 'd-m-Y H:i:s') }}</td>
											<td class="text-left">{{ $dddd->namatarif }}</td>
											<td class="text-center">{{ $dddd->jumlah }}</td>
											<td class="text-right">{{ number_format($dddd->total_all) }}</td>
										</tr>
									@endif
								@endforeach
								<tr>
									<th class="text-right" colspan="4">{{ number_format($total_tindakan) }}</th>
								</tr>
							</tbody>					
						</table>
					</div>
				</div>
			</tbody>
		</table>
	</div>
	@endif
	
	@if(count($folio_ri)>0)
	<div style="PAGE-BREAK-BEFORE: always;">
		<table style="width:100%;">
			<tbody>
				<tr>
					<td style="margin-bottom:0;width:10%;"><img src="{{ asset('laravel/images/'.configrs()->logo) }}" style="width:40px; margin-right: -20px;"></td>
					<td style="margin-bottom:0;">
						<h4 style="margin-bottom:5px;font-size: 135%; font-weight: bold;">{{ configrs()->nama }}</h4>
						<h4 style="margin:0;font-size: 100%;">{{ configrs()->alamat }}</h4>
					</td>
				</tr>
				<tr style="margin:0;">
					<td colspan=2 style="margin:0;"><hr style="margin:15px 0 10px 0;padding:0;"></td>
				</tr>
			</tbody>
		</table>
		
		<table>
			<tbody>
				<div class="page">
					<table style="width:100%">
						<tbody>
							<tr>
								<td colspan="2"><h5 style="text-align:center;font-weight:bold;margin:0;">RINCIAN BIAYA PELAYANAN RAWAT INAP</h5></td>
							</tr>
							<tr>
								<td style="width:25%">NOMOR RM</td> <td>: {{ $reg->pasien->no_rm }}</td>
							</tr>
							<tr>
								<td style="width:25%">NAMA</td> <td>: {{ strtoupper($reg->pasien->nama) }}</td>
							</tr>
							<tr>
								<td>TGL LAHIR / KELAMIN</td> <td>: {{ date_format(date_create($reg->pasien->tgllahir), 'd-m-Y') }} / {{ ($reg->pasien->kelamin=='P') ? 'PEREMPUAN' : 'LAKI-LAKI' }}</td>
							</tr>
							@if($reg->bayar==1)
							<tr>
								<td>NO. SEP</td><td>: {{ $reg->no_sep }}</td>
							</tr>
							@endif
							<tr>
								<td>DPJP</td> <td>: {{ baca_dokter($reg->dokter_id) }}</td>
							</tr>

						</tbody>
					</table>
					
					<h5 style="text-align:left;font-weight:bold;">PENDAFTARAN</h5>			
					<table class="table table-bordered" >
						<thead>
							<tr class="bg-gradient">
								<th class="text-left">TANGGAL</th>
								<th class="text-left">NAMA</th>
								<th class="text-right">TARIF</th>
							</tr>
						</thead>
						<tbody>
							@php $total_pendaftaran=0; @endphp
							@foreach ($folio_ri as $key => $d)
								@if(in_array($d->kategoritarif,[7,8,9]))
									@php $total_pendaftaran = $total_pendaftaran + $d->total_all; @endphp
									<tr>
										<td class="text-left">{{ date_format(date_create($d->created_at), 'd-m-Y H:i:s') }}</td>
										<td class="text-left">{{ $d->namatarif }}</td>
										<td class="text-right">{{ number_format($d->total_all) }}</td>
									</tr>
								@endif
							@endforeach
							<tr>
								<th class="text-right" colspan="3">{{ number_format($total_pendaftaran) }}</th>
							</tr>
						</tbody>					
					</table>
					
					@if(substr($reg->status_reg,0,1)=='I')
					<h5 style="text-align:left;font-weight:bold;">RUANG INAP</h5>			
					<table class="table table-bordered" >
						<thead>
							<tr class="bg-gradient">
								<th style="text-align:center;">KAMAR</th>
								<th style="text-align:center;">TGL MASUK</th>
								<th style="text-align:center;">TGL KELUAR</th>
								<th style="text-align:center;">DURASI</th>
								<th style="text-align:center;">TARIF</th>
								<th style="text-align:center;">BIAYA</th>
							</tr>
						</thead>
						<tbody>
							@if($ruanginap!=null)
								@php $total_biaya_kamar=0; @endphp
								@foreach($ruanginap as $key => $data)
								<tr>
									<td style="text-align:left;">{{ $data->kamar->nama }}</td>
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
									@endphp
									<td style="text-align:right;">
										{{ number_format($data->tarif) }}
									</td>
									<td style="text-align:right;">{{ number_format($tarif_kamar) }}</td>
								</tr>
								@endforeach
							@endif
							<tr>
								<th style="text-align:right;" colspan="6">{{ number_format($total_biaya_kamar) }}</th>
							</tr>
						</tbody>					
					</table>
					@endif	
					
					@php $hidden=true; @endphp
					@foreach ($folio_ri as $key => $dd)
						@if(substr($dd->jenis,0,2)=='OR')
							@php $hidden=false; @endphp
						@endif
					@endforeach
					<div id="peresepan-obat-alkes" class="{{ ($hidden) ? 'hidden' : '' }}">
						<h5 style="text-align:left;font-weight:bold;">PERESEPAN OBAT DAN ALKES</h5>			
						<table class="table table-bordered" >
							<thead>
								<tr class="bg-gradient">
									<th class="text-left">JENIS</th>
									<th class="text-left">NAMA</th>
									<th class="text-center">JUMLAH</th>
									<th class="text-right">HARGA TOTAL</th>
								</tr>
							</thead>
							<tbody>
								@php $total_obat=0; @endphp
								@foreach ($folio_ri as $key => $dd)
									@if(substr($dd->jenis,0,2)=='OR')
										@php 
											$total_obat = $total_obat + $dd->total_all;
											$get_obat_res = App\Penjualandetail::where('hapus',null)->where('no_resep',$dd->namatarif)->get();
										@endphp
										@if(count($get_obat_res)>0)
											@foreach ($get_obat_res as $key => $obat)
												<input type="hidden" name="peresepan-obat-alkes" value="true">
												<tr>
													<td class="text-left">{{ $obat->masterobat->jenis }}</td>
													<td class="text-left">{{ $obat->masterobat->nama }}</td>
													<td class="text-center">{{ $obat->jumlah }}</td>
													<td class="text-right">{{ number_format($obat->hargajual) }}</td>
												</tr>
											@endforeach
										@endif
									@endif
								@endforeach
								<tr>
									<th class="text-right" colspan="4">{{ number_format($total_obat) }}</th>
								</tr>
							</tbody>					
						</table>
					</div>
					
					@php $hidden=true; @endphp
					@foreach ($folio_ri as $key => $dd)
						@if(in_array($dd->jenis,['PEM','EPO']))
							@php $hidden=false; @endphp
						@endif
					@endforeach
					<div id="penggunaan-obat-alkes" class="{{ ($hidden) ? 'hidden' : '' }}">
						<h5 style="text-align:left;font-weight:bold;">PENGGUNAAN OBAT DAN ALKES</h5>			
						<table class="table table-bordered" >
							<thead>
								<tr class="bg-gradient">
									<th class="text-left">JENIS</th>
									<th class="text-left">NAMA</th>
									<th class="text-center">JUMLAH</th>
									<th class="text-right">HARGA TOTAL</th>
								</tr>
							</thead>
							<tbody>
								@php $total_obat=0; @endphp
								@foreach ($folio_ri as $key => $dd)
									@if(in_array($dd->jenis,['PEM','EPO']))
										@php 
											$total_obat = $total_obat + $dd->total_all;
											$get_obat_pem = App\Pemakaiandetail::where('no_resep',$dd->namatarif)->get();
											$get_obat_kpo = App\Permintaanobatdetail::where('retur_by',null)->where('delete_by',null)->where('no_resep',$dd->namatarif)->get();
										@endphp
										@if(count($get_obat_pem)>0)
											@foreach ($get_obat_pem as $key => $obat1)
												<tr>
													<input type="hidden" name="penggunaan-obat-alkes" value="true">
													<td class="text-left">{{ $obat1->masterobat->jenis }}</td>
													<td class="text-left">{{ $obat1->masterobat->nama }}</td>
													<td class="text-center">{{ $obat1->jumlah }}</td>
													<td class="text-right">{{ ($obat1->jumlah*$obat1->hargajual) }}</td>
												</tr>
											@endforeach
										@endif
										@if(count($get_obat_kpo)>0)
											@foreach ($get_obat_kpo as $key => $obat2)
												<tr>
													<input type="hidden" name="penggunaan-obat-alkes" value="true">
													<td class="text-left">{{ $obat2->masterobat->jenis }}</td>
													<td class="text-left">{{ $obat2->masterobat->nama }}</td>
													<td class="text-center">{{ $obat2->jumlah }}</td>
													<td class="text-right">{{ ($obat2->jumlah*$obat2->hargajual) }}</td>
												</tr>
											@endforeach
										@endif
									@endif
								@endforeach
								<tr>
									<th class="text-right" colspan="4">{{ number_format($total_obat) }}</th>
								</tr>
							</tbody>					
						</table>
					</div>
					
					@php $hidden=true; @endphp
					@foreach ($folio_ri as $key => $ddd)
						@if(in_array($ddd->kategoritarif,[1,4,5,6]))
							@php $hidden=false; @endphp
						@endif
					@endforeach
					<div id="tindakan-umum" class="{{ ($hidden) ? 'hidden' : '' }}">
						<h5 style="text-align:left;font-weight:bold;">TINDAKAN UMUM</h5>			
						<table class="table table-bordered" >
							<thead>
								<tr class="bg-gradient">
									<th class="text-left">TANGGAL</th>
									<th class="text-left">NAMA</th>
									<th class="text-center">JUMLAH</th>
									<th class="text-right">TARIF</th>
								</tr>
							</thead>
							<tbody>
								@php $total_tindakan=0; @endphp
								@foreach ($folio_ri as $key => $ddd)
									@if(in_array($ddd->kategoritarif,[1,4,5,6]))
										@php 
											$total_tindakan = $total_tindakan + $ddd->total_all;
										@endphp
										<tr>
											<input type="hidden" name="tindakan-umum" value="true">
											<td class="text-left">{{ date_format(date_create($ddd->created_at), 'd-m-Y H:i:s') }}</td>
											<td class="text-left">{{ $ddd->namatarif }}</td>
											<td class="text-center">{{ $ddd->jumlah }}</td>
											<td class="text-right">{{ number_format($ddd->total_all) }}</td>
										</tr>
									@endif
								@endforeach
								<tr>
									<th class="text-right" colspan="4">{{ number_format($total_tindakan) }}</th>
								</tr>
							</tbody>					
						</table>
					</div>
					
					@php $hidden=true; @endphp
					@foreach ($folio_ri as $key => $dddd)
						@if($dddd->kategoritarif==2 && $dddd->total!=0)
							@php $hidden=false; @endphp
						@endif
					@endforeach
					<div id="laboratorium" class="{{ ($hidden) ? 'hidden' : '' }}">
						<h5 style="text-align:left;font-weight:bold;">LABORATORIUM</h5>
						<table class="table table-bordered" >
							<thead>
								<tr class="bg-gradient">
									<th class="text-left">TANGGAL</th>
									<th class="text-left">NAMA</th>
									<th class="text-center">JUMLAH</th>
									<th class="text-right">TARIF</th>
								</tr>
							</thead>
							<tbody>
								@php $total_tindakan=0; @endphp
								@foreach ($folio_ri as $key => $dddd)
									@if($dddd->kategoritarif==2 && $dddd->total!=0)
										@php 
											$total_tindakan = $total_tindakan + $dddd->total_all;
										@endphp
										<tr>
											<input type="hidden" name="laboratorium" value="true">
											<td class="text-left">{{ date_format(date_create($dddd->created_at), 'd-m-Y H:i:s') }}</td>
											<td class="text-left">{{ $dddd->namatarif }}</td>
											<td class="text-center">{{ $dddd->jumlah }}</td>
											<td class="text-right">{{ number_format($dddd->total_all) }}</td>
										</tr>
									@endif
								@endforeach
								<tr>
									<th class="text-right" colspan="4">{{ number_format($total_tindakan) }}</th>
								</tr>
							</tbody>					
						</table>
					</div>
					
					@php $hidden=true; @endphp
					@foreach ($folio_ri as $key => $dddd)
						@if($dddd->kategoritarif==3)
							@php $hidden=false; @endphp
						@endif
					@endforeach
					<div id="radiologi" class="{{ ($hidden) ? 'hidden' : '' }}">
						<h5 style="text-align:left;font-weight:bold;">RADIOLOGI</h5>
						<table class="table table-bordered" >
							<thead>
								<tr class="bg-gradient">
									<th class="text-left">TANGGAL</th>
									<th class="text-left">NAMA</th>
									<th class="text-center">JUMLAH</th>
									<th class="text-right">TARIF</th>
								</tr>
							</thead>
							<tbody>
								@php $total_tindakan=0; @endphp
								@foreach ($folio_ri as $key => $dddd)
									@if($dddd->kategoritarif==3)
										@php 
											$total_tindakan = $total_tindakan + $dddd->total_all;
										@endphp
										<tr>
											<input type="hidden" name="radiologi" value="true">
											<td class="text-left">{{ date_format(date_create($dddd->created_at), 'd-m-Y H:i:s') }}</td>
											<td class="text-left">{{ $dddd->namatarif }}</td>
											<td class="text-center">{{ $dddd->jumlah }}</td>
											<td class="text-right">{{ number_format($dddd->total_all) }}</td>
										</tr>
									@endif
								@endforeach
								<tr>
									<th class="text-right" colspan="4">{{ number_format($total_tindakan) }}</th>
								</tr>
							</tbody>					
						</table>
					</div>
				</div>
			</tbody>
		</table>
	</div>
	@endif
	<table class="table table-bordered" style="width: 50%;">
		<tr>
			<td>Total Tagihan</td>
			<td class="text-right">Rp. {{number_format($kuitansi->total)}}</td>
		</tr>
		<tr>
			<td>Titipan</td>
			<td class="text-right">Rp. {{number_format($total_titipan)}}</td>
		</tr>
		<tr>
			<td>Diskon</td>
			<td class="text-right">Rp. {{number_format(($kuitansi->total*$kuitansi->diskon_persen/100) + $kuitansi->diskon_rupiah + ($kuitansi->total*$kuitansi->diskon_asuransi/100))}}</td>
		</tr>
		@if($kuitansi->iur!='')
		<tr>
			<td>Uang IUR</td>
			<td class="text-right">Rp. {{number_format($kuitansi->iur)}}</td>
		</tr>
		@endif
		<tr>
		@if($kuitansi->total > $total_titipan)
			<td>Yang Harus Dibayar</td>
			<td class="text-right">Rp. {{number_format($kuitansi->total-$total_titipan-(($kuitansi->total*$kuitansi->diskon_persen/100) + $kuitansi->diskon_rupiah + ($kuitansi->total*$kuitansi->diskon_asuransi/100)))}}</td>
		@else
		<td>Yang Dikembalikan</td>
			<td class="text-right">Rp. {{number_format($total_titipan-$kuitansi->total+(($kuitansi->total*$kuitansi->diskon_persen/100) + $kuitansi->diskon_rupiah + ($kuitansi->total*$kuitansi->diskon_asuransi/100)))}}</td>
		@endif
		</tr>
	</table>

	<table style="width: 100%;">
		<tr>
			<td style="width: 60%;"></td>
			<td style="width: 40%;" class="text-center">
				{{ configrs()->kota }}, {{ date('d-m-Y') }}
				<br><br><br>
				<u>{{ Auth::user()->name }}</u><br>
				<small style="font-size: 8pt;">Petugas Kasir</small>
			</td>
		</tr>
	</table>
</body>
</html>