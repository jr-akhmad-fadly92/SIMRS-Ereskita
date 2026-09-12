@extends('master')

@section('content')
	<div class="col-md-2 no-padding" style="padding-right:10px!important;">	
		<h4 style="margin-top:0;font-size:14px;font-weight:600;">
			Input Hasil Lab
		</h4>
		<!-- border-radius:4px 4px 50px 4px!important; -->
		<div class="box box-widget widget-user" style="margin-bottom:10px;">
			<div class="widget-user-header bg-aqua-active" style="height:auto;">
				<div class="row">
					<table class="table-condensed" style="width:100%;color:white;">
						<tr>
							<td style="width:35%;">Nama</td><td class="text-right"><b>{{ $reg->pasien->nama }} /{{ hitung_umur_tahun($reg->pasien->tgllahir,'Y') }} </td>
						</tr>
						<tr>
							<td>No. RM</td><td class="text-right"><b>{{ $reg->pasien->no_rm }}</td>
						</tr>
						<tr>
							<td>Tgl. Lahir</td><td class="text-right"><b>{{ tgl_indo($reg->pasien->tgllahir) }}</td>
						</tr>
						<tr>
							<td>Alamat</td><td class="text-right"><b>{{ $reg->pasien->alamat }}</td>
						</tr>
						<tr>
							<td>Cara Bayar</td><td class="text-right"><b>{{ baca_carabayar($reg->bayar) }}</td>
						</tr>
						<tr>
							<td>DPJP</td><td class="text-right"><b>{{ baca_dokter($reg->dokter_id) }}</td>
						</tr>
						<tr>
							<td>Status</td><td class="text-right"><b>{{ ucwords($reg->posisi_pasien) }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12" style="margin-bottom:10px;">
				<button class="btn btn-warning btn-block btn-flat">Rp. {{ number_format($tagihan,0,',','.') }}</button>
			</div>
			@isset($lab)
			<div class="col-md-12" style="margin-bottom:10px;">
				<a target="_blank" href="{{ url('pemeriksaanlab/cetak/'.$reg->id.'/'.$lab->id) }}" class="btn btn-success btn-block btn-flat"><i class="fa fa-print"></i> CETAK</a>
			</div>
			@endisset
			<div class="col-md-12" style="margin-bottom:10px;">
				<a href="{{ url('laboratorium/entry-tindakan/'.$reg->id.'/'.$reg->pasien_id) }}" class="btn btn-success btn-block btn-flat"><i class="fa fa-arrow-left"></i> KEMBALI</a>
			</div>
		</div>
	</div>
	
	<div class="col-md-10 no-padding" id="div-right" style="overflow-y:auto;overflow-x:hidden;">	
		<div class="box box-primary">
			<div class="box-body">
				<div class="layout row">
					<div class="col-md-12">
						<div class="layout row">
							<div class="col-md-7">
								@if ($lab==null)
									{!! Form::open(['method' => 'POST', 'url' => 'pemeriksaanlab/store', 'class' => 'form-horizontal']) !!}
										{!! Form::hidden('pasien_id', $reg->pasien->id) !!}
										{!! Form::hidden('dokter_id', $reg->dokter_id) !!}
										{!! Form::hidden('reg_id', $reg->id) !!}
										<div class="form-group{{ $errors->has('penanggungjawab') ? ' has-error' : '' }}">
												{!! Form::label('penanggungjawab', 'Penanggung Jawab', ['class' => 'col-sm-4 control-label']) !!}
												<div class="col-sm-8">
														{!! Form::select('penanggungjawab', $petugas, session('pj'), ['class' => 'form-control select2', 'placeholder'=>'-- Pilih Penanggung Jawab --']) !!}
														<small class="text-danger">{{ $errors->first('penanggungjawab') }}</small>
												</div>
										</div>
										<div class="form-group{{ $errors->has('jam') ? ' has-error' : '' }}">
												{!! Form::label('jam', 'Jam Pengambilan Sampel', ['class' => 'col-sm-4 control-label']) !!}
												<div class="col-sm-8">
														{!! Form::text('jam', null, ['class' => 'form-control timepicker']) !!}
														<small class="text-danger">{{ $errors->first('jam') }}</small>
												</div>
										</div>
										<div class="form-group{{ $errors->has('jenissample') ? ' has-error' : '' }}">
												{!! Form::label('jenissample', 'Jenis Sampel', ['class' => 'col-sm-4 control-label']) !!}
												<div class="col-sm-8">
														{!! Form::select('jenissample', [''=>'', 'darah'=>'Darah', 'urine'=>'Urine', 'feases'=>'Feases', 'sputum'=>'Sputum', 'plasma'=>'Plasma', 'serum'=>'Serum'], null, ['class' => 'form-control select2']) !!}
														<small class="text-danger">{{ $errors->first('jenissample') }}</small>
												</div>
										</div>
										<div class="form-group{{ $errors->has('tgl_pemeriksaan') ? ' has-error' : '' }}">
												{!! Form::label('tglpemeriksaan', 'Tgl Pemeriksaan', ['class' => 'col-sm-4 control-label']) !!}
												<div class="col-sm-8">
														{!! Form::text('tgl_pemeriksaan', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
														<small class="text-danger">{{ $errors->first('tgl_pemeriksaan') }}</small>
												</div>
										</div>

										<div class="btn-group pull-right">
												{!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Yakin data sdh benar?")']) !!}
										</div>
									{!! Form::close() !!}
								@endif
							</div>
						</div>

						{{-- <RINCIAN>LAB</RINCIAN> --}}
						@if ($lab!=null)
							<div class="layout row">
								<div class="col-md-12">
									{{-- Data Lab --}}
									<div class='table-responsive'>
										<table class='table table-striped table-bordered table-hover table-condensed no-margin'>
											<tbody>
												<tr>
													<th style="width:20%;">Tanggal Bahan Diterima / Jam </th> 
													<td>{{ tgl_indo($lab->tgl_bahanditerima) }} / {{ $lab->jam }}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<h4>Rincian Hasil Lab</h4>
							<div class='table-responsive'>
								<table class='table table-striped table-bordered table-hover table-condensed'>
									<thead>
										<tr>
											<th class="text-center">
												<a href="#" class="btn btn-flat btn-warning btn-sm">
													<i class="fa fa-print" style="font-size:14px;"></i>
												</a>
											</th>
											<th>No</th>
											<th>Pemeriksaan</th>
											<th>Bawah</th>
											<th>Atas</th>
											<th>Satuan</th>
											<th style="width:120px!important;">Hasil</th>
											<th style="width:50px!important;">L/H</th>
											<th>Ket</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										@php $hasillab = 0; @endphp
										@foreach ($rincian as $key => $d)
											<tr>
												<td class="text-center" style="padding:0 5px;">
													@php
														$hasillab = $d->hasillab_id;
														$checked 	= '';
														if($d->cetak==1){
															$checked = 'checked';
														}
													@endphp
													<input type="checkbox" {{ $checked }} class="flat-col ck2" id-ch="{{ $d->id }}" style="cursor:pointer" name="cetak{{ $d->id }}">
												</td>
												<td style="padding:0 5px;">{{ $no++ }}</td>
												<td style="padding:0 5px;">{{ $d->tarif->nama }}</td>
												@if($status_umur=='laki_dewasa')
												<td style="padding:0 5px;">
													{{ (isset($d->laboratoria->nilairujukanbawah)) ? $d->laboratoria->nilairujukanbawah : '' }}
												</td>
												<td style="padding:0 5px;">
													{{ (isset($d->laboratoria->nilairujukanatas)) ? $d->laboratoria->nilairujukanatas : '' }}
												</td>
												<td style="padding:0 5px;">
													{{ (isset($d->laboratoria->satuan)) ? $d->laboratoria->satuan : '' }}
												</td>
												
												<td style="padding:0 5px;width:80px!important;">
													<input type="number" value="{{ $d->hasil }}" class="form-control" name="" onkeyup="saveHasil('hasil','{{$d->id}}',this.value, '{{(isset($d->laboratoria->nilairujukanbawah)) ? $d->laboratoria->nilairujukanbawah : 'null'}}','{{(isset($d->laboratoria->nilairujukanatas)) ? $d->laboratoria->nilairujukanatas : 'null'}}')" style="width:100%;">
												</td>
												<td style="width:50px!important;">
													<input id="low-height{{$d->id}}" type="text" value="{{$d->lh}}" class="form-control" name="" onkeyup="saveHasil('lh','{{$d->id}}',this.value)" style="width:100%;font-weight:bold;">
												</td>
												<td style="padding:0 5px;">
													<input type="text" value="{{$d->hasiltext}}" class="form-control" name="" onkeyup="saveHasil('ket','{{$d->id}}',this.value)">
												</td>
												<td style="padding:0 5px;">
													<a onclick="return confirm('Apakah Anda yakin untuk menghapus data ini?');" href="{{ url('pemeriksaanlab/deletedetail/'.$reg->id.'/'. $lab->id.'/'.$d->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
												</td>
												@elseif($status_umur=='wanita_dewasa')
												<td style="padding:0 5px;">
													{{ (isset($d->laboratoria->nilairujukanbawahwanita)) ? $d->laboratoria->nilairujukanbawahwanita : '' }}
												</td>
												<td style="padding:0 5px;">
													{{ (isset($d->laboratoria->nilairujukanataswanita)) ? $d->laboratoria->nilairujukanataswanita : '' }}
												</td>
												<td style="padding:0 5px;">
													{{ (isset($d->laboratoria->satuan)) ? $d->laboratoria->satuan : '' }}
												</td>

												<td style="padding:0 5px;width:80px!important;">
													<input type="number" value="{{ $d->hasil }}" class="form-control" name="" onkeyup="saveHasil('hasil','{{$d->id}}',this.value, '{{(isset($d->laboratoria->nilairujukanbawahwanita)) ? $d->laboratoria->nilairujukanbawahwanita : 'null'}}','{{(isset($d->laboratoria->nilairujukanataswanita)) ? $d->laboratoria->nilairujukanataswanita : 'null'}}')" style="width:100%;">
												</td>
												<td style="width:50px!important;">
													<input id="low-height{{$d->id}}" type="text" value="{{$d->lh}}" class="form-control" name="" onkeyup="saveHasil('lh','{{$d->id}}',this.value)" style="width:100%;font-weight:bold;">
												</td>
												<td style="padding:0 5px;">
													<input type="text" value="{{$d->hasiltext}}" class="form-control" name="" onkeyup="saveHasil('ket','{{$d->id}}',this.value)">
												</td>
												<td style="padding:0 5px;">
													<a onclick="return confirm('Apakah Anda yakin untuk menghapus data ini?');" href="{{ url('pemeriksaanlab/deletedetail/'.$reg->id.'/'. $lab->id.'/'.$d->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
												</td>
												@else
												<td style="padding:0 5px;">
													{{ (isset($d->laboratoria->nilairujukanbawahanak)) ? $d->laboratoria->nilairujukanbawahanak : '' }}
												</td>
												<td style="padding:0 5px;">
													{{ (isset($d->laboratoria->nilairujukanatasanak)) ? $d->laboratoria->nilairujukanatasanak : '' }}
												</td>
												<td style="padding:0 5px;">
													{{ (isset($d->laboratoria->satuan)) ? $d->laboratoria->satuan : '' }}
												</td>

												<td style="padding:0 5px;width:80px!important;">
													<input type="number" value="{{ $d->hasil }}" class="form-control" name="" onkeyup="saveHasil('hasil','{{$d->id}}',this.value, '{{(isset($d->laboratoria->nilairujukanbawahanak)) ? $d->laboratoria->nilairujukanbawahanak : 'null'}}','{{(isset($d->laboratoria->nilairujukanatasanak)) ? $d->laboratoria->nilairujukanatasanak : 'null'}}')" style="width:100%;">
												</td>
												<td style="width:50px!important;">
													<input id="low-height{{$d->id}}" type="text" value="{{$d->lh}}" class="form-control" name="" onkeyup="saveHasil('lh','{{$d->id}}',this.value)" style="width:100%;font-weight:bold;">
												</td>
												<td style="padding:0 5px;">
													<input type="text" value="{{$d->hasiltext}}" class="form-control" name="" onkeyup="saveHasil('ket','{{$d->id}}',this.value)">
												</td>
												<td style="padding:0 5px;">
													<a onclick="return confirm('Apakah Anda yakin untuk menghapus data ini?');" href="{{ url('pemeriksaanlab/deletedetail/'.$reg->id.'/'. $lab->id.'/'.$d->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
												</td>
												@endif
											</tr>
										@endforeach
											<tr>
												<td colspan="3" class="text-right">Catatan</td>
												<td colspan="7"><textarea onkeyup="saveHasil('cat','{{$hasillab}}',this.value)" class="form-control">{{$lab->catatan}}</textarea></td>
											</tr>
									</tbody>
								</table>
							</div>
							@php
								$status = Modules\Registrasi\Entities\Registrasi::where('id', $reg->id)->first();
							@endphp
							<div class="col-md-12">
								<center>
								@if(strtolower(Auth::user()->role()->first()->name)=='laboratorium')
									@if (substr($status->status_reg, 0, 1) == 'G' OR substr($status->status_reg, 0, 1) == 'J')
										<a href="{{ url('pemeriksaanlab') }}" onclick="return confirm('Pastikan hasil pemeriksaan selesai di Input! Data yang sudah disimpan tidak bisa di edit.')" class="btn btn-success btn-flat"><i class="fa fa-check"></i> SELESAI</a>
									@elseif (substr($status->status_reg, 0, 1) == 'I')
										<a href="{{ url('pemeriksaanlab') }}" onclick="return confirm('Pastikan hasil pemeriksaan selesai di Input! Data yang sudah disimpan tidak bisa di edit.')" class="btn btn-success btn-flat"><i class="fa fa-check"></i> SELESAI</a>
										<!--a href="{{ url('rawat-inap/billing') }}" onclick="return confirm('Pastikan hasil pemeriksaan selesai di Input! Data yang sudah disimpan tida bisa di edit.')" class="btn btn-success btn-flat"><i class="fa fa-check"></i> SELESAI</a-->
									@endif
								@else
									<a href="{{ url('tindakan/entry/'.$reg->id.'/'.$reg->pasien->id) }}" class="btn btn-success btn-flat"><i class="fa fa-check"></i> KEMBALI</a>
								@endif
							</div>
						@endif
					</div>
				</div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
$('#div-right').css('height',(window.innerHeight-75));
$('.content').css('padding-right','0px');
$(".select2").select2();
function saveHasil(jenis,id,val,nilaibawah=0,nilaiatas=0){
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		url: '/pemeriksaanlab/save-hasil',
		type: "POST",
		data: {jenis:jenis,id:id,val:val,nilaibawah:nilaibawah,nilaiatas:nilaiatas},
		success:function(data) {
			$("#low-height"+id).val(data.lh);
		}
	});
}

// link untuk check all https://stackoverflow.com/questions/17820080/function-select-all-and-icheck/26028982
$(".ck2").on("ifChanged", function(){
	if($(this).is(':checked')){
		var cetak = 1;
	}else{
		var cetak = 0;
	}
	
	$.ajax({
		url: '/pemeriksaanlab/update-cetak/'+$(this).attr('id-ch')+'/'+cetak,
		type: "GET",
		success:function(data) {
			
		}
	});
});
</script>
@endsection