<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
    {!! Form::label('status', 'Status KTP Pegawai', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('status', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('status') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('keterangan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('tunjangan') ? ' has-error' : '' }}">
    {!! Form::label('tunjangan', 'Tunjangan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::number('tunjangan', 0, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tunjangan') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('/direksi/statusktppegawai') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
