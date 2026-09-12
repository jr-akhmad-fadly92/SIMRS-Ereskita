<div class="col-md-12">
	<div class="form-group{{ $errors->has('tahuntarif_id') ? ' has-error' : '' }}">
		{!! Form::label('tahuntarif_id', 'Tahun Tarif', ['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">
			{!! Form::select('tahuntarif_id', $tahuntarif, null, ['class' => 'form-control']) !!}
			<small class="text-danger">{{ $errors->first('tahuntarif_id') }}</small>
		</div>
	</div>
	{{--<div class="form-group{{ $errors->has('kategoriheader_id') ? ' has-error' : '' }}">
			{!! Form::label('kategoriheader_id', 'Kategori Header', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::select('kategoriheader_id', $kategoriheader, 9, ['class' => 'form-control ']) !!}
					<small class="text-danger">{{ $errors->first('kategoriheader_id') }}</small>
			</div>
	</div>--}}

	<div class="form-group{{ $errors->has('kategoritarif_id') ? ' has-error' : '' }}">
			{!! Form::label('kategoritarif_id', 'Kategori Tarif', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::select('kategoritarif_id', $kategoritarif, 11, ['class' => 'form-control ']) !!}
					<small class="text-danger">{{ $errors->first('kategoritarif_id') }}</small>
			</div>
	</div>
	
	{{--<div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
			{!! Form::label('pelaksana', 'Pelaksana Tarif', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::select('pelaksana', $pelaksana, 1, ['class' => 'form-control ']) !!}
					<small class="text-danger">{{ $errors->first('pelaksana') }}</small>
			</div>
	</div>--}}

	<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
			{!! Form::label('nama', 'Nama Tindakan', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::text('nama', null, ['class' => 'form-control']) !!}
					<small class="text-danger">{{ $errors->first('nama') }}</small>
			</div>
	</div>
	<div class="form-group{{ $errors->has('mapping_pemeriksaan') ? ' has-error' : '' }}">
			{!! Form::label('mapping_pemeriksaan', 'Jenis Tindakan', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::select('mapping_pemeriksaan', ['PM'=>'Pemeriksaan','TN'=>'Tindakan','KS'=>'Konsultasi',''=>'Lain-Lain'], null, ['class' => 'form-control']) !!}
					<small class="text-danger">{{ $errors->first('mapping_pemeriksaan') }}</small>
			</div>
	</div>
	<div class="form-group{{ $errors->has('mapping_pemeriksaan') ? ' has-error' : '' }}">
			{!! Form::label('poli', 'Poli Tindakan', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					<select id="poli" name="poli" class="form-control">
						<option value="">-- Pilih Poli ---</option>
						@foreach(Modules\Poli\Entities\Poli::all() as $data)
						@if(isset($tarif) && $data->id == $tarif->poli)
							<option value="{{$tarif->poli}}" selected>{{$data->nama}}</option>
						@else
							<option value="{{$data->id}}">{{$data->nama}}</option>
						@endif
						@endforeach
					</select>
					<small class="text-danger">{{ $errors->first('mapping_pemeriksaan') }}</small>
			</div>
	</div>

	@if(isset($split))
			@php
					$no = 1;
					$ms = 1;
			@endphp
		@foreach ($split as $key => $d)
			<input type="hidden" name="idsplit{{ $no }}" value="{{ $d->id }}">
			<input type="hidden" name="namasplit{{ $no }}" value="{{ $d->nama }}">
			<div class="form-group text-danger">
				{!! Form::label('split'.$d->nama, $d->nama, ['class' => 'col-sm-3 control-label']) !!}
				<div class="col-sm-9">
					{!! Form::text('split'.$no, $d->nominal, ['class' => 'form-control']) !!}
				</div>
			</div>
			@php
					$no++;
					$ms++;
			@endphp
		@endforeach
		<input type="hidden" name="jmlsplit" value="{{ count($split) }}">
	@endif

	<div class="form-group{{ $errors->has('tarif_kelas_vip') ? ' has-error' : '' }}">
			{!! Form::label('tarif_kelas_vip', 'Tarif Kelas VIP', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::number('tarif_kelas_vip', null, ['class' => 'form-control']) !!}
					<small class="text-danger">{{ $errors->first('tarif_kelas_vip') }}</small>
			</div>
	</div>
	<div class="form-group{{ $errors->has('tarif_kelas_1') ? ' has-error' : '' }}">
			{!! Form::label('tarif_kelas_1', 'Tarif Kelas 1', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::number('tarif_kelas_1', null, ['class' => 'form-control']) !!}
					<small class="text-danger">{{ $errors->first('tarif_kelas_1') }}</small>
			</div>
	</div>
	<div class="form-group{{ $errors->has('tarif_kelas_2') ? ' has-error' : '' }}">
			{!! Form::label('tarif_kelas_2', 'Tarif Kelas 2', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::number('tarif_kelas_2', null, ['class' => 'form-control']) !!}
					<small class="text-danger">{{ $errors->first('tarif_kelas_2') }}</small>
			</div>
	</div>
	<div class="form-group{{ $errors->has('tarif_kelas_3') ? ' has-error' : '' }}">
			{!! Form::label('tarif_kelas_3', 'Tarif Kelas 3', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::number('tarif_kelas_3', null, ['class' => 'form-control']) !!}
					<small class="text-danger">{{ $errors->first('tarif_kelas_3') }}</small>
			</div>
	</div>
	<div class="form-group{{ $errors->has('tarif_tindakanpr') ? ' has-error' : '' }}">
			{!! Form::label('tarif_tindakanpr', 'Tarif Tindakan Perawat', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::number('tarif_tindakanpr', null, ['class' => 'form-control']) !!}
					<small class="text-danger">{{ $errors->first('tarif_tindakanpr') }}</small>
			</div>
	</div>
	
	<div class="form-group{{ $errors->has('tarif_tindakandr') ? ' has-error' : '' }}">
			{!! Form::label('tarif_tindakandr', 'Tarif Tindakan Dokter', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::number('tarif_tindakandr', null, ['class' => 'form-control']) !!}
					<small class="text-danger">{{ $errors->first('tarif_tindakandr') }}</small>
			</div>
	</div>
	<div class="form-group{{ $errors->has('managemen') ? ' has-error' : '' }}">
			{!! Form::label('managemen', 'Tarif Jasa RS', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::number('managemen', null, ['class' => 'form-control']) !!}
					<small class="text-danger">{{ $errors->first('managemen') }}</small>
			</div>
	</div>
	{{--<div class="form-group{{ $errors->has('tarif_kelas_rj') ? ' has-error' : '' }}">
			{!! Form::label('tarif_kelas_rj', 'Total Tarif Kelas RJ', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::number('tarif_kelas_rj', 0, ['class' => 'form-control']) !!}
					<small class="text-danger">{{ $errors->first('tarif_kelas_rj') }}</small>
			</div>
	</div>--}}
	<div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
			{!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-9">
					{!! Form::text('keterangan', '-', ['class' => 'form-control']) !!}
					<small class="text-danger">{{ $errors->first('keterangan') }}</small>
			</div>
	</div>

	<div class="pull-right">
		<a href="{{ url('/tarif') }}" class="btn btn-warning btn-flat">BATAL</a>
		{!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat']) !!}
	</div>
</div>