
<div class="form-group{{ $errors->has('kode_satuan') ? ' has-error' : '' }}">
    {!! Form::label('kode_satuan', 'Kode Satuan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-3">
        {!! Form::text('kode_satuan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kode_satuan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nama_satuan') ? ' has-error' : '' }}">
    {!! Form::label('nama_satuan', 'Nama Satuan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-3">
        {!! Form::text('nama_satuan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama_satuan') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('/master/satuan') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
