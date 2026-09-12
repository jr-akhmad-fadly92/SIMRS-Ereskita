@extends('master')
@section('header')
  <h1>Laporan Penjualan Obat Pasien</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      {{-- <h3 class="box-title">
        Periode Tanggal &nbsp;
      </h3> --}}
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/laporan-obat', 'class'=>'form-horizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="periode" class="col-sm-3 control-label">Periode</label>
              <div class="col-sm-9">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="tga" value="{{ isset($_POST['tga']) ? $_POST['tga'] : NULL }}" class="form-control datepicker">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="tgb" value="{{ isset($_POST['tgb']) ? $_POST['tgb'] : NULL }}" class="form-control datepicker">
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="jenis" class="col-sm-3 control-label">&nbsp;</label>
              <div class="col-sm-9">
                <button type="submit" name="check" class="btn btn-primary btn-flat" value="check">CHECK</button>
                <button type="submit" name="pdf" class="btn btn-primary btn-flat" value="pdf">PDF</button>
              </div>
            </div>

          </div>
          <div class="col-sm-6">
            

          </div>
        </div>
      {!! Form::close() !!}
      
      @isset ($penjualan)
        <h4>Periode: {{ $tga }} s/d {{ $tgb }}</h4>
        <br>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed" id="data" >
              <thead>
                <tr class="bg-primary">
                  <th>No</th>
                  <th>Nama Obat</th>
                  <th>Jumlah yang terjual</th>
                  <th>Harga Satuan</th>
                  <th class="text-center">Total</th>
                  <th>Detail</th>
                </tr>
              </thead>
              <tbody>
                @foreach($penjualan as $data)
                <tr>
                  <th>{{$no++}}</th>
                  <th>{{$data->nama}}</th>
                  <th>{{$data->total_jumlah}}</th>
                  <th>Rp. {{number_format($data->hargasatuan)}}</th>
                  <th class="text-right">Rp. {{number_format($data->total)}}</th>
                  <th>Detail</th>
                </tr>
                @endforeach
              </tbody>
            </table>
            <br>
            <h4>Total Jumlah yang terjual : <b>Rp. {{number_format($total_penjualan->total)}}</b></h4>
          </div>
      @endisset


<div class="modal fade" id="detailpenjualan">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div id="dataDetailPenjualan"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
     
@endsection

@section('script')
  <script type="text/javascript">
    $(function () {

    $('#dataPenjualan').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    });
  });
  </script>
@endsection
