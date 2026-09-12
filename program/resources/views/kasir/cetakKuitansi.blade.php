<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">

<title>Cetak Kuitansi</title>

<link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">

<link href="{{ asset('public/css/pdf.css') }}" rel="stylesheet">

<style type="text/css">

html, body{

	margin:0 10px;

}

.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{

	padding:0px 4px;

}

@media print {

	html, body{

		margin:0 10px;

	}

}

</style>

<META HTTP-EQUIV="REFRESH" CONTENT="0; URL={{ url('kasir/cetak') }}">

</head>

<body onload="window.print()">

	@if($reg->bayar==1)

		<!-- PASIEN JKN -->

		<div style="PAGE-BREAK-BEFORE: always; margin-top:5px;">

			<table style="width:100%;margin:0;">

				<tr>

					<td style="width:10%;"><img src="{{ asset('laravel/images/'.configrs()->logo) }}" style="width:35px; margin-right: -20px;">		</td>

					<td>

						<h4 style="font-size: 100%; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>

						<p>{{ configrs()->alamat }}</p>

					</td>

				</tr>

				<tr>

					<td colspan="2"><center>------------------------------------------------------------------------------------------------------------------------------------------------------------</td>

				</tr>

			</table>

			<table style="width:100%;margin:0 0 10px 0;">

				<tr>

					<td colspan="2"><h5 style="text-align:center;margin:0;"><b>INFORMASI RINCIAN BIAYA</b></h5></td>

				</tr>

			</table>

			

			<div class="row">

				<div class="col-xs-{{ (substr($reg->status_reg, 0,1) == 'I') ? '12' : '6' }} no-padding">

					<table>

						<tr>

							<td>Nomor</td> <td>: {{ $kuitansi->no_kwitansi }}</td>

						</tr>

						<tr>

							<td>Tgl Pelayanan</td> <td>: {{ date('d/m/Y H:i:s') }}</td>

						</tr>

						<tr>

							<td>Biaya Total</td> <td>: Rp. {{ number_format($kuitansi->total) }}  </td>

						</tr>

						<tr>

							<td>Keterangan </td>

							<td>: 

								Biaya total rawat

								@if(substr($reg->status_reg, 0,1) == 'I')

									inap

								@elseif(substr($reg->status_reg, 0,1) == 'J')

									jalan

								@elseif(substr($reg->status_reg, 0,1) == 'G')

									darurat

								@endif

								atas pasien: {{ $kuitansi->pasien->nama }} NO. RM {{ $kuitansi->pasien->no_rm }}

							</td>

						</tr>

					</table>

				</div>

				

				@if(substr($reg->status_reg, 0,1) != 'I')

					<div class="col-xs-6 no-padding">

						<table class="table table-bordered" style="width:100%;">

							<thead>

								<tr>

									<th class="text-left">PERINCIAN</th>

									<th class="text-right">BAYAR</th>

								</tr>

							</thead>

							<tbody>

								@php

									$pendaftaran = 0;

									$obatalkes = 0;

									$tindakanmedis = 0;

									$penunjangmedis = 0;

									$biaya_pendaftaran = DB::table('biayaregistrasis')->get();

								@endphp

								@foreach ($folio as $d)

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

										}elseif($d->poli_tipe=='L' OR $d->poli_tipe=='R'){

											$penunjangmedis += $d->total;

										}else{

											$tindakanmedis += $d->total;

										}

									@endphp

								@endforeach

								<tr>

									<td>Pendaftaran</td>

									<td class="text-right"><b>{{ number_format($pendaftaran) }}</td>

								</tr>

								<tr>

									<td>Obat & Alkes</td>

									<td class="text-right"><b>{{ number_format($obatalkes) }}</td>

								</tr>

								<tr>

									<td>Tindakan Medis</td>

									<td class="text-right"><b>{{ number_format($tindakanmedis) }}</td>

								</tr>

								@foreach($folio as $d)

									@if(substr($d->jenis,0,2)!='OR' AND substr($d->jenis,0,3)!='EPO' AND substr($d->jenis,0,3)!='PEM')

										@if(in_array($d->tarif->kategoritarif_id,[1,6]) AND $d->total>0)

										<tr>

											<td>- <i>{{$d->namatarif}}</i></td>

											<td class="text-right">

												<i>{{ number_format($d->total) }}</i>

											</td>

										</tr>

										@endif

									@endif

								@endforeach

								<tr>

									<td>Penunjang Medis</td>

									<td class="text-right"><b>{{ number_format($penunjangmedis) }}</td>

								</tr>

								@foreach($folio as $d)

									@if(substr($d->jenis,0,2)!='OR' AND substr($d->jenis,0,3)!='EPO' AND substr($d->jenis,0,3)!='PEM')

										@if(in_array($d->tarif->kategoritarif_id,[2,3]) AND $d->total>0)

										<tr>

											<td>- <i>{{$d->namatarif}}</i></td>

											<td class="text-right">

												<i>{{ number_format($d->total) }}</i>

											</td>

										</tr>

										@endif

									@endif

								@endforeach

							</tbody>

							<tfoot>

								<tr>

									<th class="text-right">Total Bayar</th>

									<th class="text-right">{{ number_format($kuitansi->total) }}</th>

								</tr>

							</tfoot>

						</table>

					</div>

				@endif			

			</div>

			

			<table style="width:100%;text-align:center;">

				<tr>

					<th class="text-left" style="width:60%;">

						Terbilang: <i>{{ terbilang($kuitansi->total) }} Rupiah

						<br>

						@php

							$diskon = 0;

							if($kuitansi->diskon_persen!=0){

								$diskon = $kuitansi->total*$kuitansi->diskon_persen/100;

							}

							if($kuitansi->diskon_rupiah!=0){

								$diskon = $diskon + $kuitansi->diskon_rupiah;

							}

						@endphp

						@if($diskon>0)

							*) Diskon: 

							Rp. {{ number_format($diskon) }}

						@endif

					</th>

					<th class="text-center" style="width:40%;">{{ configrs()->kota }}, {{ tanggalkuitansi(date('d-m-Y')) }}<br><br><br><i><u>{{ Auth::user()->name }}</u></i></th>

				</tr>

			</table>

		</div>

	@else

		<!-- PASIEN UMUM / ASURANSI -->

		<div style="PAGE-BREAK-BEFORE: always; margin-top:5px;">

			<table style="width:100%;margin:0;">

				<tr>

					<td style="width:10%;"><img src="{{ asset('laravel/images/'.configrs()->logo) }}" style="width:35px; margin-right: -20px;">		</td>

					<td>

						<h4 style="font-size: 100%; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>

						<p>{{ configrs()->alamat }}</p>

					</td>

				</tr>

				<tr>

					<td colspan="2"><center>------------------------------------------------------------------------------------------------------------------------------------------------------------</td>

				</tr>

			</table>

			<table style="width:100%;margin:0 0 10px 0;">

				<tr>

					<td colspan="2"><h5 style="text-align:center;margin:0;"><b>@if($reg->bayar==2) KWITANSI @else RINCIAN BIAYA @endif</b></h5></td>

				</tr>

			</table>

			

			<div class="row">

				<div class="col-xs-12 no-padding">

					<table>

						<tr>

							<td>Nomor</td> <td>: {{ $kuitansi->no_kwitansi }}</td>

						</tr>

						<tr>

							<td>Tgl Pelayanan</td> <td>: {{ date('d/m/Y H:i:s') }}</td>

						</tr>

						<tr>

							<td>Biaya Total</td> <td>: Rp. @if($reg->bayar==2) {{ number_format($kuitansi->dibayar) }} @else {{ number_format($kuitansi->total) }} @endif </td>

						</tr>

						<tr>

							<td>Keterangan </td>

							<td>: 

								Biaya total rawat

								@if(substr($reg->status_reg, 0,1) == 'I')

									inap

								@elseif(substr($reg->status_reg, 0,1) == 'J')

									jalan

								@elseif(substr($reg->status_reg, 0,1) == 'G')

									darurat

								@endif

								atas pasien: {{ $kuitansi->pasien->nama }} NO. RM {{ $kuitansi->pasien->no_rm }}

							</td>

						</tr>

					</table>

				</div>	

			</div>

			

			<table style="width:100%;text-align:center;">

				<tr>

					<th class="text-left" style="width:60%;">

						Terbilang: <i>@if($reg->bayar==2) {{ terbilang($kuitansi->dibayar) }} @else {{ terbilang($kuitansi->total) }} @endif Rupiah

						<br>

						@php

							$diskon = 0;

							if($kuitansi->diskon_persen!=0){

								$diskon = $kuitansi->total*$kuitansi->diskon_persen/100;

							}

							if($kuitansi->diskon_rupiah!=0){

								$diskon = $diskon + $kuitansi->diskon_rupiah;

							}

						@endphp

						@if($diskon>0)

							*) Diskon: 

							Rp. {{ number_format($diskon) }}

						@endif

					</th>

					<th class="text-center" style="width:40%;">{{ configrs()->kota }}, {{ tanggalkuitansi(date('d-m-Y')) }}<br><br><br><i><u>{{ Auth::user()->name }}</u></i></th>

				</tr>

			</table>

		</div>

	@endif

	

	@if($kuitansi->iur > 0)

		<!-- IUR -->

		<div style="PAGE-BREAK-BEFORE: always; margin-top:5px;">

			<table style="width:100%;margin:0;">

				<tr>

					<td style="width:10%;"><img src="{{ asset('laravel/images/'.configrs()->logo) }}" style="width:35px; margin-right: -20px;">		</td>

					<td>

						<h4 style="font-size: 100%; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>

						<p>{{ configrs()->alamat }}</p>

					</td>

				</tr>

				<tr>

					<td colspan="2"><center>------------------------------------------------------------------------------------------------------------------------------------------------------------</td>

				</tr>

			</table>

			<table style="width:100%;margin:0 0 10px 0;">

				<tr>

					<td colspan="2"><h5 style="text-align:center;margin:0;"><b>KWITANSI</b></h5></td>

				</tr>

			</table>

			

			<div class="row">

				<div class="col-xs-12 no-padding">

					<table>

						<tr>

							<td>Nomor</td> <td>: {{ $kuitansi->no_kwitansi }}</td>

						</tr>

						<tr>

							<td>Tgl Pelayanan</td> <td>: {{ date('d/m/Y H:i:s') }}</td>

						</tr>

						<tr>

							<td>Biaya Total</td> <td>: Rp. {{ number_format($kuitansi->iur) }}</td>

						</tr>

						<tr>

							<td>Keterangan </td>

							<td>: 

								Biaya IUR total rawat

								@if(substr($reg->status_reg, 0,1) == 'I')

									inap

								@elseif(substr($reg->status_reg, 0,1) == 'J')

									jalan

								@elseif(substr($reg->status_reg, 0,1) == 'G')

									darurat

								@endif

								atas pasien: {{ $kuitansi->pasien->nama }} NO. RM {{ $kuitansi->pasien->no_rm }}

							</td>

						</tr>

					</table>

				</div>	

			</div>

			

			<table style="width:100%;text-align:center;">

				<tr>

					<th class="text-left" style="width:60%;">

						Terbilang: <i>{{ terbilang($kuitansi->iur) }} Rupiah

					</th>

					<th class="text-center" style="width:40%;">{{ configrs()->kota }}, {{ tanggalkuitansi(date('d-m-Y')) }}<br><br><br><i><u>{{ Auth::user()->name }}</u></i></th>

				</tr>

			</table>

		</div>

	@endif



	@if($uang_muka > $kuitansi->dibayar)

		<!-- PENGEMBALIAN UANG MUKA -->

		<div style="PAGE-BREAK-BEFORE: always; margin-top:5px;">

			<table style="width:100%;margin:0;">

				<tr>

					<td style="width:10%;"><img src="{{ asset('laravel/images/'.configrs()->logo) }}" style="width:35px; margin-right: -20px;">		</td>

					<td>

						<h4 style="font-size: 100%; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>

						<p>{{ configrs()->alamat }}</p>

					</td>

				</tr>

				<tr>

					<td colspan="2"><center>------------------------------------------------------------------------------------------------------------------------------------------------------------</td>

				</tr>

			</table>

			<table style="width:100%;margin:0 0 10px 0;">

				<tr>

					<td colspan="2"><h5 style="text-align:center;margin:0;"><b>TANDA TERIMA PENGEMBALIAN UANG</b></h5></td>

				</tr>

			</table>

			

			<div class="row">

				<div class="col-xs-12 no-padding">

					<table>

						<tr>

							<td>Tgl Pelayanan</td> <td>: {{ date('d/m/Y H:i:s') }}</td>

						</tr>

						<tr>

							<td>Total Pengembalian</td> <td>: Rp. {{ number_format($uang_muka - $kuitansi->dibayar) }}  </td>

						</tr>

						<tr>

							<td>Keterangan </td>

							<td>: 

								Pengembalian uang titipan

								@if(substr($reg->status_reg, 0,1) == 'I')

									inap

								@elseif(substr($reg->status_reg, 0,1) == 'J')

									jalan

								@elseif(substr($reg->status_reg, 0,1) == 'G')

									darurat

								@endif

								atas pasien: {{ $kuitansi->pasien->nama }} NO. RM {{ $kuitansi->pasien->no_rm }}

							</td>

						</tr>

					</table>

				</div>	

			</div>

			

			<table style="width:100%;text-align:center;">

				<tr>

					<th class="text-left" style="width:60%;">

						Terbilang: <i>{{ terbilang($uang_muka - $kuitansi->dibayar) }} Rupiah

					</th>

					<th class="text-center" style="width:40%;">{{ configrs()->kota }}, {{ tanggalkuitansi(date('d-m-Y')) }}<br><br><br><i><u>{{ Auth::user()->name }}</u></i></th>

				</tr>

			</table>

		</div>

	@endif

</body>

</html>

