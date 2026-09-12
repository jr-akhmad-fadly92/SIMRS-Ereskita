<div class="form-group{{ $errors->has('id_produsen') ? ' has-error' : '' }}">
    {!! Form::label('id_produsen', 'ID Produsen', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        @if(isset($produsen))
        {!! Form::text('id_produsen', null, ['class' => 'form-control','readonly' => 'true']) !!}
        @else
        {!! Form::text('id_produsen', null, ['class' => 'form-control ']) !!}
        @endif
        <small class="text-danger">{{ $errors->first('id_produsen') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nama_produsen') ? ' has-error' : '' }}">
    {!! Form::label('nama_produsen', 'Nama Produsen', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama_produsen', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama_produsen') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('alamat_produsen') ? ' has-error' : '' }}">
    {!! Form::label('alamat_produsen', 'Alamat', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('alamat_produsen', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('alamat_produsen') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('telp') ? ' has-error' : '' }}">
    {!! Form::label('telp', 'Telepon / WA', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('telp', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('telp') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    {!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('email') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
    {!! Form::label('website', 'Website', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('website', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('website') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kategori') ? ' has-error' : '' }}">
    {!! Form::label('kategori', 'Kategori', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('kategori', ['obat'=>'obat','inventaris'=>'inventaris','nonmedis'=>'nonmedis'], null, ['class' => 'form-control', 'required' => 'required']) !!}
        <small class="text-danger">{{ $errors->first('kategori') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('/backoffice/produsen-supplier') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
