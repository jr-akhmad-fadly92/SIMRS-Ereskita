<div class="row">
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
      {!! Form::label('poli_id', 'Poli Tujuan', ['class' => 'col-sm-3']) !!}
      <div class="col-sm-9">
        <select class="form-control select2" name="poli_id">
          @foreach ($poli as $key => $d)
            @if ($d->id == '6')
              <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
            @else
              <option value="{{ $d->id }}">{{ $d->nama }}</option>
            @endif
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        {!! Form::label('status', 'Status', ['class' => 'col-sm-3']) !!}
        <div class="col-sm-9">
          @if ($pasien && !empty($pasien->id))
            {!! Form::select('status', [2=>'Lama'], 2, ['class' => 'form-control select2', 'readonly'=>true]) !!}
          @else
            {!! Form::select('status', [1=>'Baru'], 1, ['class' => 'form-control select2', 'readonly'=>true]) !!}
          @endif
            <small class="text-danger">{{ $errors->first('status') }}</small>
        </div>
    </div>    
    {!! Form::hidden('status_reg', 'G1') !!}
  </div>
  {{-- =========================================================== --}}
  <div class="col-md-6">
    {!! Form::hidden('tipe_layanan', '1') !!}
    <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
        {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::select('dokter_id', $dokter, null, ['class' => 'form-control select2', 'placeholder'=>'-- Pilih Dokter --']) !!}
            <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('sebabsakit_id') ? ' has-error' : '' }}">
        {!! Form::label('sebabsakit_id', 'Sebab Sakit', ['class' => 'col-sm-3']) !!}
        <div class="col-sm-3">
            {!! Form::select('sebabsakit_id', $sebabsakit, null, ['class' => 'form-control select2', 'placeholder'=>'-- pilih --']) !!}
            <small class="text-danger">{{ $errors->first('sebabsakit_id') }}</small>
        </div>
        {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-2']) !!}
        <div class="col-sm-4">
            {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
            <small class="text-danger">{{ $errors->first('sebabsakit_id') }}</small>
        </div>
    </div>
    {!! Form::hidden('bayar', '1') !!}
  </div>	
	<div class="col-md-12">
		<hr>
		<div class="btn-group pull-right">
				<a href="{{ url('antrian/daftarantrian') }}" class="btn btn-warning btn-flat">Batal</a>
				{!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Anda yakin data yang di input sudah benar?")']) !!}
		</div>
  </div>
</div>
