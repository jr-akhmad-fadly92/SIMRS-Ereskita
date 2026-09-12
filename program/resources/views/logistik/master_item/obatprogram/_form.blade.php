
<div class="form-group{{ $errors->has('nama_program') ? ' has-error' : '' }}">
    {!! Form::label('nama_program', 'Nama Program', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-3">
        {!! Form::text('nama_program', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama_program') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-3">
        {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('keterangan') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('/master/obat_program') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
