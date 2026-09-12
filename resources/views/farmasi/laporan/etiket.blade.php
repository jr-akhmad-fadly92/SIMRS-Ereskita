<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cetak Etiket</title>
	<link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
	<style media="print">
		body{
			font-size: 9px;
			margin: 10px;
		}
		.etiket{
			width: 100%;
			height: auto;
			PAGE-BREAK-BEFORE: always
		}
		.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
			font-size:9px;
		}
	</style>
</head>
<script>
	setTimeout(function(){
			window.close();
	}, 500);
</script>
<body onload="print()">
	@isset($penjualan->id)
		@if(substr($penjualan->registrasi->status_reg,0,1)=='I')
			@if($sort_data_obat_minum!=null)
			@for($i=1; $i<=2; $i++)
				@php
					if($i==1){ // NON RACIK
						$det = App\Penjualandetail::where('penjualan_id', $penjualan->id)->where('cetak', 'Y')->where('status_racikan',null)->get();
					}elseif($i==2){ // RACIKAN
						$det = App\Penjualandetail::where('penjualan_id', $penjualan->id)->where('cetak', 'Y')->where('status_racikan','!=',null)->groupBy('obat_racikan_id')->get();
					}
					$no = 1;
				@endphp
				@foreach($det as $key => $d)
					<div class="etiket">
						@include('farmasi.laporan.etiket-header')						
						@if(substr($penjualan->registrasi->status_reg,0,1)=='I')
							<div class="col-md-12">
								<center><b style="font-size:9px;">
									@if($i==1)
										{{ strtoupper($d->masterobat->nama).' ('.$d->jumlah.')' }}
									@elseif($i==2)
										Racikan {{ $no++ }}
									@endif
								</b></center>
							</div>
							<p class="text-center" style="font-size:9px;">
								@if($d->informasi2!=null)
									{{ $d->informasi2 }}
								@else
									{{ ($d->aturan_pakai!=null) ? App\Aturanetiket::where('aturan',$d->aturan_pakai)->first()->konversi : '' }}
								@endif
								{{ ' '.$d->jumlah_aturanpakai.' '.$d->satuan_aturanpakai }}
								<br>
								{{ $d->informasi1 }}
								@if($d->informasi1!='')
									<br>
								@endif
							</p>
							<div class="row">
								<div class="col-md-12 no-padding" style="font-size:9px;"><center>
									Exp: {{ ($d->expired!=null) ? tgl_indo($d->expired) : '' }}
								</center></div>
							</div>
						@endif
					</div>
				@endforeach
			@endfor

			@endif
			
			@if($sort_data_obat_injeksi!=null)
				@foreach($sort_data_obat_injeksi as $key_jam => $dataobat)
					<div class="etiket">
						@include('farmasi.laporan.etiket-header')
						<center>
							<p style="font-size:9px;margin:0;"><b>OBAT INJEKSI</b></p>
							<span style="font-size:9px;">
								@foreach($dataobat as $do)
									{{ $do }}<br>
								@endforeach
								<br>
								{{ $key_jam }}			
							</span>
						</center>
					</div>
				@endforeach
			@endif
			
			@if($sort_data_obat_alkes!=null)
				@foreach($sort_data_obat_alkes as $key_jam => $dataobat)
					<div class="etiket">
						@include('farmasi.laporan.etiket-header')
						<center>
							<p style="font-size:9px;margin:0;"><b>ALKES</b></p>
							<span style="font-size:9px;">
								@foreach($dataobat as $do)
									{{ $do }}<br>
								@endforeach			
							</span>
						</center>
					</div>
				@endforeach
			@endif
			
			@if($sort_data_obat_infus!=null)
				@foreach($sort_data_obat_infus as $key_jam => $dataobat)
					<div class="etiket">
						@include('farmasi.laporan.etiket-header')
						<center>
							<p style="font-size:9px;margin:0;"><b>INFUS</b></p>
							<span style="font-size:9px;">
								@foreach($dataobat as $do)
									{{ $do }}<br>
								@endforeach			
							</span>
						</center>
					</div>
				@endforeach
			@endif
		@else
			@for($i=1; $i<=2; $i++)
				@php
					if($i==1){ // NON RACIK
						$det = App\Penjualandetail::where('penjualan_id', $penjualan->id)->where('cetak', 'Y')->where('status_racikan',null)->get();
					}elseif($i==2){ // RACIKAN
						$det = App\Penjualandetail::where('penjualan_id', $penjualan->id)->where('cetak', 'Y')->where('status_racikan','!=',null)->groupBy('obat_racikan_id')->get();
					}
					$no = 1;
				@endphp
				@foreach($det as $key => $d)
					<div class="etiket">
						@include('farmasi.laporan.etiket-header')						
						@if(substr($penjualan->registrasi->status_reg,0,1)=='J' OR substr($penjualan->registrasi->status_reg,0,1)=='G')
							<div class="col-md-12">
								<center><b style="font-size:9px;">
									@if($i==1)
										{{ strtoupper($d->masterobat->nama).' ('.$d->jumlah.')' }}
									@elseif($i==2)
										Racikan {{ $no++ }}
									@endif
								</b></center>
							</div>
							<p class="text-center" style="font-size:9px;">
								@if($d->informasi2!=null)
									{{ $d->informasi2 }}
								@else
									{{ ($d->aturan_pakai!=null) ? App\Aturanetiket::where('aturan',$d->aturan_pakai)->first()->konversi : '' }}
								@endif
								{{ ' '.$d->jumlah_aturanpakai.' '.$d->satuan_aturanpakai }}
								<br>
								{{ $d->informasi1 }}
								@if($d->informasi1!='')
									<br>
								@endif
							</p>
							<div class="row">
								<div class="col-md-12 no-padding" style="font-size:9px;"><center>
									Exp: {{ ($d->expired!=null) ? tgl_indo($d->expired) : '' }}
								</center></div>
							</div>
						@endif
					</div>
				@endforeach
			@endfor
		@endif
	@endisset
</body>
</html>
