
<div class="form-group{{ $errors->has('jenis_racikan') ? ' has-error' : '' }}">
    {!! Form::label('jenis_racikan', 'Jenis Racikan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-3">
        {!! Form::text('jenis_racikan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('jenis_racikan') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('/master/jenis_racikan') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
