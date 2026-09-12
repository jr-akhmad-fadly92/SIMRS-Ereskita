@extends('master')
@section('header')
  <h1>Tracer <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <form method="POST" class="form-horizontal" role="form">
        <div class="row">
          <div class="col-md-6 col-lg-6">
            <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::text('tanggal', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                </div>
            </div>
           </div>
           <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
             <div class="form-group{{ $errors->has('poli') ? ' has-error' : '' }}">
                 {!! Form::label('poli', 'Poli Tujuan', ['class' => 'col-sm-3 control-label']) !!}
                 <div class="col-sm-9">
                     <select class="form-control" name="poli">
                       <option value="">[Semua]</option>
                       @foreach (Modules\Poli\Entities\Poli::all() as $key => $d)
                         <option value="{{ $d->id }}">{{ $d->nama }}</option>
                       @endforeach
                     </select>
                     <small class="text-danger">{{ $errors->first('poli') }}</small>
                 </div>
             </div>
            </div>
        </div>
      </form>
      <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pasien</th>
              <th>No. RM</th>
              <th>Klinik Tujuan</th>
              <th>Dokter</th>
              <th>Cara Bayar</th>
              <th>Antrian Klinik</th>
              <th>Cetak</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>

@endsection

@section('script')
  <script type="text/javascript">
  $(document).ready(function() {
    var table = $('.table').DataTable({
      language : { "url": "/json/pasien.datatable-language.json" },
      serverSide : true,
      ordering : false,
      info : true,
      autoWidth : false,
      destroy : true,
      processing : true,
      ajax: '/frontoffice/data-tracer/',
      columns: [
        {data: 'nomorbaris'},
        {data: 'pasien'},
        {data: 'norm'},
        {data: 'poli'},
        {data: 'dokter'},
        {data: 'bayar'},
        {data: 'antrian_poli'},
        {data: 'cetak'}
      ]
    });
  });

    $('select[name="poli"]').on('change', function(e) {
      e.preventDefault()
      var poli_id = $(this).val();
      if(poli_id == '') {
        var table = $('.table').DataTable({
          language : { "url": "/json/pasien.datatable-language.json" },
          serverSide : true,
          ordering : true,
          info : false,
          autoWidth : false,
          destroy : true,
          processing : true,
          ajax: '/frontoffice/data-tracer/',
          columns: [
            {data: 'nomorbaris'},
            {data: 'pasien'},
            {data: 'norm'},
            {data: 'poli'},
            {data: 'dokter'},
            {data: 'bayar'},
            {data: 'antrian_poli'},
            {data: 'cetak'}
          ]
        });
      } else {
        var tanggal = $('input[name="tanggal"]').val();
        var table = $('.table').DataTable({
          language : { "url": "/json/pasien.datatable-language.json" },
          serverSide : true,
          ordering : false,
          info : false,
          autoWidth : false,
          destroy : true,
          processing : true,
          ajax: '/frontoffice/data-tracer/'+poli_id+'/'+tanggal,
          columns: [
            {data: 'nomorbaris'},
            {data: 'pasien'},
            {data: 'norm'},
            {data: 'poli'},
            {data: 'dokter'},
            {data: 'bayar'},
            {data: 'antrian_poli'},
            {data: 'cetak'}
          ]
        });
      }
    })

  </script>
@endsection
