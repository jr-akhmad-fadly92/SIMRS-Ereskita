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

				Penerimaan Obat / Inventaris / Non-Medis 

			</h3>

			<a id="back_to_purchaseorder" class="btn btn-success btn-flat pull-right btn-sm" href="{{url('/gudang/penerimaan-obat')}}">

			<span class="glyphicon glyphicon-arrow-left"></span> Back

			</a>

		</div>

		<div class="box-body">

		<div class="panel panel-primary" id="halaman_purchaseorder_record">

  

		<div id="up-konten"class="panel-body" style="padding:15px;">

			<div id="">

			{!! Form::open(['method' => 'POST','id'=>'laporanTagihan', 'url' => '/gudang/penerimaan-obat/orderdetail/'.$datapo->po_no_purchaseorder, 'class' => 'form-horizontal']) !!}



			<table class="table table-striped">

			@if(!isset($penerimaan_po))

				<tr>

				<td width="20%"><b>Nomor Purchase Order</b></td>

				<td width="40%">: {{$datapo->po_no_purchaseorder}}</td>

				<td width="10%">Total Item</td>

				<td width="30%">: {{$totalitem}} Item</td>

				</tr>

				<tr>

				<td width="20%">Nama Pemohon / Penanggung Jawab</td>

				<td width="40%">: {{baca_pegawai($datapo->po_nama_pemohon)}}</td>

				<td width="10%">Harga Awal</td>

				<td width="30%">: Rp {{number_format($datapo->po_hargatotal)}}</td>

				</tr>

				<tr>

				<td width="20%">Tanggal Pengajuan</td>

				<td width="40%">: {{tanggalkuitansi(tgl_indo($datapo->po_tanggal_pemesanan))}}</td>

				<td width="20%"></td>

				<td></td>

				</tr>

				<tr>

				<td width="20%">Nomor Faktur</td>

				<td width="40%">: <input type="text" name="no_faktur"  value=""placeholder=""></td>

				<td width="20%">Nomor Batch</td>

				<td width="40%">: <input type="text" name="no_batch"  placeholder=""></td>

				</tr>

				<tr>

				<td width="20%">Tanggal Diterima</td>

				<td width="40%">: <input type="date"  name="tanggal"  placeholder=""></td>

				<td width="20%">Tanggal Bayar</td>

				<td>: <input type="date"  name="tanggal_pembayaran"  placeholder=""></td>

				</tr>
				

			@else

				<tr>

				<td width="20%"><b>Nomor Purchase Order</b></td>

				<td width="40%">: {{$datapo->po_no_purchaseorder}}</td>

				<td width="10%">Total Item</td>

				<td width="30%">: {{$totalitem}} Item</td>

				</tr>

				<tr>

				<td width="20%">Nama Pemohon / Penanggung Jawab</td>

				<td width="40%">: {{baca_pegawai($datapo->po_nama_pemohon)}}</td>

				<td width="10%">Harga Awal</td>

				<td width="30%">: Rp {{number_format($datapo->po_hargatotal)}}</td>

				</tr>

				<tr>

				<td width="20%">Tanggal Pengajuan</td>

				<td width="40%">: {{tanggalkuitansi(tgl_indo($datapo->po_tanggal_pemesanan))}}</td>

				<td width="20%"></td>

				<td></td>

				</tr>

				<tr>

				<td width="20%">Nomor Faktur</td>

				<td width="40%">: <input type="text" name="no_faktur"  value="{{$penerimaan->no_faktur}}"placeholder="" disabled></td>

				<td width="20%">Nomor Batch</td>

				<td width="40%">: <input type="text" name="no_batch" value="{{$penerimaan->no_batch}}" placeholder=""></td>

				</tr>

				<tr>

				<td width="20%">Tanggal Pengajuan</td>

				<td width="40%">: <input type="date"  name="tanggal" value="{{$penerimaan->tanggal}}" placeholder=""></td>

				<td width="20%">Tanggal Bayar</td>

				<td>: <input type="date"  name="tanggal_pembayaran" value="{{$penerimaan->tanggal_pembayaran}}" placeholder=""></td>

				</tr>


			@endif       

			</table>
 			@if($cek < 1 )
			<input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="INPUT">
 			@else
			<input type="submit" name="update" class="btn btn-primary btn-flat" value="UPDATE">

			<a href="{{url('/gudang/penerimaan-obat/laporan_penerimaan/'.$datapo->po_no_purchaseorder)}}"  name="laporan" class="btn btn-primary btn-flat">CETAK LAPORAN</a>

			<a href="{{url('/gudang/penerimaan-obat/retur_penerimaan/'.$datapo->po_no_purchaseorder)}}"  name="laporan" class="btn btn-primary btn-flat">CETAK RETUR</a>
 			@endif
			{!! Form::close() !!}

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

						

						<table class="table table-striped table-bordered no-margin" id="list_faktur"> 

							<thead>

								<tr>

									<th>Kode Obat</th>

									<th>Nama Obat</th>

									<th>Jumlah Pesanan</th>

									<th>Jumlah Diterima</th>

									<th>Selisih</th>

									<th>Action</th>

								</tr>

							</thead>

							@isset($penerimaan_po)

							<tbody>

	
							</tbody>

							@endisset

						</table>

	
					</div>

					

				</div>

			</div>

					<div class="col-sm-12 no-padding">

						<a href="{{ url('/gudang/penerimaan/simpan/'.$datapo->po_no_purchaseorder) }}" class="btn btn-success btn-flat pull-right" onclick="return confirm('Yakin transaksi diselesaikan?')">Selesai Pengecekan</a>

					</div>

		</div>



  <div class="modal fade" id="modaljumlah" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

          <h4 class="modal-title" id="">Jumlah Penerimaan</h4>

        </div>

        <div class="modal-body">

          <form method="POST" class="form-horizontal" id="formjumlah">

              {{ csrf_field() }} {{ method_field('POST') }}

            <div class="form-group" id="inputid" hidden>

              <label for="id" class="col-md-3 form-label">id</label>

              <div class="col-md-9">

                <input type="text" name="id"  id="id" >

                <span class="text-danger"><p id="id-error"></p> </span>

              </div>

            </div>

			<div class="form-group" id="inputjumlah">

              <label for="jumlah" class="col-md-3 form-label">Jumlah</label>

              <div class="col-md-9">

                <input type="number" name="jumlah"  >

                <span class="text-danger"><p id="jumlah-error"></p> </span>

              </div>

            </div>

			<div class="form-group" id="inputexpired">

              <label for="expired" class="col-md-3 form-label">expired</label>

              <div class="col-md-9">

                <input type="date" name="expired" >

                <span class="text-danger"><p id="expired-error"></p> </span>

              </div>

            </div>

			<div class="form-group" id="inputketerangan">

              <label for="keterangan" class="col-md-3 form-label">Keterangan</label>

              <div class="col-md-9">

                <input type="text" name="keterangan"  >

                <span class="text-danger"><p id="keterangan-error"></p> </span>

              </div>

            </div>

        </div>

        <div class="modal-footer">

          <div class="btn-group">

            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>

            <button type="button" class="btn btn-success btn-flat" id="savejumlah">Simpan</button>

          </div>

          </form>

        </div>

      </div>

    </div>

  </div>

  

	

@stop



@section('script')

@isset($penerimaan_po)

<script >

var table = $('#list_faktur').DataTable({

		

		lengthChange: true,

		paging      : true,

		searching   : true,

		ordering    : true,

		autoWidth   : true,

		processing  : true,

		info        : true,

		serverSide  : true,

		ajax: '/gudang/penerimaan-obat/list-faktur/{{$penerimaan->no_faktur}}',

		columns: [

				

				{data: 'kode'},

				{data: 'nama_obj'},

				{data: 'jumlah'},

				{data: 'jumlah_diterima'},

				{data: 'selisih'},

				

				{data: 'add'}

		]

	});

$(document).on('click', '.insert',function () {

		$('input[name="id"]').val($(this).attr('data-kode'));

	

		$('#addItem').modal('hide');

	});



$('#formjumlah').keypress(function (event) {

    if (event.keyCode == 13) {

        event.preventDefault();

    }

});	

	$('#tambahjumlah').on('click', function () {

    $('#modaljumlah').modal('show');

    $('.modal-title').text('Tambah jumlah');

    $('#formjumlah')[0].reset();

    $('#inputjumlah').removeClass('has-error');

    $('#jumlah-error').html("");

	$('#inputexpired').removeClass('has-error');

    $('#expired-error').html("");

	$('#inputid').removeClass('has-error');

    $('#id-error').html("");

	$('#inputketerangan').removeClass('has-error');

    $('#keterangan-error').html("");

  });

//Save

$('#savejumlah').on('click', function() {

    var id = $('input[name="id"]').val();



      url = '/gudang/penerimaan-obat/simpanitem';

    

    $.ajax({

      url: url,

      type:'POST',

      data: $('#formjumlah').serialize(),

      success: function (data) {

        console.log(data);

        if(data.errors) {

          if(data.errors.jumlah) {

            $('#inputjumlah').addClass('has-error');

            $('#jumlah-error').html( data.errors.jumlah[0] );

			$('#inputketerangan').addClass('has-error');

            $('#keterangan-error').html( data.errors.keterangan[0] );

          }

        };

        if (data.success == 1) {

          $('#formjumlah')[0].reset();

          $('#modaljumlah').modal('hide');

          table.ajax.reload();

          //document.location.href = '/mastergizi';

        }

      }

    });

  });

</script>

@endisset

@endsection

