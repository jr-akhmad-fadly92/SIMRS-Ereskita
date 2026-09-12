
<div class="form-group{{ $errors->has('nama_golongan') ? ' has-error' : '' }}">
    {!! Form::label('nama_golongan', 'Nama Golongan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-3">
        {!! Form::text('nama_golongan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama_golongan') }}</small>
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
    <a href="{{ url('/master/golongan_obat') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
