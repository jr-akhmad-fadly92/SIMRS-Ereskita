<style>
.content{
	padding:0 15px 15px 15px !important; 
}
</style>
@extends('master')
@section('header')
  <!--h1>Order Obat</h1-->
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
					Data Order Obat &nbsp; &nbsp;
					@if($status_aksi)
						<a href="{{ url('depo-obat/order') }}" class="btn btn-success btn-sm btn-flat">ORDER BARU</a>
					@endif
        </h3>
      </div>
      <div class="box-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed tableData'>
              <thead>
                <tr>
                  <th>No</th>
				  <th>Depo</th>
                  <th>No. Order</th>
                  <th>Tanggal Order</th>
                  <th>Tanggal Penerimaan</th>
                  <th>Petugas</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
      </div>
    </div>

{{-- DETAIL PO --}}
<div class="modal fade" id="detailPO" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog" style="width:750px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""></h4>
      </div>
      <div class="modal-body">
          <table class='table table-striped table-bordered table-hover table-condensed'>
              <tbody>
                <tr>
                    <th>Tanggal</th> <td id="tanggal">  </td>
                </tr>
                <tr>
										<th>No. PO</th> <td id="no_po">  </td>
                </tr>
                <tr>
                    <th>Petugas</th> <td id='user_create'>  </td>
                </tr>
                <tr>
                    <th>Catatan</th> <td id='catatan'>  </td>
                </tr>
                <tr>
                    <th>Status</th> <td id='status'>  </td>
                </tr>
              </tbody>
          </table>

          <div class='table-responsive'>
            <table id="dataDetailPO" class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Kode Pemberian</th>
                    <th>Nama Pemberian</th>
                    <th>Jumlah Pemberian</th>
                    <th>Satuan</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-flat" data-dismiss="modal">Close</button>
		@if(!$status_aksi)
			<button type="button" class="btn btn-success btn-flat" onclick="simpanSetuju()" id="simpan_setuju">Simpan & Setuju</button>
			<input type="hidden" id="no_po_hidden" value="">
		@endif
      </div>
    </div>
  </div>
</div>

@stop

@section('script')
<script type="text/javascript">
	function updatePemberian(value,no_po,kode_item){
		$.ajax({
            url: 'dist-update-pemberian/'+value+'/'+no_po+'/'+kode_item,
            type: 'GET',
            success: function (data) {
                //$('#data').html(data.data_);
            }
        })
	}
	function simpanSetuju(){
		var no_po = $('#no_po_hidden').val();
		$.ajax({
				url: 'dist-simpan-setuju/'+no_po,
				type: 'GET',
				success: function (data) {
						if(data.sukses){
			window.location.reload(true);
		}else{
			alert(data.message);
		}
				}
		})
	}
	
	$('.tableData').DataTable({
		
		autoWidth: false,
		processing: true,
		serverSide: true,
		ajax: '/depo-data',
		columns: [
				{data: 'rownum'},
				{data: 'id_depo'},
				{data: 'no_po'},
				{data: 'tanggal'},
				{data: 'tgl_penerimaan'},
				{data: 'user_create'},
				{data: 'status'},
				{data: 'aksi'}
		]
	});

	//DETAIL PO
	$(document).on('click', '.view',function () {
			$('#detailPO').modal('show');
			$('.modal-title').text('Detail PO');
			var id = $(this).attr('data-id');

			$.ajax({
					url: 'depo-data-detail/'+id,
					type: 'GET',
					success: function (data) {
							$('#tanggal').html(data.tanggal);
							$('#no_po').html(data.po.no_po);
							$('#no_po_hidden').val(data.po.no_po);
							$('#distributor').html(data.distributor);
							$('#user_create').html(data.po.user_create);
							$('#catatan').html(data.po.catatan);
							$('#status').html(data.po.status);
			if(data.po.status=="Selesai"){
				$('#simpan_setuju').hide();
			}
					}
			})

			//DATA DETAIL ON MODAL
	$('#dataDetailPO').DataTable().destroy();
	var table = $('#dataDetailPO').DataTable({
			
			lengthChange: false,
			paging      : false,
			searching   : false,
			ordering    : false,
			autoWidth   : false,
			processing  : false,
			info        : false,
			serverSide  : true,
			ajax: '/depo-detail/'+id,
			columns: [
				{data: 'rownum'},
				{data: 'kode_item'},
				{data: 'nama_item'},
				{data: 'jumlah'},
				{data: 'kode_item_pemberian'},
				{data: 'nama_item_pemberian'},
				{data: 'jumlah_pemberian'},
				{data: 'satuan'}
			]
	});
});
</script>
@endsection
