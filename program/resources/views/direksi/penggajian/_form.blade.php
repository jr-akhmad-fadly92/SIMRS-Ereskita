<div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
    {!! Form::label('kode', 'NIP Pegawai', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode', null, ['class' => 'form-control','readonly' => 'true'],) !!}
        <small class="text-danger">{{ $errors->first('kode') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Pegawai', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control','readonly' => 'true']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
{!! Form::text('tunjanganktp', App\StatusKtpPegawai::find($pegawai->status_ktp_pegawai)->tunjangan , ['class' => ' hidden col-sm-3 control-label']) !!}
{!! Form::text('tunjangan', App\MasterJabatan::find($pegawai->jabatan)->tunjangan_jabatan , ['class' => 'hidden col-sm-3 control-label']) !!}
<div class="hidden form-group{{ $errors->has('jabatan') ? ' has-error' : '' }}">
    {!! Form::label('jabatan', 'Jabatan Pegawai', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('jabatan', null, ['class' => 'form-control','readonly' => 'true']) !!}
        <input name="jabatan1" value="{{$pegawai->tunjangan_jabatan}}" class = 'form-control'>
        <small class="text-danger">{{ $errors->first('jabatan') }}</small>
    </div>
</div>
<div class="hidden form-group{{ $errors->has('status_ktp_pegawai') ? ' has-error' : '' }}">
    {!! Form::label('status_ktp_pegawai', 'status nikah', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('status_ktp_pegawai', null, ['class' => 'form-control','readonly' => 'true']) !!}
        
        <small class="text-danger">{{ $errors->first('status_ktp_pegawai') }}</small>
    </div>
</div>
<div class="hidden form-group{{ $errors->has('status_pegawai') ? ' has-error' : '' }}">
    {!! Form::label('status_pegawai', 'status Kerja', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        
        {!! Form::text('status_pegawai', null, ['class' => 'form-control','readonly' => 'true']) !!}
        <small class="text-danger">{{ $errors->first('status_pegawai') }}</small>
    </div>
</div>

@if(Modules\Pegawai\Entities\Pegawai::find($pegawai->id)->status_pegawai==1)
<div class="form-group{{ $errors->has('gaji_kontrak') ? ' has-error' : '' }}" hidden>
    {!! Form::label('gaji_kontrak', 'penggajian pegawai kontrak', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::number('gaji_kontrak', null.'%', ['class' => 'form-control', 'readonly' => 'true']) !!} %
        <small class="text-danger">{{ $errors->first('gaji_kontrak') }}</small>
    </div>
</div>
@else
<div class="form-group{{ $errors->has('gaji_kontrak') ? ' has-error' : '' }}">
    {!! Form::label('gaji_kontrak', 'penggajian pegawai kontrak', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-8">
    @foreach(App\Penggajian::where('kode',$pegawai->id)->get() as $gapok)
        {!! Form::number('gaji_kontrak',$gapok->gaji_kontrak, ['class' => '']) !!} %
    @endforeach    
        <small class="text-danger">{{ $errors->first('gaji_kontrak') }}</small>
    </div>
</div>
@endif
@if(Modules\Pegawai\Entities\Pegawai::find($pegawai->id)->status_gaji==1)
<div class="form-group{{ $errors->has('gaji_pokok') ? ' has-error' : '' }}">
    {!! Form::label('gaji_pokok', 'Gaji Pokok', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
    @foreach(App\Penggajian::where('kode',$pegawai->id)->get() as $gapok)
        {!! Form::number('gaji_pokok', $gapok->gaji_pokok, ['class' => 'form-control']) !!}
    @endforeach
        <small class="text-danger">{{ $errors->first('gaji_pokok') }}</small>
    </div>
</div>
@else
<div class="form-group{{ $errors->has('gaji_pokok') ? ' has-error' : '' }}">
    {!! Form::label('gaji_pokok', 'Gaji Pokok', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::number('gaji_pokok', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('gaji_pokok') }}</small>
    </div>
</div>
@endif
<div class="btn-group pull-right">
    <a href="{{ url('/direksi/penggajian') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
