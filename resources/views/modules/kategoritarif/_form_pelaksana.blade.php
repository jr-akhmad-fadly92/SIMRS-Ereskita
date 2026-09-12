<div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
    {!! Form::label('pelaksana', 'Pelaksana Tarif Instalasi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('pelaksana', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('[pelaksana]') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ route('kategoritarif') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
