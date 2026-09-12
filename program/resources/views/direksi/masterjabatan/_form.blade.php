<div class="form-group{{ $errors->has('kode_jabatan') ? ' has-error' : '' }}">
    {!! Form::label('kode_jabatan', 'Kode Jabatan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode_jabatan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kode_jabatan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nama_jabatan') ? ' has-error' : '' }}">
    {!! Form::label('nama_jabatan', 'Nama Jabatan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama_jabatan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama_jabatan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('tunjangan_jabatan') ? ' has-error' : '' }}">
    {!! Form::label('tunjangan_jabatan', 'Tunjangan Jabatan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('tunjangan_jabatan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tunjangan_jabatan') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('/direksi/masterjabatan') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
