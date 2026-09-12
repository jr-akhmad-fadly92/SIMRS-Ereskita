<input type="hidden" value="{{$reg->id}}" name="registrasi_id">
<input type="hidden" value="{{$reg->tipe_layanan}}" name="tipe_layanan">
@php
	$status_reg = substr($reg->status_reg,0,1);
	$datepicker = '';
	if($status_reg=='G'){
		$datepicker = 'datepicker';
	}
	$readonly = true;
	if($status_reg=="J"){
		$readonly = false;
	}
@endphp
<div class="box-body">
	{{-- progress bar --}}
	<div class="progress progress-md active hidden">
		<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
			<span class="sr-only">97% Complete</span> Loading...
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
					{!! Form::label('no_rm', 'No. RM', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
							{!! Form::text('no_rm', !empty($no_rm) ? $no_rm : $reg->pasien->no_rm, ['class' => 'form-control']) !!}
							<small class="text-danger">{{ $errors->first('no_rm') }}</small>
					</div>
			</div>
			<div class="form-group{{ $errors->has('no_tlp') ? ' has-error' : '' }}">
					{!! Form::label('no_tlp', 'No. HP', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
							{!! Form::text('no_tlp', !empty($reg->pasien->nohp) ? $reg->pasien->nohp : '', ['class' => 'form-control']) !!}
							<small class="text-danger">{{ $errors->first('no_tlp') }}</small>
					</div>
			</div>
			<div class="form-group{{ $errors->has('no_bpjs') ? ' has-error' : '' }}">
					{!! Form::label('no_bpjs', 'No. Kartu BPJS', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
							{!! Form::text('no_bpjs', !empty($no_kartu) ? $no_kartu : session('noka'), ['class' => 'form-control']) !!}
							<small class="text-danger">{{ $errors->first('no_bpjs') }}</small>
					</div>
			</div>
			<div class="form-group{{ $errors->has('asalRujukan') ? ' has-error' : '' }}">
					{!! Form::label('asalRujukan', 'Asal Rujukan', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
						@if($readonly)
							{!! Form::hidden('asalRujukan', $asal_rujukan) !!}
							{!! Form::text('asalRujukanText', ($asal_rujukan==1) ? 'Faske 1 (PPK)' : 'Faskes 2 (RS)', ['class' => 'form-control', 'readonly'=>$readonly]) !!}
						@else
							{!! Form::select('asalRujukan', ['1'=>'Faske 1 (PPK)', '2'=>'Faskes 2 (RS)'], !empty($asal_rujukan) ? $asal_rujukan : '', ['class' => 'form-control select2']) !!}
						@endif
							<small class="text-danger">{{ $errors->first('asalRujukan') }}</small>
					</div>
			</div>
			<div class="form-group{{ $errors->has('tgl_rujukan') ? ' has-error' : '' }}">
					{!! Form::label('tgl_rujukan', 'Tgl Rujukan', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
							{!! Form::text('tgl_rujukan', !empty($tgl_rujukan) ? $tgl_rujukan : date('d-m-Y'), ['class' => 'form-control '.$datepicker, 'readonly' => 'true']) !!}
							<small class="text-danger">{{ $errors->first('tgl_rujukan') }}</small>
					</div>
			</div>
			<div class="form-group{{ $errors->has('no_rujukan') ? ' has-error' : '' }}">
					{!! Form::label('no_rujukan', 'No. Rujukan', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
							{!! Form::text('no_rujukan', $no_rujukan, ['class' => 'form-control', 'readonly'=>true]) !!}
							<small class="text-danger">{{ $errors->first('no_rujukan') }}</small>
					</div>
			</div>
			<div class="form-group{{ $errors->has('ppk_rujukan') ? ' has-error' : '' }}">
					{!! Form::label('ppk_rujukan', 'PPK Rujukan', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
							{!! Form::hidden('ppk_rujukan', !empty($kd_ppk) ? $kd_ppk : null) !!}
							{!! Form::hidden('nama_rujukan', !empty($nama_ppk) ? $nama_ppk : null) !!}
							{!! Form::text('text_rujukan', !empty($kd_ppk) ? $kd_ppk.' / '.$nama_ppk : null, ['class' => 'form-control', 'readonly'=>true, 'style'=>'background:#fafafa;']) !!}
							<small class="text-danger">{{ $errors->first('ppk_rujukan') }}</small>
					</div>
			</div>
			<div class="form-group{{ $errors->has('catatan_bpjs') ? ' has-error' : '' }}">
					{!! Form::label('catatan_bpjs', 'Catatan BPJS', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
							{!! Form::text('catatan_bpjs', !empty($no_rm) ? $no_rm :session('no_rm'), ['class' => 'form-control']) !!}
							<small class="text-danger">{{ $errors->first('catatan_bpjs') }}</small>
					</div>
			</div>
			<div class="form-group{{ $errors->has('diagnosa_awal') ? ' has-error' : '' }}">
					{!! Form::label('diagnosa_awal', 'Diagnosa Awal', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-2" style="padding-right:0;">
							{!! Form::text('diagnosa_awal', $diagnosa_kode, ['class' => 'form-control', 'id'=>'diagnosa_awal']) !!}
							<small class="text-danger">{{ $errors->first('diagnosa_awal') }}</small>
					</div>
					<div class="col-sm-6" style="padding-left:0;">
							{!! Form::text('diagnosa_text', $diagnosa_nama, ['class' => 'form-control', 'readonly'=>true, 'id'=>'diagnosa_text']) !!}
					</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group{{ $errors->has('jenis_layanan') ? ' has-error' : '' }}">
					{!! Form::label('jenis_layanan', 'Jenis Layanan', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
							{!! Form::select('jenis_layanan', ['2'=>'Rawat Jalan'], 2, ['class' => 'form-control select2']) !!}
							<small class="text-danger">{{ $errors->first('jenis_layanan') }}</small>
					</div>
			</div>
			<div class="form-group{{ $errors->has('jkn') ? ' has-error' : '' }}">
					{!! Form::label('jkn', 'JKN', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
							{!! Form::select('jkn', ['PBI'=>'PBI', 'NON PBI'=>'NON PBI'], null, ['class' => 'form-control select2']) !!}
							<small class="text-danger">{{ $errors->first('jkn') }}</small>
					</div>
			</div>
			<div class="form-group{{ $errors->has('poli_bpjs') ? ' has-error' : '' }}">
					{!! Form::label('poli_bpjs', 'Poli BPJS', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">									
							@php
								if($kode_poli==null){
									$data_polibpjs = Modules\Poli\Entities\Poli::find($reg->poli_id)->bpjs;
								}else{
									$data_polibpjs = $kode_poli;
								}
							@endphp
							<select class="form-control form-control select2" name="poli_bpjs" id="poli_bpjs">
								<option value=""></option>
								@if($poli!=null)
									@foreach($poli as $key => $data)
										<option {{ ($data_polibpjs==$data->bpjs) ? 'selected' : '' }} value="{{ $data->bpjs }}">{{ $data->nama }}</option>
									@endforeach
								@endif
							</select>
							<small class="text-danger">{{ $errors->first('poli_bpjs') }}</small>
					</div>
			</div>
			<div class="form-group{{ $errors->has('hak_kelas') ? ' has-error' : '' }}">
					{!! Form::label('hak_kelas', 'Hak Kelas', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
							{!! Form::select('hak_kelas', [1=>1,2=>2,3=>3],!empty($hak_kelas) ? $hak_kelas : null, ['class' => 'form-control', 'type' => 'number']) !!}
							<small class="text-danger">{{ $errors->first('hak_kelas') }}</small>
					</div>
			</div>
			<div class="form-group{{ $errors->has('cob') ? ' has-error' : '' }}">
				{!! Form::label('cob', 'COB', ['class' => 'col-sm-4']) !!}
				<div class="col-sm-8">
						{!! Form::select('cob', ['0'=>'Tidak', '1'=>'Ya'], $cob, ['class' => 'form-control select2', 'readonly'=>true]) !!}
						<small class="text-danger">{{ $errors->first('cob') }}</small>
				</div>
			</div>
			<div class="form-group{{ $errors->has('katarak') ? ' has-error' : '' }}">
				{!! Form::label('katarak', 'Katarak', ['class' => 'col-sm-4']) !!}
				<div class="col-sm-8">
						{!! Form::select('katarak', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2']) !!}
						<small class="text-danger">{{ $errors->first('katarak') }}</small>
				</div>
			</div>
			<div class="form-group{{ $errors->has('laka_lantas') ? ' has-error' : '' }}">
				{!! Form::label('laka_lantas', 'Laka Lantas', ['class' => 'col-sm-4']) !!}
				<div class="col-sm-8">
						{!! Form::select('laka_lantas', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2', 'onchange'=>'chLaka(this.value)']) !!}
						<small class="text-danger">{{ $errors->first('laka_lantas') }}</small>
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('no_surat_kontrol', 'No. Surat Kontrol', ['class' => 'col-sm-4']) !!}
				<div class="col-sm-8">
						{!! Form::text('no_surat_kontrol', $reg->no_surat_kontrol, ['class' => 'form-control', 'readonly'=>true]) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('kode_dpjp', 'Kode DPJP', ['class' => 'col-sm-4']) !!}
				<div class="col-sm-8">
					<select class="form-control select2" name="kode_dpjp" id="kode_dpjp">
						<option value=""></option>
						@if($status_reg=="J" OR $status_reg=="G")
							@if($dokter_dpjp!=null)
								@foreach($dokter_dpjp as $key => $data)
									<option value="{{ $data->kode }}">{{ strtoupper($data->nama) }}</option>
								@endforeach
							@endif
						@else
							@if($dokter_dpjp!=null)
								@foreach($dokter_dpjp as $key => $data)
									<option {{ ($reg->dokter_id==$data['id']) ? 'selected' : '' }} value="{{ $data['kode']}}">{{ strtoupper($data['nama']) }}</option>
								@endforeach
							@endif
						@endif
					</select>
				</div>
			</div>
		</div>
		<div id="laka">
			<div class="col-md-12">
				<hr style="margin-bottom:5px;">
				<center><h3 style="margin-top:5px;margin-bottom:15px;">Data Laka Lantas</h3></center>
			</div>
			<div class="col-md-6">
				<div class="form-group{{ $errors->has('penjamin') ? ' has-error' : '' }}">
					{!! Form::label('penjamin', 'Penjamin', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
						{!! Form::select('penjamin', ['0'=>'', '1'=>'Jasa Raharja', '2'=>'BPJS Ketenagakerjaan', '3'=>'TASPEN', '4'=>'ASABRI PT'], null, ['class' => 'form-control select2']) !!}
						<small class="text-danger">{{ $errors->first('penjamin') }}</small>
					</div>
				</div>
				<div class="form-group{{ $errors->has('tgl_kejadian') ? ' has-error' : '' }}">
					{!! Form::label('tgl_kejadian', 'Tgl Kejadian', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
						{!! Form::text('tgl_kejadian', null, ['class' => 'form-control datepicker']) !!}
						<small class="text-danger">{{ $errors->first('tgl_kejadian') }}</small>
					</div>
				</div>
				<div class="form-group{{ $errors->has('keterangan_laka') ? ' has-error' : '' }}">
					{!! Form::label('keterangan_laka', 'Keterangan Laka', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
						{!! Form::text('keterangan_laka', null, ['class' => 'form-control']) !!}
						<small class="text-danger">{{ $errors->first('keterangan_laka') }}</small>
					</div>
				</div>
				<div class="form-group{{ $errors->has('suplesi') ? ' has-error' : '' }}">
					{!! Form::label('suplesi', 'Suplesi', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
						{!! Form::select('suplesi', ['0'=>'Tidak', '1'=>'Ya'], null, ['class' => 'form-control select2']) !!}
						<small class="text-danger">{{ $errors->first('suplesi') }}</small>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					{!! Form::label('no_suplesi', 'No Suplesi', ['class' => 'col-sm-4']) !!}
					<div class="col-sm-8">
						{!! Form::text('no_suplesi', null, ['class' => 'form-control']) !!}
					</div>
				</div>						
				<div class="form-group">
						{!! Form::label('bpjs_province_id', 'Propinsi', ['class' => 'col-sm-4']) !!}
						<div class="col-sm-8">
								<select class="form-control form-control select2" name="bpjs_province_id" id="bpjs_province_id">
									<option value=""></option>
									@if($provinsi!=null)
										@foreach($provinsi as $key => $data)
											<option value="{{ $data->kode }}">{{ $data->nama }}</option>
										@endforeach
									@endif
							</select>
						</div>
				</div>
				<div class="form-group">
						{!! Form::label('bpjs_regency_id', 'Kabupaten', ['class' => 'col-sm-4']) !!}
						<div class="col-sm-8">
								<select class="form-control select2" name="bpjs_regency_id" id="bpjs_regency_id">
									<option value=""></option>
								</select>
						</div>
				</div>
				<div class="form-group">
						{!! Form::label('bpjs_district_id', 'Kecamatan', ['class' => 'col-sm-4']) !!}
						<div class="col-sm-8">
							<select class="form-control select2" name="bpjs_district_id" id="bpjs_district_id">
								<option value=""></option>
							</select>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="box-footer" style="padding-top:20px;">
	<div class="col-md-7">
		<div class="form-group {{ $errors->has('no_sep') ? ' has-error' : '' }}">
			<div class="col-sm-3">
			<button type="button" id="createSEP" class="btn btn-flat btn-primary"><i class="fa fa-recycle"></i> BUAT SEP</button>
			</div>
			<div class="col-sm-9" id="fieldSEP">
				{!! Form::text('no_sep', null, ['class' => 'form-control', 'readonly'=>true, 'id'=>'noSEP']) !!}
				<small class="text-danger">{{ $errors->first('no_sep') }}</small>
			</div>                  
		</div>
	</div>
	<div class="col-md-5">
		<div class="btn-group pull-right">
			{!! Form::submit("SIMPAN", ['class' => 'btn btn-flat btn-success']) !!}
		</div>
	</div>
</div>