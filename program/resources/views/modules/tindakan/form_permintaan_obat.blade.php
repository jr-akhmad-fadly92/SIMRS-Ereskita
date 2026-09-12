<input type="hidden" name="isUpdateEpo" id="isUpdateEpo" value="0">
<input type="hidden" name="permintaan_id" id="permintaan_id" value="0">
<div class="rowx">
	<div class="form-group{{ $errors->has('epo_alergi') ? ' has-error' : '' }}">
		{!! Form::label('epo_alergi', 'Alergi', ['class' => 'col-sm-2']) !!}
		<div class="col-md-2 no-padding">
			@php
				$display = 'style=display:none;';
				$keterangan = '';
			@endphp
			<select name="epo_alergi" id="epo_alergi" onchange="changeAlergi(this.value)" class="form-control">
				@if($permintaan==null)
					<option value="0">Tidak</option>
					<option value="1">Ya</option>
				@else
					<option {{ ($permintaan->alergi==0 OR $permintaan->alergi==null) ? 'selected' : '' }} value="0">Tidak</option>
					<option {{ ($permintaan->alergi==1) ? 'selected' : '' }} value="1">Ya</option>
					@php
						if($permintaan->alergi==1){
							$display = '';
							$keterangan = $permintaan->keterangan_alergi;
						}else{
							$display = 'style=display:none;';
							$keterangan = '';
						}
					@endphp
				@endif
			</select>
		</div>
	</div>
	
	<div id="div-ket-alergi-epo" {{ $display }}>
		<div class="form-group{{ $errors->has('epo_ket_alergi') ? ' has-error' : '' }}">
			{!! Form::label('epo_ket_alergi', 'Keterangan Alergi', ['class' => 'col-sm-2']) !!}
			<div class="col-md-6 no-padding">
				<textarea id="epo_ket_alergi" class="form-control" name="epo_ket_alergi">{{ $keterangan }}</textarea>
			</div>
		</div>
	</div>
		
	<div id="isCreateEpo">
		<div class="form-group{{ $errors->has('epo_racikan') ? ' has-error' : '' }}">
			{!! Form::label('epo_racikan', 'Racikan', ['class' => 'col-sm-2']) !!}
			<div class="col-md-6 no-padding">
				<div class="input-group col-md-12">
					<div class="col-md-4 col-md-6 col-xs-6 no-padding">
						<select name="epo_racikan" id="" onchange="changeRacikan(this.value)" class="form-control">
							<option value="0">Tidak</option>
							<option value="1">Ya</option>
						</select>
					</div>
					<div class="col-md-6 col-md-6 col-xs-6 no-padding" id="status_racikan_epo" style="display:none;">
						<select name="status_racikan_epo" onchange="statusRacikan(this.value)" class="form-control">
							<option value="0">Tambah Baru</option>
							@if($data_racikan_epo!=null)
								@foreach($data_racikan_epo as $kex => $dr)									
									<option value="{{$dr->obat_racikan_id}}">{{$dr->nama}}</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
			</div>
		</div>
		
		<div id="div-jenis-racikan-epo">
			<input type="hidden" name="text_epo_id_racikan" id="text_epo_id_racikan" value="">
			<div class="form-group{{ $errors->has('epo_jenis_racikan') ? ' has-error' : '' }}">
				{!! Form::label('epo_jenis_racikan', 'Jenis Racikan', ['class' => 'col-sm-2']) !!}
				<div class="col-md-2 no-padding">
					<input type="text" style="display:none;" id="text_epo_jenis_racikan" value="" class="form-control" readonly=true>
					{!! Form::select('epo_jenis_racikan', $jenis_racikan, null, ['id'=>'epo_jenis_racikan','class' => 'form-control']) !!}
				</div>
			</div>
			
			<div class="form-group{{ $errors->has('epo_jumlah_racikan') ? ' has-error' : '' }}">
				{!! Form::label('epo_jumlah_racikan', 'Jumlah Racikan', ['class' => 'col-sm-2']) !!}
				<div class="col-md-6 no-padding">
					<div class="input-group col-md-12">
						<div class="col-md-6 col-md-6 col-xs-6 no-padding">
							<input type="number" name="epo_jumlah_racikan" id="epo_jumlah_racikan" value="1" class="form-control">
						</div>
						<div class="col-md-6 col-md-6 col-xs-6 no-padding">
							<input type="text" style="display:none;" id="text_epo_satuan_racikan" value="" class="form-control" readonly=true>
							{!! Form::select('epo_satuan_racikan', $satuan, null, ['id'=>'epo_satuan_racikan','class' => 'form-control select2']) !!}
						</div>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-8 no-padding">
					<button type="button" id="saveRacikanEpo" class="btn btn-primary btn-flat pull-right">Simpan</button>
					<button type="button" id="addRacikanEpo" class="btn btn-primary btn-flat pull-right">Tambah Racikan</button>
				</div>
			</div>
		</div>
	</div>

	<div id="div-data-obat-epo">
		<div class="form-group{{ $errors->has('epo_masterobat_id') ? ' has-error' : '' }}">
			{!! Form::label('epo_masterobat_id', 'Pilih Obat', ['class' => 'col-sm-2']) !!}
			<div class="col-md-6 no-padding">
				<div class="col-md-8 no-padding">
					<select name="epo_masterobat_id" id="epo_masterobat_id" class="form-control select2ajax" style="width:100%!important" onchange="getExpiredEpo(this.value)">
					</select>
					<small class="text-danger">{{ $errors->first('epo_masterobat_id') }}</small>
				</div>
				<div class="col-md-4">
					<input type="text" id="epo_expired" name="epo_expired" placeholder="Expired" value="" class="form-control">
				</div>
			</div>
		</div>
		
		<div class="form-group{{ $errors->has('epo_jumlah_obat') ? ' has-error' : '' }}">
			{!! Form::label('epo_jumlah_obat', 'Jumlah Obat', ['class' => 'col-sm-2']) !!}
			<div class="col-md-6 no-padding">
				<div class="input-group col-md-12">
					<div class="col-md-4 col-md-4 col-xs-4 no-padding">
						<input type="number" name="epo_jumlah" value="1" class="form-control">
					</div>
				</div>
			</div>
		</div>
		
		<div id="aturan-pakai" class="form-group{{ $errors->has('epo_aturan_pakai') ? ' has-error' : '' }}">
			{!! Form::label('epo_aturan_pakai', 'Jadwal Aturan Pakai', ['class' => 'col-sm-2']) !!}
			<div class="col-md-6 no-padding">
				<div class="input-group col-md-12">
					<div class="col-md-4 col-md-4 col-xs-4 no-padding">
						{!! Form::select('epo_aturan_pakai', $aturan, null, ['style'=>'width:100%!important', 'class' => 'form-control select2']) !!}
					</div>
					<div class="col-md-1 col-md-1 col-xs-1 no-padding text-center" style="line-height:3;">
						X
					</div>
					<div class="col-md-3 col-md-3 col-xs-3 no-padding">
						{!! Form::text('epo_jumlah_aturanpakai', 1, ['class' => 'form-control', 'placeholder'=>'Jumlah']) !!}
					</div>
					<div class="col-md-4 col-md-4 col-xs-4">
						{!! Form::select('epo_satuan_aturanpakai', $takaran, null, ['style'=>'width:100%!important', 'class' => 'form-control select2']) !!}
					</div>
				</div>
			</div>
		</div>

		<div class="form-group{{ $errors->has('epo_informasi1') ? ' has-error' : '' }}">
			{!! Form::label('epo_informasi1', 'Informasi 1', ['class' => 'col-sm-2']) !!}
			<div class="col-md-2 no-padding">
				{!! Form::select('epo_informasi1', [''=>'','Sebelum Makan'=>'Sebelum Makan','Bersama Makan'=>'Bersama Makan','Setelah Makan'=>'Setelah Makan'], null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
				<small class="text-danger">{{ $errors->first('epo_informasi1') }}</small>
			</div>
		</div>

		<div class="hidden form-group{{ $errors->has('epo_informasi2') ? ' has-error' : '' }}">
			{!! Form::label('epo_informasi2', 'Keterangan', ['class' => 'col-sm-2', 'autocomplete' => 'off']) !!}
			<div class="col-md-6 no-padding">
				{!! Form::text('epo_informasi2', null, ['class' => 'form-control']) !!}
				<small class="text-danger">{{ $errors->first('epo_informasi2') }}</small>
			</div>
		</div>
		
		<div class="form-group{{ $errors->has('cetak') ? ' has-error' : '' }}">
			<div class="col-md-8">
				<div class="col-sm-12" style="background:#f9f9f9;padding:10px;border:solid 1px #eee;">
					<button type="button" id="saveItemEpo" class="btn btn-primary btn-flat pull-right">Tambahkan</button>
					<button type="button" id="batalEditEpo" class="btn btn-warning btn-flat pull-right" style="display:none;">Batal Edit</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function getExpiredEpo(val){
	if(val!=''){
		$.ajax({
			url: '/farmasi/get-masterobat/'+val,
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				$('input[name="epo_expired"]').val(data.expired);
			}
		});
	}
}
function statusRacikan(val){
	if(val!=0){
		$.ajax({
			url: '/farmasi/get-racikan/'+val,
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				$('input[name="text_epo_jenis_racikan"]').val(data.val);
				$('select[name="epo_jenis_racikan"]').val(data.jenis_racikan);
				$('input[name="epo_jumlah_racikan"]').val(data.jumlah_racikan);
				$('select[name="epo_satuan_racikan"]').val(data.satuan_racikan);
				
				$('input[name="epo_jumlah_racikan"]').prop("readonly",true);
				$('#epo_jenis_racikan').hide();
				$('#epo_satuan_racikan').hide();
				$('#text_epo_jenis_racikan').val($('select[name="epo_jenis_racikan"]').val());
				$('#text_epo_satuan_racikan').val($('select[name="epo_satuan_racikan"]').val());
				$('#text_epo_id_racikan').val(val);
				$('#text_epo_jenis_racikan').show();
				$('#text_epo_satuan_racikan').show();
				$('#addRacikanEpo').show();
				$('#saveRacikanEpo').hide();
				$("#div-data-obat-epo").show();
			}
		});
	}
}
</script>