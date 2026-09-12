<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama', ['class' => 'col-sm-2']) !!}
    <div class="col-sm-5">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('politype') ? ' has-error' : '' }}">
    {!! Form::label('politype', 'Jenis Poli', ['class' => 'col-sm-2']) !!}
    <div class="col-sm-5">
        {!! Form::select('politype', $poli, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('politype') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('bpjs') ? ' has-error' : '' }}">
    {!! Form::label('bpjs', 'BPJS', ['class' => 'col-sm-2']) !!}
    <div class="col-sm-5">
        {!! Form::text('bpjs', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('bpjs') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('cetak_antrian') ? ' has-error' : '' }}">
    {!! Form::label('cetak_antrian', 'Cetak Antrian', ['class' => 'col-sm-2']) !!}
    <div class="col-sm-5">
        {!! Form::select('cetak_antrian', ['1'=>'Ya', '0'=>'Tidak'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('cetak_antrian') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kuota') ? ' has-error' : '' }}">
    {!! Form::label('kuota', 'Kuota', ['class' => 'col-sm-2']) !!}
    <div class="col-sm-5">
        {!! Form::text('kuota', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kuota') }}</small>
    </div>
</div>
<!--div class="form-group{{ $errors->has('instalasi_id') ? ' has-error' : '' }}">
    {!! Form::label('instalasi_id', 'Instalasi', ['class' => 'col-sm-2']) !!}
    <div class="col-sm-5">
        {!! Form::select('instalasi_id', $instalasi, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('instalasi_id') }}</small>
    </div>
</div-->
<!--div class="form-group{{ $errors->has('kamar_id') ? ' has-error' : '' }}">
    {!! Form::label('kamar_id', 'Kamar', ['class' => 'col-sm-2']) !!}
    <div class="col-sm-5">
        {!! Form::select('kamar_id', $kamar, null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kamar_id') }}</small>
    </div>
</div-->

<div class="col-sm-offset-2 col-sm-5">
	<div class="btn-group pull-right">
		{!! Form::reset("Reset", ['class' => 'btn btn-warning btn-flat']) !!}
		{!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
	</div>
</div>