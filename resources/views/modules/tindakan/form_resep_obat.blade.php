<input type="hidden" name="isUpdateResep" id="isUpdateResep" value="0">
<input type="hidden" name="penjualan_id" id="penjualan_id" value="0">
<div class="rowx">
	<div class="form-group{{ $errors->has('resep_alergi') ? ' has-error' : '' }}">
		{!! Form::label('resep_alergi', 'Alergi', ['class' => 'col-sm-2']) !!}
		<div class="col-md-2 no-padding">
			@php
				$display = 'style=display:none;';
				$keterangan = '';
			@endphp
			<select name="resep_alergi" id="resep_alergi" onchange="changeAlergi(this.value)" class="form-control">
				@if($penjualan==null)
					<option value="0">Tidak</option>
					<option value="1">Ya</option>
				@else
					<option {{ ($penjualan->alergi==0 OR $penjualan->alergi==null) ? 'selected' : '' }} value="0">Tidak</option>
					<option {{ ($penjualan->alergi==1) ? 'selected' : '' }} value="1">Ya</option>
					@php
						if($penjualan->alergi==1){
							$display = '';
							$keterangan = $penjualan->keterangan_alergi;
						}
					@endphp
				@endif
			</select>
		</div>
	</div>
	
	<div id="div-ket-alergi-resep" {{ $display }}>
		<div class="form-group{{ $errors->has('resep_ket_alergi') ? ' has-error' : '' }}">
			{!! Form::label('resep_ket_alergi', 'Keterangan Alergi', ['class' => 'col-sm-2']) !!}
			<div class="col-md-6 no-padding">
				<textarea id="resep_ket_alergi" class="form-control" name="resep_ket_alergi">{{ $keterangan }}</textarea>
			</div>
		</div>
	</div>
	
	<div id="isCreateResep">
		<div class="form-group{{ $errors->has('resep_racikan') ? ' has-error' : '' }}">
			{!! Form::label('resep_racikan', 'Racikan', ['class' => 'col-sm-2']) !!}
			<div class="col-md-6 no-padding">
				<div class="input-group col-md-12">
					<div class="col-md-4 col-md-6 col-xs-6 no-padding">
						<select name="resep_racikan" id="" onchange="changeRacikan(this.value)" class="form-control">
							<option value="0">Tidak</option>
							<option value="1">Ya</option>
						</select>
					</div>
					<div class="col-md-6 col-md-6 col-xs-6 no-padding" id="status_racikan_resep" style="display:none;">
						<select name="status_racikan_resep" onchange="statusRacikan(this.value)" class="form-control">
							<option value="0">Tambah Baru</option>
							@if($data_racikan_resep!=null)
								@foreach($data_racikan_resep as $kex => $dr)									
									<option value="{{$dr->obat_racikan_id}}">{{$dr->nama}}</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
			</div>
		</div>
		
		<div id="div-jenis-racikan-resep">
			<input type="hidden" name="text_resep_id_racikan" id="text_resep_id_racikan" value="">
			<div class="form-group{{ $errors->has('resep_jenis_racikan') ? ' has-error' : '' }}">
				{!! Form::label('resep_jenis_racikan', 'Jenis Racikan', ['class' => 'col-sm-2']) !!}
				<div class="col-md-2 no-padding">
					<input type="text" style="display:none;" id="text_resep_jenis_racikan" value="" class="form-control" readonly=true>
					{!! Form::select('resep_jenis_racikan', $jenis_racikan, null, ['id'=>'resep_jenis_racikan','class' => 'form-control']) !!}
				</div>
			</div>
			
			<div class="form-group{{ $errors->has('resep_jumlah_racikan') ? ' has-error' : '' }}">
				{!! Form::label('resep_jumlah_racikan', 'Jumlah Racikan', ['class' => 'col-sm-2']) !!}
				<div class="col-md-6 no-padding">
					<div class="input-group col-md-12">
						<div class="col-md-6 col-md-6 col-xs-6 no-padding">
							<input type="number" name="resep_jumlah_racikan" id="resep_jumlah_racikan" value="1" class="form-control">
						</div>
						<div class="col-md-6 col-md-6 col-xs-6 no-padding">
							<input type="text" style="display:none;" id="text_resep_satuan_racikan" value="" class="form-control" readonly=true>
							{!! Form::select('resep_satuan_racikan', $satuan, null, ['id'=>'resep_satuan_racikan','class' => 'form-control select2']) !!}
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-8 no-padding">
					<button type="button" id="saveRacikanResep" class="btn btn-primary btn-flat pull-right">Simpan</button>
					<button type="button" id="addRacikanResep" class="btn btn-primary btn-flat pull-right">Tambah Racikan</button>
				</div>
			</div>
		</div>
	</div>

	<div id="div-data-obat-resep">
		<div class="form-group{{ $errors->has('resep_masterobat_id') ? ' has-error' : '' }}">
			{!! Form::label('resep_masterobat_id', 'Pilih Obat', ['class' => 'col-sm-2']) !!}
			<div class="col-md-6 no-padding">
				<div class="col-md-8 no-padding">
					<select name="resep_masterobat_id" id="resep_masterobat_id" class="form-control select2ajax" style="width:100%!important;" onchange="getExpiredResep(this.value)">
					</select>
					<small class="text-danger">{{ $errors->first('resep_masterobat_id') }}</small>
				</div>
				<div class="col-md-4">
					<input type="text" id="resep_expired" name="resep_expired" placeholder="Expired" value="" class="form-control">
				</div>
			</div>
		</div>
		
		<div class="form-group{{ $errors->has('resep_jumlah_obat') ? ' has-error' : '' }}">
			{!! Form::label('resep_jumlah_obat', 'Jumlah Obat', ['class' => 'col-sm-2']) !!}
			<div class="col-md-6 no-padding">
				<div class="input-group col-md-12">
					<div class="col-md-4 col-md-4 col-xs-4 no-padding">
						<input type="number" name="resep_jumlah" value="1" class="form-control">
					</div>
				</div>
			</div>
		</div>
		
		<div id="aturan-pakai" class="form-group{{ $errors->has('resep_aturan_pakai') ? ' has-error' : '' }}">
			{!! Form::label('resep_aturan_pakai', 'Jadwal Aturan Pakai', ['class' => 'col-sm-2']) !!}
			<div class="col-md-6 no-padding">
				<div class="input-group col-md-12">
					<div class="col-md-4 col-md-4 col-xs-4 no-padding">
						{!! Form::select('resep_aturan_pakai', $aturan, null, ['style'=>'width:100%!important', 'class' => 'form-control select2']) !!}
					</div>
					<div class="col-md-1 col-md-1 col-xs-1 no-padding text-center" style="line-height:3;">
						X
					</div>
					<div class="col-md-3 col-md-3 col-xs-3 no-padding">
						{!! Form::text('resep_jumlah_aturanpakai', 1, ['class' => 'form-control', 'placeholder'=>'Jumlah']) !!}
					</div>
					<div class="col-md-4 col-md-4 col-xs-4">
						{!! Form::select('resep_satuan_aturanpakai', $takaran, null, ['style'=>'width:100%!important', 'class' => 'form-control select2']) !!}
					</div>
				</div>
			</div>
		</div>

		<div class="form-group{{ $errors->has('resep_informasi1') ? ' has-error' : '' }}">
			{!! Form::label('resep_informasi1', 'Informasi 1', ['class' => 'col-sm-2']) !!}
			<div class="col-md-2 no-padding">
				{!! Form::select('resep_informasi1', [''=>'','Sebelum Makan'=>'Sebelum Makan','Bersama Makan'=>'Bersama Makan','Setelah Makan'=>'Setelah Makan'], null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
				<small class="text-danger">{{ $errors->first('resep_informasi1') }}</small>
			</div>
		</div>

		<div class="hidden form-group{{ $errors->has('resep_informasi2') ? ' has-error' : '' }}">
			{!! Form::label('resep_informasi2', 'Keterangan', ['class' => 'col-sm-2', 'autocomplete' => 'off']) !!}
			<div class="col-md-6 no-padding">
				{!! Form::text('resep_informasi2', null, ['class' => 'form-control']) !!}
				<small class="text-danger">{{ $errors->first('resep_informasi2') }}</small>
			</div>
		</div>
		<div class="form-group{{ $errors->has('cetak') ? ' has-error' : '' }}">
			<div class="col-md-8">
				<div class="col-sm-12" style="background:#f9f9f9;padding:10px;border:solid 1px #eee;">
					<div class="col-md-7 no-padding">
						@role(['apotik'])
						{!! Form::label('is_did', 'Apakah DID ?', ['class' => 'col-sm-12 no-padding']) !!}
						{!! Form::select('is_did', ['0'=>'Tidak','1'=>'Ya'], null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
						@endrole
					</div>
					<div class="col-md-5 no-padding">
						@role(['apotik'])
						{!! Form::label('aksi', '-', ['class' => 'col-sm-12 no-padding text-right']) !!}
						@endrole
						<button type="button" id="saveItemResep" class="btn btn-primary btn-flat pull-right">Tambahkan</button>
						<button type="button" id="batalEditRes" class="btn btn-warning btn-flat pull-right" style="display:none;">Batal Edit</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
function getExpiredResep(val){
	if(val!=''){
		$.ajax({
			url: '/farmasi/get-masterobat/'+val,
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				$('input[name="resep_expired"]').val(data.expired);
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
				$('input[name="text_resep_jenis_racikan"]').val(data.val);
				$('select[name="resep_jenis_racikan"]').val(data.jenis_racikan);
				$('input[name="resep_jumlah_racikan"]').val(data.jumlah_racikan);
				$('select[name="resep_satuan_racikan"]').val(data.satuan_racikan);
				
				$('input[name="resep_jumlah_racikan"]').prop("readonly",true);
				$('#resep_jenis_racikan').hide();
				$('#resep_satuan_racikan').hide();
				$('#text_resep_jenis_racikan').val($('select[name="resep_jenis_racikan"]').val());
				$('#text_resep_satuan_racikan').val($('select[name="resep_satuan_racikan"]').val());
				$('#text_resep_id_racikan').val(val);
				$('#text_resep_jenis_racikan').show();
				$('#text_resep_satuan_racikan').show();
				$('#addRacikanResep').show();
				$('#saveRacikanResep').hide();
				$("#div-data-obat-resep").show();
			}
		});
	}
}
</script>