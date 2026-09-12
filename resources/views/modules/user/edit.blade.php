@extends('master')
@section('header')
  <h1>Management User</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Edit User &nbsp;
        <a href="{{ route('user') }}" class="btn btn-default btn-sm">KEMBALI</a>
      </h3>
    </div>
    <div class="box-body">
      {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

          @include('user::_formupdate')

      {!! Form::close() !!}
    </div>
  </div>
@endsection


@section('script')
  <script type="text/javascript">

  </script>
@endsection