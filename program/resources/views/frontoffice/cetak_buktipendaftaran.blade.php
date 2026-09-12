<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Bukti Pendaftaran Rawat {{ (substr($regs->status_reg,0,1)=='G') ? 'Darurat' : 'Jalan' }}</title>
    <link rel="stylesheet" href="{{ asset('public/style/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/style/dist/css/AdminLTE.min.css') }}">
    <style media="screen">
			@page {
				margin: 0cm;
				width: 100%;
				height: auto;
      }
    </style>
  <head>
	<script>
		setTimeout(function(){
				window.close();
		}, 500);
	</script>
  <body onload="window.print()" style="padding:10px;">
    <table style="font-size:9px;line-height:1;width:100%;">
      <tr>
        <td style="width:20%;"><img src="{{ asset('laravel/images/'.configrs()->logo) }}" style="width:28px; margin-right: -20px;"></td>
        <td>
          <h4 style="font-size:10px;font-weight:bold;margin:0;text-align:center;">{{ configrs()->nama }} </h4>
          <p style="font-size:8px;text-align:center;">{{ configrs()->alamat }}</p>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="text-align:center;font-weight:bold;">
          Tanda Bukti Registrasi
        </td>
      </tr>
    </table>
    <table style="font-size:9px;width:100%;">
			<!--tr>
				<td>No. Pendaftaran</td>
				<td>: {{ $regs->reg_id }}</td>
			</tr>
			<tr>
				<td>Dokter</td>
				<td>: {{ $regs->pegawai->nama }}</td>
			</tr-->
			<tr>
				<td>No. RM</td>
				<td>: {{ $regs->pasien->no_rm }}</td>
			</tr>
			<tr>
				<td>Nama</td>
				<td>: {{ $regs->pasien->nama }}</td>
			</tr>
			<!--tr>
				<td>Tgl. Lahir</td>
				<td>: {{ tgl_indo($regs->pasien->tgllahir) }}</td>
			</tr-->
			<tr>
				<td>Cara Bayar</td>
				<td>: {{ baca_carabayar($regs->bayar) }}</td>
			</tr>
    </table>
		<hr style="margin:8px 0;">
		<center><img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($regs->pasien->no_rm, 'C128',1,24,array(1,1,1), true) }}" alt=""></center>
		<hr style="margin:8px 0;">
    <table style="font-size:9px;width:100%;text-align:center;">
			<tr>
				<td style="width:50%;">{{ date('H:i:s') }}</td>
				<td>{{ date('d-m-Y') }}</td>
			</tr>
			<tr>
				<td style="border:1px solid #ddd;">{{ ($regs->poli->cetak_antrian==1) ? 'No. Antrian' : '' }}</td>
				<td></td>
			</tr>
			<tr>
				<td style="border:1px solid #ddd;">{{ baca_dokter($regs->dokter_id) }}</td>
				<td></td>
			</tr>
			<tr>
				<td style="font-size:20px;font-weight:bold;border:1px solid #ddd;">{{ ($regs->poli->cetak_antrian==1) ? $regs->antrian_poli : '' }}</td>
				<td style="vertical-align:bottom;">{{ Auth::user()->name }}</td>
			</tr>
    </table>
		<div class="text-left" style="margin-top:8px;font-size:8px;">
			Nb:
		</div>
		<div class="text-left" style="font-size:8px;">
			1. Simpan kartu dan jangan sampai hilang
		</div>
		<div class="text-left" style="font-size:8px;">
			2. Kartu ini dapat digunakan untuk mengambil antrian apotek
		</div>
  </body>
</html>
