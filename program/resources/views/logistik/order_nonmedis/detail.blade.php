
<style>
.content{
	padding:0 15px 15px 15px !important; 
}
form input[type="text"]:focus {
 outline-color: none;
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
				Detail Order Non Medis 
			</h3>
			<button id="back_to_purchaseorder" class="btn btn-success btn-flat pull-right btn-sm">
			<span class="glyphicon glyphicon-arrow-left"></span> Back
			</button>
		</div>
		<div class="box-body">
		<div class="panel panel-primary" id="halaman_purchaseorder_record">
  
		<div id="up-konten"class="panel-body" style="padding:15px;">
			<div id="">
		
			<table class="table table-striped">
				<tr>
				<td width="40%"><b>No PO</b></td>
				<td width="60%">: {{$Po->no_po}}</td>
				</tr>
				<tr>
				<td width="40%"><b>Pemohon</b></td>
				<td width="60%">: {{$Po->user_create}}</td>
				</tr>
				<tr>
				<td width="40%"><b>Catatan</b></td>
				<td width="60%">: {{$Po->catatan}}</td>
				</tr>
				<tr>
				<td width="40%"><b>Status</b></td>
				<td width="60%">: {{$Po->status}}</td>
				</tr>
				<tr>
				<td width="40%"><b>Tanggal</b></td>
				<td width="60%">: {{$Po->tanggal}}</td>
				</tr>
			</table>
			<form method="post" action="{{url('/gudang/dist-nonmedis/tambahitem/'.$Po->id)}}" >
					{{ csrf_field() }}
			<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text" id="">Tambah Data Order barang</span>
			</div>
 			<select class="select2" name="kode_item_pemberian" id="kode_item_pemberian">
				<option value="">[semua]</option>
				@foreach (App\Masternonmedis::select('kode_barang', 'nama_barang')->whereNotIn('kode_barang',$list_po1)->whereNotIn('stok',[0])->get() as $key => $d)
				<option value="{{ $d->kode_barang }}">{{ $d->kode_barang }} / {{ $d->nama_barang }}</option>
				@endforeach
			</select>
			<input type="number" name="jumlah_pemberian" class="input-sm">
			</div>
			<button type="submit" class="btn btn-success btn-flat fa fa-check" onclick="return confirm('Yakin akan menambah data ini?')">Tambah</button>
			</form>
			</div>
		</div>
    </div>
	
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">
					Daftar PO Obat / Barang
				</h3>
			</div>
			<div class="box-body">
				<div class="">
					<div class='table-responsive' style="overflow-x:auto;">
					

						<table class="table table-striped table-bordered no-margin" id="data"> 
							<thead>
								<tr>
									<th>No</th>
									<th>Kode Obat</th>
									<th>Nama Obat</th>
									<th>Jumlah Pesanan</th>
									<th>Kode / Nama Pemberian</th>
									<th>Jumlah Pemberian</th>
									<th>Action</th>
								</tr>
							</thead>
							
							<tbody>
 								@foreach($list_po as $data)
								 	
										<tr>
										<form method="post" action="{{url('/gudang/dist-nonmedis/simpanitem')}}" >
									 	{{ csrf_field() }}
 											<td>{{$no++}}
											 	<input type="hidden" name="id" value="{{$data->id}}"class="form-control" >
											</td>
											<td>{{$data->kode_barang}}</td>
											<td>{{$data->nama_barang}}</td>
											<td>{{$data->jumlah}}</td>
											<td>
											@if($data->kode_barang_pemberian==null)
											<select class="form-control select2" name="kode_item_pemberian" id="kode_item_pemberian">
												<option value="">[semua]</option>
												@foreach (App\Masternonmedis::select('kode_barang', 'nama_barang')->whereNotIn('stok',[0])->get() as $key => $d)
												<option value="{{ $d->kode_barang }}">{{ $d->kode_barang }} / {{ $d->nama_barang }}</option>
												@endforeach
											</select>
											@else
											{{$data->kode_barang_pemberian}} / {{$data->nama_barang_pemberian}}
											@endif
											</td>
											<td>
											@if($data->kode_barang_pemberian==null)
												<input type="number" name="jumlah_pemberian" class="form-control" id="jumlah_pemberian">
											@else
											{{$data->jumlah_pemberian}}
											@endif
											</td>
											<td>
											@if($data->kode_barang_pemberian==null)
												<button type="submit" class="btn btn-success btn-flat fa fa-check" ></button>
												
 											@else
										 	<a href="{{url('/gudang/dist-nonmedis/deleteitem/'.$data->id)}}" onclick="return confirm('Yakin akan menghapus data ini ?')" class="btn btn-danger btn-flat fa fa-trash" ></a>
											<a href="{{url('/gudang/dist-nonmedis/resetitem/'.$data->id)}}" onclick="return confirm('Yakin akan reset data ini	?')"class="btn btn-warning btn-flat fa fa-refresh" ></a>
											@endif
											</td>
										</form>
										</tr>
									
 								@endforeach
							</tbody>
						
						</table>
					</div>
					
				</div>
				
			</div>
		</div>	<a href="{{url('/gudang/dist-nonmedis/selesai/'.$Po->no_po)}}" onclick="return confirm('Yakin menutup transaksi ?')" class="btn btn-success btn-flat " >selesai</a>
						
											
 
	
@stop

@section('script')

<script type="text/javascript">

var table = $('#list_po').DataTable({
		
		lengthChange: false,
		paging      : false,
		searching   : false,
		ordering    : false,
		autoWidth   : false,
		processing  : false,
		info        : false,
		serverSide  : true,
		ajax: '/gudang/dist-obat/detail/list/{{$id}}',
		columns: [
				{data: 'rownum'},
				{data: 'kode_obat'},
				{data: 'nama_obj'},
				{data: 'permintaan'},
				{data: 'kode_obat_pemberian'},
				{data: 'nama_obj_pemberian'},
				{data: 'jumlah_pemberian'},
			
		]
	});
	
	
</script>

@endsection
