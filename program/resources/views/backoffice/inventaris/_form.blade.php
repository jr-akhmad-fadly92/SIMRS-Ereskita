<div class="form-group{{ $errors->has('kode_barang') ? ' has-error' : '' }}">
    {!! Form::label('kode_barang', 'Kode Barang', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode_barang', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kode_barang') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nama_barang') ? ' has-error' : '' }}">
    {!! Form::label('nama_barang', 'Nama Barang', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama_barang', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama_barang') }}</small>
    </div>
</div>
{{--<div class="form-group{{ $errors->has('jumlah_barang') ? ' has-error' : '' }}">
    {!! Form::label('jumlah_barang', 'Jumlah Barang', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::number('jumlah_barang', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('jumlah_barang') }}</small>
    </div>
</div>--}}
<div class="form-group{{ $errors->has('produsen') ? ' has-error' : '' }}">
    {!! Form::label('produsen', 'Produsen', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select class="form-control" name="produsen">
          <option value=""></option>
          @foreach (App\Masterprodusen::where('kategori','inventaris')->get() as $d)
            @if (isset($Inventarisglobal) && $Inventarisglobal->produsen == $d->id_produsen)
              <option value="{{ $d->id_produsen }}" selected>{{ $d->nama_produsen }}</option>
            @else
              <option value="{{ $d->id_produsen }}">{{ $d->nama_produsen }}</option>
            @endif
          @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('produsen') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('merk') ? ' has-error' : '' }}">
    {!! Form::label('merk', 'Merk', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('merk', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('merk') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('tahun_produksi') ? ' has-error' : '' }}">
    {!! Form::label('tahun_produksi', 'Tahun Produksi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::number('tahun_produksi', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('tahun_produksi') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('harga_unit') ? ' has-error' : '' }}">
    {!! Form::label('harga_unit', 'Harga Per Unit', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::number('harga_unit', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('harga_unit') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('katagori_barang') ? ' has-error' : '' }}">
    {!! Form::label('katagori_barang', 'Katagori Barang', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select class="form-control" name="kategori_barang">

          @if(isset($Inventarisglobal) && $Inventarisglobal->kategori_barang=='nonelektronik')<option value="nonelektronik" selected>Non Elektronik</option>@else<option value="nonelektronik">Non Elektronik</option>@endif
          @if(isset($Inventarisglobal) && $Inventarisglobal->kategori_barang=='elektronik')<option value="elektronik" selected>Elektronik</option>@else<option value="elektronik">Elektronik</option>@endif
          
        </select>
        <small class="text-danger">{{ $errors->first('katagori_barang') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('jenis_barang') ? ' has-error' : '' }}">
    {!! Form::label('jenis_barang', 'Jenis Barang', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select class="form-control" name="jenis_barang">
          <option value="">---Pilih---</option>
          @foreach (App\Masterjenisbarang::all() as $d)
            @if (isset($Inventarisglobal) && $Inventarisglobal->jenis_barang == $d->id)
              <option value="{{ $d->id }}" selected>{{ $d->jenis_barang }}</option>
            @else
              <option value="{{ $d->id }}">{{ $d->jenis_barang }}</option>
            @endif
          @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('jenis_barang') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('/backoffice/Inv-global') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
