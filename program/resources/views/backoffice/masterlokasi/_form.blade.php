<div class="form-group{{ $errors->has('ruangan_id') ? ' has-error' : '' }}">
    {!! Form::label('ruangan_id', 'Ruangan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select class="form-control" name="ruangan_id">
          <option value=""></option>
          @foreach (App\Masterruangan::all() as $d)
            @if (isset($lokasi_barang) && $lokasi_barang->ruangan_id == $d->id)
              <option value="{{ $d->id }}" selected>{{ $d->ruangan }}</option>
            @else
              <option value="{{ $d->id }}">{{ $d->ruangan }}</option>
            @endif
          @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('ruangan_id') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('lokasi') ? ' has-error' : '' }}">
    {!! Form::label('lokasi', 'Nama Lokasi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('lokasi', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('lokasi') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('/backoffice/master_lokasi_barang') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
