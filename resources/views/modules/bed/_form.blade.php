<div class="form-group{{ $errors->has('kelompokkelas_id') ? ' has-error' : '' }}">
    {!! Form::label('kelompokkelas_id', 'Kelompok', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select class="form-control" name="kelompokkelas_id">
          <option value=""></option>
          @foreach (App\Kelompokkelas::all() as $d)
            @if (isset($bed) && $bed->kamar->kelompokkelas_id == $d->id)
              <option value="{{ $d->id }}" selected>{{ $d->kelompok }}</option>
            @else
              <option value="{{ $d->id }}">{{ $d->kelompok }}</option>
            @endif
          @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('kelompokkelas_id') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kelas_id') ? ' has-error' : '' }}">
    {!! Form::label('kelas_id', 'Kelas', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select class="form-control" name="kelas_id">
          @if (isset($bed))
            <option value="{{ $bed->kamar->kelas_id }}" selected>{{ Modules\Kelas\Entities\Kelas::find($bed->kamar->kelas_id)->nama }}</option>
          @endif
        </select>
        <small class="text-danger">{{ $errors->first('kelas_id') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('kamarid') ? ' has-error' : '' }}">
    {!! Form::label('kamarid', 'Nama Kamar', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select class="form-control" name="kamarid">
          @if (isset($bed))
            <option value="{{ $bed->kamar_id }}" selected>{{ Modules\Kamar\Entities\Kamar::find($bed->kamar_id)->nama }}</option>
          @endif
        </select>
        <small class="text-danger">{{ $errors->first('kamarid') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
    {!! Form::label('nama', 'Nama Bed', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kode') ? ' has-error' : '' }}">
    {!! Form::label('kode', 'Kode Bed', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('kode', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('kode') }}</small>
    </div>
</div>
{{-- <div class="form-group{{ $errors->has('reserved') ? ' has-error' : '' }}">
    {!! Form::label('reserved', 'Reserved', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('reserved', ['N'=>'Kosong', 'Y'=>'Isi'], null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('reserved') }}</small>
    </div>
</div> --}}
<div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('keterangan') }}</small>
    </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ route('bed') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>



