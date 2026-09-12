<div class="form-group">
    {!! Form::label('role', 'Role Saat Ini', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
      <h4 class="text-danger">
        @foreach ($user->role as $r)
          {{ $r->display_name }}
        @endforeach
      </h4>
    </div>
</div>
<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
    {!! Form::label('role', 'Ubah Role', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
      <select class="form-control select2" name="role">
        <option value="">--</option>
        @foreach ($role as $key => $d)
          <option value="{{ $d->id }}">{{ $d->display_name }}</option>
        @endforeach
      </select>
      <small class="text-danger">{{ $errors->first('role') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name', 'Nama', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('name', $pegawai, null, ['class' => 'form-control select2']) !!}
        <small class="text-danger">{{ $errors->first('name') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    {!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('email') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    {!! Form::label('password', 'Password', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::password('password', ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('password') }}</small>
        </div>
</div>
<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
    {!! Form::label('password_confirmation', 'Password Konfirmasi', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
        </div>
</div>

<div class="form-group{{ $errors->has('kelompokkelas_id') ? ' has-error' : '' }}">
    {!! Form::label('kelompokkelas_id', 'Kelompok Kelas', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <select name="kelompokkelas_id" class="form-control">
                <option value=""></option>
                @foreach (App\Kelompokkelas::all() as $d)
                    <option value="{{ $d->id }}"
						@if ($user->kelompokkelas_id==$d->id)
							selected="selected"
						@endif
					>{{ $d->kelompok }}</option>
                @endforeach
                <option value="10"
					@if ($user->kelompokkelas_id==10)
						selected="selected"
					@endif
				>[Semua]</option>
            </select>
            <small class="text-danger">{{ $errors->first('kelompokkelas_id') }}</small>
        </div>
</div>


<div class="form-group{{ $errors->has('foto') ? ' has-error' : '' }}">
    {!! Form::label('foto', 'Foto', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::file('foto', ['class' => 'form-control']) !!}
            <p class="help-block">Help block text</p>
            <small class="text-danger">{{ $errors->first('foto') }}</small>
        </div>
</div>

<div class="btn-group pull-right">
    <a href="{{ route('user') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
