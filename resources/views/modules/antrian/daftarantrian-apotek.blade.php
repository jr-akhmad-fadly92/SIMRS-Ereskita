@extends('master')

@section('header')
<h1>Apotek - Daftar Antrian Loket {{$loket}} </h1>
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
				<div class="col-md-4">
					<div id="daftarantrian"><center>Loading...</center></div>
				</div>
				<div class="col-md-8">
					<div class="panel panel-default no-border">
						<div class="panel-heading bg-primary">
							<h3 class="panel-title" style="color:white;">Sudah di panggil</h3>
						</div>
						<div class="panel-body no-padding">
							<div class='table-responsive'>
								<table class='table table-striped table-bordered table-hover table-condensed'>
									<thead>
										<tr>
											<th class="text-center">Antrian</th>
											<th>Waktu Antri</th>
											<th>Panggil Ulang</th>
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
													@if ($d->status==3 AND $d->panggil==2)
														<a href="#" class="btn btn-success btn-sm btn-flat"><i class="fa fa-check"></i> Sudah Dilayani</a>
													@else
														@if ($d->status <= 2)
															<a href="#" id="click-panggil-lagi" class="btn btn-info btn-sm btn-flat"><i class="fa fa-microphone"></i> {{ $d->nomor }}</a>
															<a href="{{ url('penjualan') }}" type="button" class="btn btn-success btn-flat btn-sm"><i class="fa fa-registered"></i> Rawat Jalan</a>
															<a href="{{ url('penjualan') }}" type="button" class="btn btn-success btn-flat btn-sm"><i class="fa fa-registered"></i> Rawat Inap</a>
															<a href="{{ url('penjualan/irna') }}" type="button" class="btn btn-success btn-flat btn-sm"><i class="fa fa-registered"></i> Rawat Darurat</a>
															<a href="{{ url('penjualan/retur') }}" type="button" class="btn btn-success btn-flat btn-sm"><i class="fa fa-registered"></i> Retur</a>
														@else ($d->status==3 AND $d->panggil!=2)
															<a href="#" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-close"></i> Lewat</a>
														@endif
													@endif
												</td>
											</tr>
										@endforeach
										<tr>
											<td colspan="3">&nbsp;</td>
										</tr>
										<tr>
											<td colspan="3">&nbsp;</td>
										</tr>
										<tr>
											<td colspan="3">&nbsp;</td>
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

	<!-- jQuery 3 -->
	<script src="{{ asset('/public/style/bower_components/jquery/dist/jquery.min.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			setInterval(function () {
				$('#daftarantrian').load("{{ route('antrian.daftarpanggil-apotek',$loket) }}");
			},2000);
		});
		
		$('#click-panggil-lagi').on('click', function () {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				},
				type: 'POST',
				url: '/antrian/panggilkembali-apotek',
				data: {id: $("#id_antrianb").val(), loket: $("#loketb").val()},
				success: function (data) {
					if(data.status == false) {
						alert(data.message);
					}else if(data.status == true) {
						window.location.href = '/antrian/daftarantrian-apotek/'+$("#loketb").val();
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
					{data: 'jkn', searchable: false, sClass: 'text-center'},
					{data: 'non-jkn', searchable: false, sClass: 'text-center'}
				]
			});
		}
	</script>
	@stop