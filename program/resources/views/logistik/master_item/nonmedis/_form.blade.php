
<div class="col-md-6">
    <div class="form-group{{ $errors->has('kode_barang') ? ' has-error' : '' }}">
        {!! Form::label('kode_barang', 'Kode Barang', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('kode_barang', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('kode_obat') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('nama_barang') ? ' has-error' : '' }}">
        {!! Form::label('nama_barang', 'Nama Barang', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('nama_barang', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('nama_barang') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('jenis') ? ' has-error' : '' }}">
        {!! Form::label('jenis', 'Jenis Barang', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            <select class="form-control select2" name="jenis">
            <option value=""></option>
            @foreach (App\Masterjenisbarang::all() as $d)
                @if (isset($non_medis) && $non_medis->jenis == $d->id)
                <option value="{{ $d->id }}" selected>{{ $d->jenis_barang }}</option>
                @else
                <option value="{{ $d->id }}">{{ $d->jenis_barang }}</option>
                @endif
            @endforeach
            </select>
            <small class="text-danger">{{ $errors->first('jenis') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('satuan') ? ' has-error' : '' }}">
        {!! Form::label('satuan', 'Satuan', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            <select class="form-control select2" name="satuan">
            <option value=""></option>
            @foreach (App\Satuan::all() as $d)
                @if (isset($non_medis) && $non_medis->satuan == $d->kode_satuan)
                <option value="{{ $d->kode_satuan }}" selected>{{ $d->nama_satuan }}</option>
                @else
                <option value="{{ $d->kode_satuan }}">{{ $d->nama_satuan }}</option>
                @endif
            @endforeach
            </select>
            <small class="text-danger">{{ $errors->first('satuan') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('stok') ? ' has-error' : '' }}">
        {!! Form::label('stok', 'Stok', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('stok', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('stok') }}</small>
        </div>
    </div><div class="form-group{{ $errors->has('harga') ? ' has-error' : '' }}">
        {!! Form::label('harga', 'Harga', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('harga', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('harga') }}</small>
        </div>
    </div>
    
<div class="btn-group pull-right">
    <a href="{{ url('/master-nonmedis') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
</div>