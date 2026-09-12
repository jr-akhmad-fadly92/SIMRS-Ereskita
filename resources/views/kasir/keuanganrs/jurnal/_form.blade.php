<div class="form-group{{ $errors->has('kode_keuangan') ? ' has-error' : '' }}">

    {!! Form::label('kode_keuangan', 'Kode Keuangan', ['class' => 'col-sm-3 control-label']) !!}

    <div class="col-sm-9">

        {!! Form::number('kode_keuangan', null, ['class' => 'form-control']) !!}

        <small class="text-danger">{{ $errors->first('kode_keuangan') }}</small>

    </div>

</div>

<div class="form-group{{ $errors->has('nama_akun') ? ' has-error' : '' }}">

    {!! Form::label('nama_akun', 'Nama Akun Keuangan', ['class' => 'col-sm-3 control-label']) !!}

    <div class="col-sm-9">

        {!! Form::text('nama_akun', null, ['class' => 'form-control']) !!}

        <small class="text-danger">{{ $errors->first('nama_akun') }}</small>

    </div>

</div>

<div class="form-group{{ $errors->has('tipe') ? ' has-error' : '' }}">

    {!! Form::label('tipe', 'Tipe Kelompok Keuangan', ['class' => 'col-sm-3 control-label']) !!}

    <div class="col-sm-9">

        {!! Form::select('tipe', ['N'=>'Neraca', 'R'=>'Laba/Rugi', 'P'=>'Perubahan Modal'], null, ['class' => 'form-control']) !!}

        <small class="text-danger">{{ $errors->first('tipe') }}</small>

    </div>

</div>

<div class="form-group{{ $errors->has('balance') ? ' has-error' : '' }}">

    {!! Form::label('balance', 'Balance', ['class' => 'col-sm-3 control-label']) !!}

    <div class="col-sm-9">

        {!! Form::select('balance', ['D'=>'Debet', 'K'=>'Kredit'], null, ['class' => 'form-control']) !!}

        <small class="text-danger">{{ $errors->first('balance') }}</small>

    </div>

</div>

<div class="btn-group pull-right">

    <a href="{{ url('/kasir/keuangan/akun') }}" class="btn btn-warning btn-flat">Batal</a>

    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}

</div>

