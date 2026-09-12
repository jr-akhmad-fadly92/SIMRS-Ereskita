@extends('master')
@section('header')
  <h1>Uang Titipan Rawat Inap <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => '/kasir/uang-titipan', 'class' => 'form-horizontal']) !!}
				{!! Form::hidden('pasien_id', null) !!}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
								{!! Form::label('nama', 'Pasien', ['class' => 'col-sm-3 control-label']) !!}
								<div class="col-sm-9">
									<div class="input-group">
											{!! Form::text('nama', null, ['class' => 'form-control']) !!}
											<span class="input-group-btn">
												<button type="button" id="openModal" class="btn btn-default btn-flat"><i class="fa fa-search"></i> </button>
											</span>
									</div>
								</div>
						</div>
						<div class="form-group">
								{!! Form::label('nama', 'No. RM', ['class' => 'col-sm-3 control-label']) !!}
								<div class="col-sm-9">
										{!! Form::text('no_rm', null, ['class' => 'form-control', 'readonly'=>true]) !!}
										<small class="text-danger">{{ $errors->first('no_rm') }}</small>
								</div>
						</div>
						<div class="btn-group pull-right">
							{!! Form::submit("LANJUT", ['class' => 'btn btn-success btn-flat']) !!}
						</div>
					</div>
				</div>
      {!! Form::close() !!}

      @isset($reg)
				@if ($reg->count() > 0)
					@foreach ($reg as $key => $d)
					<div class="col-md-12" style="margin:15px 0;" id="list-uangtitipan">
						<table class='table table-striped table-bordered table-hover table-condensed'>
							<thead>
								<tr>
									<th>No. RM</th>
									<th>No. Registrasi</th>
									<th>Nama Lengkap</th>
									<th>Alamat</th>
									<th>Cara Bayar</th>
									<th>Dokter</th>
									<th>Titip</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{ $d->pasien->no_rm }}</td>
									<td>{{ $d->reg_id }}</td>
									<td>{{ $d->pasien->nama }}</td>
									<td>{{ $d->pasien->alamat }}</td>
									<td>{{ !empty($d->bayar) ? baca_carabayar($d->bayar) : '' }}</td>
									<td>{{ !empty($d->dokter_id) ? baca_dokter($d->dokter_id) : '' }}</td>
									<td>
										<button type="button" id="titipUM" id-data="{{$d->id}}" class="btn btn-primary btn-flat"> <i class="fa fa-dollar"></i> </button>
									</td>
								</tr>
								<tr>
									<th class="text-center" colspan=7>Data Titipan</th>
								</tr>
								<tr>
									<td class="text-center" colspan=7>
										<table style="width:100%;font-size:12px;" class='table table-striped table-bordered table-hover table-condensed'>
											<tr>
												<th>No</th>
												<th>Atas sNama</th>
												<th>No HP</th>
												<th class="text-right">Total</th>
												<th>Keterangan</th>
												<th>Tanggal</th>
												<th>Cetak</th>
												<th>Aksi</th>
											</tr>
											@php
												$data_um = App\UangMuka::where('registrasi_id',$d->id)->where('deleted_by',null)->get();
												$no=1;
											@endphp
											@if($data_um!=null)
												@foreach($data_um as $key => $dt)
												<tr>
													<td>{{$no++}}</td>
													<td>{{$dt->nama}}</td>
													<td>{{$dt->no_hp}}</td>
													<td class="text-right">{{number_format($dt->total)}}</td>
													<td>{{$dt->keterangan}}</td>
													<td>{{date_format($dt->created_at,'d M Y H:i:s')}}</td>
													<td>{{$dt->jumlah_cetak}}x</td>
													<td>
														<button type="button" id="cetakKwitansi" onclick="cetakKwitansi({{$dt->id}})" class="btn btn-small btn-success btn-flat" name="button">Kwitansi</button>
														<button type="button" id="hapusUm" onclick="hapusUm({{$dt->id}})" class="btn btn-small btn-danger btn-flat" name="button">Hapus</button>
													</td>
												</tr>
												@endforeach
											@endif
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					@endforeach
        @endif
      @endisset
    </div>
  </div>

  <div class="modal fade" id="modalUM" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="FormUM" method="post">
            {{ csrf_field() }} {{ method_field('POST') }}
						<input type="hidden" name="registrasi_id" value="" id="reg_id">
            <div class="form-group " id="inputNominal">
              <label for="nominal" class="col-md-3 control-label">Nominal</label>
              <div class="col-md-8">
                <div class="input-group">
                  <span class="input-group-addon">Rp. </span>
                  <input type="text" name="nominal" class="form-control" id="" placeholder="">
                  <span class="input-group-addon">,00</span>
                </div>
                <small class="text-danger"><p id="nominal-error"></p></small>
              </div>
            </div>
            <div class="form-group " id="inputNama">
              <label for="nominal" class="col-md-3 control-label">Atas Nama</label>
              <div class="col-md-8">
                <input type="text" name="nama" class="form-control" id="" placeholder="">
                <small class="text-danger"><p id="nama-error"></p></small>
              </div>
            </div>
            <div class="form-group " id="inputNohp">
              <label for="nominal" class="col-md-3 control-label">No. HP</label>
              <div class="col-md-8">
                <input type="text" name="nohp" class="form-control" id="" placeholder="">
                <small class="text-danger"><p id="nohp-error"></p></small>
              </div>
            </div>
            <div class="form-group " id="inputStatus">
              <label for="nominal" class="col-md-3 control-label">Keterangan</label>
              <div class="col-md-8">
                <input type="text" name="keterangan" class="form-control" id="" placeholder="">
                <small class="text-danger"><p id="keterangan-error"></p></small>
              </div>
            </div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">TUTUP</button>
							<button type="button" id="saveUM" class="btn btn-success btn-flat" name="button">SIMPAN</button>
						</div>
          </form>
				</div>
      </div>
    </div>
  </div>
	<div id="div-print" style="text-align:center;display:none;">
		<table style="width:100%;margin:0;">
			<tr>
				<td colspan=2 style="text-align:center;font-weight:bold;">TANDA TERIMA</td>
			</tr>
			<tr>
				<td colspan=2 style="text-align:center;font-weight:bold;"><hr></td>
			</tr>
			<tr>
				<td style="width:20%;">No. RM</td>
				<td>: <span id="print_norm"></span></td>
			</tr>
			<tr>
				<td style="width:20%;">Nomor</td>
				<td>: <span id="print_no"></span></td>
			</tr>
			<tr>
				<td>Telah terima dari</td>
				<td>: <span id="print_dari"></span></td>
			</tr>
			<tr>
				<td>Uang sejumlah</td>
				<td>: <span id="print_total_text"></span> Rupiah</td>
			</tr>
			<tr>
				<td>Uang pembayaran</td>
				<td>: Uang muka/titipan biaya perawatan atas pasien <span id="print_keterangan"></span></td>
			</tr>
			<tr>
				<td colspan=2 style="text-align:center;font-weight:bold;"><hr></td>
			</tr>
		</table>
		<table style="width:100%;margin:0;">
			<tr>
				<td style="text-align:center;">
					Rp. <span id="print_total"></span>
					<br>
					<br>
					<span id="jumlah_cetak"></span>
				</td>
				<td style="text-align:center;">
					<br>
					Semarang, <span>{{date('d-m-Y')}}</span>
					<br>
					<br>
					<br>
					<br>
					( {{ Auth::user()->name }} )
				</td>
			</tr>
		</table>
	</div>


	{{-- MODAL SEARCH pasien --}}
	<div class="modal fade" id="searchPasien" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id=""></h4>
				</div>
				<div class="modal-body">
					<div class='table-responsive'>
						<table id="dataPasien" class='table table-striped table-bordered table-hover table-condensed'>
							<thead>
								<tr>
									<th>No. RM</th>
									<th>Nama Lengkap</th>
									<th>Alamat</th>
									<th>Input</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		if($('select[name="jenis_pasien"]').val() == 1) {
			$('select[name="tipe_jkn"]').removeAttr('disabled');
		} else {
			$('select[name="tipe_jkn"]').attr('disabled', true);
		}

		$('select[name="jenis_pasien"]').on('change', function () {
			if ($(this).val() == 1) {
				$('select[name="tipe_jkn"]').removeAttr('disabled');
			} else {
				$('select[name="tipe_jkn"]').attr('disabled', true);
			}
		});

		//SEARCH PASIEN
		$('#openModal').on('click', function () {
			$("#dataPasien").DataTable().destroy();
			$('#searchPasien').modal('show');
			$('.modal-title').text('Cari Pasien');
			$('#dataPasien').DataTable({
					"language": {
							"url": "/json/pasien.datatable-language.json",
					},

					pageLength: 10,
					autoWidth: false,
					processing: true,
					serverSide: true,
					ordering: false,
					//ajax: '/kasir/data-pasien',
					ajax: '/frontoffice/lap-rekammedis/datapasien',
					columns: [
							{data: 'no_rm'},
							{data: 'nama'},
							{data: 'alamat'},
							{data: 'input', searchable: false},
					]
			});
		});

		$(document).on('click', '.inputPasien', function (e) {
			$('input[name="nama"]').val($(this).attr('data-nama'));
			$('input[name="no_rm"]').val($(this).attr('data-no_rm'));
			$('input[name="pasien_id"]').val($(this).attr('data-pasien_id'));
			$('#searchPasien').modal('hide');
			$('#list-uangtitipan').hide();
		});

		$('input[name="nama"]').on('keyup', function () {
			if ( $('input[name="nama"]').val() == '' ) {
				$('input[name="no_rm"]').val('');
				$('input[name="pasien_id"]').val('');
			}
		});

	});

//TITIP UANG TITIPAN
	$('#titipUM').on('click', function () {
		var id = $(this).attr('id-data');
		$("#reg_id").val(id);
		$('#modalUM').modal('show');
		$('.modal-title').text('Uang Titipan');
		//Remove Notif Error
		$('#nominal-error').html("");
		$('#nama-error').html("");
		$('#nohp-error').html("");
		$('#status-error').html("");
		$('#inputNominal').removeClass('has-error');
		$('#inputNama').removeClass('has-error');
		$('#inputNohp').removeClass('has-error');
		$('#inputStatus').removeClass('has-error');

	});

	function cetakKwitansi(id_um){
		$.ajax({
			url: '/kasir/cetak-kwitansi-uang-titipan/'+id_um,
			type: 'GET',
			data: null,
			success: function (data) {
				$("#print_norm").html(data.no_rm);
				$("#print_no").html(data.no);
				$("#print_dari").html(data.cetak.nama);
				$("#print_total_text").html(data.terbilang);
				$("#print_keterangan").html(data.nama_pasien);
				$("#print_total").html(data.cetak.total);
				if(data.cetak.jumlah_cetak==1){
					$("#jumlah_cetak").html('**kwitansi asli**');
				}else{
					$("#jumlah_cetak").html('**kwitansi copy - cetak ke '+data.cetak.jumlah_cetak+'**');
				}
				var divToPrint	=	document.getElementById('div-print');
				var newWin			=	window.open('','Print-Window','width=1000,height=400,bottom=0,right=0');
				newWin.document.open();
				newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
				newWin.document.close();
				setTimeout(function(){newWin.close();},10);
				window.location.reload();
			}
		});
	}
	function hapusUm(id_um){
		if(confirm('Apakah Anda yakin menghapus uang titipan ini ?')){
			$.ajax({
				url: '/kasir/hapus-uang-titipan/'+id_um,
				type: 'GET',
				data: null,
				success: function (data) {
					if(data.success){
						window.location.reload();
					}else{
						alert('Data gagal dihapus');
					}
				}
			});
		}
	}
	$('#saveUM').on('click', function () {
		$.ajax({
			url: '/kasir/save-uang-titipan',
			type: 'POST',
			data: $('#FormUM').serialize(),
			success: function (data) {
				console.log(data);
				if(data.errors) {
					if(data.errors.nominal) {
						$('#inputNominal').addClass('has-error');
						$('#nominal-error').html( data.errors.nominal[0] );
					}
					if(data.errors.nama) {
						$('#inputNama').addClass('has-error');
						$('#nama-error').html( data.errors.nama[0] )
					}
					if(data.errors.nohp) {
						$('#inputNohp').addClass('has-error');
						$('#nohp-error').html( data.errors.nohp[0] )
					}
					if(data.errors.status) {
						$('#inputStatus').addClass('has-error');
						$('#status-error').html( data.errors.status[0] )
					}
				}
				if(data.success) {
					$("#print_norm").html(data.no_rm);
					$("#print_no").html(data.no);
					$("#print_dari").html(data.cetak.nama);
					$("#print_total_text").html(data.terbilang);
					$("#print_keterangan").html(data.nama_pasien);
					$("#print_total").html(data.cetak.total);
					var divToPrint	=	document.getElementById('div-print');
					var newWin			=	window.open('','Print-Window','width=1000,height=400,bottom=0,right=0');
					newWin.document.open();
					newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
					newWin.document.close();
					setTimeout(function(){newWin.close();},10);
					window.location.reload();
				}
			}
		});
	});

</script>
@endsection
