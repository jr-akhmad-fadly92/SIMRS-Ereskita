<div class="form-group{{ $errors->has('departemen') ? ' has-error' : '' }}">
    {!! Form::label('departemen', 'Nama Departemen', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('departemen', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('departemen') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('/direksi/kategoripegawai') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
