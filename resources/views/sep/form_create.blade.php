@extends('master')
@section('header')	
	@php
		$status_reg = substr($reg->status_reg,0,1);
		$nomor = 'Nomor Rujukan';
		$layanan = '';
		if($status_reg=="G"){
			$nomor = 'Nomor Kartu BPJS';
			$layanan = 'Gawat Darurat';
		}elseif($status_reg=="J"){
			$layanan = 'Rawat Jalan';
		}elseif($status_reg=="I"){
			$layanan = 'Rawat Inap';
		}
	@endphp
  <h1>Form Pembuatan SEP<small> - {{$layanan}}</small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
			<div id="formKartu" class=""> {{-- cari-sep/noka --}}
			{!! Form::open(['method' => 'POST', 'url' => 'registrasi/v-claim/cari-peserta', 'class' => 'form-horizontal']) !!}
				<input type="hidden" value="{{$reg->status_reg}}" name="status_reg">
				<input type="hidden" value="{{$reg->poli_id}}" name="poli_bpjs">
				<div class="col-md-12" style="background:#f9f9f9;padding:10px 10px 5px 10px;border:1px solid #eee;">
					<div class="form-group{{ $errors->has('no_kartu') ? ' has-error' : '' }}">
						<div class="col-xs-4">
						</div>
						<div class="col-xs-3">
							{!! Form::text('nomor', '', ['class' => 'form-control', 'placeholder' => $nomor]) !!}
							<small class="text-danger">{{ $errors->first('nomor') }}</small>
						</div>
						<div class="col-xs-1 no-padding">
							{!! Form::submit("CARI", ['class' => 'btn btn-block btn-flat btn-success']) !!}
						</div>
					</div>
				</div>

				@if (isset($keterangan))
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6">
							Status:
							<div class="form-group {{ $keterangan == 'AKTIF' ? 'has-success' : 'has-error' }}">
								<input type="text" class="form-control" value="{{ $keterangan }}">
							</div>
						</div>
						<div class="col-md-6">
							Nama:
							<div class="form-group {{ $keterangan == 'AKTIF' ? 'has-success' : 'has-error' }}">
								<input type="text" class="form-control" value="{{ $nama }}">
							</div>
						</div>
					</div>
				</div>
				@endif			
			{!! Form::close() !!}
			</div>
    </div>
		
		{!! Form::open(['method' => 'POST', 'url' => 'simpan-no-sep', 'class' => 'form-horizontal', 'id'=>'formSEP']) !!}
			@include('sep.form_sep')
		{!! Form::close() !!}

		<div class="modal fade" id="ICD10" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id=""></h4>
					</div>
					<div class="modal-body">
						<div class='table-responsive'>
							<table id='dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
								<thead>
									<tr>
										<th>No</th>
										<th>Kode</th>
										<th>Nama</th>
										<th>Add</th>
									</tr>
								</thead>

							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
$("input[name='nomor']").val("");
$(".select2").select2();
function chLaka(val){
	if(val==1){
		$("#laka").show();
	}else{
		$("#laka").hide();
	}
}

$(document).ready(function() {
  $("input[name='diagnosa_awal']").on('focus', function () {
		$("#dataICD10").DataTable().destroy()
		$("#ICD10").modal('show');
		$('#dataICD10').DataTable({
			"language": {
				"url": "/json/pasien.datatable-language.json",
			},

			pageLength: 10,
			autoWidth: false,
			processing: true,
			serverSide: true,
			ordering: false,
			ajax: '/sep/geticd10',
			columns: [
				// {data: 'rownum', orderable: false, searchable: false},
				{data: 'id'},
				{data: 'nomor'},
				{data: 'nama'},
				{data: 'add', searchable: false}
			]
		});
	});

	$(document).on('click', '.addICD', function (e) {
		document.getElementById("diagnosa_awal").value = $(this).attr('data-nomor');
		document.getElementById("diagnosa_text").value = $(this).attr('data-nama');
		$('#ICD10').modal('hide');
	});


	$('#createSEP').on('click', function () {
		$.ajax({
			url : '{{ url('/buat-sep') }}',
			type: 'POST',
			data: $("#formSEP").serialize(),
			processing: true,
			beforeSend: function () {
			$('.progress').removeClass('hidden')
			},
			complete: function () {
			$('.progress').addClass('hidden')
			},
			success:function(data){
				console.log(data);
				if(data.sukses){
					$('#fieldSEP').removeClass('has-error');
					$("input[name='no_sep']").val( data.sukses );
				} else if (data.msg) {
					alert(data.msg);
					$('#fieldSEP').addClass('has-error');
					$("input[name='no_sep']").val( data.msg );
				}
			}
		});
  });
});
setTimeout(function(){
	$("#laka").hide();
}, 100);
</script>
@endsection
