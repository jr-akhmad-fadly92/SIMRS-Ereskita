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

				Order {{ ucfirst(strtolower(Auth::user()->role()->first()->display_name)) }}

			</h3>

		</div>

		<div class="box-body">

			<div class="row">

				<div class="col-md-6">

					@if(!isset($po_id))

						{!! Form::open(['method' => 'POST', 'url' => '/gudang/po-obat/order', 'class' => 'form-horizontal']) !!}				  

							<div class="form-group{{ $errors->has('po_tanggal_pemesanan') ? ' has-error' : '' }}">

								<div class="col-sm-12">

									{!! Form::label('po_tanggal_pemesanan', 'Tanggal', ['class' => 'control-label']) !!}

									{!! Form::text('po_tanggal_pemesanan', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}

									<small class="text-danger">{{ $errors->first('po_tanggal_pemesanan') }}</small>

								</div>

							</div>				  

							<div class="form-group">

								<div class="col-sm-12">

									{!! Form::label('po_catatan', 'Catatan', ['class' => 'control-label']) !!}

									{!! Form::text('po_catatan', null, ['class' => 'form-control']) !!}

								</div>

							</div>			  

							<div class="form-group">

								<div class="col-sm-12">

									{!! Form::label('po_supplier', 'Distributor', ['class' => 'control-label']) !!}

									<select id="po_supplier" name="po_supplier" class="form-control select2 @error('po_supplier') is-invalid @enderror">

										<option value="" selected disabled>Pilih</option>

										@foreach($supplier as $data)

										<option value="{{ $data->id_produsen }}">{{ $data->nama_produsen }}</option>

										@endforeach

									</select>

								</div>

							</div>

							<div class="form-group" hidden>

								<div class="col-sm-12">

									{!! Form::label('po_kategori_order', 'Kategori', ['class' => 'control-label']) !!}

									{!! Form::text('po_kategori_order', $kategori, ['class' => 'form-control']) !!}

								</div>

							</div>

							<div class="form-group">

								<div class="col-sm-12">

									{!! Form::label('po_nama_pemohon', 'Pemohon', ['class' => 'control-label']) !!}

									<select name="po_nama_pemohon" class="form-control select2 @error('po_nama_pemohon') is-invalid @enderror">

										<option value="" selected disabled>Pilih</option>

										@foreach(Modules\Pegawai\Entities\Pegawai::all() as $data)

										<option value="{{ $data->id }}">{{ $data->nama }}</option>

										@endforeach

									</select>

								</div>

							</div>

							<br>

							<div class="btn-groups pull-right">

								<a href="{{ url('/gudang/po-obat') }}" class="btn btn-success btn-flat">BATAL</a>

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

										<th>Kategori PO</th> <td> {{ $kategori }} </td>

									</tr>

									<tr>

										<th>Petugas</th> <td> {{ baca_pegawai($user_create) }} </td>

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

							<div class="col-sm-12 no-padding" hidden>

								<label for="kode_barang" class="control-label">Kode </label>

								<input type="text" name="suplier" value="{{ $supplier }}">

							</div>

							<div class="col-sm-8 no-padding">

								<label for="jumlah_kemasan_besar" class="control-label">jumlah kemasan besar </label>

								<input type="number" name="dpo_qty" class="form-control" id="" placeholder="">

								<span class="text-danger" id=dpo_qty-error></span>

							</div>

							<div class="col-sm-4 no-padding">

								<label for="dpo_item_unit" class="control-label">Kemasan</label>

								<select class="form-control chosen-select select2" name="dpo_item_unit">

									<option value="">[Semua]</option>

									@foreach (App\Satuan::select('id', 'nama_satuan')->get() as $key => $d)

									<option value="{{ $d->nama_satuan }}">{{ $d->nama_satuan }}</option>

									@endforeach

								</select>

								<span class="text-danger" id=dpo_item_unit-error></span>

							</div>

							<div class="col-sm-8 no-padding">

								<label for="dpo_qty_unit" class="control-label">jumlah Kecil </label>

								<input type="number" name="dpo_qty_unit" class="form-control" id="" placeholder="">

								<span class="text-danger" id=dpo_qty_unit-error></span>

							</div>

							<div class="col-sm-4 no-padding">

								<label for="dpo_conv_unit" class="control-label">Kemasan</label>

								<select class="form-control chosen-select select2" name="dpo_conv_unit">

									<option value="">[Semua]</option>

									@foreach (App\Satuan::select('id', 'nama_satuan')->get() as $key => $d)

									<option value="{{ $d->nama_satuan }}">{{ $d->nama_satuan }}</option>

									@endforeach

								</select>

								<span class="text-danger" id=dpo_conv_unit-error></span>

							</div>

							

							<div class="col-sm-12 no-padding">

								<label for="dpo_price" class="control-label">Harga Satuan Besar</label>

								<input type="number" name="dpo_price" class="form-control" id="" placeholder="">

								<span class="text-danger" id=dpo_price-error></span>

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

					Daftar PO 

				</h3>

			</div>

			<div class="box-body">

				<div class="">

					<div class='table-responsive' style="overflow-x:auto;">

						<table id="dataDetailPO" class='table table-striped table-bordered table-hover table-condensed'>

							<thead>

								<tr>

									<th>No</th>

									<th>Kode </th>

									<th>Nama </th>

									<th>Supplier</th>

									<th>Jumlah </th>

									<th>Harga Satuan</th>

									<th>Harga Total</th>

									<th>Hapus</th>

								</tr>

							</thead>

							<tbody>



							</tbody>

						</table>

					</div>

					<div class="col-sm-12 no-padding">

						<a href="{{ url('/gudang/po-obat/kirim-order-inv/'.$no_po) }}" class="btn btn-success btn-flat pull-right" onclick="return confirm('Yakin transaksi diselesaikan?')">Kirim Order</a>

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

						@if($kategori=='obat')

						<table id="masterObat" class='table table-striped table-bordered table-hover table-condensed'>

							<thead>

								<tr>

									<th>Kode Obat</th>

									<th>Nama Obat</th>

									

									<th>Add</th>

								</tr>

							</thead>

							<tbody></tbody>

						</table>

						@elseif($kategori=='inventaris')

						<table id="masterInv" class='table table-striped table-bordered table-hover table-condensed'>

							<thead>

								<tr>

									<th>Kode Barang</th>

									<th>Nama Barang</th>

									

									<th>Add</th>

								</tr>

							</thead>

							<tbody></tbody>

						</table>

						@else

						<table id="masterNon" class='table table-striped table-bordered table-hover table-condensed'>

							<thead>

								<tr>

									<th>Kode Barang</th>

									<th>Nama Barang</th>

									

									<th>Add</th>

								</tr>

							</thead>

							<tbody></tbody>

						</table>

						@endif

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

		

		lengthChange: false,

		paging      : false,

		searching   : false,

		ordering    : false,

		autoWidth   : false,

		processing  : false,

		info        : false,

		serverSide  : true,

		ajax: '/gudang/po-obat/'+id,

		columns: [

				{data: 'rownum'},

				{data: 'dpo_item_id'},

				{data: 'dpo_item_name'},

				{data: 'dpo_pbf'},

				{data: 'dpo_qty'},

				{data: 'dpo_price'},

				{data: 'dpo_total_price'},

				

				{data: 'delete'}

		]

	});



	//OPEN MODAL OBAT

	$('#cariItem').on('click', function() {

		$('#addItem').modal('show');

		$('.modal-title').text('Tambah Obat');

		$('#masterObat').DataTable().destroy();

		$('#masterObat').DataTable({

			

			autoWidth: false,

			processing: true,

			serverSide: true,

			ajax: '/master-obat/{{$kategori}}',

			columns: [

					{data: 'id_obat'},

					{data: 'nama_obat'},

					

					{data: 'add', searchable: false}

			]

		});

	});

	$('#cariItem').on('click', function() {

		$('#addItem').modal('show');

		$('.modal-title').text('Tambah {{$kategori}}');

		$('#masterInv').DataTable().destroy();

		$('#masterInv').DataTable({

			

			autoWidth: false,

			processing: true,

			serverSide: true,

			ajax: '/master-obat/{{$kategori}}',

			columns: [

					{data: 'kode_barang'},

					{data: 'nama_barang'},

					{data: 'add', searchable: false}

			]

		});

	});

	$('#cariItem').on('click', function() {

		$('#addItem').modal('show');

		$('.modal-title').text('Tambah {{$kategori}}');

		$('#masterNon').DataTable().destroy();

		$('#masterNon').DataTable({

			

			autoWidth: false,

			processing: true,

			serverSide: true,

			ajax: '/master-obat/{{$kategori}}',

			columns: [

					{data: 'kode_barang'},

					{data: 'nama_barang'},

					

					{data: 'add', searchable: false}

			]

		});

	});

	//ADD TO FORM

	$(document).on('click', '.insert',function () {

		$('input[name="kode_barang"]').val($(this).attr('data-kode'));

		$('input[name="nama_barang"]').val($(this).attr('data-nama'));

		//$('input[name="supplier"]').val($(this).attr('data-nama1'));

		$('input[name="dpo_price"]').val($(this).attr('data-nama2'));

		$('#addItem').modal('hide');

	});



	$('#saveItem').on('click', function () {

		$.ajax({

			type: 'POST',

			url: '/gudang/po-obat/simpanitem',

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

						if(data.errors.kode_barang) {

							$('#groupKodeBarang').addClass('has-error');

							$('#kode_barang-error').html( data.errors.kode_barang )

						}

						if(data.errors.dpo_qty) {

							$('#groupDpoQty').addClass('has-error');

							$('#dpo_qty-error').html( data.errors.dpo_qty )

						}

						if(data.errors.dpo_qty_unit) {

							$('#groupDpoQtyUnit').addClass('has-error');

							$('#dpo_qty_unit-error').html( data.errors.dpo_qty_unit )

						}

						if(data.errors.dpo_price) {

							$('#groupDpoPrice').addClass('has-error');

							$('#dpo_price-error').html( data.errors.dpo_price )

						}

						

					}

				}else if(data.sukses == true){

					table.ajax.reload();

					$('#groupNamaBarang').removeClass('has-error');

					$('#nama_barang-error').html( "" )

					$('#groupKodeBarang').removeClass('has-error');

					$('#kode_barang-error').html( "" )

					$('#groupDpoQty').removeClass('has-error');

					$('#dpo_qty-error').html( "" )

					$('#groupDpoQtyUnit').removeClass('has-error');

					$('#dpo_qty_unit-error').html( "" )

					$('#groupDpoPrice').removeClass('has-error');

					$('#dpo_price-error').html( "" )

					$('#groupDpoItemUnit').removeClass('has-error');

					$('#dpo_item_unit-error').html( "" )

					$('#groupDpoConvUnit').removeClass('has-error');

					$('#dpo_conv_unit-error').html( "" )



					$('input[name="kode_barang"]').val("");

					$('input[name="nama_barang"]').val("");

					$('input[name="dpo_qty"]').val("");

					$('input[name="dpo_qty_unit"]').val("");

					$('input[name="dpo_price"]').val("");

					$('input[name="dpo_item_unit"]').val("");

					$('input[name="dpo_conv_unit"]').val("");

					

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

			url: '/gudang/po-obat/delete/' + id,

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

