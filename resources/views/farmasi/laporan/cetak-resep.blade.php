<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Resep</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
    <style media="print">
      body{
        width: auto;
				margin:0;
      }
			.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
				padding:1px!important;
			}
    </style>
  </head>
	<script>
		setTimeout(function(){
				window.close();
		}, 500);
	</script>
  <body onload="print()">
		<table style="width:100%;margin-bottom:0;" class="no-margin">
			<tr>
				<td style="width:10%;"></td>
				<td>
					<img src="{{ asset('laravel/images/'.configrs()->logo) }}" class="pull-right" style="padding-right:10px;height:40px;">
				</td>
				<td style="text-align:left;">
					<h4 style="font-size: 16px; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>
					<p>{{ configrs()->alamat }}</p>
				</td>
			</tr>
		</table>
		
		<br>
		<table style="width:100%;text-align:left;margin-bottom:0;" class="table table-bordered table-condensed">
			<tbody>
				<tr>
					<th style="width:18%;font-size:12px;">Tanggal</th> 
					<td style="width:32%;font-size:12px;">: {{ date('d-m-Y H:i:s') }}</td>
					<th style="width:18%;font-size:12px;">Pelayanan</th> 
					<td style="width:32%;font-size:12px;">: {{ (isset($reg->poli->nama)) ? $reg->poli->nama : '' }}</td>
				</tr>
				<tr>
					<th style="font-size:12px;">Nama </th> 
					<td style="font-size:12px;">: {{ $reg->pasien->nama }}</td>
					<th style="font-size:12px;">Nama Dokter </th> 
					<td style="font-size:12px;">: {{ baca_dokter($reg->dokter_id) }}</td>
				</tr>
				<tr>
					<th style="font-size:12px;">No. RM</th> 
					<td style="font-size:12px;">: {{ $reg->pasien->no_rm }}</td>
					<th style="font-size:12px;">SIP</th> 
					<td style="font-size:12px;">: {{ (isset($reg->pegawai->sip)) ? $reg->pegawai->sip : '' }}</td>
				</tr>
				<tr>
					<th style="font-size:12px;">Tgl Lahir</th> 
					<td style="font-size:12px;">: {{ tgl_indo($reg->pasien->tgllahir) }}</td>
					<th style="font-size:12px;">-</th> 
					<td style="font-size:12px;">: -</td>
					<!--th style="font-size:12px;">Diagnosa</th> 
					<td style="font-size:12px;">: {{ $reg->diagnosa_akhir }}</td-->
				</tr>
				<tr>
					<th rowspan="2" style="font-size:12px;">Alamat</th> 
					<td rowspan="2" style="font-size:12px;">{{ $reg->pasien->alamat }}</td>
					<th style="font-size:12px;">Berat Badan</th> 
					<td style="font-size:12px;">: {{ $reg->berat_badan }} Kg</td>
				</tr>
				<tr>
					<th style="font-size:12px;">Tekanan Darah</th> 
					<td style="font-size:12px;">: {{ $reg->tekanan_darah }} mmHg</td>
				</tr>
				<tr>
					<th style="font-size:12px;">Telp/Hp</th> 
					<td style="font-size:12px;">: {{ $reg->pasien->nohp }}</td>
					<th style="font-size:12px;">Alergi</th> 
					<td style="font-size:12px;">: {{ $penjualan->keterangan_alergi }}</td>
				</tr>
			</tbody>
		</table>
		
		<center><h4 style="margin:10px 0;">RESEP OBAT</h4></center>
		
		<table style="width:100%;" class="table no-border">
			<tbody>
				@foreach ($detail_nonracik as $key => $d)
					<tr>
						<td style="width:5%;font-size:12px;">R/</td>
						<td style="width:50%;font-size:12px;">{{ $d->masterobat->nama }}</td>
						<td style="text-align:center;width:40%;font-size:12px;">No. {{ $d->jumlah }}</td>
						<td style="width:5%;font-size:12px;"></td>
					</tr>
					<tr>
						<td style="font-size:12px;"></td>
						<td colspan="2" style="font-size:12px;">{{ $d->aturan_pakai.' '.$d->jumlah_aturanpakai.' '.$d->satuan_aturanpakai }}</td>
						<td style="">{{($d->is_did) ? '(DID)' : ''}}</td>
					</tr>
					<tr>
						<td style=""></td>
						<td colspan="2"><center>------------------------------------------------------------------------------------------------</td>
						<td style=""></td>
					</tr>
				@endforeach		
				
				@foreach ($detail_racikan as $key => $d)
					@php
						$detailx 	= App\Penjualandetail::where('penjualan_id', $d->penj_id)
												->where('obat_racikan_id',$d->racikan_id)
												->where('hapus',null)
												->get();
					@endphp					
					@if($detailx!=null)
						@foreach ($detailx as $sdf => $dt)
							<tr>
								<td style="width:5%;"></td>
								<td style="width:50%;font-size:12px;">{{ ($key==0) ? 'R/' : '' }} {{ $dt->masterobat->nama }}</td>
								<td style="text-align:center;width:40%;font-size:12px;">No. {{ $dt->jumlah }}</td>
								<td style="width:5%;"></td>
							</tr>
						@endforeach
						<tr>
							<td style=""></td>
							<td style="width:35%;font-size:12px;">mf {{ strtoupper($d->jenis) }}</td>
							<td style="text-align:center;width:35%;font-size:12px;">{{ $d->jumlah_racikan }}</td>
							<td style=""></td>
						</tr>
						<tr>
							<td style=""></td>
							<td colspan="2" style="font-size:12px;">{{ $d->aturan_pakai.' '.$d->jumlah_aturanpakai.' '.$d->satuan_aturanpakai }}</td>
							<td style="">{{($d->is_did) ? '(DID)' : ''}}</td>
						</tr>
						<tr>
							<td style=""></td>
							<td colspan="2"><center>------------------------------------------------------------------------------------------------</td>
							<td style=""></td>
						</tr>	
					@endif
				@endforeach
			</tbody>
		</table>
		
		<div class="col-md-12 no-padding">
			<table style="width:100%;text-align:center;" class="table table-bordered">
				<tr>
					<td class="text-center" style="font-size:12px;width:33.333333%;">
						Penyerah Obat
						<br>
						<br>
						<br>
						<br>____________________
					</td>
					<td class="text-center" style="font-size:12px;width:33.333333%;">
						Penerima Obat dan Edukasi
						<br>
						<br>
						<br>
						<br>____________________
					</td>
					<td class="text-center" style="font-size:12px;width:33.333333%;">
						Dokter
						<br>
						<br>
						<br>
						<br>____________________
					</td>
				</tr>
			</table>
		</div>
  </body>
</html>
