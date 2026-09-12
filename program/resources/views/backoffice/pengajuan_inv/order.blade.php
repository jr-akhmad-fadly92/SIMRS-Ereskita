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
				Pengajuan Inventaris 
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
								{!! Form::label('pegawai_id', 'Yang mengajukan', ['class' => 'col-sm-3 control-label']) !!}
								<div class="col-sm-8">
								<select class="form-control chosen-select" name="pegawai_id">
													<option value="">[Semua]</option>
												@foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->get() as $key => $d)
													<option value="{{ $d->id }}">{{ $d->nama }}</option>
												@endforeach
											</select>
									<small class="text-danger">{{ $errors->first('pegawai_id') }}</small>
								</div>
							</div>
							<br>
							<div class="btn-groups pull-right">
								<a href="{{ url('depo-inv') }}" class="btn btn-success btn-flat">BATAL</a>
								{!! Form::submit("LANJUT", ['class' => 'btn btn-success btn-flat']) !!}
							</div>
						{!! Form::close() !!}
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
		$('.modal-title').text('Tambah Obat');
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
