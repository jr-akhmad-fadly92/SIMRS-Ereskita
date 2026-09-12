@extends('master')
@section('header')
  <h1>Mutasi Inventaris</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Mutasi Inventaris&nbsp;
      </h3>
    </div>
    <div class="box-body">
        <button type="button"  class="btn btn-info btn-sm btn-flat" data-toggle="modal" data-target="#modal-input"> <i class="fa fa-edit"></i>Pilin Inventaris</button>
        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No Inv</th>
                <th>Asal Ruangan</th>
                <th>Tanggal Pindah</th>
                <th>Ruangan Saat ini</th>
                <th>Kondisi Barang</th>
                <th>Petugas</th>
                
              </tr>
            </thead>
            <tbody>
              @foreach($historiinventaris as $histori)
                <tr>
                  <td>{{$histori->no_inv}}</td>
                  <td>{{App\Masterruangan::find($histori->asal_ruangan)->ruangan}}</td>
                  <td>{{tgl_indo($histori->tanggal_pindah)}}</td>
                  <td>{{App\Masterruangan::find($histori->update_ruangan)->ruangan}}</td>
                  <td>{{$histori->kondisi_barang}}</td>
                  <td>{{baca_dokter($histori->petugas)}}</td>
                </tr>
              @endforeach
             
            </tbody>
          </table>
        </div>

    </div>
  </div>
  <!---- modal --->
  <div class="modal fade" id="modal-input" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">List Inventaris</h4>
        </div>
        <div class="modal-body">
        <table class='table table-striped table-bordered table-hover table-condensed' id="Mutasi">
            <thead>
              <tr>
                <th>No Inv</th>
                <th>Nama Barang</th>
                <th>Ruangan Saat ini</th>
                <th>Kondisi Barang</th>
                <th>Pilih</th>
              </tr>
            </thead>
            <tbody>
            @foreach($Inventarisdetail as $inv)
             <tr>
                <td>{{$inv->no_inv}}</td>
                <td>{{$inv->nama_barang}}</td>
                <td>{{$inv->ruangan}}</td>
                <td>{{$inv->kondisi_barang}}</td>
                <td><a href="{{ url('/backoffice/Inv-mutasi/'.$inv->no_inv) }}" class="btn btn-info btn-sm"><i class="fa fa-check-square"></i></a>
                </td>
                
             </tr>
            @endforeach
            </tbody>
          </table>
                
        <div class="modal-footer">
          <div class="btn-group">
          
          </div>
          
        </div>
      </div>
    </div>
  </div>
  
@endsection
@section('script')
<script type="text/javascript">
$('#Mutasi').DataTable( {
  autoWidth: false,
  processing: true,
        } );
</script>
@endsection