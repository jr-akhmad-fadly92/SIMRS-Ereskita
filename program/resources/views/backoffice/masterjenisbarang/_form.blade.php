<div class="form-group{{ $errors->has('jenis_barang') ? ' has-error' : '' }}">
    {!! Form::label('jenis_barang', 'Jenis Barang', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('jenis_barang', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('jenis_barang') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('/backoffice/master_jenis_barang') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
