<div class="form-group{{ $errors->has('kelompokkelas_id') ? ' has-error' : '' }}">
    {!! Form::label('kelompokkelas_id', 'Kelompok', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kelompokkelas_id', $kelompok, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kelompokkelas_id') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('kelas_id') ? ' has-error' : '' }}">
    {!! Form::label('kelas_id', 'Kelas', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kelas_id', $kelas, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kelas_id') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Kamar', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('tarif') ? ' has-error' : '' }}">
    {!! Form::label('tarif', 'Tarif', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::number('tarif', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tarif') }}</small>
    </div>
</div>

<div class="pull-right">
    <a href="{{ route('kamar') }}" class="btn btn-warning btn-flat">BATAL</a>
    {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat']) !!}
</div>
