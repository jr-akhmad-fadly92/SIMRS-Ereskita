<form method="POST" id="Register" class="form-horizontal">
	{{ csrf_field() }} {{ method_field('POST') }}
	{!! Form::hidden('registrasi_id', null) !!}
	{!! Form::hidden('carabayar_id', null) !!}
	{!! Form::hidden('status_reg', null) !!}
	{!! Form::hidden('no_rm', null) !!}
	<div class="hidden" id="pasienJKN">
		{{-- progress bar --}}
		<div class="progress progress-md active hidden">
			<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
				<span class="sr-only">87% Complete</span> Loading...
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="background:#f9f9f9;padding:10px 0;margin-bottom:10px;">
				<div class="form-group no-margin" id="statusNoJKN">
						<div class="col-sm-3"></div>
						<div class="col-sm-3 no-padding">
								{!! Form::text('no_bpjs_search', null, ['placeholder'=>'Nomor BPJS', 'class' => 'form-control']) !!}
								<small class="text-danger">{{ $errors->first('no_bpjs_search') }}</small>
						</div>
						<div class="col-sm-3 no-padding">
							<button class="btn btn-success btn-block form-control" id="cekStatus"><i class="fa "></i> CEK PESERTA JKN</button>
						</div>
						<div class="col-sm-3"></div>
				</div>
			</div>
			
			<!-- FORM SEP INAP -->
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group{{ $errors->has('no_tlp') ? ' has-error' : '' }}">
								{!! Form::label('no_tlp', 'No. HP', ['class' => 'col-sm-4']) !!}
								<div class="col-sm-8">
										{!! Form::text('no_tlp', '', ['class' => 'form-control']) !!}
										<small class="text-danger">{{ $errors->first('no_tlp') }}</small>
								</div>
						</div>
						<div class="form-group{{ $errors->has('no_bpjs') ? ' has-error' : '' }}">
								{!! Form::label('no_bpjs', 'No. Kartu BPJS', ['class' => 'col-sm-4']) !!}
								<div class="col-sm-8">
										{!! Form::text('no_bpjs', '', ['class' => 'form-control', 'readonly'=>true]) !!}
										<small class="text-danger">{{ $errors->first('no_bpjs') }}</small>
								</div>
						</div>
						<div class="form-group{{ $errors->has('no_rujukan') ? ' has-error' : '' }}">
								{!! Form::label('no_rujukan', 'No. Rujukan', ['class' => 'col-sm-4']) !!}
								<div class="col-sm-8">
										{!! Form::text('no_rujukan_ranap', null, ['class' => 'form-control', 'readonly'=>true]) !!}
										<small class="text-danger">{{ $errors->first('no_rujukan') }}</small>
								</div>
						</div>
						<div class="form-group{{ $errors->has('catatan_bpjs') ? ' has-error' : '' }}">
								{!! Form::label('catatan_bpjs', 'Catatan BPJS', ['class' => 'col-sm-4']) !!}
								<div class="col-sm-8">
										{!! Form::text('catatan_bpjs', '', ['class' => 'form-control']) !!}
										<small class="text-danger">{{ $errors->first('catatan_bpjs') }}</small>
								</div>
						</div>
						<div class="form-group{{ $errors->has('jenis_layanan') ? ' has-error' : '' }}">
								{!! Form::label('jenis_layanan', 'Jenis Layanan', ['class' => 'col-sm-4']) !!}
								<div class="col-sm-8">
										{!! Form::select('jenis_layanan', ['1'=>'Rawat Inap'], 1, ['class' => 'form-control', 'readonly'=>true]) !!}
										<small class="text-danger">{{ $errors->first('jenis_layanan') }}</small>
								</div>
						</div>
						<div class="form-group{{ $errors->has('diagnosa_awal') ? ' has-error' : '' }}">
								{!! Form::label('diagnosa_awal', 'Diagnosa Awal', ['class' => 'col-sm-4']) !!}
								<div class="col-sm-2" style="padding-right:0;">
										{!! Form::text('diagnosa_awal', null, ['class' => 'form-control', 'id'=>'diagnosa_awal']) !!}
										<small class="text-danger">{{ $errors->first('diagnosa_awal') }}</small>
								</div>
								<div class="col-sm-6" style="padding-left:0;">
										{!! Form::text('diagnosa_text', null, ['class' => 'form-control', 'readonly'=>true, 'id'=>'diagnosa_text']) !!}
								</div>
						</div>
						<div class="form-group{{ $errors->has('asalRujukan') ? ' has-error' : '' }}">
								{!! Form::label('asalRujukan', 'Asal Rujukan', ['class' => 'col-sm-4']) !!}
								<div class="col-sm-8">
										{!! Form::select('asalRujukan', ['0'=>'', '1'=>'PPK 1', '2'=>'RS'], 2, ['class' => 'form-control']) !!}
										<small class="text-danger">{{ $errors->first('asalRujukan') }}</small>
								</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group{{ $errors->has('jkn') ? ' has-error' : '' }}">
								{!! Form::label('jkn', 'JKN', ['class' => 'col-sm-4']) !!}
								<div class="col-sm-8">
										{!! Form::select('jkn', ['PBI'=>'PBI', 'NON PBI'=>'NON PBI'], '', ['class' => 'form-control']) !!}
										<small class="text-danger">{{ $errors->first('jkn') }}</small>
								</div>
						</div>
						<input type="hidden" name="poli_bpjs" value="">
						<div class="form-group{{ $errors->has('hak_kelas') ? ' has-error' : '' }}">
								{!! Form::label('hak_kelas', 'Hak Kelas Inap', ['class' => 'col-sm-4']) !!}
								<div class="col-sm-8">
									{!! Form::hidden('hak_kelas_default', null) !!}
									{!! Form::select('hak_kelas', [1=>1,2=>2,3=>3], null, ['class' => 'form-control']) !!}
									<small class="text-danger">{{ $errors->first('hak_kelas') }}</small>
								</div>
						</div>
						<div class="form-group{{ $errors->has('cob') ? ' has-error' : '' }}">
							{!! Form::label('cob', 'COB', ['class' => 'col-sm-4']) !!}
							<div class="col-sm-8">
									{!! Form::hidden('cob', null) !!}
									{!! Form::text('cob_text', '', ['class' => 'form-control', 'readonly'=>true]) !!}
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
									{!! Form::text('no_surat_kontrol', null, ['class' => 'form-control', 'readonly'=>true]) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('kode_dpjp', 'Kode DPJP', ['class' => 'col-sm-4']) !!}
							<div class="col-sm-8">
								<select class="form-control select2" name="kode_dpjp" id="kode_dpjp" style="width:100%;">
									<option value=""></option>
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
									</select>
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('bpjs_regency_id', 'Kabupaten', ['class' => 'col-sm-4']) !!}
								<div class="col-sm-8">
									<select class="form-control select2" name="bpjs_regency_id" id="bpjs_regency_id" style="width:100%;">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('bpjs_district_id', 'Kecamatan', ['class' => 'col-sm-4']) !!}
								<div class="col-sm-8">
									<select class="form-control select2" name="bpjs_district_id" id="bpjs_district_id" style="width:100%;">
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
			</div>
			<!-- FORM SEP INAP -->
		</div>
	</div>
	{!! Form::hidden('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
	<br>
	<div class="pull-right" >
		<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">TUTUP</button>
		<button type="button" id="submitSepRanap" class="btn btn-success btn-flat">SIMPAN</button>
	</div>
{!! Form::close() !!}
<br>
<br>
