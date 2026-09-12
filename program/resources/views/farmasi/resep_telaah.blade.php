@extends('master')
@section('header')
	@php
		$jenis_link = 'formpenjualan';
		if($jenis=='epo'){
			$jenis_link = 'formpermintaan';
		}
	@endphp
	<h1 class="pull-right">
		<a href="{{ url('penjualan/'.$jenis_link.'/'.$register->pasien_id.'/'.$register->id.'/'.$no_resep->id) }}" class="btn btn-flat btn-success">Kembali</a>
	</h1>
  <h1>Telaah Resep</h1>
@endsection

@section('content')
{!! Form::open(['method' => 'POST', 'url' => 'farmasi/simpan-telaah']) !!}
{{ csrf_field() }} {{ method_field('POST') }}
{!! Form::hidden('registrasi_id', $register->id) !!}
{!! Form::hidden('pasien_id', $register->pasien_id) !!}
{!! Form::hidden('penjualan_id', $no_resep->id) !!}
{!! Form::hidden('jenis', $jenis) !!}
  <div class="box box-primary">
    <div class="box-body">
			<table class='table table-striped table-bordered table-hover table-condensed'>
				<tbody>
				  <tr>
						<th>No. RM</th>
						<th>Nama</th>
						<th>Tgl Lahir</th>
						<th>Alamat</th>
				  </tr>
				  <tr>
						<td>{{$register->pasien->no_rm}}</td>
						<td>{{$register->pasien->nama}}</td>
						<td>{{tgl_indo($register->pasien->tgllahir)}}</td>
						<td>{{$register->pasien->alamat}}</td>
				  </tr>
				</tbody>
			</table>
			<div class="col-md-12 no-padding" style="margin:10px 0;">
				<div class="col-md-4 no-padding">
					<div class="form-group{{ $errors->has('berat_badan') ? ' has-error' : '' }}">
						{!! Form::label('berat_badan', 'Berat Badan', ['class' => 'col-sm-12 no-padding no-margin']) !!}
						<div class="col-md-12 no-padding">
							<div class="input-group">
								{!! Form::text('berat_badan', $register->berat_badan, ['class' => 'form-control', 'readonly'=>true, 'autocomplete' => 'off']) !!}
								<small class="text-danger">{{ $errors->first('berat_badan') }}</small>
								<span class="input-group-btn">
									<input type="button" class="btn btn-flat pull-right" value="Kg">
								</span>
							</div>
						</div>
					</div>
				</div>				
				<div class="col-md-4 no-padding">
					<div class="form-group{{ $errors->has('tekanan_darah') ? ' has-error' : '' }}">
						{!! Form::label('tekanan_darah', 'Tekanan Darah', ['class' => 'col-sm-12 no-padding no-margin']) !!}
						<div class="col-md-12 no-padding">
							<div class="input-group">
								{!! Form::text('tekanan_darah', $register->tekanan_darah, ['class' => 'form-control', 'readonly'=>true, 'autocomplete' => 'off']) !!}
								<small class="text-danger">{{ $errors->first('tekanan_darah') }}</small>
								<span class="input-group-btn">
									<input type="button" class="btn btn-flat pull-right" value="mmHg">
								</span>
							</div>
						</div>
					</div>
				</div>				
				<div class="col-md-4 no-padding">
					<div class="form-group{{ $errors->has('diagnosa_akhir') ? ' has-error' : '' }}">
						{!! Form::label('diagnosa_akhir', 'Diagnosa Pasien', ['class' => 'col-sm-12 no-padding no-margin']) !!}
						<div class="col-md-12 no-padding">
							{!! Form::textarea('diagnosa_akhir', $register->diagnosa_akhir, ['class' => 'form-control', 'readonly'=>true, 'id'=>'diagnosa_akhir', 'style'=>'height:70px;resize:none;']) !!}
							<small class="text-danger">{{ $errors->first('diagnosa_akhir') }}</small>
						</div>
					</div>
				</div>	
			</div>
    </div>
  </div>
	<h5>Nomor Resep: #{{$no_resep->no_resep}}</h5>
  <div class="box" style="border-top:none;">
    <div class="box-body">
			<div class="col-md-4">
				<table class='table table-hover'>
					<tbody>
						<tr class="bg-primary">
							<th style="vertical-align:middle;width:5%;">NO.</th>
							<th style="vertical-align:middle;width:55%;">ASPEK TELAAH</th>
							<th style="text-align:center;width:20%;">YA</th>
							<th style="text-align:center;width:20%;">TIDAK</th>
						</tr>
						@php
							$no = 1;
						@endphp
						@foreach($master_telaah as $key => $data1)
							@if($data1->aspek_telaah==1)
								<tr>
									<td style="vertical-align:middle;">{{$no}}</td>
									<td style="vertical-align:middle;">{{$data1->uraian}}</td>
									<td style="text-align:center;">
										<label>
											@php
												$checked 	= '';
												$get_data = App\ResepTelaah::where('jenis',$jenis)->where('telaah_id',$data1->id)->where('registrasi_id', $register->id)->first();
												if($get_data!=null){
													if($get_data->jawaban=='1'){
														$checked = 'checked';
													}
												}
											@endphp
											<input {{$checked}} class="flat-col" style="cursor:pointer;" type="radio" name="aspektelaah{{$data1->id}}" id="aspektelaah{{$data1->id}}" value="1">
										</label>
									</td>
									<td style="text-align:center;">
										<label>
											@php
												$checked 	= '';
												if($get_data!=null){
													if($get_data->jawaban=='0'){
														$checked = 'checked';
													}
												}
											@endphp
											<input {{$checked}} class="flat-col" style="cursor:pointer;" type="radio" name="aspektelaah{{$data1->id}}" id="aspektelaah{{$data1->id}}" value="0">
										</label>
									</td>
								</tr>
								@php
									$no++;
								@endphp
							@endif
						@endforeach
					</tbody>
				</table>
			</div>
			
			<div class="col-md-3">
				<table class='table table-hover'>
					<tbody>
						<tr class="bg-primary">
							<th style="vertical-align:middle;width:5%;">NO.</th>
							<th style="vertical-align:middle;width:55%;">TELAAH OBAT</th>
							<th colspan=2 style="text-align:center;width:40%;">CHECK LIST</th>
						</tr>
						@php
							$no = 1;
						@endphp
						@foreach($master_telaah as $key => $data1)
							@if($data1->telaah_obat==1)
								<tr>
									<td style="vertical-align:middle;">{{$no}}</td>
									<td style="vertical-align:middle;">{{$data1->uraian}}</td>
									<td colspan=2 style="text-align:center;">
										<label>
											@php
												$checked 	= '';
												$get_data = App\ResepTelaah::where('jenis',$jenis)->where('telaah_id',$data1->id)->where('registrasi_id', $register->id)->first();
												if($get_data!=null){
													if($get_data->jawaban=='on'){
														$checked = 'checked';
													}
												}
											@endphp
											<input {{ $checked }} class="flat-col" style="cursor:pointer;" type="checkbox" name="telaahobat{{$data1->id}}" id="telaahobat{{$data1->id}}" >
										</label>
									</td>
								</tr>
								@php
									$no++;
								@endphp
							@endif
						@endforeach
					</tbody>
				</table>
			</div>
			
			<div class="col-md-5">
				<table class='table table-hover'>
					<tbody>
						<tr class="bg-primary">
							<th style="vertical-align:middle;width:5%;">NO.</th>
							<th style="vertical-align:middle;width:45%;">PELAYANAN RESEP</th>
							<th colspan=2 style="text-align:center;width:50%;">PETUGAS FARMASI</th>
						</tr>
						@php
							$no = 1;
						@endphp
						@foreach($master_telaah as $key => $data1)
							@if($data1->pelayanan_resep==1)
								<tr>
									<td style="vertical-align:middle;">{{$no}}</td>
									<td style="vertical-align:middle;">{{$data1->uraian}}</td>
									<td colspan=2 style="text-align:center;">
										@if($data1->id==16)
											<input value="{{Auth::user()->id}}" type="hidden" name="id_pelayananresep{{$data1->id}}" id="id_pelayananresep{{$data1->id}}">
											<input readonly style="cursor:pointer;" value="{{ Auth::user()->name }}" type="text" name="pelayananresep{{$data1->id}}" id="pelayananresep{{$data1->id}}" class="form-control">
										@elseif($data1->id==17)
											<input value="{{$no_resep->user_id}}" type="hidden" name="id_pelayananresep{{$data1->id}}" id="id_pelayananresep{{$data1->id}}">
											<input readonly style="cursor:pointer;" value="{{ App\User::where('id',$no_resep->user_id)->first()->name }}" type="text" name="pelayananresep{{$data1->id}}" id="pelayananresep{{$data1->id}}" class="form-control">
										@else
											<select name="pelayananresep{{$data1->id}}[]" id="pelayananresep{{$data1->id}}" class="form-control select2" multiple="multiple">
												<option value="0">--pilih--</option>
												@foreach($apoteker_perawat as $key => $data)
													@php
														$selected 	= '';
														$get_data = App\ResepTelaah::where('jenis',$jenis)->where('telaah_id',$data1->id)->where('registrasi_id', $register->id)->first();
														if($get_data!=null){
															$data_jawaban = json_decode($get_data->jawaban);
															if($data_jawaban!=null){
																if(in_array($data->id, $data_jawaban)){
																	$selected = 'selected';
																}
															}
														}
													@endphp
													<option {{$selected}} value="{{$data->id}}">{{$data->nama}}</option>
												@endforeach
											</select>
										@endif
									</td>
								</tr>
								@php
									$no++;
								@endphp
							@endif
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="col-md-12">
				@foreach($master_telaah as $key => $data1)
					@if($data1->uraian_interaksi==1)
						<label>{{$data1->uraian}}</label>						
						@php
							$textarea 	= '';
							$get_data = App\ResepTelaah::where('jenis',$jenis)->where('telaah_id',$data1->id)->where('registrasi_id', $register->id)->first();
							if($get_data!=null){
								$textarea = $get_data->jawaban;
							}
						@endphp
						<textarea name="uraianinteraksi{{$data1->id}}" class="form-control" style="height:100px;" placeholder="Tuliskan uraian disini...">{{$textarea}}</textarea>
					@endif
				@endforeach
			</div>
    </div>
  </div>
  <div class="box box-primary">
    <div class="box-body">
			<button class="btn btn-primary btn-flat pull-right">SIMPAN</button>
			<a href="{{ url('penjualan/'.$jenis_link.'/'.$register->pasien_id.'/'.$register->id.'/'.$no_resep->id) }}" class="btn btn-flat btn-warning pull-right">BATAL</a>
			<a href="#" class="btn btn-flat btn-default pull-right">CETAK</a>
    </div>
  </div>
{!! Form::close() !!}
@endsection
