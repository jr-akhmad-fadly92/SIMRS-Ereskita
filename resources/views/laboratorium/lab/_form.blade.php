<div class="form-group">
    {!! Form::label('mastermapping_biaya_id', 'Lab Group', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('mastermapping_biaya_id', $group, null, ['class' => 'form-control select2', 'placeholder'=>'-- Pilih Group --']) !!}
    </div>
</div>
<div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
    {!! Form::label('tarif_id', 'Nama Tindakan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('tarif_id', Modules\Tarif\Entities\Tarif::where('kategoritarif_id',2)->pluck('nama','id'), null, ['class' => 'form-control form-control select2', 'placeholder'=>'-- Pilih Tindakan --']) !!}
        <small class="text-danger">{{ $errors->first('tarif_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nilairujukanbawah') ? ' has-error' : '' }}">
    {!! Form::label('nilairujukanbawah', 'Nilai Rujukan Bawah', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nilairujukanbawah', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nilairujukanbawah') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nilairujukanatas') ? ' has-error' : '' }}">
    {!! Form::label('nilairujukanatas', 'Nilai Rujukan Atas', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nilairujukanatas', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nilairujukanatas') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nilairujukanbawahwanita') ? ' has-error' : '' }}">
    {!! Form::label('nilairujukanbawahwanita', 'Nilai Rujukan Bawah Wanita', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nilairujukanbawahwanita', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nilairujukanbawahwanita') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nilairujukanataswanita') ? ' has-error' : '' }}">
    {!! Form::label('nilairujukanataswanita', 'Nilai Rujukan Atas Wanita', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nilairujukanataswanita', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nilairujukanataswanita') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nilairujukanbawahanak') ? ' has-error' : '' }}">
    {!! Form::label('nilairujukanbawahanak', 'Nilai Rujukan Bawah Anak / Bayi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nilairujukanbawahanak', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nilairujukanbawahanak') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nilairujukanatasanak') ? ' has-error' : '' }}">
    {!! Form::label('nilairujukanatasanak', 'Nilai Rujukan Atas Anak / Bayi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nilairujukanatasanak', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nilairujukanatasanak') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('satuan') ? ' has-error' : '' }}">
    {!! Form::label('satuan', 'Satuan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('satuan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('satuan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
    </div>
</div>
<hr>
<div class="pull-right">
	<a href="{{ url('lab') }}" class="btn btn-flat btn-warning">BATAL</a>
	{!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat']) !!}
</div>
