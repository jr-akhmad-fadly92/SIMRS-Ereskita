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
				Order Obat {{ ucfirst(strtolower(Auth::user()->role()->first()->display_name)) }}
			</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					
					@if(isset($po_id))
						<h5>Detail Order</h5>
						<div class='table-responsive'>
							<table class='table table-striped table-bordered table-hover table-condensed'>
								<tbody>
									<tr>
										<th>Tanggal</th> <td> {{ tgl_indo($tanggal) }} </td>
									</tr>
									<tr>
										<th>No. PO</th> <td> {{ $no_po }} </td>
									</tr>
									<tr>
										<th>Catatan</th> <td> {{ $catatan }} </td>
									</tr>
									<tr>
										<th>Status</th> <td> {{ $status }} </td>
									</tr>
								</tbody>
							</table>
						</div>
					@endif
				</div>
				<div class="col-md-6">
					
				</div>
			</div>
		</div>
    </div>
	
	

	<div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id=""></h4>
				</div>
				<div class="modal-body">
					<div class='table-responsive'>
						<table id="masterObat" class='table table-striped table-bordered table-hover table-condensed'>
							<thead>
								<tr>
									<th>Nama</th>
									<th>Satuan</th>
									<th>Sisa Stok</th>
									<th>Add</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success btn-flat" data-dismiss="modal">Close</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop

@section('script')
<script type="text/javascript">
	//DATA DETAIL
	var id = $('input[name="po_id"]').val();
	var table = $('#dataDetailPO').DataTable({
		'language': {
				'url': '/json/pasien.datatable-language.json',
		},
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
				{data: 'satuan'},
				{data: 'delete'}
		]
	});

	//OPEN MODAL OBAT
	$('#cariItem').on('click', function() {
		$('#addItem').modal('show');
		$('.modal-title').text('Tambah Obat');
		$('#masterObat').DataTable().destroy();
		$('#masterObat').DataTable({
			'language': {
					'url': '/json/pasien.datatable-language.json',
			},
			autoWidth: false,
			processing: true,
			serverSide: true,
			ajax: '/depo-masterobat/{{$supplier}}',
			columns: [
					{data: 'nama'},
					{data: 'satuan'},
					{data: 'stok'},
					{data: 'add', searchable: false}
			]
		});
	});

	//ADD TO FORM
	$(document).on('click', '.insert',function () {
		$('input[name="kode_item"]').val($(this).attr('data-kode'));
		$('input[name="nama_item"]').val($(this).attr('data-nama'));
		$('input[name="satuan"]').val($(this).attr('data-satuan'));
		$('#addItem').modal('hide');
	});

	$('#saveItem').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '/depo-simpanitem/{{$supplier}}',
			data: $('#formAdd').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					if(data.message!="") {
						alert(data.message)
					}else{
						if(data.errors.nama_item) {
							$('#groupNamaItem').addClass('has-error');
							$('#nama_item-error').html( data.errors.nama_item )
						}
						if(data.errors.jumlah_item) {
							$('#groupJumlahItem').addClass('has-error');
							$('#jumlah_item-error').html( data.errors.jumlah_item )
						}
						if(data.errors.satuan) {
							$('#groupSatuan').addClass('has-error');
							$('#satuan-error').html( data.errors.satuan )
						}
					}
				}else if(data.sukses == true){
					table.ajax.reload();
					$('#groupNamaItem').removeClass('has-error');
					$('#nama_item-error').html( "" )
					$('#groupJumlahItem').removeClass('has-error');
					$('#jumlah_item-error').html( "" )
					$('#groupSatuan').removeClass('has-error');
					$('#satuan-error').html( "" )

					$('input[name="kode_item"]').val("");
					$('input[name="nama_item"]').val("");
					$('input[name="jumlah_item"]').val("");
					$('input[name="satuan"]').val("");
				}
			}
		});
	});

//HAPUS ITEM
$(document).on('click', '.hapus', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	if (confirm('Apakah yakin item ini akan dihapus?')) {
		$.ajax({
			url: '/depo-hapus-detail/' + id,
			type: 'GET',
			success: function (data) {
				console.log(data);
				if(data.sukses == true) {
						table.ajax.reload();
				}else{
					alert("Data gagal dihapus")
				}
			}
		});
	}
})
</script>
@endsection
