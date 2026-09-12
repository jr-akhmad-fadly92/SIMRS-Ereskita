<h5 class="text-center" style="font-weight: bold;font-size:9px;">{{ configrs()->nama }} <br> {{ configrs()->alamat }} </h5>
<table style="width:100%;">
	<tr>
		<td style="font-size:9px;width:auto;">{{ tgl_indo(date("Y-m-d")) }} </td>
		<td style="font-size:9px;width:auto;text-align:right;">{{ baca_dokter($penjualan->registrasi->dokter_id) }}</td>
	</tr>
	<tr>
		<td style="font-size:9px;">{{ $penjualan->registrasi->pasien->no_rm }}</td>
		<td style="font-size:9px;text-align:right;">{{ $penjualan->registrasi->pasien->tgllahir }}</td>
	</tr>
	<tr>
		<td style="font-size:9px;"><b>{{ substr(strtoupper($penjualan->registrasi->pasien->nama),0,10).'..' }}</b></td>
		<td style="font-size:9px;text-align:right;">
			@php
				$kamar = App\Rawatinap::where('registrasi_id',$penjualan->registrasi_id)->first();
				if($kamar!=null){
					echo '<b>'.$kamar->kamar->nama.'</b>';
				}
			@endphp
		</b></td>
	</tr>
</table>					
<div style="font-size:9px;"><center>---------------</center></div>	