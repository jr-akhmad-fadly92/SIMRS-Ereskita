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
				Retur Obat
			</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					@if(!isset($po_id))
						{!! Form::open(['method' => 'POST', 'url' => '/retur-order', 'class' => 'form-horizontal']) !!}				  
							<div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
								<div class="col-sm-12">
									{!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
									{!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
									<small class="text-danger">{{ $errors->first('tanggal') }}</small>
								</div>
							</div>				  
							<div class="form-group">
								<div class="col-sm-12">
									{!! Form::label('catatan', 'Catatan', ['class' => 'control-label']) !!}
									{!! Form::text('catatan', null, ['class' => 'form-control']) !!}
								</div>
							</div>
							<input type="hidden" name="supplier" value="Logistik">
							<div class="btn-group pull-right">
								<a href="{{ url('po') }}" class="btn btn-success btn-flat">Batal</a>
								{!! Form::submit("Lanjut", ['class' => 'btn btn-success btn-flat']) !!}
							</div>
						{!! Form::close() !!}
					@endif
					@if(isset($po_id))
						<h5>Detail Order</h5>
						<div class='table-responsive'>
							<table class='table table-striped table-bordered table-hover table-condensed'>
								<tbody>
									<tr>
										<th>Tanggal</th> <td> {{ tanggalkuitansi(valid_date($tanggal)) }} </td>
									</tr>
									<tr>
										<th>No. Retur</th> <td> {{ $no_retur }} </td>
									</tr>
									<tr>
										<th>Distributor</th> <td> Logistik </td>
									</tr>
									<tr>
										<th>Petugas</th> <td> {{ $user_create }} </td>
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
						<!--div class="pull-right">
                          <a href="{{ url('po-cetak/'.$po_id) }}" target="_blank" class="btn btn-info btn-md btn-flat"><i class="fa fa-file-pdf-o"></i> CETAK </a>
						</div-->
					@endif
				</div>
				<div class="col-md-6">
					@if(isset($po_id))
						<form id="formAdd" method="post" class="form-horizontal">
							{{ csrf_field() }} {{ method_field('POST') }}
							<input type="hidden" name="po_id" value="{{ $po_id }}">
							<input type="hidden" name="no_retur" value="{{ $no_retur }}">
							<div class="col-sm-12 no-padding">
									<button type="button" id="cariItem" class="btn btn-success btn-flat">
										<i class="fa fa-search"> </i> Cari
									</button>
							</div>
							<div class="col-sm-12 no-padding">
								<label for="kode_item" class="control-label">Kode </label>
									<input type="text" name="kode_item" class="form-control" readonly="true">
							</div>
							<div class="col-sm-12 no-padding">
								<label for="nama" class="control-label">Nama </label>
									<input type="text" name="nama_item" class="form-control" readonly="true">
									<span class="text-danger" id=nama_item-error></span>
							</div>
							<div class="col-sm-12 no-padding" hidden>
								<label for="satuan" class="control-label">Satuan</label>
									<input type="text" name="satuan" class="form-control" id="satuan" readonly="true" placeholder="">
									<span class="text-danger" id=satuan-error></span>
							</div>
							<div class="col-sm-12 no-padding">
								<label for="jumlah" class="control-label">Jumlah </label>
									<input type="number" name="jumlah_item" class="form-control" id="" placeholder="">
									<span class="text-danger" id=jumlah_item-error></span>
							</div>
							<div class="col-sm-12 no-padding">
								<label for="keterangan" class="control-label">Keterangan </label>
									<input type="text" name="keterangan" class="form-control" id="" placeholder="">
									<span class="text-danger" id=keterangan-error></span>
							</div>
							<div class="col-sm-12 no-padding">
								<label for="expired" class="control-label">Expired </label>
									<input type="text" name="expired" class="form-control datepicker" id="" placeholder="">
									<span class="text-danger" id=expired-error></span>
							</div>
							<div class="col-sm-12 no-padding">
								<br>
								<button type="button" id="saveItem" class="btn btn-primary btn-flat pull-right">Tambahkan</button>
							</div>
						</form>
					@endif
				</div>
			</div>
		</div>
    </div>
	
	@if(isset($po_id))
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">
					Daftar Obat
				</h3>
			</div>
			<div class="box-body">
				<div class="">
					<div class='table-responsive' style="overflow-x:auto;">
						<table id="dataDetailPO" class='table table-striped table-bordered table-hover table-condensed'>
							<thead>
								<tr>
									<th>No</th>
									<th>Kode</th>
									<th>Nama Item</th>
									<th>Jumlah</th>
									<th>Satuan</th>
									<th>Hapus</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
					<div class="col-sm-12 no-padding">
						<a href="{{ url('retur-kirim-order/'.$po_id) }}" class="btn btn-success btn-flat pull-right" onclick="return confirm('Yakin transaksi diselesaikan?')">Kirim Retur</a>
					</div>
				</div>
			</div>
		</div>
	@endif

	<div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 >Pilih Obat yang akan Di retur</h4>
				</div>
				<div class="modal-body">
					<div class='table-responsive'>
						<table id="masterObat" class='table table-striped table-bordered table-hover table-condensed'>
							<thead>
								<tr>
									<th>Kode</th>
									<th>Nama</th>
									<th>Satuan</th>
									<th>No. Batch</th>
									<th>Kadaluarsa</th>
									<th>Stok</th>
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
var id = $('input[name="no_retur"]').val();
var table = $('#dataDetailPO').DataTable({
	  
	  lengthChange: false,
	  paging      : true,
	  searching   : true,
	  ordering    : true,
	  autoWidth   : false,
	  processing  : true,
	  info        : true,
	  serverSide  : true,
	  ajax: '/retur-detail/'+id,
	  columns: [
		  {data: 'rownum'},
		  {data: 'kode'},
		  {data: 'nama'},
		  {data: 'jumlah'},
		  {data: 'satuan'},
		  {data: 'delete'},

	  ]
});

//OPEN MODAL OBAT
$('#cariItem').on('click', function() {
	$('#addItem').modal('show');
	$('.modal-title').text('Tambah Obat');
	if($('.modal-body tbody').html()==''){
		$('#masterObat').DataTable({
			autoWidth: false,
			processing: true,
			serverSide: true,
			ajax: '/retur-masterobat',
			columns: [
				{data: 'kode'},
				{data: 'nama'},
				{data: 'satuan'},
				{data: 'no_batch'},
				{data: 'expired_date'},
				{data: 'stok'},
				{data: 'add', searchable: false}
			]
		});
	}
});

//ADD TO FORM
$(document).on('click', '.insert',function () {
	$('input[name="kode_item"]').val($(this).attr('data-kode'));
	$('input[name="nama_item"]').val($(this).attr('data-nama'));
	$('input[name="satuan"]').val($(this).attr('data-satuan'));
	$('input[name="jumlah_item"]').val($(this).attr('data-jumlah'));
	$('input[name="expired"]').val($(this).attr('data-date'));
	$('#addItem').modal('hide');
});


$('#saveItem').on('click', function () {
	$.ajax({
		type: 'POST',
		url: '/retur-simpanitem',
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
					if(data.errors.jumlah_item) {
						$('#groupKeterangan').addClass('has-error');
						$('#keterangan-error').html( data.errors.keterangan )
					}
					if(data.errors.expired) {
						$('#groupExpired').addClass('has-error');
						$('#expired-error').html( data.errors.expired )
					}
					if(data.errors.satuan) {
						$('#groupSatuan').addClass('has-error');
						$('#satuan-error').html( data.errors.satuan )
					}
				}
			}else if(data.sukses == true) {
				table.ajax.reload();
				$('#groupNamaItem').removeClass('has-error');
				$('#nama_item-error').html( "" )
				$('#groupJumlahItem').removeClass('has-error');
				$('#jumlah_item-error').html( "" )
				$('#groupKeterangan').removeClass('has-error');
				$('#keterangan-error').html( "" )
				$('#groupSatuan').removeClass('has-error');
				$('#satuan-error').html( "" )
				$('#groupExpired').removeClass('has-error');
				$('#expired-error').html( "" )

				$('input[name="kode_item"]').val("");
				$('input[name="nama_item"]').val("");
				$('input[name="jumlah_item"]').val("");
				$('input[name="keterangan"]').val("");
				$('input[name="satuan"]').val("");
				$('input[name="expired"]').val("");
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
			url: '/retur-hapus-detail/' + id,
			type: 'GET',
			success: function (data) {
				console.log(data);
				if(data.sukses == true) {
					table.ajax.reload();
				}
			}
		});
	}
})
</script>
@endsection
