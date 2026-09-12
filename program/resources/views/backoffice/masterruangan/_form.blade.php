<div class="form-group{{ $errors->has('ruangan') ? ' has-error' : '' }}">
    {!! Form::label('ruangan', 'Nama Ruangan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('ruangan', null, ['class' => 'form-control']) !!}
        <small class="text-danger">{{ $errors->first('ruangan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
    {!! Form::label('role', 'Nama Role', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select id="role" name="role" class="form-control select2">
            <option>--pilih--</option>
            @foreach(App\Role::all() as $data)
            @if(isset($ruangan) && $data->id==$ruangan->role)
            <option value="{{$data->id}}" selected>{{$data->display_name}}</option> 
            @else
            <option value="{{$data->id}}">{{$data->display_name}}</option>
            @endif
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('role') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('/backoffice/master_ruangan') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
