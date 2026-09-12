<div class='table-responsive'>
	<table class='table table-striped table-bordered table-hover table-condensed' id='data'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>No. RM</th>
				<th>Umur</th>
				{{-- <th>Alamat</th> --}}
				<th>Klinik Tujuan</th>
				<th>Dokter</th>
				<th>Jenis</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($histreg as $key => $d)
				@php
					$reg = Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id);
				@endphp
				<tr>
					<td>{{ $no++ }}</td>
					<td>{{ $reg->pasien->nama }}</td>
					<td>{{ $reg->pasien->no_rm }}</td>
					<td>{{ hitung_umur($reg->pasien->tgllahir) }}</td>
					<td>
						{{ baca_poli($reg->poli_id) }}
					</td>
					<td>
						{{ $reg->pegawai->nama }}
					</td>
					<td>{{ baca_carabayar($d->bayar) }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>