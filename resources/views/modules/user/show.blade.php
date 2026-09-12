@extends('master')
@section('header')
  <h1>Management User</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Data User &nbsp;

      </h3>
    </div>
    <div class="box-body">
      {!! Form::model($user, ['url' => ['user/updateuser'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}

      <div class="form-group">
          {!! Form::label('email', 'Role', ['class' =>'col-sm-3 control-label']) !!}
          <div class="col-sm-5">
            <input type="text" class="form-control" value="{{ Auth::user()->role()->first()->display_name }}" readonly>
          </div>
      </div>
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('name', 'Nama Lengkap', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-5">
                  {!! Form::text('name', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('name') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              {!! Form::label('email', 'Email address', ['class' =>'col-sm-3 control-label']) !!}
              <div class="col-sm-5">
                  {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'readonly' => true]) !!}
                  <small class="text-danger">{{ $errors->first('email') }}</small>
              </div>
          </div>
          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              {!! Form::label('password', 'Password', ['class' => 'col-sm-3 control-label']) !!}
                  <div class="col-sm-5">
                      {!! Form::password('password', ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('password') }}</small>
                  </div>
          </div>
          <div class="form-group">
              {!! Form::label('email', ' ', ['class' =>'col-sm-3 control-label']) !!}
              <div class="col-sm-5">
                  {!! Form::submit("Update", ['class' => 'btn btn-success btn-flat']) !!}
              </div>
          </div>

        {!! Form::close() !!}
    </div>
  </div>
@endsection
