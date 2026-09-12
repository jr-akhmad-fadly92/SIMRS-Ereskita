@extends('master')
@section('header')
  <h1>Stok Gudang Obat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Penerimaan Barang&nbsp;
      </h3>
    </div>
    <div class="box-body">
    <button  data-toggle="modal" data-target="#myModal" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-edit"></i>Pilih PO</button>
    <a class="btn btn-info btn-sm btn-flat" href="{{url('/gudang/penerimaan-obat/laporan')}}"> <i class="fa fa-file"></i> Laporan</a>
    <a id="back_to_purchaseorder" class="btn btn-success btn-flat pull-right btn-sm" href="{{url('/backoffice')}}">
			<span class="glyphicon glyphicon-arrow-left"></span> Back
    </a>
       <br><br>
       <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>No PO</th>
                <th>No Faktur</th>
                <th>Tanggal Pemesanan</th>
                <th>Tanggal Penerimaan</th>
                <th>Total Harga PO</th>
                <th>status</th>
                <th>detail</th>
              </tr>
            </thead>
            <tbody>
            @foreach($list_faktur as $data)
            
              <tr>
                <td>{{$no++}}</td>
                <td>{{$data->no_po}}</td>
                <td>{{$data->no_faktur}}</td>
                <td>{{tanggalkuitansi(tgl_indo($data->po_tanggal_pemesanan))}}</td>
                <td>{{tanggalkuitansi(tgl_indo($data->tanggal_terima))}}</td>
                <td>Rp. {{number_format($data->total+$data->total/100+6000)}}</td>
                <td>{{$data->po_status}}</td>
                <td>
                <a href="{{url('/gudang/penerimaan-obat/laporan_penerimaan/'.$data->no_po)}}"  name="laporan" class="btn btn-primary btn-flat"><i class="fa fa-file"> Penerimaan</i></a>
                <a href="{{url('/gudang/penerimaan-obat/retur_penerimaan/'.$data->no_po)}}"  name="laporan" class="btn btn-primary btn-flat"><i class="fa fa-file"></i> Retur</a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>
  <!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- konten modal-->
			<div class="modal-content">
				<!-- heading modal -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Pilih PO </h4>
				</div>
				<!-- body modal -->
				<div class="modal-body">
          
          <table class='table table-striped table-bordered table-hover table-condensed' id="dataDetailPO" >
            <thead>
              <tr>
                
                <th>No PO</th>
                <th>Supplier</th>
                <th>Tanggal Pemesanan</th>
                <th>Total Harga PO</th>
                <th>detail</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
         
          
				</div>
				<!-- footer modal -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup Modal</button>
				</div>
			</div>
		</div>
	</div>
  <!---endmodal---->  
@endsection
@section('script')
<script type="text/javascript">

</script>

  <script>
  

var table = $('#dataDetailPO').DataTable({
		
		lengthChange: true,
		paging      : true,
		searching   : true,
		ordering    : true,
		autoWidth   : false,
		processing  : true,
		info        : true,
		serverSide  : true,
		ajax: '/gudang/penerimaan-obat/list-po',
		columns: [
				
				{data: 'po_no_purchaseorder'},
				{data: 'nama_produsen'},
				{data: 'po_tanggal_pemesanan'},
				{data: 'total_harga'},
				
				{data: 'add'}
		]
	});

</script>
@endsection