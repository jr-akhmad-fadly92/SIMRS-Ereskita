@extends('master')

@section('content')
	<div class="col-md-2 no-padding" style="padding-right:10px!important;">	
		<h4 style="margin-top:0;font-size:14px;font-weight:600;">
			Input Hasil Radiologi
		</h4>
		<!-- border-radius:4px 4px 50px 4px!important; -->
		<div class="box box-widget widget-user" style="margin-bottom:10px;">
			<div class="widget-user-header bg-aqua-active" style="height:auto;">
				<div class="row">
					<table class="table-condensed" style="width:100%;color:white;">
						<tr>
							<td style="width:35%;">Nama</td><td class="text-right"><b>{{ $reg->pasien->nama }}</td>
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
		<div class="col-md-12 no-padding">
			<a target="_blank" href="{{ url('/radiologi/q/cetak/'.$reg->id) }}" class="btn btn-warning btn-block btn-flat">CETAK HASIL</a>
			<a href="{{ url('/radiologi/entry-tindakan/'.$reg->id.'/'.$reg->pasien->id) }}" class="btn btn-success btn-block btn-flat">KEMBALI</a>
		</div>
	</div>
	
	<div class="col-md-10 no-padding" id="div-right" style="overflow-y:auto;overflow-x:hidden;">	
		<div class="box box-primary">
			{!! Form::open(['method' => 'POST', 'url' => 'radiologi/save-hasil', 'class' => 'form-horizontal']) !!}
				<div class="box-body">
					{!! Form::hidden('registrasi_id', $reg->id) !!}
					@if($order_radiologi_data!=null)
						@foreach($order_radiologi_data as $key => $data)
							<input type="hidden" name="data_order_id{{$data->id}}" value="{{$data->id}}">
							<div class="col-md-12 no-padding">
								<h5 class="text-bold" style="margin:10px 0;">#{{ ($key+1).'. '.$data->tindakanRadiologi->tindakan_radiologi }} - {{ strtoupper($data->tindakanRadiologiSub->kelompok) }}</h5>
								<div class="col-md-8 no-padding">
									@php
										$hasil_pemeriksaan = "";
										$kesan_pemeriksaan = "";
										$dokter_radiologi = "";
										$hasil = App\Hasilradiologi::where('data_order_radiologi_id',$data->id)->first();
										if($hasil!=null){
											$hasil_pemeriksaan = $hasil->hasil_pemeriksaan;
											$kesan_pemeriksaan = $hasil->kesan;
											$dokter_radiologi = $hasil->dokter_id;
										}
									@endphp
									<textarea class="form-control" placeholder="Silahkan tuliskan hasil disini..." name="hasil_radiologi{{$data->id}}" style="height:250px;">{{$hasil_pemeriksaan}}</textarea>
								</div>
								<div class="col-md-4" style="padding-left:10px;padding-right:0;">
									<textarea class="form-control" placeholder="Silahkan tuliskan kesan disini..." name="kesan_radiologi{{$data->id}}" style="height:200px;">{{$kesan_pemeriksaan}}</textarea>
									<br>
									{{ Form::select('dokter_radiologi'.$data->id, $dokter, $dokter_radiologi, ['class' => 'form-control select2', 'placeholder'=>'-- Pilih Dokter Radiologi --']) }}
								</div>
							</div>
							<div class="col-md-12 no-padding">
								<br>
							</div>
						@endforeach
					@endif
					<div class="col-md-12 no-padding">
						<hr class="no-margin">
					</div>
					<div class="col-md-12 no-padding">
						<center>
						{!! Form::submit("SIMPAN", ['style' => 'margin-top:10px;', 'class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
$('#div-right').css('height',(window.innerHeight-75));
$('.content').css('padding-right','0px');
$('.select2').select2({});
</script>
@endsection