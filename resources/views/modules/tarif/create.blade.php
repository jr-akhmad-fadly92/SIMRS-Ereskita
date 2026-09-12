@extends('master')

@section('header')
  <h1>Master Tarif </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Master Tarif &nbsp;
          <a href="{{ route('tarif.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'tarif.store', 'class' => 'form-horizontal']) !!}
            @include('tarif::_form')
        {!! Form::close() !!}
      </div>
    </div>
    <script>
      function sum() {
      var satu = document.getElementById('tarif_tindakan_perawat').value;
      var dua = document.getElementById('tarif_tindakan_dokter').value;
      var tiga = document.getElementById('tarif_jasa_rumah_sakit').value;
      var result = parseInt(satu) + parseInt(dua) + parseInt(tiga);
      if (!isNaN(result)) {
         document.getElementById('tarif_kelas_rj').value = result;
      }
}
</script>
@stop
