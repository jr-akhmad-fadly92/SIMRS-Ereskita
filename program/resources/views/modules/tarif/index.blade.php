@extends('master')

@section('header')
  <h1>Keuangan - Tarif Rawat Inap </h1>
@endsection

@section('content')
	<div class="box box-primary">
		@role(['administrator'])
		<div class="box-header with-border">
			<h3 class="box-title">
				Data Master Tarif &nbsp;
				<a href="{{ url('tarif/create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
				<a  id="edit_jasa_medis" class="btn btn-default btn-sm">Jasa Medis</i></a>
				
			</h3>
			@role(['administrator'])
			<div class="col-md-8 no-padding pull-right">
			{!! Form::open(['method' => 'POST', 'url' => '/tarif/filter-by-request', 'class' => 'form-horizontal']) !!}
				<div class="row">
						<div class="col-md-6">
							<div class="form-group{{ $errors->has('tahuntarif') ? ' has-error' : '' }}">
								{!! Form::label('tahuntarif', 'Tahun Tarif', ['class' => 'col-sm-4']) !!}
								{!! Form::select('tahuntarif', $thn_tarif, Request::segment(3) ? Request::segment(3) : configrs()->tahuntarif, ['class' => 'form-control select2']) !!}
								<small class="text-danger">{{ $errors->first('tahuntarif') }}</small>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group{{ $errors->has('kategoritarif_id') ? ' has-error' : '' }}">
								{!! Form::label('kategoritarif_id', 'Kategori Tarif', ['class' => 'col-sm-4']) !!}
								{!! Form::select('kategoritarif_id', $kh, Request::segment(4), ['class' => 'form-control select2', 'onchange'=>'this.form.submit()']) !!}
								<small class="text-danger">{{ $errors->first('kategoritarif_id') }}</small>
							</div>
						</div>
				</div>
			{!! Form::close() !!}
				
			</div>
			@endrole
		</div>
		@endrole
		<div class="box-body">
			<div class='table-responsive'>
				<table id="tarif" class='table table-striped table-bordered table-hover table-condensed'>
					<thead>
						<tr>
							<th class="text-center" style="vertical-align: middle;">No</th>
							<th class="text-center" style="vertical-align: middle;">Tahun Tarif</th>
							<th class="text-center" style="vertical-align: middle;">Nama</th>
							<th class="text-center" style="vertical-align: middle;">RJ</th>
							<th class="text-center" style="vertical-align: middle;">RD</th>
							<th class="text-center" style="vertical-align: middle;">RI</th>
							<th class="text-center" style="vertical-align: middle;">Tarif VIP</th>
							<th class="text-center" style="vertical-align: middle;">Tarif Kelas 1</th>
							<th class="text-center" style="vertical-align: middle;">Tarif Kelas 2</th>
							<th class="text-center" style="vertical-align: middle;">Tarif Kelas 3</th>
							<th class="text-center" style="vertical-align: middle;">Tarif Kelas RJ</th>
							@role(['administrator'])
							<th class="text-center" style="vertical-align: middle;">Edit</th>
							{{--<th class="text-center" style="vertical-align: middle;">Hapus</th>--}}
							@endrole
						</tr>
					</thead>
					<tbody>
						@foreach ($tarif as $key => $d)
							<tr>
								<td>{{ $no++ }}</td>
								<td>{{ $d->tahuntarif->tahun }}</td>
								<td>{{ $d->nama }}</td>
								<td>@if($d->jenis_rj) <i class="fa fa-check"></i> @endif</td>
								<td>@if($d->jenis_rd) <i class="fa fa-check"></i> @endif</td>
								<td>@if($d->jenis_ri) <i class="fa fa-check"></i> @endif</td>
								<td class="text-right">{{ number_format($d->tarif_kelas_vip) }}</td>     
								<td class="text-right">{{ number_format($d->tarif_kelas_1) }}</td>     
								<td class="text-right">{{ number_format($d->tarif_kelas_2) }}</td>     
								<td class="text-right">{{ number_format($d->tarif_kelas_3) }}</td>     
								<td class="text-right">{{ number_format($d->tarif_kelas_rj) }}</td>
								@role(['administrator'])
								<td>
									<a href="{{ url('tarif/'.$d->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
								</td>
								{{--<td>
									<a href="{{ url('tarif/'.$d->id.'/hapus') }}" onclick="alert('data sudah terhapus')" class="btn btn-danger btn-sm"><i class="fa fa-close"></i></a>
								</td>--}}
								@endrole
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="jasa_medis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			<h5 class="modal-title" id=""></h5>
		</div>
		<div class="modal-body">
		<div class='table-responsive'>
							<form id="update_jasa_medis">
							{{ csrf_field() }} 
							<div class="col-sm-12 no-padding">
								<label for="satuan" class="control-label">Dokter</label>
								<input type="text" name="jasa_dokter" class="form-control jasa_dokter" id="jasa_dokter" placeholder="Berapa Persen dari Tarif" value="{{$jasa_medis->dokter}}">
								<span class="text-danger" id=satuan-error></span>
							</div>
							<div class="col-sm-12 no-padding">
								<label for="jumlah" class="control-label">Perawat / Bidan </label>
								<input type="number" name="jasa_perawat" class="form-control jasa_perawat" id="jasa_perawat" placeholder="Berapa Persen dari Tarif" value="{{$jasa_medis->perawat}}">
								<span class="text-danger" id=jumlah_item-error></span>
							</div>
							
		</div>							
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<a type="button" id="saveJasa" class="btn btn-primary ">Save changes</button>
		</form>
		</div>
		</div>
	</div>
	</div>
@stop

@section('script')
<script type="text/javascript">
$(document).ready(function() {
	$('#tarif').DataTable({
		
	});
});

$('#edit_jasa_medis').on('click', function() {
		$('#jasa_medis').modal('show');
		$('.modal-title').text('Jasa Medis');
		//$('#masterObat').DataTable().destroy();
	
		
	});

	$('#saveJasa').on('click', function () {
		$.ajax({
			type: 'POST',
			url: 'tarif/jasa_medis_update',
			data: $('#update_jasa_medis').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == true){
					$('input[name="jasa_dokter"]').val(data.jasa_dokter);
					$('input[name="jasa_perawat"]').val(data.jasa_perawat);
					$('#jasa_medis').modal('hide');
				}
			}
		});
	});
</script>
@endsection