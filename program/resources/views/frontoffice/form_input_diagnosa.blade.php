@extends('master')
@section('header')
  <h1>Diagnosa Rawat Inap </h1>
@endsection

@section('content')
<div class="box box-primary">
{!! Form::open(['method' => 'POST', 'url' => 'frontoffice/simpan-diagnosa', 'class' => 'form-horizontal']) !!}
	<div class="box-body">
		<h4 class="text-green" style="margin-top:0px;font-size:14px;font-weight:600;">#Data Pasien</h4>
		<div class='table-responsive'>
			<table class='table table-bordered table-hover table-condensed'>
				<tbody>
					<tr>
						<th style="width:15%;">No RM</th> 
						<td style="width:30%">{{ $reg->pasien->no_rm }}</td> 
						<th>Alamat</th> 
						<td>{{ $reg->pasien->alamat }}</td>
					</tr>
					<tr>
						<th>Nama </th> 
						<td>{{ $reg->pasien->nama }}</td> 
						<th>No HP/Telp</th> 
						<td>{{ $reg->pasien->nohp }}</td>
					</tr>
					<tr>
						<th>Umur</th> 
						<td>{{ hitung_umur($reg->pasien->tgllahir) }}</td> 
						<th>Agama</th> 
						<td>{{ Modules\Pasien\Entities\Agama::find($reg->pasien->agama_id)->agama }}</td>
					</tr>
					<tr>
						<th>Jenis Kelamin</th> 
						<td>{{ ($reg->pasien->kelamin == 'L') ? 'Laki-laki' : 'Perempuan' }}</td>
						<th>Pekerjaan</th> 
						<td>{{ ($reg->pasien->pekerjaan) ? $reg->pasien->pekerjaan->nama : '' }}</td>
					</tr>
					<tr>
						<th>Status Perkawinan</th> 
						<td>{{ $reg->pasien->status_marital }}</td>
						<th>Pendidikan Terakhir</th> 
						<td>{{ ($reg->pasien->pendidikan) ? $reg->pasien->pendidikan->nam : '' }}</td>
					</tr>
					<tr>
						<th>Berat Badan</th> 
						<td>{{ $reg->berat_badan }}</td>
						<th>Bahasa</th> 
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		@if(substr($reg->status_reg,0,1)=='I')
			<div class="col-md-12 no-padding">
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
								<th style="text-align:center;">Durasi</th>
							</tr>
						</thead>
						<tbody>
							@if($hist_kamar!=null)
								@php $total_biaya_kamar=0; @endphp
								@foreach($hist_kamar as $key => $data)
								<tr>
									<td style="text-align:center;">{{ $data->kelas->nama }}</td>
									<td style="text-align:center;">{{ $data->kamar->nama }}</td>
									<td style="text-align:center;">{{ $data->bed->nama }}</td>
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
									<td style="text-align:center;">
										{{ $hari.' hari '.$jam.' jam '.$menit.' menit' }}
									</td>
								</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		@endif
		
		<div class="col-md-12 no-padding">
			<h4 class="text-green" style="margin-top:0px;font-size:14px;font-weight:600;">#Data Registrasi</h4>
			<div class='table-responsive'>
				<div class='col-md-6 no-padding'>
					<table class='table table-bordered table-hover table-condensed'>
						<tbody>
							<tr>
								<th style="width:15%;">Tanggal Periksa</th> 
								<td style="width:35%">{{ date_format(date_create($reg->created_at), 'd-m-Y H:i:s') }}</td> 
							</tr>
							<tr>
								<th style="width:15%;">Tanggal Keluar</th> 
								<td style="width:35%">{{ date_format(date_create($reg->tgl_pulangk), 'd-m-Y H:i:s') }}</td> 
							</tr>
							<tr>
								<th style="width:15%;">Cara Bayar</th> 
								<td style="width:35%">{{ $reg->bayars->carabayar }}</td> 
							</tr>
							<tr>
								<th style="width:15%;">Cara Masuk</th> 
								<td style="width:35%">
									@php
										$caramasuk = '';
										if(count($hist_igd)>0){
											$caramasuk = 'IGD';
										}elseif($reg->no_rujukan!=null){
											$caramasuk = 'Rujukan';
										}else{
											$caramasuk = 'Poli';
										}
									@endphp
									{{$caramasuk}}
								</td>
							</tr>
							<tr>
								<th style="width:15%;">Poli</th> 
								<td style="width:35%">{{ $reg->poli->nama }}</td> 
							</tr>
							<tr>
								<th style="width:15%;">Cara Keluar</th> 
								<td style="width:35%">{{ $reg->kondisi->namakondisi }}</td> 
							</tr>
							<tr>
								<th style="width:15%;">DPJP</th> 
								<td style="width:35%">{{ baca_dokter($reg->dokter_id) }}</td> 
							</tr>
							<tr>
								<th style="width:15%;">Status Pasien</th> 
								<td style="width:35%">{{ $reg->status }}</td> 
							</tr>
							<tr>
								<th style="width:15%;">Sebab Sakit/Cidera</th> 
								<td style="width:35%">{{ ($reg->sebabsakit) ? $reg->sebabsakit->nama : 'Sakit' }}</td> 
							</tr>
						</tbody>
					</table>
				</div>
				<div class='col-md-6 no-padding'>
					<table class='table table-bordered table-hover table-condensed'>
						<tbody>
							<tr>
								<th style="width:15%;">Kondisi Keluar</th> 
								<td style="width:35%">								
									<select id="kondisikeluar" name="kondisikeluar" class="form-control select2" onchange="changeKondisiKeluar(this.value)" style="width:100%;">
										<option {{ ($reg->keadaan_keluar_inap==null) ? 'selected' : '' }} value="">-- pilih kondisi keluar --</option>
										<option {{ ($reg->keadaan_keluar_inap=='Sembuh') ? 'selected' : '' }} value="Sembuh">Sembuh</option>
										<option {{ ($reg->keadaan_keluar_inap=='Membaik') ? 'selected' : '' }} value="Membaik">Membaik</option>
										<option {{ ($reg->keadaan_keluar_inap=='Meninggal < 48 Jam') ? 'selected' : '' }} value="Meninggal < 48 Jam">Meninggal < 48 Jam</option>
										<option {{ ($reg->keadaan_keluar_inap=='Meninggal > 48 Jam') ? 'selected' : '' }} value="Meninggal > 48 Jam">Meninggal > 48 Jam</option>
									</select>
								</td> 
							</tr>
							<tr>
								<th style="width:15%;">Keterangan</th> 
								<td style="width:35%"><input type="text" class="form-control" value="{{$reg->keterangan}}" onkeyup="updateKeterangan(this.value)" name="keterangan" id="keterangan"/></td> 
							</tr>
							<tr>
								<th>Kasus</th> 
								<td>
									<select id="kasus" name="kasus" class="form-control select2" onchange="changeKasus(this.value)" style="width:100%;">
										<option {{ ($reg->kasus==null) ? 'selected' : '' }} value="">-- pilih kasus --</option>
										<option {{ ($reg->kasus=='Baru') ? 'selected' : '' }} value="Baru">Baru</option>
										<option {{ ($reg->kasus=='Lama') ? 'selected' : '' }} value="Lama">Lama</option>
									</select>
								</td>
							</tr>
							<tr>
								<th style="width:15%;">GPA</th> 
								<td style="width:35%"><input type="text" class="form-control" value="{{$reg->kehamilan_gpa}}" onkeyup="updateGpa(this.value)" name="kehamilan_gpa" id="kehamilan_gpa"/></td> 
							</tr>
							<tr>
								<th style="width:15%;">Sebab Kematian</th> 
								<td style="width:35%"><input type="text" class="form-control" value="{{$reg->sebab_kematian}}" onkeyup="updateSebabKematian(this.value)" name="sebab_kematian" id="sebab_kematian"/></td> 
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		{!! Form::hidden('registrasi_id', $reg->id) !!}
		{!! Form::hidden('cara_bayar', $reg->bayar) !!}
		<div class="row">
			<div class="col-md-12">
				<h4 class="text-green" style="margin:0px;font-size:14px;font-weight:600;">#Diagnosa</h4>
			</div>
			<div class="col-md-6">
				@isset($perawatanicd10)
						<h4>Diagnosa Sebelumnya</h4>
						<div class="table-responsive">
							<table class="table table-hover table-condensed">
								<tbody>
									@foreach ($perawatanicd10 as $key => $d)
										<tr>
											<td>{{ $d->icd10 }}</td>
											<td>{{ baca_diagnosa($d->icd10) }}</td>
											<td>
												<a href="{{ url('frontoffice/hapus-diagnosa/'.$d->id.'/'.$reg->id) }}" class="btn btn-flat btn-danger btn-xs" title="hapus"> <i class="fa fa-trash"></i></a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
				@endisset
				<hr>
				<h4>Diagnosa</h4>
				@for ($i=1; $i <= 5; $i++)
					<div class="form-group{{ $errors->has('icd10'.$i) ? ' has-error' : '' }}">
							{!! Form::label('icd10', 'Diagnosa '.$i, ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
									{!! Form::text('icd10'.$i, null, ['class' => 'form-control', 'id'=>'icd10'.$i]) !!}
									<small class="text-danger">{{ $errors->first('icd10'.$i) }}</small>
							</div>
					</div>
				@endfor
				<!--hr>
				<div class="form-group{{ $errors->has('status_kondisi') ? ' has-error' : '' }}">
						{!! Form::label('status_kondisi', 'Kondisi Pasien', ['class' => 'col-sm-3 control-label']) !!}
						<div class="col-sm-9">
								{!! Form::select('status_kondisi', $kondisi, null, ['class' => 'form-control select2']) !!}
								<small class="text-danger">{{ $errors->first('status_kondisi') }}</small>
						</div>
				</div>
				<div class="form-group{{ $errors->has('posisi_berkas_rm') ? ' has-error' : '' }}">
						{!! Form::label('posisi_berkas_rm', 'Posisi Berkas', ['class' => 'col-sm-3 control-label']) !!}
						<div class="col-sm-9">
								{!! Form::select('posisi_berkas_rm', $posisi, null, ['class' => 'form-control select2']) !!}
								<small class="text-danger">{{ $errors->first('posisi_berkas_rm') }}</small>
						</div>
				</div-->
			</div>
			{{-- ======================================================================= --}}
			<div class="col-md-6">
				@isset($perawatanicd9)
						<h4>Prosedur Sebelumnya</h4>
						<div class="table-responsive">
							<table class="table table-hover table-condensed">
								<tbody>
									@foreach ($perawatanicd9 as $key => $d)
										<tr>
											<td>{{ $d->icd9 }}</td>
											<td>{{ baca_prosedur($d->icd9) }} </td>
											<td>
												<a href="{{ url('frontoffice/hapus-prosedur/'.$d->id.'/'.$reg->id) }}" class="btn btn-flat btn-danger btn-xs" title="hapus"> <i class="fa fa-trash"></i></a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
				@endisset
				<hr>
				<h4>Prosedur</h4>
				@for ($i=1; $i <= 5; $i++)
					<div class="form-group{{ $errors->has('icd9'.$i) ? ' has-error' : '' }}">
							{!! Form::label('icd9'.$i, 'Prosedur '.$i, ['class' => 'col-sm-3 control-label']) !!}
							<div class="col-sm-9">
									{!! Form::text('icd9'.$i, null, ['class' => 'form-control']) !!}
							</div>
					</div>
				@endfor
			</div>
		</div>  
			
		@if(substr($reg->status_reg,0,1)=='I')
		<div class="col-md-12 no-padding">
			<h4 class="text-green" style="margin-top:0px;font-size:14px;font-weight:600;">#Operasi</h4>
			<div class='table-responsive'>
				<table class='table table-bordered table-hover table-condensed'>
					<tbody>
						<tr>
							<th>Operasi</th> 
							<th>Jenis</th> 
							<th>Tanggal</th> 
							<th>Operator</th> 
							<th>Anestesi</th> 
						</tr>
						@if(count($operasi)>0)
							@foreach($operasi as $key => $op)
								<tr>
									<th>{{$key+1}}</th> 
									<th>{{$op->namatarif}}</th> 
									<th>{{date_format(date_create($op->created_at,'d-m-Y'))}}</th> 
									<th>{{baca_dokter($op->pelaksana->dokter_operator1)}}</th> 
									<th>{{baca_dokter($op->pelaksana->dokter_anestesi1)}}</th> 
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
		@endif
	</div>
	<div class="box-footer">
	@if($nilai=="1")
	<div class="pull-left">
		<a href="{{ url('frontoffice/input_diagnosa_rawatinap') }}" class="btn btn-warning btn-flat">BATAL</a>
	</div>
	<div class="pull-left">
		<a href="{{ url('frontoffice/input_diagnosa_rawatinap') }}" class="btn btn-primary btn-flat"> <i class="fa fa-backward"></i> SELESAI</a>
	</div>
	@else
	<div class="pull-left">
		<a href="{{ url('frontoffice/input_diagnosa_rawatjalan') }}" class="btn btn-warning btn-flat">BATAL</a>
	</div>
	<div class="pull-left">
		<a href="{{ url('frontoffice/input_diagnosa_rawatjalan') }}" class="btn btn-primary btn-flat"> <i class="fa fa-backward"></i> SELESAI</a>
	</div>
	@endif
	<div class="pull-right">
		{!! Form::submit('SIMPAN', ['class' => 'btn btn-success btn-flat','onclick'=>'return confirm("Yakin data sudah benar semua?")']) !!}
	</div>
	</div>
{!! Form::close() !!}
</div>

<div class="modal fade" id="icd9" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="">Data ICD9</h4>
			</div>
			<div class="modal-body">
				<div class='table-responsive'>
					<table id='dataICD9' class='table table-striped table-bordered table-hover table-condensed'>
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Nama</th>
								<th>Add</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="icd10" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="">Data ICD10</h4>
			</div>
			<div class="modal-body">
				<div class='table-responsive'>
					<table id='dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Nama</th>
								<th>Add</th>
							</tr>
						</thead>

					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
function changeKondisiKeluar(val){
	var reg_id = '{{$reg->id}}';
	$.ajax({
		headers:{
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		type: 'POST',
		url: '/frontoffice/update-kondisi',
		data: {id: reg_id, kondisi: val},
		success: function (data) {
			console.log(data);
			if(!data.status){
				alert('Gagal update kondisi keluar pasien')
			}
		}
	});
}
function changeKasus(val){
	var reg_id = '{{$reg->id}}';
	$.ajax({
		headers:{
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		type: 'POST',
		url: '/frontoffice/update-kasus',
		data: {id: reg_id, kasus: val},
		success: function (data) {
			console.log(data);
			if(!data.status){
				alert('Gagal update kasus pasien')
			}
		}
	});
}
function updateGpa(val){
	var reg_id = '{{$reg->id}}';
	$.ajax({
		headers:{
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		type: 'POST',
		url: '/frontoffice/update-gpa',
		data: {id: reg_id, gpa: val},
		success: function (data) {
			console.log(data);
			if(!data.status){
				alert('Gagal update GPA')
			}
		}
	});
}
function updateKeterangan(val){
	var reg_id = '{{$reg->id}}';
	$.ajax({
		headers:{
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		type: 'POST',
		url: '/frontoffice/update-keterangan',
		data: {id: reg_id, keterangan: val},
		success: function (data) {
			console.log(data);
			if(!data.status){
				alert('Gagal update keterangan')
			}
		}
	});
}
function updateSebabKematian(val){
	var reg_id = '{{$reg->id}}';
	$.ajax({
		headers:{
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		type: 'POST',
		url: '/frontoffice/update-kematian',
		data: {id: reg_id, kematian: val},
		success: function (data) {
			console.log(data);
			if(!data.status){
				alert('Gagal update sebab kematian')
			}
		}
	});
}
</script>
@endsection