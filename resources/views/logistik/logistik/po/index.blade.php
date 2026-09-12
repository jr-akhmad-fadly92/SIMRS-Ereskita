@extends('master')
@section('header')
  <h1>Stok Gudang Obat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Pengadaan Barang&nbsp; 
      </h3>
    </div>
    <div class="box-body">
        <a type="button" href="{{url('/gudang/po-obat/order/'.$data='obat')}}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-edit"></i>Order Obat</a>
        <a type="button" href="{{url('/gudang/po-obat/order/'.$data='inventaris')}}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-edit"></i>Order Inventaris</a>
        <a type="button" href="{{url('/gudang/po-obat/order/'.$data='nonmedis')}}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-edit"></i>Order Non Medis</a>
        <a id="back_to_purchaseorder" class="btn btn-success btn-flat pull-right btn-sm" href="{{url('/backoffice')}}">
          <span class="glyphicon glyphicon-arrow-left"></span> Back
        </a>
       <div class='table-responsive col-md-12'>
       <br>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>No PO</th>
                <th>Nama Yang mengajukan</th>
                <th>Tanggal Pemesanan</th>
                <th>Total Harga PO</th>
                <th>detail</th>
              </tr>
            </thead>
            <tbody>
              @foreach($tbpurchase as $data)
              @php
              $total=App\Tbdetailpurchase::where('dpo_no_purchaseorder',$data->po_no_purchaseorder)->sum('dpo_total_price');
              $materai=6000;
              $ppn=$total/100*10;
              @endphp
                <tr>
                  <td>{{$no++}}</td>
                  <td>{{$data->po_no_purchaseorder}}</td>
                  <td>{{baca_pegawai($data->po_nama_pemohon)}}</td>
                  <td>{{tgl_indo($data->po_tanggal_pemesanan)}}</td>
                  <td>Rp. {{number_format($total+$materai+$ppn)}}</td>
                  <td>
                    <a href="{{ url('/gudang/po-obat/pdf/'.$data->po_no_purchaseorder) }}" class="btn btn-warning btn-sm"><i class="fa fa-file"></i></a>
                  </td>
                  
                </tr>
              @endforeach 
            </tbody>
          </table>
        </div>

    </div>
  </div>
  <script>
function deletelist() {
  confirm("Anda Yakin ingin menghapus ?");
}
</script>
  
@endsection
