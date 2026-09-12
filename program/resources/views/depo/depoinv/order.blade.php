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
				Order Inventaris {{ ucfirst(strtolower(Auth::user()->role()->first()->display_name)) }}
			</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					@if(!isset($po_id))
						{!! Form::open(['method' => 'POST', 'url' => 'depo-inv/order', 'class' => 'form-horizontal']) !!}				  
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
							<div class="form-group">
								<div class="col-sm-12">
									{!! Form::label('distributor', 'Distributor', ['class' => 'control-label']) !!}
									{!! Form::select('distributor', ['Logistik'=>'Logistik'], null, ['class' => 'form-control']) !!}
								</div>
							</div>
							<br>
							<div class="btn-groups pull-right">
								<a href="{{ url('depo-inv') }}" class="btn btn-success btn-flat">BATAL</a>
								{!! Form::submit("LANJUT", ['class' => 'btn btn-success btn-flat']) !!}
							</div>
						{!! Form::close() !!}
					@endif
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
										<th>Distributor</th>
										<td>
											{{ $supplier }}
										</td>
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
					@endif
				</div>
				<div class="col-md-6">
					@if(isset($po_id))
						<form id="formAdd" method="post" class="form-horizontal">
							{{ csrf_field() }} {{ method_field('POST') }}
							<input type="hidden" name="po_id" value="{{ $po_id }}">
							<input type="hidden" name="no_po" value="{{ $no_po }}">
							<div class="col-sm-12 no-padding">
								<button type="button" id="cariItem" class="btn btn-success btn-flat">
									<i class="fa fa-search"> </i> Cari
								</button>
							</div>
							<div class="col-sm-12 no-padding">
								<label for="kode_barang" class="control-label">Kode </label>
								<input type="text" name="kode_barang" class="form-control" readonly="true">
							</div>
							<div class="col-sm-12 no-padding">
								<label for="nama_barang" class="control-label">Nama </label>
								<input type="text" name="nama_barang" class="form-control" readonly="true">
								<span class="text-danger" id=nama_barang-error></span>
							</div>
							
							<div class="col-sm-12 no-padding">
								<label for="jumlah_barang" class="control-label">Jumlah </label>
								<input type="number" name="jumlah_barang" class="form-control" id="" placeholder="">
								<span class="text-danger" id=jumlah_barang-error></span>
							</div>
							<div class="col-sm-12 no-padding">
								<label for="ruangan" class="control-label">Ruangan </label>
								<select id="ruangan" name="ruangan" class="form-control @error('ruangan') is-invalid @enderror">
									<option value="" selected disabled>Pilih Ruangan</option>
									@foreach( $masterruangan as $data)
										<option value="{{ $data->id }}">{{ $data->ruangan }}</option>
									@endforeach
								</select>
								<span class="text-danger" id=ruangan-error></span>
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
					Daftar Inventaris
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
									<th>Ruangan</th>
									<th>Hapus</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
					<div class="col-sm-12 no-padding">
						<a href="{{ url('depo-kirim-order-inv/'.$po_id) }}" class="btn btn-success btn-flat pull-right" onclick="return confirm('Yakin transaksi diselesaikan?')">Kirim Order</a>
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
					<h4 class="modal-title" id=""></h4>
				</div>
				<div class="modal-body">
					<div class='table-responsive'>
						<table id="masterObat" class='table table-striped table-bordered table-hover table-condensed'>
							<thead>
								<tr>
									<th>Nama</th>
									
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
		ajax: '/depo-detail-inv/'+id,
		columns: [
				{data: 'rownum'},
				{data: 'kode_barang'},
				{data: 'nama_barang'},
				{data: 'jumlah'},
				{data: 'nama_ruang'},
				{data: 'delete'}
		]
	});

	//OPEN MODAL OBAT
	$('#cariItem').on('click', function() {
		$('#addItem').modal('show');
		$('.modal-title').text('Tambah Inventaris');
		$('#masterObat').DataTable().destroy();
		$('#masterObat').DataTable({
			
			autoWidth: false,
			processing: true,
			serverSide: true,
			ajax: '/depo-master-inv',
			columns: [
					{data: 'nama_barang'},
					{data: 'jumlah'},
					{data: 'add', searchable: false}
			]
		});
	});

	//ADD TO FORM
	$(document).on('click', '.insert',function () {
		$('input[name="kode_barang"]').val($(this).attr('data-kode'));
		$('input[name="nama_barang"]').val($(this).attr('data-nama'));
	
		$('#addItem').modal('hide');
	});

	$('#saveItem').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '/depo-simpanitem-inv',
			data: $('#formAdd').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					if(data.message!="") {
						alert(data.message)
					}else{
						if(data.errors.nama_barang) {
							$('#groupNamaBarang').addClass('has-error');
							$('#nama_barang-error').html( data.errors.nama_barang )
						}
						if(data.errors.jumlah_item) {
							$('#groupJumlahBarang').addClass('has-error');
							$('#jumlah_barang-error').html( data.errors.jumlah_barang )
						}
						if(data.errors.ruangan) {
							$('#groupRuangan').addClass('has-error');
							$('#ruangan-error').html( data.errors.ruangan )
						}
					}
				}else if(data.sukses == true){
					table.ajax.reload();
					$('#groupNamaBarang').removeClass('has-error');
					$('#nama_barang-error').html( "" )
					$('#groupJumlahBarang').removeClass('has-error');
					$('#jumlah_barang-error').html( "" )
					$('#groupRuangan').removeClass('has-error');
					$('#ruangan-error').html( "" )

					$('input[name="kode_barang"]').val("");
					$('input[name="nama_barang"]').val("");
					$('input[name="jumlah_barang"]').val("");
					$('input[name="ruangan"]').val("");
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
			url: '/depo-hapus-detail-inv/' + id,
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
