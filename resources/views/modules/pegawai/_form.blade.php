<style>
.datepicker {
  z-index: 1999!important;
}
</style>
<div class="form-group">
    {!! Form::label('kode', 'Kode (opsional) / NIP', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Lengkap', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kategori_pegawai') ? ' has-error' : '' }}">
    {!! Form::label('kategori_pegawai', 'Kategori Pegawai', ['class' => 'col-md-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('kategori_pegawai', $kat, null, ['class' => 'form-control select2']) !!}
        <small class="text-danger">{{ $errors->first('kategori_pegawai') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('departemen') ? ' has-error' : '' }}">
    {!! Form::label('departemen', 'Departemen Pegawai', ['class' => 'col-md-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('departemen', $departemen, null, ['class' => 'form-control select2']) !!}
        <small class="text-danger">{{ $errors->first('departemen') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('jabatan') ? ' has-error' : '' }}">
    {!! Form::label('jabatan', 'Jabatan Pegawai', ['class' => 'col-md-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('jabatan', $jabatan, null, ['class' => 'form-control select2']) !!}
        <small class="text-danger">{{ $errors->first('jabatan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('status_pegawai') ? ' has-error' : '' }}">
    {!! Form::label('status_pegawai', 'Status Kerja Pegawai', ['class' => 'col-md-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('status_pegawai', $status_pegawai, null, ['class' => 'form-control select2']) !!}
        <small class="text-danger">{{ $errors->first('status_pegawai') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('tgllahir') ? ' has-error' : '' }}">
    {!! Form::label('tgllahir', 'Tanggal Lahir', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('tgllahir', !empty($pegawai->tgllahir) ? tgl_indo($pegawai->tgllahir) : null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tgllahir') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('tmplahir') ? ' has-error' : '' }}">
    {!! Form::label('tmplahir', 'Tempat Lahir', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('tmplahir', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tmplahir') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kelamin') ? ' has-error' : '' }}">
    {!! Form::label('kelamin', 'Jenis Kelamin', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('kelamin', ['L'=>'Laki-laki','P'=>'Perempuan'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kelamin') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('status_ktp_pegawai') ? ' has-error' : '' }}">
    {!! Form::label('status_ktp_pegawai', 'Status Nikah', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
    {!! Form::select('status_ktp_pegawai', $status_ktp_pegawai, null, ['class' => 'form-control select2']) !!}
    <small class="text-danger">{{ $errors->first('status_ktp_pegawai') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('agama') ? ' has-error' : '' }}">
    {!! Form::label('agama', 'Agama', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('agama', ['islam'=>'Islam', 'kristen'=>'Kristen', 'katolik'=>'Katolik', 'hindu'=>'Hindu', 'budha'=>'Budha'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('agama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
    {!! Form::label('alamat', 'Alamat', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('alamat', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('alamat') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
    {!! Form::label('sip', 'SIP', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('sip', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('sip') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
    {!! Form::label('str', 'STR', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('str', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('str') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
    {!! Form::label('kompetensi', 'Kompetensi', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('kompetensi', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kompetensi') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
    {!! Form::label('tupoksi', 'Tupoksi', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-9">
        {!! Form::text('tupoksi', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tupoksi') }}</small>
    </div>
</div>

{{-- user ID --}}
{!! Form::hidden('user_id', Auth::user()->id) !!}
