@extends('master')

@section('header')
<h1>Front Office - Daftar Antrian Loket {{session('no_loket')}} </h1>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">
				Data Antrian Hari Ini &nbsp;
			</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-2">
					<div id="daftarantrian"><center>Loading...</center></div>
				</div>
				<div class="col-md-10" style="padding-left:0;">
					<div class="panel panel-default no-border">
						<div class="panel-heading bg-primary">
							<h3 class="panel-title" style="color:white;">Sudah di panggil</h3>
						</div>
						<div class="panel-body no-padding">
							<div class='table-responsive'>
								<table class='table table-striped table-bordered table-hover table-condensed'>
									<thead>
										<tr>
											<th class="text-center">ANTRIAN</th>
											<th>WAKTU ANTRIAN</th>
											<th>PANGGIL ULANG</th>
											<th>NO REG</th>
											<th>RM</th>
											<th>NAMA</th>
											<th>KIUP</th>
											<th>KIB BARU</th>
											<th>KIB LAMA</th>
											<th>LABEL</th>
											<th>REGISTRASI</th>
											<th>SEP</th>
										</tr>
									</thead>
									<tbody>
										<input type="hidden" value="{{$loket}}" id="loketb">
										@foreach ($terpanggil as $key => $d)
											<input type="hidden" value="{{$d->id}}" id="id_antrianb">
											<tr>
												<td class="text-center">{{ $d->nomor }}</td>
												<td>{{ $d->created_at }}</td>
												<td>
													@if (cek_registrasi($d->id, session('no_loket')) < 1)
														@if ($d->status <= 2)
															<a href="#" id="click-panggil-lagi" antrian="{{$d->id}}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-microphone"></i></a>
														@endif
														<button type="button" class="btn btn-success btn-flat btn-sm" onclick="searchPasien({{ $d->id }})"><i class="fa fa-registered"></i> Proses</button>
													@else
														<i class="fa fa-check"></i> Sudah terdaftar
													@endif
												</td>
												<td>{{ (cek_registrasi($d->id, session('no_loket')) == 1) ? $d->registrasi->reg_id : '' }}</td>
												<td>{{ (cek_registrasi($d->id, session('no_loket')) == 1) ? $d->registrasi->pasien->no_rm : '' }}</td>
												<td>{{ (cek_registrasi($d->id, session('no_loket')) == 1) ? $d->registrasi->pasien->nama : '' }}</td>
												<td>
													@if(cek_registrasi($d->id, session('no_loket')) == 1)
														<a target="_blank" href="{{ url('frontoffice/cetak-kiup/'.$d->registrasi->id) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-print text-center"></i></a>
													@endif
												</td>
												<td>
													@if(cek_registrasi($d->id, session('no_loket')) == 1)
														<a target="_blank" href="{{ url('frontoffice/cetak_kib/baru/'.$d->registrasi->id) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-print text-center"></i></a>
													@endif
												</td>
												<td>
													@if(cek_registrasi($d->id, session('no_loket')) == 1)
														<a target="_blank" href="{{ url('frontoffice/cetak_kib/lama/'.$d->registrasi->id) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-print text-center"></i></a>
													@endif
												</td>
												<td>
													@if(cek_registrasi($d->id, session('no_loket')) == 1)
														<a target="_blank" href="{{ url('frontoffice/cetak_barcode/'.$d->registrasi->pasien_id.'/'.$d->registrasi->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
													@endif
												</td>
												<td>
													@if(cek_registrasi($d->id, session('no_loket')) == 1)
														<a target="_blank" href="{{ url('frontoffice/cetak_antrian/'.$d->registrasi->pasien_id.'/'.$d->registrasi->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
													@endif
												</td>
												<td>
													@if(cek_registrasi($d->id, session('no_loket')) == 1)
														@if (!empty($d->registrasi->no_sep))
															<a href="{{ url('cetak-sep/'.$d->registrasi->no_sep) }}" target="_blank"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
														@endif
													@endif
												</td>
											</tr>
										@endforeach
										<tr>
											<td colspan="12">&nbsp;</td>
										</tr>
										<tr>
											<td colspan="12">&nbsp;</td>
										</tr>
										<tr>
											<td colspan="12">&nbsp;</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="panel-footer bg-primary"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- Modal pencarian --}}
	<div class="modal fade" id="pasien">
		<div class="modal-dialog" style="width:95%!important;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
						<b>Pasien Baru: </b>
						<a href="{{ url('/registrasi/create') }}" class="btn btn-primary btn-flat btn-sm">JKN</a>
						<a href="{{ url('/registrasi/create_umum') }}" class="btn btn-success btn-flat btn-sm">NON JKN</a>
					<div class="table-responsive" style="margin-top: -30px;">
						<table class="table table-hover table-condensed table-bordered" id="tablePasien">
							<thead>
								<tr>
									<th>Nama</th>
									<th>Tgl Lahir</th>
									<th>No. RM</th>
									<th>Ibu Kandung</th>
									<th>Alamat</th>
									<th>Asuransi</th>
									<th class="text-center">JKN</th>
									<th class="text-center">Non JKN</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>
	<!-- jQuery 3 -->
	<script src="{{ asset('/public/style/bower_components/jquery/dist/jquery.min.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			setInterval(function () {
				$('#daftarantrian').load("{{ route('antrian.daftarpanggil',$loket) }}");
			},2000);
		});
		
		$('#click-panggil-lagi').on('click', function () {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				},
				type: 'POST',
				url: '/antrian/panggilkembali',
				data: {id: $(this).attr('antrian'), loket: $("#loketb").val()},
				success: function (data) {
					if(data.status == false) {
						alert(data.message);
					}else if(data.status == true) {
						window.location.href = '/antrian/daftarantrian/'+$("#loketb").val();
					}
				}
			});
		});
		
		function searchPasien(antrian_id){
			$('#pasien').modal('show');
			$('.modal-title').text('Pendaftaran Pasien')
			var table;
			table = $('#tablePasien').DataTable({
				'language': {
						"url": "/json/pasien.datatable-language.json",
				},
				pageLength  : 10,
				paging      : true,
				lengthChange: false,
				searching   : true,
				ordering    : false,
				info        : false,
				autoWidth   : false,
				destroy     : true,
				processing  : true,
				serverSide  : true,
				ajax: '/pasien/search-pasien/'+antrian_id+'/'+1,
				columns: [
					{data: 'nama'},
					{data: 'tgllahir'},
					{data: 'no_rm'},
					//{data: 'no_rm_lama'},
					{data: 'ibu_kandung'},
					{data: 'alamat'},
					{data: 'asuransi'},
					{data: 'jkn', searchable: false, sClass: 'text-center'},
					{data: 'non-jkn', searchable: false, sClass: 'text-center'}
				]
			});
		}
	</script>
	@stop