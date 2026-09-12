<div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
    {!! Form::label('kode', 'Kode', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kode') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nama_bidang') ? ' has-error' : '' }}">
    {!! Form::label('nama_bidang', 'Nama Bidang', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama_bidang', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama_bidang') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ url('/direksi/kodebidang') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
