@extends('master')

@section('header')
  <h1>Bridging INACBG E-Klaim 5.2 {{ (substr($reg->status_reg,0,1)=="I") ? 'Rawat Inap' : 'Rawat Jalan' }} <small></small></h1>
@endsection
<style type="text/css">
.grouper-bg{
	padding:10px;
	border-bottom: solid 1px #eee;
}
</style>
@section('content')
{!! Form::open(['method' => 'POST', 'url' => '/eklaim/new-claim', 'class' => 'form-horizontal', 'id'=>'formINACBG']) !!}
  <div class="box box-primary">
    <div class="box-header with-border">
			<a onclick="return confirm('Apakah yakin data akan dihapus?')" href="{{ url('eklaim/hapus-data-pasien/'.$reg->id.'/'.$reg->pasien->no_rm.'/'.config('app.coder_nik')) }}" class="btn btn-danger pull-right">Hapus Pasien</a>
      <h4 style="margin:5px 0;">Data Pasien {{(substr($reg->status_reg,0,1)=="I") ? 'Rawat Inap' : 'Rawat Jalan'}}</h4>
    </div>
		<input type="hidden" name="special_cmg" id="special_cmg" value="{{ (isset($inacbg)) ? $inacbg->special_cmg : '' }}">
    <div class="box-body">
			{!! Form::hidden('registrasi_id', $reg->id) !!}
			{!! Form::hidden('gender', ($reg->pasien->kelamin == 'L') ? 1 : 2) !!}
			{!! Form::hidden('jenis_rawat', (substr($reg->status_reg,0,1)=="I") ? 1 : 2) !!}
			@if(substr($reg->status_reg,0,1)!="I")
				{!! Form::hidden('adl_sub_acute', '-') !!}
				{!! Form::hidden('adl_chronic', '-') !!}
				{!! Form::hidden('icu_indikator', '-') !!}
				{!! Form::hidden('icu_los', 0) !!}
				{!! Form::hidden('ventilator_hour', 0) !!}
				{!! Form::hidden('upgrade_class_ind', 0) !!}
				{!! Form::hidden('upgrade_class_class', 0) !!}
				{!! Form::hidden('upgrade_class_los', 0) !!}
				{!! Form::hidden('add_payment_pct', 0) !!}
			@endif
			{!! Form::hidden('tarif_poli_eks', 0) !!}
			{!! Form::hidden('payor_id', config('app.payor_id')) !!}
			{!! Form::hidden('payor_cd', config('app.payor_cd')) !!}
			{!! Form::hidden('cob_cd', config('app.cob_cd')) !!}
			{!! Form::hidden('coder_nik', config('app.coder_nik')) !!}

			<div class="row">
				<div class="col-md-2" style="padding-right:0;">
					<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
						{!! Form::label('nama', 'Nama Pasien', ['class' => 'col-sm-12']) !!}
						<div class="col-sm-12">
							{!! Form::text('nama', $reg->pasien->nama, ['class' => 'form-control', 'readonly'=>true, 'style'=>'background:white;']) !!}
							<small class="text-danger">{{ $errors->first('nama') }}</small>
						</div>
					</div>
				</div>
				<div class="col-md-2" style="padding-right:0;">
					<div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
						{!! Form::label('no_rm', 'No. RM', ['class' => 'col-sm-12']) !!}
						<div class="col-sm-12">
							{!! Form::text('no_rm', $reg->pasien->no_rm, ['class' => 'form-control', 'readonly'=>true, 'style'=>'background:white;']) !!}
							<small class="text-danger">{{ $errors->first('no_rm') }}</small>
						</div>
					</div>
				</div>
				<div class="col-md-2" style="padding-right:0;">
					<div class="form-group{{ $errors->has('tgllahir') ? ' has-error' : '' }}">
						{!! Form::label('tgllahir', 'Tgl Lahir', ['class' => 'col-sm-12']) !!}
						<div class="col-sm-12">
							{!! Form::hidden('tgllahir', $reg->pasien->tgllahir) !!}
							{!! Form::text('tgllahir_text', $reg->pasien->tgllahir, ['class' => 'form-control', 'disabled'=>true, 'style'=>'background:white;']) !!}
							<small class="text-danger">{{ $errors->first('tgllahir') }}</small>
						</div>
					</div>
				</div>
				<div class="col-md-2" style="padding-right:0;">
					<div class="form-group{{ $errors->has('umur') ? ' has-error' : '' }}">
						{!! Form::label('umur', 'Umur', ['class' => 'col-sm-12']) !!}
						<div class="col-sm-12">
							{!! Form::text('umur', hitung_umur($reg->pasien->tgllahir), ['class' => 'form-control', 'readonly'=>true, 'style'=>'background:white;']) !!}
							<small class="text-danger">{{ $errors->first('umur') }}</small>
						</div>
					</div>
				</div>
				<div class="col-md-2" style="padding-right:0;">
					<div class="form-group" id="groupNoKartu">
						{!! Form::label('no_kartu', 'No. Kartu', ['class' => 'col-sm-12']) !!}
						<div class="col-sm-12">
							{!! Form::text('no_kartu', $reg->no_jkn, ['class' => 'form-control']) !!}
							<small id="no_kartu-error" class="text-danger"></small>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group" id="groupSEP">
						{!! Form::label('no_sep', 'No. SEP', ['class' => 'col-sm-12']) !!}
						<div class="col-sm-12">
							{!! Form::text('no_sep', $reg->no_sep, ['class' => 'form-control']) !!}
							<small id="no_sep-error" class="text-danger"></small>
						</div>
					</div>
				</div>				
			</div>
			<div id="divKlaimBaru" class="col-md-12" style="padding:10px;margin:10px 0;background:#fafafa;height:50px;">
				<center><a id="btnKlaimBaru" href="#" class="btn btn-success">Buat Klaim Baru</a></center>
			</div>
			<div class="modal fade" id="modalRincianBiaya" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id=""></h4>
						</div>
						<div class="modal-body">
							<div class='table-responsive'>
								<table class='table table-striped table-bordered table-hover table-condensed'>
									<thead>
										<tr>
											<th>No</th>
											<th>Tindakan</th>
											<th>Jenis Pelayanan</th>
											<th>Tagihan</th>
										</tr>
									</thead>
									<tbody class="tagihan">
									</tbody>
								</table>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="progress progress-md active hidden">
		<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
			<span class="sr-only">97% Complete</span> Mengambil detail klaim...
		</div>
	</div>
	
  <div class="box box-primary" id="dataDetailClaim" style="display:none;">
    <div class="box-header with-border">
			<a id="btn-hapus-klaim" onclick="return confirm('Apakah yakin klaim akan dihapus?')" href="{{ url('eklaim/hapus-data-klaim/'.$reg->id.'/'.$reg->no_sep.'/'.config('app.coder_nik')) }}" class="btn btn-danger pull-right">Hapus Klaim</a>
			@isset($inacbg)
				@if($inacbg->final_klaim=='N')
				@endif
			@endisset
      <h4 style="margin:5px 0;">Tarif RS</h4>
    </div>		
    <div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group{{ $errors->has('birth_weight') ? ' has-error' : '' }}">
						{!! Form::label('beratlahir', 'Berat Lahir', ['class' => 'col-sm-4 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('birth_weight', ($inacbg!=null) ? $inacbg->berat : $reg->berat_badan, ['class' => 'form-control']) !!}
							<small class="text-danger">{{ $errors->first('birth_weight') }}</small>
						</div>
					</div>
					<div class="form-group{{ $errors->has('nama_dokter') ? ' has-error' : '' }}">
						{!! Form::label('nama_dokter', 'Dokter DPJP', ['class' => 'col-sm-4 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('nama_dokter', baca_dokter($reg->dokter_id), ['class' => 'form-control', 'readonly'=>true]) !!}
							<small class="text-danger">{{ $errors->first('nama_dokter') }}</small>
						</div>
					</div>
					<div class="form-group{{ $errors->has('discharge_status') ? ' has-error' : '' }}">
						{!! Form::label('discharge_status', 'Cara Pulang', ['class' => 'col-sm-4 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::hidden('discharge_status', $reg->kondisi_akhir_pasien) !!}
							{!! Form::text('discharge_status_text', ($reg->kondisi_akhir_pasien!=null) ? App\KondisiAkhirPasien::find($reg->kondisi_akhir_pasien)->namakondisi : '', ['class' => 'form-control', 'readonly'=>true]) !!}
							<small class="text-danger">{{ $errors->first('discharge_status') }}</small>
						</div>
					</div>
					<div class="form-group" id="groupKelas">
						{!! Form::label('kelas_rawat', 'Kelas Rawat', ['class' => 'col-sm-4 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::select('kelas_rawat', [1=>1, 2=>2, 3=>3], ($inacbg!=null) ? $inacbg->kelas_perawatan : $reg->hak_kelas_inap, ['class' => 'form-control']) !!}
							<small id="hakkelas-error" class="text-danger"></small>
						</div>
					</div>	
				</div>				
				<div class="col-md-6">
					<div class="form-group{{ $errors->has('tgl_masuk') ? ' has-error' : '' }}">
						{!! Form::label('tgl_masuk', 'Tgl Masuk', ['class' => 'col-sm-4 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('tgl_masuk', $reg->created_at, ['class' => 'form-control', 'required' => 'required', 'readonly'=>true]) !!}
							<small class="text-danger">{{ $errors->first('tgl_masuk') }}</small>
						</div>
					</div>
					<div class="form-group{{ $errors->has('tgl_pulang') ? ' has-error' : '' }}">
						{!! Form::label('tgl_pulang', 'Tgl Pulang', ['class' => 'col-sm-4 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('tgl_pulang', $reg->tgl_pulang, ['class' => 'form-control', 'required' => 'required', 'readonly'=>true]) !!}
							<small class="text-danger">{{ $errors->first('tgl_pulang') }}</small>
						</div>
					</div>
					@php
						$tarif = Modules\Registrasi\Entities\Folio::where('registrasi_id', $reg->id)->sum('total');
					@endphp
					<div class="form-group{{ $errors->has('tarif_rs') ? ' has-error' : '' }}">
						{!! Form::label('tarif_rs', 'Tarif RS', ['class' => 'col-sm-4 control-label']) !!}
						<div class="col-sm-6" style="padding-right:0;">
							{!! Form::hidden('tarif_rs', total_tagihan($reg->id,'Y')) !!}
							{!! Form::text('tarif_rs_text', 0, ['class' => 'form-control', 'readonly'=>true, 'style' => 'background:#f9f9f9;font-weight:bold;']) !!}
							<small class="text-danger">{{ $errors->first('tarif_rs') }}</small>
						</div>
						<div class="col-sm-2">
							<span class="input-group-btn">
								<button type="button" onclick="rincianBiaya({{ $reg->id }}, '{{ $reg->pasien->nama }}', '{{ $reg->pasien->no_rm }}' )" class="btn btn-default btn-block"><i class="fa fa-search"></i> RB</button>
							</span>
						</div>
					</div>
					<div class="form-group{{ $errors->has('kode_tarif') ? ' has-error' : '' }}">
						{!! Form::label('kode_tarif', 'Tipe RS', ['class' => 'col-sm-4 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('kode_tarif', config('app.kode_tarif'), ['class' => 'form-control', 'readonly'=>true]) !!}
							<small class="text-danger">{{ $errors->first('kode_tarif') }}</small>
						</div>
					</div>
				</div>
				
				@if(substr($reg->status_reg,0,1)=="I")				
					<div class="col-md-12">
						<hr style="margin:10px 0 15px 0;">
					</div>
					<div class="col-md-4">
						<div class="form-group{{ $errors->has('adl_sub_acute') ? ' has-error' : '' }}">
								{!! Form::label('adl_sub_acute', 'ADL Sub Acute', ['class' => 'col-sm-4 control-label']) !!}
								<div class="col-sm-8">
										<select name="adl_sub_acute" class="form-control select2" >
											<option value="-">-</option>
											@for ($i = 12; $i <= 60 ; $i++)
												<option value="{{ $i }}">{{ $i }}</option>
											@endfor
										</select>
										<small class="text-danger">{{ $errors->first('adl_sub_acute') }}</small>
								</div>
						</div>
						<div class="form-group{{ $errors->has('adl_chronic') ? ' has-error' : '' }}">
								{!! Form::label('adl_chronic', 'ADL Chronic', ['class' => 'col-sm-4 control-label']) !!}
								<div class="col-sm-8">
										<select name="adl_chronic" class="form-control select2" >
											<option value="-">-</option>
											@for ($i = 12; $i <= 60 ; $i++)
												<option value="{{ $i }}">{{ $i }}</option>
											@endfor
										</select>
										<small class="text-danger">{{ $errors->first('adl_chronic') }}</small>
								</div>
						</div>
						<div class="form-group{{ $errors->has('icu_indikator') ? ' has-error' : '' }}">
								{!! Form::label('icu_indikator', 'ICU Indikator', ['class' => 'col-sm-4 control-label']) !!}
								<div class="col-sm-8">
										<select name="icu_indikator" class="form-control select2" >
											<option value="-">-</option>
											@for ($i = 0; $i <= 100 ; $i++)
												<option value="{{ $i }}">{{ $i }}</option>
											@endfor
										</select>
										<small class="text-danger">{{ $errors->first('icu_indikator') }}</small>
								</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group{{ $errors->has('icu_los') ? ' has-error' : '' }}">
								{!! Form::label('icu_los', 'ICU LOS', ['class' => 'col-sm-4 control-label']) !!}
								<div class="col-sm-8">
										<select name="icu_los" class="form-control select2" >
											<option value="-">-</option>
											@for ($i = 0; $i <= 100 ; $i++)
												<option value="{{ $i }}">{{ $i }}</option>
											@endfor
										</select>
										<small class="text-danger">{{ $errors->first('icu_los') }}</small>
								</div>
						</div>
						<div class="form-group{{ $errors->has('ventilator_hour') ? ' has-error' : '' }}">
								{!! Form::label('ventilator_hour', 'Ventilator hours', ['class' => 'col-sm-4 control-label']) !!}
								<div class="col-sm-8">
										<select name="ventilator_hour" class="form-control select2" >
											<option value="-">-</option>
											@for ($i = 0; $i <= 100 ; $i++)
												<option value="{{ $i }}">{{ $i }}</option>
											@endfor
										</select>
										<small class="text-danger">{{ $errors->first('ventilator_hour') }}</small>
								</div>
						</div>
						<div class="form-group{{ $errors->has('upgrade_class_ind') ? ' has-error' : '' }}">
								{!! Form::label('upgrade_class_ind', 'Upgrade Class Ind', ['class' => 'col-sm-4 control-label']) !!}
								<div class="col-sm-8">
										<select name="upgrade_class_ind" class="form-control select2" >
											<option value="-">-</option>
											@for ($i = 0; $i <= 3 ; $i++)
												<option value="{{ $i }}">{{ $i }}</option>
											@endfor
										</select>
										<small class="text-danger">{{ $errors->first('upgrade_class_ind') }}</small>
								</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group{{ $errors->has('upgrade_class_class') ? ' has-error' : '' }}">
								{!! Form::label('upgrade_class_class', 'Upgrade Class Class', ['class' => 'col-sm-4 control-label']) !!}
								<div class="col-sm-8">
										<select name="upgrade_class_class" class="form-control select2" >
											<option value="-">-</option>
											@for ($i = 0; $i <= 3 ; $i++)
												<option value="{{ $i }}">{{ $i }}</option>
											@endfor
										</select>
										<small class="text-danger">{{ $errors->first('upgrade_class_class') }}</small>
								</div>
						</div>
						<div class="form-group{{ $errors->has('upgrade_class_los') ? ' has-error' : '' }}">
								{!! Form::label('upgrade_class_los', 'Upgrade Class Los', ['class' => 'col-sm-4 control-label']) !!}
								<div class="col-sm-8">
										<select name="upgrade_class_los" class="form-control select2" >
											<option value="-">-</option>
											@for ($i = 0; $i <= 25 ; $i++)
												<option value="{{ $i }}">{{ $i }}</option>
											@endfor
										</select>
										<small class="text-danger">{{ $errors->first('upgrade_class_los') }}</small>
								</div>
						</div>
						<div class="form-group{{ $errors->has('add_payment_pct') ? ' has-error' : '' }}">
								{!! Form::label('add_payment_pct', 'Add Payment PCT', ['class' => 'col-sm-4 control-label']) !!}
								<div class="col-sm-8">
										<select name="add_payment_pct" class="form-control select2" >
											<option value="-">-</option>
											@for ($i = 0; $i <= 5 ; $i++)
												<option value="{{ $i }}">{{ $i }}</option>
											@endfor
										</select>
										<small class="text-danger">{{ $errors->first('add_payment_pct') }}</small>
								</div>
						</div>
					</div>
				@endif
				
				<div class="col-md-12">
					<hr style="margin:10px 0 15px 0;">
				</div>
				
				<div class="col-md-3">
					<div class="form-group{{ $errors->has('prosedur_non_bedah') ? ' has-error' : '' }}">
						{!! Form::label('prosedur_non_bedah', 'Prosedur Non Bedah', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('prosedur_non_bedah', $prosedur_non_bedah, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
					<div class="form-group{{ $errors->has('tenaga_ahli') ? ' has-error' : '' }}">
						{!! Form::label('tenaga_ahli', 'Tenaga Ahli', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('tenaga_ahli', $tenaga_ahli, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
					<div class="form-group{{ $errors->has('radiologi') ? ' has-error' : '' }}">
						{!! Form::label('radiologi', 'Radiologi', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('radiologi', $radiologi, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
					<div class="form-group{{ $errors->has('rehabilitasi') ? ' has-error' : '' }}">
						{!! Form::label('rehabilitasi', 'Rehabilitasi', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('rehabilitasi', $rehabilitasi, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group{{ $errors->has('obat') ? ' has-error' : '' }}">
						{!! Form::label('obat', 'Obat', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('obat', $obat, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
					<div class="form-group{{ $errors->has('sewa_alat') ? ' has-error' : '' }}">
						{!! Form::label('sewa_alat', 'Sewa Alat', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('sewa_alat', $sewa_alat, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
					<div class="form-group{{ $errors->has('prosedur_bedah') ? ' has-error' : '' }}">
						{!! Form::label('prosedur_bedah', 'Prosedur Bedah', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('prosedur_bedah', $prosedur_bedah, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
					<div class="form-group{{ $errors->has('keperawatan') ? ' has-error' : '' }}">
						{!! Form::label('keperawatan', 'Keperawatan', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('keperawatan', $keperawatan, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group{{ $errors->has('laboratorium') ? ' has-error' : '' }}">
						{!! Form::label('laboratorium', 'Laboratorium', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('laboratorium', $laboratorium, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
					<div class="form-group{{ $errors->has('kamar') ? ' has-error' : '' }}">
						{!! Form::label('kamar', 'Kamar', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('kamar', $kamar, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
					<div class="form-group{{ $errors->has('alkes') ? ' has-error' : '' }}">
						{!! Form::label('alkes', 'Alkes', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('alkes', $alkes, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
					<div class="form-group{{ $errors->has('konsultasi') ? ' has-error' : '' }}">
						{!! Form::label('konsultasi', 'Konsultasi', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('konsultasi', $konsultasi, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group{{ $errors->has('penunjang') ? ' has-error' : '' }}">
						{!! Form::label('penunjang', 'Penunjang', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('penunjang', $penunjang, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
					<div class="form-group{{ $errors->has('pelayanan_darah') ? ' has-error' : '' }}">
						{!! Form::label('pelayanan_darah', 'Pelayanan Darah', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('pelayanan_darah', $pelayanan_darah, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
					<div class="form-group{{ $errors->has('rawat_intensif') ? ' has-error' : '' }}">
						{!! Form::label('rawat_intensif', 'Rawat Intensif', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('rawat_intensif', $rawat_intensif, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
					<div class="form-group{{ $errors->has('bmhp') ? ' has-error' : '' }}">
						{!! Form::label('bmhp', 'BMHP', ['class' => 'col-sm-5 control-label']) !!}
						<div class="col-sm-7">
							{!! Form::number('bmhp', $bmhp, ['class' => 'form-control', 'readonlyxxx' => 'truexxx']) !!}
						</div>
					</div>
				</div>
				<div class="col-md-12" style="padding:10px 0;">
					<center><input type="checkbox" checked disabled="true"> Menyatakan benar bahwa data tarif yang tersebut di atas adalah benar sesuai dengan kondisi yang sesungguhnya.</center>
				</div>
				<div class="col-md-12">
					<div class="col-md-12 bg-aqua-active" style="padding:10px;margin:10px 0;height:auto;">
						<div class="col-md-6 no-padding">
							<div class="form-group" id="groupDiagnosa">
								{!! Form::label('diagnosa', 'Diagnosa ICD10', ['class' => 'col-sm-4 control-label']) !!}
								<div class="col-sm-6" style="padding-right:0;">
									{!! Form::text('diagnosa', ($inacbg!=null) ? $inacbg->icd1 : '', ['class' => 'form-control', 'onkeyup'=>'resetSepcmg()']) !!}
									<small class="text-danger" id="diagnosa-error"></small>
								</div>
								<div class="col-sm-2" style="padding-left:0;">
									<span class="input-group-btn">
										<button type="button" id="openICD10" class="btn btn-block btn-default">ICD10</button>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-6 no-padding">
							<div class="form-group" id="groupProcedure">
								{!! Form::label('procedure', 'Procedure ICD9', ['class' => 'col-sm-4 control-label']) !!}
								<div class="col-sm-6" style="padding-right:0;">
									{!! Form::text('procedure', ($inacbg!=null) ? $inacbg->prosedur1 : '', ['class' => 'form-control', 'onkeyup'=>'resetSepcmg()']) !!}
									<small class="text-danger" id="procedure-error"></small>
								</div>
								<div class="col-sm-2" style="padding-left:0;">
									<span class="input-group-btn">
										<button type="button" id="openICD9" class="btn btn-block btn-default">ICD9</button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div id="btn-grouper" class="col-md-12" style="padding:10px;margin:10px 0;background:#fafafa;height:50px;">
						<center>
							<button type="button" id="startGrouping" class="btn btn-success btn-flat">
								GROUPER
							</button>
						</center>
					</div>
				</div>
			</div>
    </div>
  </div>
	
	<div class="box box-primary" id="hasil-grouper" style="display:none;margin-top:10px;">
		<div class="box-header with-border">
			<h4 style="margin:5px 0;">Hasil Grouper</h4>
		</div>		
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12 grouper-bg">
						<div class="col-sm-2">Group</div>
						<div class="col-sm-4" id="grouper-group-desc"></div>
						<div class="col-sm-3" id="grouper-group-code"></div>
						<div class="col-sm-3 text-right" id="grouper-group-tarif"></div>
					</div>		
					<div class="col-md-12 grouper-bg">
						<div class="col-sm-2">Sub Acute</div>
						<div class="col-sm-4" id="grouper-subacute-desc"></div>
						<div class="col-sm-3" id="grouper-subacute-code"></div>
						<div class="col-sm-3 text-right" id="grouper-subacute-tarif"></div>
					</div>		
					<div class="col-md-12 grouper-bg">
						<div class="col-sm-2">Chronic</div>
						<div class="col-sm-4" id="grouper-chronic-desc"></div>
						<div class="col-sm-3" id="grouper-chronic-code"></div>
						<div class="col-sm-3 text-right" id="grouper-chronic-tarif"></div>
					</div>			
					<div class="col-md-12 grouper-bg">
						<div class="col-sm-2">Special Procedure</div>
						<div class="col-sm-4" id="grouper-specialprocedure-desc">
							<select id="special" name="specialprocedure" class="form-control special" onchange="startGroupingStage2(this.value,false,true)">
								<option>-</option>
							</select>
						</div>
						<div class="col-sm-3" id="grouper-specialprocedure-code"></div>
						<div class="col-sm-3 text-right" id="grouper-specialprocedure-tarif"></div>
					</div>			
					<div class="col-md-12 grouper-bg">
						<div class="col-sm-2">Special Prosthesis</div>
						<div class="col-sm-4" id="grouper-specialprosthesis-desc">
							<select id="special" name="specialprosthesis" class="form-control special" onchange="startGroupingStage2(this.value,false,true)">
								<option>-</option>
							</select>
						</div>
						<div class="col-sm-3" id="grouper-specialprosthesis-code"></div>
						<div class="col-sm-3 text-right" id="grouper-specialprosthesis-tarif"></div>
					</div>			
					<div class="col-md-12 grouper-bg">
						<div class="col-sm-2">Special Investigation</div>
						<div class="col-sm-4" id="grouper-specialinvestigation-desc">
							<select id="special" name="specialinvestigation" class="form-control special" onchange="startGroupingStage2(this.value,false,true)">
								<option>-</option>
							</select>
						</div>
						<div class="col-sm-3" id="grouper-specialinvestigation-code"></div>
						<div class="col-sm-3 text-right" id="grouper-specialinvestigation-tarif"></div>
					</div>			
					<div class="col-md-12 grouper-bg">
						<div class="col-sm-2">Special Drug</div>
						<div class="col-sm-4" id="grouper-specialdrug-desc">
							<select id="special" name="specialdrug" class="form-control special" onchange="startGroupingStage2(this.value,false,true)">
								<option>-</option>
							</select>
						</div>
						<div class="col-sm-3" id="grouper-specialdrug-code"></div>
						<div class="col-sm-3 text-right" id="grouper-specialdrug-tarif"></div>
					</div>
					<div class="col-md-12 bg-aqua-active" style="padding:10px;margin:10px 0;height:auto;">
						<div class="col-sm-2"></div>
						<div class="col-sm-4"></div>
						<div class="col-sm-3 text-right text-bold">TOTAL</div>
						<div class="col-sm-3 text-right text-bold" id="grouper-total-tarif"></div>
					</div>	
					<div class="col-md-12" style="padding:10px;margin:10px 0;background:#fafafa;height:50px;">
						<centerx>
							@isset($inacbg)
								@if($inacbg->kirim_dc=='Y')
									<button type="button" disabled class="btn btn-success btn-flat pull-right">
										<i class="fa fa-check"></i> SUDAH KIRIM DC
									</button>				
								@else
									<button type="button" id="startKirimDc" class="btn btn-success btn-flat pull-right">
										KIRIM DC
									</button>		
								@endif
								@if($inacbg->final_klaim=='Y')
									<button type="button" disabled class="btn btn-success btn-flat pull-right">
										<i class="fa fa-check"></i> SUDAH FINAL KLAIM
									</button>					
								@endif
							@endisset
							<button type="button" id="startFinalKlaim" class="btn btn-success btn-flat pull-right">
								FINAL KLAIM
							</button>
						</centerx>	
					</div>	
				</div>	
			</div>		
		</div>		
	</div>
	
	<div class="box box-primary" id="data-lpk" style="display:none;margin-top:10px;margin-bottom:100px;">
		<div class="box-header with-border">
			<h4 style="margin:5px 0;">Lembar Pengajuan Klaim</h4>
		</div>		
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">	
					<div class="col-md-3">	
						Ruang Rawat
						<select id="ruangrawat" name="ruangrawat" class="form-control select2" style="width:100%;">
							<option>-</option>
						</select>
					</div>	
					<div class="col-md-3">	
						Kelas Rawat
						<select id="kelasrawat" name="kelasrawat" class="form-control select2" style="width:100%;">
							<option>-</option>
						</select>
					</div>		
					<div class="col-md-3">
						Spesialistik
						<select id="spesialistik" name="spesialistik" class="form-control select2" style="width:100%;">
							<option>-</option>
						</select>
					</div>		
					<div class="col-md-3">	
						Pasca Pulang
						<select id="pascapulang" name="pascapulang" class="form-control select2" style="width:100%;">
							<option>-</option>
						</select>
					</div>	
				</div>	
				<div class="col-md-12" style="margin-top:10px;">	
					<div class="col-md-3">	
						Tindak Lanjut
						<select id="tindaklanjut" name="tindaklanjut" class="form-control select2" onchange="changeTindakLanjut(this.value)" style="width:100%;">
							<option>-- pilih tindak lanjut --</option>
							<option value="1">Diperbolehkan Pulang</option>
							<option value="2">Pemeriksaan Penunjang</option>
							<option value="3">Dirujuk ke</option>
							<option value="4">Kontrol Kembali</option>
						</select>
					</div>		
					<div class="col-md-3" id="ppk-rujukan" style="display:none;">	
						PPK Rujukan
						<input type="text" class="form-control" name="ppk_rujukan" value="{{$reg->ppk_rujukan}}" readonly="true">
					</div>			
					<div class="col-md-3" id="tanggal-kontrol" style="display:none;">	
						Tanggal Kontrol
						<input type="text" class="form-control datepicker" name="tanggalkontrol" value="">
					</div>				
					<div class="col-md-3" id="poli-kontrol" style="display:none;">	
						Poli
						<select id="polikontrol" name="polikontrol" class="form-control select2" style="width:100%;">
							<option>-</option>
						</select>
					</div>	
				</div>	
				<div class="col-md-12">	
					<div class="col-md-12" style="padding:10px;margin:10px 0;background:#fafafa;height:50px;">
						@if($inacbg->kirim_lpk=='Y')
							<button type="button" disabled class="btn btn-success btn-flat pull-right">
								<i class="fa fa-check"></i> SUDAH KIRIM LPK
							</button>					
						@else
							<button type="button" id="startKirimLpk" class="btn btn-success btn-flat pull-right">
								KIRIM LPK
							</button>
						@endif
					</div>					
				</div>					
			</div>		
		</div>		
	</div>
{!! Form::close() !!}

{{-- Modal ICD9 --}}
<div class="modal fade" id="icd9DATA" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id=""></h4>
			</div>
			<div class="modal-body">
				<div class='table-responsive'>
					<table id="icd9VIEW" class='table table-striped table-bordered table-hover table-condensed'>
						<thead>
							<tr>
								<th>Nomor</th>
								<th>Nama</th>
								<th>Input</th>
							</tr>
						</thead>

					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

{{-- modal icd10 --}}
<div class="modal fade" id="icd10DATA" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id=""></h4>
			</div>
			<div class="modal-body">
				<div class='table-responsive'>
					<table id="icd10VIEW" class='table table-striped table-bordered table-hover table-condensed'>
						<thead>
							<tr>
								<th>Nomor</th>
								<th>Nama</th>
								<th>Input</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

{{-- Modal Sukses --}}
<div class="modal fade" id="suksesReturn" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id=""></h4>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-condensed table-bordered table-hover">
						<tbody>
							<tr>
								<th>Total Biaya Perawatan</th><td id="total_rs"></td>
							</tr>
							<tr>
								<th>Total di Jamin INACBG</th><td id="dijamin"></td>
							</tr>
							<tr>
								<th>Kode Grouper</th><td id="kode"></td>
							</tr>
							<tr>
								<th>Deskripsi</th><td id="deskripsi_grouper"></td>
							</tr>
							<tr>
								<th>Final Klaim</th><td id="final_klaim"></td>
							</tr>
							<tr>
								<th>Kirim DC Kemenkes</th><td id="kirim_dc"></td>
							</tr>
							<tr>
								<th>Petugas Costing</th><td id="who_update"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
					<div class="btn-group btn-group-sm">
						<a href="" id="tombolCetak" class="btn btn-success btn-flat">CETAK BERKAS</a>
					</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog" style="top:30%!important;">
		<div class="modal-content">
			<div class="modal-body" style="padding:30px;"><center>
				<h5 class="no-margin" style="font-size:14px!important;">Sedang memproses...</h5>
				<div class="progress progress2 progress-md active" style="margin-top:7px;">
					<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
						<span class="sr-only">97% Complete</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
	setTimeout(function(){
		getDetailClaim();
	}, 100);
	function changeTindakLanjut(val){
		if(val==4){
			$("#tanggal-kontrol").fadeIn();
			$("#poli-kontrol").fadeIn();
			$("#ppk-rujukan").fadeOut();
		}else if(val==3){
			$("#tanggal-kontrol").fadeOut();
			$("#poli-kontrol").fadeOut();
			$("#ppk-rujukan").fadeIn();
		}else{
			$("#tanggal-kontrol").fadeOut();
			$("#poli-kontrol").fadeOut();
			$("#ppk-rujukan").fadeOut();
		}
	}
	
	function resetSepcmg(){
		$('input[name="special_cmg"]').val('')
		$('#hasil-grouper').fadeOut('right');
	}
	function getDetailClaim(){
		var sep = $('input[name="no_sep"]').val()
		var kartu = $('input[name="no_kartu"]').val()
		if(sep!="" && kartu!=""){
			$('.progress').removeClass('hidden')
			$.ajax({
				type: 'GET',
				url: '/inacbg/data-detail-per-claim/'+sep,
				dataType: 'json',
				data: null,
				success: function (data) {
					$('.progress').addClass('hidden')
					if(data.metadata.code==400){
						if(data.metadata.message=='Nomor SEP tidak ditemukan'){
							//$('#btnKlaimBaru').click();
						}
						alert(data.metadata.message)
					}else{
						if(data.response.data.kemenkes_dc_status_cd=='sent'){
							$("#data-lpk").fadeIn('top');
							getDataLpk();
						}
						if(data.response.data.klaim_status_cd=='final'){
							$("#btn-hapus-klaim").fadeOut('right');
							$("#btn-grouper").fadeOut('right');
							$("#startFinalKlaim").fadeOut('right');
							$("#hasil-grouper").fadeIn('left');
							$("#hasil-grouper").focus();
							console.log(data)
							setDataClaim(data.response.data.grouper.response, data.response.data.grouper.response.special_cmg, false, true);							
						}else{
							$('#startGrouping').click();
						}
						$('#dataDetailClaim').fadeIn('top');
						$('#divKlaimBaru').hide();
					}
				}
			});
		}
	}
	function getDataLpk(){
		$.ajax({
			type: 'GET',
			url: '/sep/data-lpk/'+$('input[name="registrasi_id"]').val(),
			dataType: 'json',
			data: null,
			success: function (data) {
				var ruangrawat = '';
				if(data.lpk.ruangrawat!=null){
					for(var i=0; i<data.lpk.ruangrawat.length; i++){
						var selected = '';
						if(data.lpk.kamar==data.lpk.ruangrawat[i].nama){
							selected = 'selected';
						}
						ruangrawat = ruangrawat+'<option '+selected+' value="'+data.lpk.ruangrawat[i].kode+'">'+data.lpk.ruangrawat[i].nama+'</option>';
					}
					$('select[name="ruangrawat"]').html(ruangrawat);
				}
				
				var kelasrawat = '';
				if(data.lpk.kelasrawat!=null){
					for(var i=0; i<data.lpk.kelasrawat.length; i++){
						var selected = '';
						if(data.lpk.kelas==data.lpk.kelasrawat[i].nama){
							selected = 'selected';
						}
						kelasrawat = kelasrawat+'<option '+selected+' value="'+data.lpk.kelasrawat[i].kode+'">'+data.lpk.kelasrawat[i].nama+'</option>';
					}
					$('select[name="kelasrawat"]').html(kelasrawat);
				}
				
				var spesialistik = '<option>-- pilih spesialistik --</option>';
				for(var i=0; i<data.lpk.spesialistik.length; i++){
					var selected = '';
					if(data.lpk.kelas==data.lpk.spesialistik[i].nama){
						selected = 'selected';
					}
					spesialistik = spesialistik+'<option '+selected+' value="'+data.lpk.spesialistik[i].kode+'">'+data.lpk.spesialistik[i].nama+'</option>';
				}
				$('select[name="spesialistik"]').html(spesialistik);
				
				var pascapulang = '<option>-- pilih pasca pulang --</option>';
				for(var i=0; i<data.lpk.pascapulang.length; i++){
					var selected = '';
					if(data.lpk.kelas==data.lpk.pascapulang[i].nama){
						selected = 'selected';
					}
					pascapulang = pascapulang+'<option '+selected+' value="'+data.lpk.pascapulang[i].kode+'">'+data.lpk.pascapulang[i].nama+'</option>';
				}
				$('select[name="pascapulang"]').html(pascapulang);
				
				var polikontrol = '<option value="">-- pilih poli --</option>';
				for(var i=0; i<data.lpk.polikontrol.length; i++){
					var selected = '';
					if(data.lpk.poli==data.lpk.polikontrol.bpjs){
						selected = 'selected';
					}
					polikontrol = polikontrol+'<option '+selected+' value="'+data.lpk.polikontrol[i].bpjs+'">'+data.lpk.polikontrol[i].nama+'</option>';
				}
				$('select[name="polikontrol"]').html(polikontrol);
			}
		});
	}
	
	$('input[name="tarif_rs_text"]').val('Rp '+ribuan($('input[name="tarif_rs"]').val())+',-');
	function rincianBiaya(registrasi_id, nama, no_rm) {
		$('#modalRincianBiaya').modal('show');
		$('.modal-title').text(nama +' | '+no_rm)
		$('.tagihan').empty();
		$.ajax({
			url: '/frontoffice/e-claim/bridging-rincian-biaya/'+registrasi_id,
			type: 'GET',
			dataType: 'json',
			success: function(data) {
				if(data.status_reg=='I'){
					$('.tagihan').append('<tr><td>0</td> <td>Biaya Kamar</td> <td class="text-right" id="total_kamar">Layanan Rawat Inap</td> <td>'+ribuan(data.kamar)+'</td></tr>')
				}
				$.each(data.tagihan, function(key, value) {
					$('.tagihan').append('<tr> <td>'+ (key+1) +'</td> <td>'+ value.namatarif+'</td> <td>'+ jenisLayanan(value.jenis)+'</td> <td class="text-right">'+ ribuan(value.total)+'</td> </tr>')
				});
			}
		});
	}
	
	function jenisLayanan(jenis) {
		switch (jenis) {
			case 'TA' : return 'Layanan rawat jalan'; break;
			case 'TG' : return 'Layanan rawat darurat'; break;
			case 'TI' : return 'Layanan rawat inap'; break;
			default : return 'Apotek'; break;
		}
	}
	
	function ribuan(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}
	
	function setDataClaim(data, special_cmg=null, chgspec=false, final_klaim=false){
		var total_tarif = 0;
		if(data!=undefined){
			$("#grouper-specialprocedure-code").html('-');
			$("#grouper-specialprocedure-tarif").html('Rp. 0');
			$("#grouper-specialprosthesis-code").html('-');
			$("#grouper-specialprosthesis-tarif").html('Rp. 0');
			$("#grouper-specialinvestigation-code").html('-');
			$("#grouper-specialinvestigation-tarif").html('Rp. 0');
			$("#grouper-specialdrug-code").html('-');
			$("#grouper-specialdrug-tarif").html('Rp. 0');
			// group
			$("#grouper-group-desc").html(data.cbg.description);
			$("#grouper-group-code").html(data.cbg.code);
			$('#hasil-grouper').fadeIn('top');
			if(data.cbg.tariff!=undefined){
				total_tarif = total_tarif + parseInt(data.cbg.tariff);
				$("#grouper-group-tarif").html('Rp. '+ribuan(data.cbg.tariff));
			}else{
				$("#grouper-group-tarif").html('Rp. 0');
			}
			// subacute
			if(data.sub_acute!=undefined){
				$("#grouper-subacute-desc").html(data.sub_acute.description);
				$("#grouper-subacute-code").html(data.sub_acute.code);
				if(data.sub_acute.tariff!=undefined){
					total_tarif = total_tarif + parseInt(data.sub_acute.tariff);
					$("#grouper-subacute-tarif").html('Rp. '+ribuan(data.sub_acute.tariff));
				}else{
					$("#grouper-subacute-tarif").html('Rp. 0');
				}
			}
			// chronic
			if(data.chronic!=undefined){
				$("#grouper-chronic-desc").html(data.chronic.description);
				$("#grouper-chronic-code").html(data.chronic.code);
				if(data.chronic.tariff!=undefined){
					total_tarif = total_tarif + parseInt(data.chronic.tariff);
					$("#grouper-chronic-tarif").html('Rp. '+ribuan(data.chronic.tariff));
				}else{
					$("#grouper-chronic-tarif").html('Rp. 0');
				}
			}
			
			if(special_cmg!=null){
				var cl = special_cmg.length;
				var option_null = '<option value="">-</option>';
				if(final_klaim){
					option_null = '';
					$('select[name="specialprocedure"]').prop('disabled',true);
					$('select[name="specialprosthesis"]').prop('disabled',true);
					$('select[name="specialinvestigation"]').prop('disabled',true);
					$('select[name="specialdrug"]').prop('disabled',true);
				}
				for(var i=0; i<cl; i++){					
					if(special_cmg[i].type=='Special Procedure'){
						$('select[name="specialprocedure"]').prop('disabled',false);
						$('select[name="specialprocedure"]').html(option_null+'<option value="'+special_cmg[i].code+'">'+special_cmg[i].description+'</option>');
					}else if(special_cmg[i].type=='Special Prosthesis'){
						$('select[name="specialprosthesis"]').prop('disabled',false);
						$('select[name="specialprosthesis"]').html(option_null+'<option value="'+special_cmg[i].code+'">'+special_cmg[i].description+'</option>');
					}else if(special_cmg[i].type=='Special Investigation'){
						$('select[name="specialinvestigation"]').prop('disabled',false);
						$('select[name="specialinvestigation"]').html(option_null+'<option value="'+special_cmg[i].code+'">'+special_cmg[i].description+'</option>');
					}else if(special_cmg[i].type=='Special Drug'){
						$('select[name="specialdrug"]').prop('disabled',false);
						$('select[name="specialdrug"]').html(option_null+'<option value="'+special_cmg[i].code+'">'+special_cmg[i].description+'</option>');
					}
				}
			}
			
			if(data.special_cmg!=undefined){
				if(!chgspec){
					var split_special_cmg = $('input[name="special_cmg"]').val().split('#');
					for(var c=0; c<split_special_cmg.length; c++){
						$('select[name="specialprocedure"] option').each(function(){
							if($(this).val()==split_special_cmg[c]){
								$('select[name="specialprocedure"]').val(split_special_cmg[c]);
							}
						})
						$('select[name="specialprosthesis"] option').each(function(){
							if($(this).val()==split_special_cmg[c]){
								$('select[name="specialprosthesis"]').val(split_special_cmg[c]);
							}
						})
						$('select[name="specialinvestigation"] option').each(function(){
							if($(this).val()==split_special_cmg[c]){
								$('select[name="specialinvestigation"]').val(split_special_cmg[c]);
							}
						})
						$('select[name="specialdrug"] option').each(function(){
							if($(this).val()==split_special_cmg[c]){
								$('select[name="specialdrug"]').val(split_special_cmg[c]);
							}
						})
					}
				}
				
				for(var x=0; x<data.special_cmg.length; x++){
					if(data.special_cmg[x].type=='Special Procedure'){
						$("#grouper-specialprocedure-code").html(data.special_cmg[x].code);
						if(data.special_cmg[x].tariff!=undefined){
							total_tarif = total_tarif + parseInt(data.special_cmg[x].tariff);
							$("#grouper-specialprocedure-tarif").html('Rp. '+ribuan(data.special_cmg[x].tariff));
						}else{
							$("#grouper-specialprocedure-tarif").html('Rp. 0');
						}
					}
						
					if(data.special_cmg[x].type=='Special Prosthesis'){
						$("#grouper-specialprosthesis-code").html(data.special_cmg[x].code);
						if(data.special_cmg[x].tariff!=undefined){
							total_tarif = total_tarif + parseInt(data.special_cmg[x].tariff);
							$("#grouper-specialprosthesis-tarif").html('Rp. '+ribuan(data.special_cmg[x].tariff));
						}else{
							$("#grouper-specialprosthesis-tarif").html('Rp. 0');
						}
					}
					
					if(data.special_cmg[x].type=='Special Investigation'){
						$("#grouper-specialinvestigation-code").html(data.special_cmg[x].code);
						if(data.special_cmg[x].tariff!=undefined){
							total_tarif = total_tarif + parseInt(data.special_cmg[x].tariff);
							$("#grouper-specialinvestigation-tarif").html('Rp. '+ribuan(data.special_cmg[x].tariff));
						}else{
							$("#grouper-specialinvestigation-tarif").html('Rp. 0');
						}
					}
					
					if(data.special_cmg[x].type=='Special Drug'){
						$("#grouper-specialdrug-code").html(data.special_cmg[x].code);
						if(data.special_cmg[x].tariff!=undefined){
							total_tarif = total_tarif + parseInt(data.special_cmg[x].tariff);
							$("#grouper-specialdrug-tarif").html('Rp. '+ribuan(data.special_cmg[x].tariff));
						}else{
							$("#grouper-specialdrug-tarif").html('Rp. 0');
						}
					}
				}
			}
			$("#grouper-total-tarif").html('Rp. '+ribuan(total_tarif));
		}
	}
		
	$('#btnKlaimBaru').on('click', function () {
		$('#hasil-grouper').fadeOut('right');
		$('#loading').modal('show');
		$('#dataDetailClaim').fadeOut('right');
		$('.progress').removeClass('hidden')
		$.ajax({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			type: 'POST',
			url: '/eklaim/buat-klaim-baru',
			dataType: 'json',
			data: {
				nomor_kartu: $('input[name="no_kartu"]').val(),
				nomor_sep: $('input[name="no_sep"]').val(),
				nomor_rm: $('input[name="no_rm"]').val(),
				nama_pasien: $('input[name="nama"]').val(),
				tgl_lahir: $('input[name="tgllahir"]').val(),
				gender: $('input[name="gender"]').val()
			},
			success: function (data) {
				$('.progress').addClass('hidden')
				$('#loading').modal('hide');
				alert(data.text);
				getDetailClaim();
			}
		});
	});
	
	$('#openICD9').on('click', function () {
		$('input[name="special_cmg"]').val('')
		$('#hasil-grouper').fadeOut('right');
		$("#icd9VIEW").DataTable().destroy();
		$('#icd9DATA').modal('show');
		$('.modal-title').text('Data Prosedure');
		$('#icd9VIEW').DataTable({
				"language": {
						"url": "/json/pasien.datatable-language.json",
				},
				pageLength: 10,
				autoWidth: false,
				processing: true,
				serverSide: true,
				ordering: false,
				ajax: '/frontoffice/e-claim/get-icd9-data',
				columns: [
						{data: 'nomor'},
						{data: 'nama'},
						{data: 'input', searchable: false}
				]
		});
	});

	$(document).on('click', '.insert-prosedure', function (e) {
		var procedure = $('input[name="procedure"]').val();
		var input = $(this).attr('data-nomor');
		if( procedure != '' ) {
			$('input[name="procedure"]').val(procedure+'#'+input);
		} else {
			$('input[name="procedure"]').val(input);
		}
		$('#icd9DATA').modal('hide');
	});
	
  // ICD10
  $('#openICD10').on('click', function () {
		$('input[name="special_cmg"]').val('')
		$('#hasil-grouper').fadeOut('right');
    $("#icd10VIEW").DataTable().destroy();
    $('#icd10DATA').modal('show');
    $('.modal-title').text('Data Diagnosa');
    $('#icd10VIEW').DataTable({
        "language": {
            "url": "/json/pasien.datatable-language.json",
        },
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/frontoffice/e-claim/get-icd10-data',
        columns: [
            {data: 'nomor'},
            {data: 'nama'},
            {data: 'input', searchable: false}
        ]
    });
  });

  $(document).on('click', '.insert-diagnosa', function (e) {
    var diagnosa = $('input[name="diagnosa"]').val();
    var input = $(this).attr('data-nomor');
    if( diagnosa != '' ) {
      $('input[name="diagnosa"]').val(diagnosa+'#'+input);
    } else {
      $('input[name="diagnosa"]').val(input);
    }
    $('#icd10DATA').modal('hide');
  });
	
	$('#startGrouping').on('click', function(){
		$('select[name="specialprocedure"]').prop('disabled',true);
		$('select[name="specialprosthesis"]').prop('disabled',true);
		$('select[name="specialinvestigation"]').prop('disabled',true);
		$('select[name="specialdrug"]').prop('disabled',true);
		$('select[name="specialprocedure"]').html('<option value="">-</option>');
		$('select[name="specialprosthesis"]').html('<option value="">-</option>');
		$('select[name="specialinvestigation"]').html('<option value="">-</option>');
		$('select[name="specialdrug"]').html('<option value="">-</option>');
		$('#hasil-grouper').fadeOut('right');
		$('#loading').modal('show');
		$('.progress').removeClass('hidden')
		$.ajax({
			type: 'POST',
			url: '/eklaim/new-claim',
			data: $('#formINACBG').serialize(),
			success: function (data) {
				console.log(data);
				$('#loading').modal('hide');
				$('.progress').addClass('hidden')
				if(data.sukses){
					$("#hasil-grouper").fadeIn('left');
					$("#hasil-grouper").focus();
					setDataClaim(data.data.response, data.data.special_cmg_option, false);
					startGroupingStage2(null,true,false);
				}else{
					if(data.errors) {
						if(data.errors.no_kartu) {
							$('#no_kartu-error').html( data.errors.no_kartu[0] );
							$('#groupNoKartu').addClass('has-error');
						}else	if(data.errors.no_sep) {
							$('#no_sep-error').html( data.errors.no_sep[0] );
							$('#groupSEP').addClass('has-error');
						}else	if(data.errors.diagnosa) {
							$('#diagnosa-error').html( data.errors.diagnosa[0] );
							$('#groupDiagnosa').addClass('has-error');
						}else	if(data.errors.procedure) {
							$('#procedure-error').html( data.errors.procedure[0] );
							$('#groupProcedure').addClass('has-error');
						}
					}else{
						alert(data.message)
					}
				}
			}
		});
	});
	
	function startGroupingStage2(vals, load=false, chgspec=false){
		var special_cmg = '';
		if(!load){
			$('#loading').modal('show');
			$('.progress2').removeClass('hidden');
		
			$('.special').each(function(){
				if($(this).val()!='' && $(this).val()!='-'){
					if(special_cmg==''){
						special_cmg = $(this).val();
					}else{
						special_cmg = special_cmg+'#'+$(this).val();
					}
				}
			});
		}else{
			special_cmg = $('input[name="special_cmg"]').val();
		}
		$.ajax({
			type: 'GET',
			url: '/eklaim/grouper-stage2/'+$('input[name="no_sep"]').val(),
			data: { special_cmg : special_cmg },
			success: function (data) {
				console.log(data);
				if(!load){
					$('#loading').modal('hide');
					$('.progress2').addClass('hidden')
				}
				if(data.sukses){
					setDataClaim(data.data, null, chgspec); //, data.data.special_cmg_option
				}else{
					alert(data.message)
				}
			}
		});
	}
	
	$('#startFinalKlaim').on('click', function(){
		if(confirm('Apakah yakin untuk melakukan final klaim ?')){
			$('#loading').modal('show');
			$('.progress2').removeClass('hidden');
			$.ajax({
				type: 'GET',
				url: '/eklaim/final-klaim/'+$('input[name="no_sep"]').val(),
				data: null,
				success: function (data) {
					console.log(data);
					$('#loading').modal('hide');
					$('.progress2').addClass('hidden')
					if(data.sukses){
						$("#startKirimDc").fadeIn();
						$("#startKirimLpk").fadeIn();
					}else{
						alert(data.message)
					}
				}
			});
		}
	});
	
	$('#startKirimDc').on('click', function(){
		if(confirm('Apakah yakin untuk mengirim klaim individual ke data center ?')){
			$('#loading').modal('show');
			$('.progress2').removeClass('hidden');
			$.ajax({
				type: 'GET',
				url: '/eklaim/kirim-dc/'+$('input[name="no_sep"]').val(),
				data: null,
				success: function (data) {
					console.log(data);
					$('#loading').modal('hide');
					$('.progress2').addClass('hidden')
					if(data.status){
						$("#startKirimDc").prop('disabled',true);
						$("#data-lpk").fadeIn('top');
					}
					alert(data.message)
				}
			});
		}
	});
	
	$('#startKirimLpk').on('click', function(){
		if(confirm('Apakah yakin untuk mengirim lembar pengajuan klaim ?')){
			$('#loading').modal('show');
			$('.progress2').removeClass('hidden');
			$.ajax({
				headers:{
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				},
				type: 'POST',
				url: '/frontoffice/v-claim/kirim-lpk/'+$('input[name="no_sep"]').val(),
				data: {ruangrawat: $('select[name="ruangrawat"]').val(), kelasrawat: $('select[name="kelasrawat"]').val(), spesialistik: $('select[name="spesialistik"]').val(), pascapulang: $('select[name="pascapulang"]').val(), tindaklanjut: $('select[name="tindaklanjut"]').val(), tanggalkontrol: $('input[name="tanggalkontrol"]').val(), polikontrol: $('select[name="polikontrol"]').val()},
				success: function (data) {
					console.log(data);
					$('#loading').modal('hide');
					$('.progress2').addClass('hidden')
					if(data.status){
						$(this).fadeOut();
					}
					alert(data.message)
				}
			});
		}
	});

	$('#closeModal').on('click', function() {
		$('input[name="diagnosa"]').val() = "";
		$('input[name="procedure"]').val() = "";
		$('input[name="no_kartu"]').val() = "";
		$('input[name="no_sep"]').val() = "";
		$('#no_kartu-error').html("");
		$('#groupNoKartu').removeClass('has-error');
		$('#no_sep-error').html("");
		$('#groupSEP').removeClass('has-error');
		$('#diagnosa-error').html("");
		$('#groupDiagnosa').removeClass('has-error');
		$('#procedure-error').html("");
		$('#groupProcedure').removeClass('has-error');
		$('#suksesReturn').modal('hide');
	})
</script>
@endsection