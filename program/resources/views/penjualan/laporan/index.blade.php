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
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/laporan', 'class'=>'form-horizontal']) !!}
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
        <div class="table-responsive">
          <table class="table table-hover table-condensed table-bordered">
            <thead>
              <tr>
                <th></th>
                <th>JKN</th>
                <th>NON JKN</th>
                <th>TOTAL</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>Penjualan</th>
                <td>{{ $jkn->count() }}</td>
                <td>{{ $penjualan->count() - $jkn->count() }}</td>
                <td>{{ $penjualan->count() }}</td>
              </tr>
              <tr>
                <th>Total</th>
                <td>{{ number_format( $jkn->sum('total') ) }}</td>
                <td>{{ number_format($penjualan->sum('total') - $jkn->sum('total')) }}</td>
                <td>{{ number_format($penjualan->sum('total')) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed" id="dataPenjualan">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No. Faktur</th>
                  <th>Nama Pasien</th>
                  <th>No. RM</th>
                  <th class="text-center">Total</th>
                  <th>Jenis Pasien</th>
                  <th class="text-center">Tanggal</th>
                  <th>User</th>
                  <th>Detail</th>
                </tr>
              </thead>
              <tbody>
                @if ($penjualan->count() < 3000)
                  @foreach ($penjualan as $d)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $d->namatarif }}</td>
                        <td>{{ $d->pasien_id == 0 ? 'Pasien Langsung' : $d->pasien->nama }}</td>
                        <td>{{ $d->pasien_id == 0 ? 'Pasien Langsung' : $d->pasien->no_rm }}</td>
                        <td class="text-right">{{ number_format($d->total) }}</td>
                        <td class="text-center">{{ !empty($d->cara_bayar_id) ? baca_carabayar($d->cara_bayar_id) : 'Penjualan Langsung' }}</td>
                        <td class="text-right">{{ $d->created_at->format('d-m-Y') }}</td>
                        <td>{{ App\User::find($d->user_id)->name }}</td>
                        <td>
                          <button class="btn btn-success btn-sm btn-flat" onclick="detailLaporan('{{ $d->namatarif }}')"><i class="fa fa-folder-open"></i></button>
                        </td>
                      </tr>
                  @endforeach
                @else
                  <tr>
                    <th class="text-center" colspan="8">Data lebih dari 3000 tidak bisa di tampilkan</th>
                  </tr>
                @endif
                
              </tbody>
            </table>
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

    function detailLaporan(faktur) {
      $('#detailpenjualan').modal('show');
      $('.modal-title').text('Detail Penjualan No. Faktur: '+faktur);
      $('#dataDetailPenjualan').load('/penjualan/laporan/'+faktur)
    }

  </script>
@endsection
