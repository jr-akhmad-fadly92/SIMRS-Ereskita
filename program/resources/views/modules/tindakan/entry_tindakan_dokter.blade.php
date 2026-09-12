@extends('master')
<title>{{$reg->pasien->no_rm.' | '.$reg->pasien->nama}}</title>

@section('content')
	{!! Form::hidden('registrasi_idx', $idreg, ['id'=>'registrasi_idx']) !!}
	<div class="col-md-12 no-padding" id="div-right" style="overflow-y:auto;overflow-x:hidden;">
		<div class="nav-tabs-custom" style="margin-bottom:0;">
			<ul class="nav nav-tabs">
				<li id="tabrm" ><a href="#tab_rm" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">SUBJECT</a></li>
				<li id="tabobject" ><a href="#tab_object" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">OBJECT</a></li>
				<li id="tabassesment" ><a href="#tab_assesment" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">ASSESMENT</a></li>
				@if(strtolower(Auth::user()->role()->first()->name)!='adminpoli')
				<li id="tabtindakan" class="active"><a href="#tab_tindakan" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">TINDAKAN</a></li>
				<li id="tabpakaiobat"><a href="#tab_pakaiobat" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">PEMAKAIAN OBAT</a></li>
				@endif
				@if(strtolower(Auth::user()->role()->first()->name)=='rawatinap'  || strtolower(Auth::user()->role()->first()->name)=='kamarbersalin' || strtolower(Auth::user()->role()->first()->name)=='supervisor')
					<li id="tabkpo"><a href="#tab_kpo" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">PERMINTAAN OBAT</a></li>
				@endif
				@if(strtolower(Auth::user()->role()->first()->name)!='adminpoli')
				<li id="tabresepobat">
					<a href="#tab_resepobat" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">
						@if(strtolower(Auth::user()->role()->first()->name)=='rawatinap')
							OBAT PULANG
						@else
							RESEP OBAT
						@endif
					</a>
				</li>
				<li id="tablain" ><a href="#tab_lain" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">LAIN LAIN</a></li>
				@endif
				<div class="pull-right" style="width: 40%;">
					<div class="col-md-12 col-sm-12 col-xs-12 no-padding">
						{{--  KONDISI PASIEN AKHIR  --}}
						@if(strtolower(Auth::user()->role()->first()->name)!='adminpoli')
						<form id="formKondisi_Akhir_Pasien" method="post" class="form-horizontal">
						{{ csrf_field() }} {{ method_field('POST') }}
							{!! Form::hidden('registrasi_id', $reg_id) !!}
							{!! Form::hidden('status_reg', substr($reg->status_reg,0,1)) !!}
								<div class="form-group no-margin">
									@if(strtolower(Auth::user()->role()->first()->name)=='administrator' || $reg->supervisor_edit==1)
										@if(strtolower(Auth::user()->role()->first()->name)=='supervisor')
											<div class="col-md-7 col-sm-7 col-xs-7" style="margin-top:3.2px;">
											</div>
											<div class="col-md-5 col-sm-5 col-xs-5" style="padding-left:0;margin-top:5px;">
												{!! Form::submit("SIMPAN PERUBAHAN", ['class' => 'btn btn-success btn-block btn-flat', 'onclick'=>'javascript:return confirm("Yakin data ini sudah benar?")']) !!}
											</div>
										@endif
									@else
										@if($persalinan)
											<div class="col-md-12" style="padding-left:0;margin-top:5px;">
												{!! Form::submit("SELESAI PERSALINAN", ['class' => 'btn btn-success btn-flat pull-right', 'onclick'=>'javascript:return confirm("Yakin data ini sudah benar?")']) !!}
											</div>
										@else
											<div class="col-md-7 col-sm-7 col-xs-7" style="margin-top:3.2px;">
												{!! Form::select('kondisi_akhir_pasien', $kondisi, $reg->kondisi_akhir_pasien, ['class' => 'form-control', 'onchange'=>'kondisiAkhirPasien(this.value)']) !!}
											</div>
											<div class="col-md-5 col-sm-5 col-xs-5" style="padding-left:0;margin-top:5px;">
												<button type="button" id="Kondisi_Akhir_Pasien" class="btn btn-success btn-block btn-flat" >PULANGKAN PASIEN</button>
												
											</div>
										@endif
									@endif
								</div>
						</form>
						@endif
						
					</div>
				</div>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_rm">
					<div class="rowx">						
						<div class="row">
							<div class="col-md-4">
								<h4 style="margin-top:0;font-size:14px;font-weight:600;">
									@if (substr($reg->status_reg,0,1) == 'G')
										Penata Jasa Rawat Darurat #{{$reg->reg_id}}
									@elseif (substr($reg->status_reg,0,1) == 'I')
										Penata Jasa Rawat Inap #{{$reg->reg_id}}
									@else
										Penata Jasa {{$poli->nama}} #{{$reg->reg_id}}
									@endif
								</h4>
								<div class="box box-widget widget-user" style="margin-bottom:10px;">
									<div class="widget-user-header bg-aqua-active" style="height:auto;">
										<div class="row">
											<table class="table-condensed" style="width:100%;color:white;" name="table_info_rekammedis" id="table_info_rekammedis">
												<tr>
													<td style="width:35%;">Nama</td><td class="text-right"><b>{{ $pasien->nama }}</td>
												</tr>
												<tr>
													<td>No. RM</td><td class="text-right"><b>{{ $pasien->no_rm }}</td>
												</tr>
												<tr>
													<td>Tgl. Lahir</td><td class="text-right"><b>{{ tgl_indo($pasien->tgllahir) }}</td>
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
												<tr>
													<td>Diagnosa Sementara</td><td class="text-right" id="tampilan_diagnosa_awal" style="font-weight: bold;">{{ ucwords($reg->diagnosa_awal) }}</td>
												</tr>
												<tr>
													<td>Diagnosa Akhir</td><td class="text-right" id="tampilan_diagnosa_akhir" style="font-weight: bold;">{{ ucwords($reg->diagnosa_akhir) }}</td>
												</tr>
											</table>
										</div>
									</div>
								</div>
								<div class="col-md-12 no-padding" style="margin-bottom:5px;">
									<button class="btn btn-warning btn-block btn-flat">Rp. {{ number_format(total_tagihan($reg->id)) }}</button>
								</div>
								<div class="col-md-12 no-padding" style="margin-bottom:5px;">
									<button class="btn btn-warning btn-block btn-flat  bg-aqua-active" id="show_histori">Histori Pemeriksaan Fisik</button>
								</div>
							</div>							
							<div class="col-md-7 no-padding">
								<h4 style="margin-top:0;font-size:14px;font-weight:600;">
									Data Kondisi Pasien
								</h4>
								<div class="col-md-12 no-padding">
									<div class="col-md-4 no-padding">
										{!! Form::label('berat_badan', 'Berat Badan', ['class' => 'col-sm-12 no-padding no-margin']) !!}
										<div class="input-group">
											{!! Form::text('berat_badan', $reg->berat_badan, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											<small class="text-danger">{{ $errors->first('berat_badan') }}</small>
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right" value="Kg">
											</span>
										</div>
									</div>
									<div class="col-md-4 no-padding">
										{!! Form::label('sistolik', 'Tensi (Atas)', ['class' => 'col-sm-12 no-padding no-margin']) !!}
										<div class="input-group">
											@if($cek==null)
											{!! Form::text('sistolik', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											@else
											{!! Form::text('sistolik', $reg->sistolik, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											@endif
											
											<small class="text-danger">{{ $errors->first('sistolik') }}</small>
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right" value="mmHg">
											</span>
										</div>
									</div>
									<div class="col-md-4 no-padding">
										{!! Form::label('diastolik', 'Tensi (Bawah)', ['class' => 'col-sm-12 no-padding no-margin']) !!}
										<div class="input-group">
											@if($cek==null)
											{!! Form::text('diastolik', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											@else
											{!! Form::text('diastolik', $reg->diastolik, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											@endif
											<small class="text-danger">{{ $errors->first('diastolik') }}</small>
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right" value="mmHg">
											</span>
										</div>
									</div>
								</div>
								<div class="col-md-12 no-padding">
									<div class="col-md-4 no-padding">
										{!! Form::label('tinggi', 'Tinggi Badan', ['class' => 'col-sm-12 no-padding no-margin']) !!}
										<div class="input-group">
											@if($cek==null)
											{!! Form::text('tinggi', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											@else
											{!! Form::text('tinggi', $reg->tinggi, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											@endif
											<small class="text-danger">{{ $errors->first('tinggi') }}</small>
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right" value="Meter">
											</span>
										</div>
									</div>
									<div class="col-md-4 no-padding">
										{!! Form::label('suhu', 'Suhu Badan', ['class' => 'col-sm-12 no-padding no-margin']) !!}
										<div class="input-group">
											@if($cek==null)
											{!! Form::text('suhu', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											@else
											{!! Form::text('suhu', $reg->suhu, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											@endif
											<small class="text-danger">{{ $errors->first('suhu') }}</small>
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right" value="°C">
											</span>
										</div>
									</div>
									<div class="col-md-4 no-padding">
										{!! Form::label('respirasi', 'Respirasi', ['class' => 'col-sm-12 no-padding no-margin']) !!}
										<div class="input-group">
											@if($cek==null)
											{!! Form::text('respirasi', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											@else
											{!! Form::text('respirasi', $reg->respirasi, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											@endif
											<small class="text-danger">{{ $errors->first('respirasi') }}</small>
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right" value="x/Mnt">
											</span>
										</div>
									</div>
									<div class="col-md-12 no-padding " >
										{!! Form::label('gizi', 'Status Gizi', ['class' => 'col-sm-12 no-padding no-margin']) !!}
										<div class="input-group status_gizi" id="status_gizi" name="status_gizi">
											@if($cek==null)
											{!! Form::text('gizi', null, ['class' => 'form-control', 'autocomplete' => 'off','readonly'=>'true']) !!}
											@else
											{!! Form::text('gizi', $reg->status_gizi, ['class' => 'form-control', 'autocomplete' => 'off','readonly'=>'true']) !!}
											@endif
											@if($cek==null)
											{!! Form::hidden('tekanan_darah', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											@else
											{!! Form::hidden('tekanan_darah', $reg->tekanan_darah, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											@endif
											<small class="text-danger">{{ $errors->first('gizi') }}</small>
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right" value="#">
											</span>
										</div>
									</div>
								</div>
								
								<div class="col-md-12 no-padding">
									<div class="col-md-12 no-padding">
										{!! Form::label('keluhan_pasien', 'Keluhan Utama Pasien', ['class' => 'col-sm-12 no-padding no-margin']) !!}
										{!! Form::text('keluhan_pasien', $reg->keluhan, ['class' => 'form-control', 'autocomplete' => 'off','id'=>'keluhan_pasien']) !!}
										<small class="text-danger">{{ $errors->first('keluhan_pasien') }}</small>
									</div>
								</div>
                                <div class="col-md-12 no-padding">
									<div class="col-md-12 no-padding">
                                    {!! Form::label('tingkat_keluhan_pasien', 'Tingkat Keluhan', ['class' => 'col-sm-12 no-padding no-margin']) !!}
                                    <div class="slidecontainer">
                                        <input type="range" min="0" max="8" step='1' class="slider" name="tingkat_keluhan_pasien" id="tingkat_keluhan_pasien" value="{{$reg->tingkat_keluhan_pasien}}" list='tickmarks'>
                                        <div id="tickmarks">
                                            <p>0</p>
                                            <p>1</p>
                                            <p>2</p>
                                            <p>3</p>
                                            <p>4</p>
                                            <p>5</p>
                                            <p>6</p>
                                            <p>7</p>
                                            <p>8</p>
                                        </div>
                                    </div>
                                    </div>
								</div>
                                
                               {{-- <div class="col-md-12 no-padding">
									<div class="col-md-12 no-padding">
										{!! Form::label('anamnesis', 'Anamnesis', ['class' => 'col-sm-12 no-padding no-margin']) !!}
										{!! Form::textarea('anamnesis', $reg->anamnesis, ['class' => 'form-control', 'id'=>'anamnesis', 'style'=>'height:50px;resize:none;']) !!}
										<small class="text-danger">{{ $errors->first('anamnesis') }}</small>
									</div>
								</div>
								<div class="col-md-12 no-padding">
									<div class="col-md-12 no-padding">
										{!! Form::label('diagnosa_akhir', 'Diagnosa Pasien', ['class' => 'col-sm-12 no-padding no-margin']) !!}
										<div class="form-check">
										<input class="form-check-input" type="radio" name="kategori_diagnosa" id="kategori_diagnosa" value="awal" >
										<label class="form-check-label" for="kategori_diagnosa">
										Diagnosa Sementara
										</label>
										<input class="form-check-input" type="radio" name="kategori_diagnosa" id="kategori_diagnosa" value="akhir">
										<label class="form-check-label" for="kategori_diagnosa">
										Diagnosa Akhir
										</label>
										</div>
										@if($reg->pasien_no_dirujuk!=null)
											@php
												$dataxxx = json_decode($reg->pasien_text_dirujuk);
												if($reg->bayar==1){
													$diagRujukanText = $dataxxx->response->rujukan->diagnosa->kode.' | '.$rujukan->response->rujukan->diagnosa->nama;
												}else{
													$diagRujukanText = $dataxxx->request->t_rujukan->diagRujukan.' | '.$dataxxx->request->t_rujukan->diagRujukanText;
												}
											@endphp
											<input type="text" name="diagRujukanText" id="diagRujukanText" value="{{$diagRujukanText}}" class="form-control" readonly=true />
										@else
											<input type="hidden" name="diagRujukan" value="" class="form-control"/>
											<input type="text" name="diagRujukanText" id="diagRujukanText" value="" class="form-control" readonly=true />
										@endif
										<small class="text-danger">{{ $errors->first('diagnosa_akhir') }}</small>
									</form>
									</div>
								</div>--}}
								<div class="col-md-12 no-padding">
									<div class="form-group no-margin">
										<div class="col-md-12 no-padding">
											<button style="margin:10px 0;" type="button" id="updateDataPasien" class="btn btn-primary btn-block btn-flat pull-left">SIMPAN</button>
										</div>
									</div>
								</div>	
							</div>
							
							@if(count($bayi)>0 OR $pasien->id_orangtua!='')
							<div class="col-md-12">
								<hr>
								<h4 style="margin-top:0;font-size:14px;font-weight:600;">
									{{ (count($bayi)>0) ? 'Data Pasien Bayi' : 'Data Ibu Bayi' }}
								</h4>
								<div class="col-md-12 no-padding">
									<table class='no-margin table table-striped table-bordered table-hover table-condensed'>
										<thead>
											<tr>
												<th>REGISTRASI</th>
												<th>NO RM</th>
												<th>NAMA</th>
												<th>KELAMIN</th>
												<th>BERAT BADAN</th>
												<th>TEKANAN DARAH</th>
												<th>DIAGNOSA</th>
												<th>AKSI</th>
											</tr>
										</thead>
										<tbody>
											@if(count($bayi)>0)
												@foreach($bayi as $key => $databayi)
													<tr>
														<td>{{$databayi->reg_id}}</td>
														<td>{{$databayi->no_rm}}</td>
														<td>{{$databayi->nama}}</td>
														<td>{{$databayi->kelamin}}</td>
														<td>{{$databayi->berat_badan}}</td>
														<td>{{$databayi->tekanan_darah}}</td>
														<td>{{$databayi->diagnosa_akhir}}</td>
														<td>
															<a href="{{ url('tindakan/entry/'.$databayi->id.'/'.$databayi->pasien_id) }}" class="btn btn-primary">
																PROSES
															</a>
														</td>
													</tr>
												@endforeach
											@else
												<tr>
													<td>{{$pasien->orangtua->reg_id}}</td>
													<td>{{$pasien->orangtua->pasien->no_rm}}</td>
													<td>{{$pasien->orangtua->pasien->nama}}</td>
													<td>{{$pasien->orangtua->pasien->kelamin}}</td>
													<td>{{$pasien->orangtua->berat_badan}}</td>
													<td>{{$pasien->orangtua->tekanan_darah}}</td>
													<td>{{$pasien->orangtua->diagnosa_akhir}}</td>
													<td>
														<a href="{{ url('tindakan/entry/'.$pasien->orangtua->id.'/'.$pasien->id_orangtua) }}" class="btn btn-primary">
															LIHAT IBU BAYI
														</a>
													</td>
												</tr>
											@endif
										</tbody>
									</table>
								</div>
							</div>
							@endif
						</div>

                        <div class="row">
                        <div class="col-md-12 ">
						<div class="nav-tabs-custom " style="margin-bottom:0;width:100%; height:500px;">
                            <ul class="nav nav-tabs nav-justified">
                                <li id="taballergi"><a href="#tab_allergi" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">ALERGI</a></li>
                                <li id="tabriwayatpenyakit" ><a href="#tab_riwayat_penyakit" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">RIWAYAT PENYAKIT</a></li>
                                <li id="tabpenyakitturunan"><a href="#tab_penyakit_turunan" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">RIWAYAT PENYAKIT TURUNAN</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_allergi">
                                <div class="col-md-12 ">
										<form id="formSimpan_Alergi" method="post" class="form-horizontal">
										{{ csrf_field() }} {{ method_field('POST') }}
										<input type="hidden" name="registrasi_id" value="{{ $reg->id }}">
										<div class="col-md-6">
          									<div class="form-group">
											{!! Form::label('jenis_alergi', 'Jenis Alergi', ['class' => 'col-sm-3 control-label','style'=>'font-size:16px;vertical-align: middle;']) !!}
											<div class="col-sm-8">
											<select class="form-control select2" name="jenis_alergi" id="jenis_alergi">
											@foreach($Master_Jenis_Alergi as $data_1)
												<optgroup label="{{$data_1->jenis_alergi}}">
												@foreach(App\MasterAlergi::where('id_jenis_alergi',$data_1->id)->get() as $data)
												<option value="{{$data->id}}">{{$data_1->jenis_alergi}} / {{$data->macam_alergi}}</option>
												@endforeach
												</optgroup>
												
											@endforeach
											</select>
											</div>
											</div>
										</div>
										<div class="col-md-6">
          									<div class="form-group">
											{!! Form::label('detail_alergi', 'Detail Alergi', ['class' => 'col-sm-3 control-label','style'=>'font-size:16px;vertical-align: middle;']) !!}
											<div class="col-sm-8">
											<div class="input-group">
											{!! Form::text('detail_alergi', null, ['class' => 'form-control']) !!}
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right simpan-alergi" id="simpan-alergi" value="Simpan">
											</span>
											</div>
											</div>
											</div>
										</div>
                                        </form>
												
								</div>
								<div class="col-md-12">
										<br><br>
										<table class="table table-striped table-bordered table-hover table-condensed" name="table_histori_alergi" id="table_histori_alergi" style="text-align: center;">
											<thead>
											<tr>
												<th style="text-align: center;">Tanggal Input</th>
												<th style="text-align: center;">Jenis Alergi</th>
												<th style="text-align: center;">Detail Alergi</th>
												<th style="text-align: center;">Aksi</th>
											</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
								</div>
                                </div>
                                <div class="tab-pane " id="tab_riwayat_penyakit">
								<div class="col-md-12 ">
												<form id="formSimpan_riwayat_penyakit" method="post" class="form-horizontal">
												{{ csrf_field() }} {{ method_field('POST') }}
												<input type="hidden" name="registrasi_id" value="{{ $reg->id }}">
												<div class="col-md-12">
												
													<div class="form-group{{ $errors->has('nama_icd10') ? ' has-error' : '' }}">
														{!! Form::label('icd10', 'Diagnosa ', ['class' => 'col-sm-2 control-label']) !!}
														<div class="col-sm-10">
														<div class="input-group">
															{!! Form::text('nama_icd10', null, ['class' => 'form-control', 'id'=>'nama_icd10']) !!}
															{!! Form::hidden('nomor_icd10', null, ['class' => 'form-control', 'id'=>'nomor_icd10']) !!}
															<span class="input-group-btn">
																<input type="button" class="btn btn-flat pull-right simpan-riwayat" id="simpan-riwayat" value="Simpan">
															</span>
															<small class="text-danger">{{ $errors->first('nama_icd10') }}</small>
														</div>
													</div>
												</div>
												</div>
												</form>
								</div>
								<div class="col-md-12">
										<br><br>
										<table class="table table-striped table-bordered table-hover table-condensed" name="table_histori_icd10" id="table_histori_icd10" style="text-align: center;">
											<thead>
											<tr>
												<th style="text-align: center;">Tanggal</th>
												<th style="text-align: center;">ICD 10 </th>
												<th style="text-align: center;">Aksi</th>
											</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
								</div>
                                </div>
                                <div class="tab-pane " id="tab_penyakit_turunan">
								<div class="col-md-12 ">
												<form id="formSimpan_riwayat_penyakit_turunan" method="post" class="form-horizontal">
												{{ csrf_field() }} {{ method_field('POST') }}
												<input type="hidden" name="registrasi_id" value="{{ $reg->id }}">
												<div class="col-md-12">
												
													<div class="form-group{{ $errors->has('nama_icd10') ? ' has-error' : '' }}">
														{!! Form::label('icd10', 'Diagnosa ', ['class' => 'col-sm-2 control-label']) !!}
														<div class="col-sm-10">
														<div class="input-group">
															{!! Form::text('nama_icd10', null, ['class' => 'form-control', 'id'=>'nama_icd10']) !!}
															{!! Form::hidden('nomor_icd10', null, ['class' => 'form-control', 'id'=>'nomor_icd10']) !!}
															<span class="input-group-btn">
																<input type="button" class="btn btn-flat pull-right simpan-riwayat-turunan" id="simpan-riwayat-turunan" value="Simpan">
															</span>
															<small class="text-danger">{{ $errors->first('nama_icd10') }}</small>
														</div>
													</div>
												</div>
												</div>
												</form>
								</div>
								<div class="col-md-12">
										<br><br>
										<table class="table table-striped table-bordered table-hover table-condensed" name="table_histori_penyakit_turunan" id="table_histori_penyakit_turunan" style="text-align: center;">
											<thead>
											<tr>
												<th style="text-align: center;">Tanggal</th>
												<th style="text-align: center;">ICD 10 </th>
												<th style="text-align: center;">Aksi</th>
											</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
								</div>
                                </div>
                                
                            </div>
                        </div>
                            
                        
                        </div>
						</div>

					</div>
				</div>
				<div class="tab-pane" id="tab_object">
					<div class="row">
						<div style="padding:0;">
							<div class="col-md-12">
								<div class="col-md-4 no-padding">
									<div class="boxz" style="border:none;">
										<div style="background:#f8f8f8;border:solid 1px #eee;padding:10px;margin-right:10px;">
											<form id="formAddPemeriksaan_Object" method="post" class="form-horizontal">
												{{ csrf_field() }} {{ method_field('POST') }}
												{!! Form::hidden('pasien_id', $pasien->id) !!}
												{!! Form::hidden('registrasi_id', $idreg) !!}
												<div class="rowx">
													<div class="form-group{{ $errors->has('masterobat_id') ? ' has-error' : '' }}">
														{!! Form::label('kategori_pemeriksaan', 'Pilih Kategori', ['class' => 'col-sm-12']) !!}
														<div class="col-sm-4">
															{{--<select style="width:100%;" name="kategori_pemeriksaan" id="kategori_pemeriksaan" class="form-control ">
																<option value="mata">Mata</option>
																<option value="telinga">Telinga</option>
																<option value="hidung">Hidung</option>
																<option value="mulut">Mulut</option>
																<option value="kepala">Kepala</option>
																<option value="leher">Leher</option>
																<option value="paru">Paru - Paru</option>
																<option value="jantung">Jantung</Jption>
																<option value="ekg">EKG</option>
																<option value="badan">Badan</option>
																<option value="gerak">Gerak</option>
																<option value="lain_lain">Lain-lain</option>

															</select>--}}
															<div class="form-check">
															<input class="form-check-input" type="radio" name="kategori_pemeriksaan" value="mata" >
															<label class="form-check-label" >
																Mata
															</label>
															</div>
															<div class="form-check">
															<input class="form-check-input" type="radio" name="kategori_pemeriksaan"  value="telinga">
															<label class="form-check-label" >
																Telinga
															</label>
															</div>
															<div class="form-check">
															<input class="form-check-input" type="radio" name="kategori_pemeriksaan"  value="hidung">
															<label class="form-check-label" >
																Hidung
															</label>
															</div><div class="form-check">
															<input class="form-check-input" type="radio" name="kategori_pemeriksaan"  value="mulut">
															<label class="form-check-label" >
																Mulut
															</label>
															</div>
															<small class="text-danger">{{ $errors->first('kategori_pemeriksaan') }}</small>
														</div>
														<div class="col-sm-4">
															<div class="form-check">
															<input class="form-check-input" type="radio" name="kategori_pemeriksaan" value="kepala" >
															<label class="form-check-label" >
																Kepala
															</label>
															</div>
															<div class="form-check">
															<input class="form-check-input" type="radio" name="kategori_pemeriksaan" value="jantung">
															<label class="form-check-label" >
																Jantung
															</label>
															</div>
															<div class="form-check">
															<input class="form-check-input" type="radio" name="kategori_pemeriksaan" value="leher" >
															<label class="form-check-label" >
																Leher
															</label>
															</div>
															<div class="form-check">
															<input class="form-check-input" type="radio" name="kategori_pemeriksaan"  value="paru">
															<label class="form-check-label" >
																Paru - Paru
															</label>
															</div>
															<small class="text-danger">{{ $errors->first('kategori_pemeriksaan') }}</small>
														</div>
														<div class="col-sm-4">
															
															<div class="form-check">
															<input class="form-check-input" type="radio" name="kategori_pemeriksaan" value="ekg">
															<label class="form-check-label" >
																EKG
															</label>
															</div>
															<div class="form-check">
															<input class="form-check-input" type="radio" name="kategori_pemeriksaan"  value="badan">
															<label class="form-check-label" >
																Badan
															</label>
															</div>
															<div class="form-check">
															<input class="form-check-input" type="radio" name="kategori_pemeriksaan"  value="gerak">
															<label class="form-check-label" >
																Gerak
															</label>
															</div>
															<div class="form-check">
															<input class="form-check-input" type="radio" name="kategori_pemeriksaan"  value="lain_lain">
															<label class="form-check-label" >
																Lain-lain
															</label>
															</div>
															<small class="text-danger">{{ $errors->first('kategori_pemeriksaan') }}</small>
														</div>
													</div>
													<div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
														{!! Form::label('catatan', 'Catatan Pemeriksaan', ['class' => 'col-sm-12']) !!}
														<div class="col-sm-8">
															<textarea class="form-control" width="100%" height="100%" name="keterangan" id="keterangan"></textarea>
															{{--<input type="number" name="jumlah" value="1" class="form-control">--}}
														</div>
														<div class="col-sm-4">
															<button type="button" id="simpan-pemeriksaan-object" class="btn btn-primary btn-block btn-flat simpan-pemeriksaan-object">Simpan</button>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
									
								<div class="col-md-8 no-padding">
									<div>
										<table id="detailPemeriksaan_object" class='table table-striped table-bordered table-hover table-condensed' style="margin:0!important;">
											<thead>
												<tr>
												<th>Kategori</th>
												<th>Catatan Pemeriksaan</th>
												<th>Hapus</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane active" id="tab_tindakan">
					<div class="row">
						<div style="padding:0 10px;">
							<div class="col-md-4">
								{!! Form::open(['method' => 'POST', 'route' => 'tindakan.save', 'class' => 'form-horizontal', 'style' => 'margin-bottom:0;']) !!}
								{!! Form::hidden('registrasi_id', $reg_id) !!}
								{!! Form::hidden('jenis', $reg->jenis_pasien) !!}
								{!! Form::hidden('pasien_id', $pasien->id) !!}
								{!! Form::hidden('dokter_id', $reg->dokter_id) !!}
								{!! Form::hidden('jumlah', 1) !!}
								<div class="row">
									<div class="col-md-12">
									
										<div class="form-group{{ $errors->has('pelaksana') ? ' has-error' : '' }}">
											{!! Form::label('pelaksana', ($persalinan) ? 'Dokter Obsgyn' : 'Dokter Pelaksana', ['class' => 'col-sm-3']) !!}
											<div class="col-sm-9">
												<select id="pelaksana" name="pelaksana" class="select2 form-control">
													<option value="">-- Pilih {{($persalinan) ? 'Dokter Obsgyn' : 'Dokter Pelaksana'}} --</option>
													@foreach($dokter as $key => $data)
														@php
															$selected = '';
															if(session('pelaksana')==$data->id){
																$selected = 'selected';
															}elseif($reg->dokter_id==$data->id){
																$selected = 'selected';
															}
														@endphp
														<option {{ $selected }} value="{{ $data->id }}">{{ $data->nama }}</option>
													@endforeach
												</select>
												<small class="text-danger">{{ $errors->first('pelaksana') }}</small>
											</div>
										</div>										
										@if(strtolower(Auth::user()->role()->first()->name)=='rawatinap' AND !$persalinan)
											<div class="form-group{{ $errors->has('dokter_visit') ? ' has-error' : '' }}">
												{!! Form::label('dokter_visit', 'Dokter Konsulen', ['class' => 'col-sm-3']) !!}
												<div class="col-sm-9">
													<select id="dokter_visit" name="dokter_visit" class="select2 form-control">
														<option value="">-- Pilih Dokter Konsulen --</option>
														@foreach($dokter as $key => $data)
															@php
																$selected = '';
																if(session('dokter_visit')==$data->id){
																	$selected = 'selected';
																}
																if(session('dokter_visit')==''){
																	$selected = '';
																}
															@endphp
															<option {{ $selected }} value="{{ $data->id }}">{{ $data->nama }}</option>
														@endforeach
													</select>
													<small class="text-danger">{{ $errors->first('dokter_visit') }}</small>
												</div>
											</div>
										@endif
										@if($persalinan)
											<div class="form-group{{ $errors->has('dokter_anak') ? ' has-error' : '' }}">
												{!! Form::label('dokter_anak', 'Dokter Anak', ['class' => 'col-sm-3']) !!}
												<div class="col-sm-9">
													<select id="dokter_anak" name="dokter_anak" class="select2 form-control">
														<option value="">-- Pilih Dokter Anak --</option>
														@foreach($dokter as $key => $data)
															@php
																$selected = '';
																if(session('dokter_anak')){
																	if(session('dokter_anak')==$data->id){
																		$selected = 'selected';
																	}
																}
															@endphp
															<option {{ $selected }} value="{{ $data->id }}">{{ $data->nama }}</option>
														@endforeach
													</select>
													<small class="text-danger">{{ $errors->first('dokter_anak') }}</small>
												</div>
											</div>
										@else
											<div class="form-group{{ $errors->has('perawat') ? ' has-error' : '' }}">
												{!! Form::label('perawat', 'Perawat Pelaksana', ['class' => 'col-sm-3']) !!}
												<div class="col-sm-9">
													<select id="perawat" name="perawat" class="select2 form-control">
														<option value="">-- Pilih Perawat Pelaksana --</option>
														@foreach($perawat as $key => $data)
															<option {{ (session('perawat')==$data->id) ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->nama }}</option>
														@endforeach
													</select>
													<small class="text-danger">{{ $errors->first('perawat') }}</small>
												</div>
											</div>
										@endif
										@if($persalinan)
											<div class="form-group{{ $errors->has('bidan1') ? ' has-error' : '' }}">
												{!! Form::label('bidan1', 'Asisten 1', ['class' => 'col-sm-3']) !!}
												<div class="col-sm-9">
													<select id="bidan1" name="bidan1" class="select2 form-control">
														<option value="">-- Pilih Asisten 1 --</option>
														@foreach($bidan as $key => $data)
															<option {{ (session('bidan1')==$data->id) ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->nama }}</option>
														@endforeach
													</select>
													<small class="text-danger">{{ $errors->first('bidan1') }}</small>
												</div>
											</div>
											<div class="form-group{{ $errors->has('bidan2') ? ' has-error' : '' }}">
												{!! Form::label('bidan2', 'Asisten 2', ['class' => 'col-sm-3']) !!}
												<div class="col-sm-9">
													<select id="bidan2" name="bidan2" class="select2 form-control">
														<option value="">-- Pilih Asisten 2 --</option>
														@foreach($bidan as $key => $data)
															<option {{ (session('bidan2')==$data->id) ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->nama }}</option>
														@endforeach
													</select>
													<small class="text-danger">{{ $errors->first('bidan2') }}</small>
												</div>
											</div>
										@endif
																
										<input type="hidden" value="{{$reg->poli_id}}" name="poli_id">
										<div class="form-group{{ $errors->has('group_id') ? ' has-error' : '' }} hidden">
											{!! Form::label('group_id', 'Tindakan Group', ['class' => 'col-sm-3']) !!}
											<div class="col-sm-9">
												<select class="form-control select2" name="group_id">
													<option value="">-- Pilih Tindakan Group --</option>
													@foreach($group_tindakan as $d)
														<option value="{{ $d->id }}">{{ $d->kelompok }}</option>
													@endforeach
												</select>
												<small class="text-danger">{{ $errors->first('group_id') }}</small>
											</div>
										</div>
										<div class="form-group{{ $errors->has('tarif_id') ? ' has-error' : '' }}">
											{!! Form::label('tarif_id', 'Tindakan Single', ['class' => 'col-sm-3']) !!}
											<div class="col-sm-9">
												<select class="form-control select2" name="tarif_id">
													<option value="">-- Pilih Tindakan Single --</option>
													@foreach($tindakan as $d)
													<option value="{{ $d->id }}">
														{{ $d->nama }} | {{ number_format(getTotalTarif($reg,$d)) }}														
													</option>
													@endforeach
												</select>
												<small class="text-danger">{{ $errors->first('tarif_id') }}</small>
											</div>
										</div>
										<div class="form-group">
											{!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3']) !!}
											<div class="col-sm-4">
												{!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
												<small class="text-danger">{{ $errors->first('jumlah') }}</small>
											</div>
											<div class="col-sm-5 no-padding">
												{!! Form::submit("SIMPAN TINDAKAN", ['class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
											</div>
										</div>
									</div>
								</div>
								{!! Form::close() !!}
							</div>
								
							<div class="col-md-8 no-padding">
								<div class="nav-tabs-custom" style="margin-bottom:0;border-radius:0!important;box-shadow:none!important;">
									<ul class="nav nav-tabs">
										<li id="tabmedis" class="active"><a href="#tab_umum" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">UMUM</a></li>
										@if(count($operasi)>0)
										<li id="taboperasi"><a href="#tab_operasi" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">OPERASI</a></li>
										@endif
										@if(in_array($reg->poli_id,[1,23]))
										<li id="tabpersalinan"><a href="#tab_persalinan" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">PERSALINAN</a></li>
										@endif
										<li id="tabpenunjang"><a href="#tab_penunjang" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">PENUNJANG</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tab_umum">
											<div class="row">
												<table class='no-margin table table-striped table-bordered table-hover table-condensed'>
													<thead>
														<tr>
														<th>No</th>
														<th>Tindakan</th>
														<th>Biaya</th>
														<th>Pelaksana</th>
														@if(strtolower(Auth::user()->role()->first()->name)=='rawatinap')
														<th>Konsulen</th>
														@endif
														<th>Waktu</th>
														<th>Status</th>
														@role(['rawatinap','rawatjalan','supervisor', 'rawatdarurat','administrator','kamarbersalin'])
														<th>Aksi</th>
														@endrole
														</tr>
													</thead>
													<tbody>
														@foreach($folio as $key => $d)
															@if(in_array($d->tarif->kategoritarif_id,[1,7,8,9]))
															<tr>
																<td>{{ $no++ }}</td>
																<td>{{ $d->namatarif }}</td>
																<td class="text-right">{{ number_format($d->total,0,',','.') }}</td>
																<td>{{ ($d->dokter_visit=='') ? pelaksana($d) : '' }}</td>
																@if(strtolower(Auth::user()->role()->first()->name)=='rawatinap')
																<td>{{ ($d->dokter_visit!='') ? pelaksana($d) : '' }}</td>
																@endif
																<td>{{ $d->created_at->format('d-m-Y') }}</td>
																<td>
																@php
																	if($d->status_proses==1){
																		echo 'Selesai';
																	}else{
																		echo 'Sukses';
																	}
																@endphp
																</td>
																@role(['rawatinap','rawatjalan','kasir', 'supervisor', 'rawatdarurat','administrator','kamarbersalin'])
																<td>
																	@if($d->lunas == 'Y' && $reg->supervisor_edit!=1)
																		<i class="fa fa-check"></i>
																	@else
																		@if(substr($d->namatarif,0,23)=='Glukosa Darah - Sewaktu')
																			<a href="{{ url('pemeriksaanlab/create/'.$d->registrasi_id) }}" onclick="return confirm('Apakah Anda akan menginputkan hasil Glukosa Darah - Sewaktu?')" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-credit-card"></i></a>
																		@endif
																		<a href="{{ url('tindakan/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
																	@endif
																</td>
																@endrole
															</tr>
															@endif
														@endforeach
													</tbody>
												</table>
											</div>
										</div>										
										@if(count($operasi)>0)
										<div class="tab-pane" id="tab_operasi">
											<div class="row">
												<table class='no-margin table table-striped table-bordered table-hover table-condensed'>
													<thead>
														<tr>
														<th>No</th>
														<th>Tindakan</th>
														<th>Biaya</th>
														<th>Pelaksana</th>
														<th>Waktu</th>
														<th>Status</th>
														@role(['rawatinap','rawatjalan','supervisor', 'rawatdarurat','administrator','kamarbersalin'])
														<th>Aksi</th>
														@endrole
														</tr>
													</thead>
													<tbody>
														@php $no=1; @endphp
														@foreach($folio as $key => $d)
															@if($d->tarif->kategoritarif_id==4)
															<tr>
																<td>{{ $no++ }}</td>
																<td>{{ $d->namatarif }}</td>
																<td class="text-right">{{ number_format($d->total,0,',','.') }}</td>
																<td>{{ pelaksana($d) }}</td>
																<td>{{ $d->created_at->format('d-m-Y') }}</td>
																<td>
																@php
																	if($d->status_proses==1){
																		echo 'Selesai';
																	}else{
																		echo '';
																	}
																@endphp
																</td>
																@role(['rawatinap','rawatjalan','kasir', 'supervisor', 'rawatdarurat','administrator','kamarbersalin'])
																<td>
																	@if ($d->lunas == 'Y' )
																		<i class="fa fa-check"></i>
																	@else
																		<a href="{{ url('tindakan/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
																	@endif
																</td>
																@endrole
															</tr>
															@endif
														@endforeach
													</tbody>
												</table>
											</div>
										</div>										
										@endif
										@if(in_array($reg->poli_id,[1,23]))
										<div class="tab-pane" id="tab_persalinan">
											<div class="row">
												<table class='no-margin table table-striped table-bordered table-hover table-condensed'>
													<thead>
														<tr>
														<th>No</th>
														<th>Tindakan</th>
														<th>Biaya</th>
														<th>Pelaksana</th>
														<th>Waktu</th>
														<th>Status</th>
														@role(['supervisor','administrator','kamarbersalin'])
														<th>Aksi</th>
														@endrole
														</tr>
													</thead>
													<tbody>
														@php $no=1; @endphp
														@foreach($folio as $key => $d)
															@if($d->tarif->kategoritarif_id==5)
															<tr>
																<td>{{ $no++ }}</td>
																<td>{{ $d->namatarif }}</td>
																<td class="text-right">{{ number_format($d->total,0,',','.') }}</td>
																<td>{{ pelaksana($d) }}</td>
																<td>{{ $d->created_at->format('d-m-Y') }}</td>
																<td>
																@php
																	if($d->status_proses==1){
																		echo 'Selesai';
																	}else{
																		echo '';
																	}
																@endphp
																</td>
																@role(['supervisor','administrator','kamarbersalin'])
																<td>
																	@if ($d->lunas == 'Y' && $reg->supervisor_edit!=1)
																		<i class="fa fa-check"></i>
																	@else
																		<a href="{{ url('tindakan/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
																	@endif
																</td>
																@endrole
															</tr>
															@endif
														@endforeach
													</tbody>
												</table>
											</div>
										</div>										
										@endif
										<div class="tab-pane" id="tab_penunjang">
											<div class="row">
												<table class='no-margin table table-striped table-bordered table-hover table-condensed'>
													<thead>
														<tr>
														<th>No</th>
														<th>Tindakan</th>
														<th>Pelayanan</th>
														<th>Biaya</th>
														<th>Pelaksana</th>
														<th>Waktu</th>
														<th>Status</th>
														@role(['supervisor','administrator'])
														<th>Aksi</th>
														@endrole
														</tr>
													</thead>
													<tbody>
														@php $no=1; @endphp
														@foreach($folio as $key => $d)
															@if(in_array($d->tarif->kategoritarif_id,[2,3,6]))
															<tr>
																<td>{{ $no++ }}</td>
																<td>{{ $d->namatarif }}</td>
																<td>{{ baca_poli($d->poli_id) }}</td>
																<td class="text-right">{{ number_format($d->total,0,',','.') }}</td>
																<td>{{ pelaksana($d) }}</td>
																<td>{{ $d->created_at->format('d-m-Y') }}</td>
																<td>
																@php
																	if($d->status_proses==1){
																		echo 'Selesai';
																	}elseif(baca_poli($d->poli_id)!='Fisioterapi' AND baca_poli($d->poli_id)!='Laboratorium' AND baca_poli($d->poli_id)!='Radiologi' AND baca_poli($d->poli_id)!='Persalinan'){
																		echo 'Sukses';
																	}
																@endphp
																</td>
																@role(['supervisor','administrator'])
																<td>
																	@if ($d->lunas == 'Y' && $reg->supervisor_edit!=1)
																		<i class="fa fa-check"></i>
																	@else
																	
																		<a href="{{ url('tindakan/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
																	@endif
																</td>
																@endrole
															</tr>
															@endif
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>								
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane active" id="tab_pakaiobat">
					<div class="row">
						<div style="padding:0;">
							<div class="col-md-12">
								<div class="col-md-4 no-padding">
									<div class="boxz" style="border:none;">
										<div style="background:#f8f8f8;border:solid 1px #eee;padding:10px;margin-right:10px;">
											<form id="formAddPakai" method="post" class="form-horizontal">
												{{ csrf_field() }} {{ method_field('POST') }}
												{!! Form::hidden('pasien_id', $pasien->id) !!}
												{!! Form::hidden('idreg', $idreg) !!}
												{!! Form::hidden('tipe_rawat', $reg->status_reg) !!}
												<div class="rowx">
													<div class="form-group{{ $errors->has('masterobat_id') ? ' has-error' : '' }}">
														{!! Form::label('masterobat_id', 'Pilih Obat', ['class' => 'col-sm-12']) !!}
														<div class="col-sm-12">
															<select style="width:100%;" name="masterobat_id" id="" class="form-control select2ajaxdepo">
															</select>
															<small class="text-danger">{{ $errors->first('masterobat_id') }}</small>
														</div>
													</div>
													<div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
														{!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-12']) !!}
														<div class="col-sm-6">
															<input type="number" name="jumlah" value="1" class="form-control">
														</div>
														<div class="col-sm-6">
															<button type="button" id="saveItemPem" class="btn btn-primary btn-block btn-flat">Tambahkan</button>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
									
								<div class="col-md-8 no-padding">
									<div>
										<table id="detailPemakaian" class='table table-striped table-bordered table-hover table-condensed' style="margin:0!important;">
											<thead>
												<tr>
												<th class="text-center">No</th>
												<th>Waktu</th>
												<th>Nama Obat</th>
												<th>Satuan</th>
												<th style="text-align:center">Jml</th>
												<th style="width:10%" class="text-center">Harga</th>
												<th>Hapus</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab_assesment">
				<div class="row">
					<div class="col-md-12 ">
						<form id="formSimpan_assesment" method="post" class="form-horizontal">
						{{ csrf_field() }} {{ method_field('POST') }}
						<input type="hidden" name="registrasi_id" value="{{ $reg->id }}">
							<div class="col-md-12">
							<div class="form-group{{ $errors->has('nama_icd10') ? ' has-error' : '' }}">
								{!! Form::label('icd10', 'Diagnosa ', ['class' => 'col-md-2 control-label']) !!}
							<div class="col-md-10">
								{!! Form::text('nama_icd10', null, ['class' => 'form-control', 'id'=>'nama_icd10']) !!}
								{!! Form::hidden('nomor_icd10', null, ['class' => 'form-control', 'id'=>'nomor_icd10']) !!}
							</div>
							</div>
							</div>
							<div class="col-md-12">
							<div class="form-group{{ $errors->has('nama_icd10') ? ' has-error' : '' }}">
								{!! Form::label('detail_diagnosa', 'Diagnosa Pasien', ['class' => 'col-md-2 control-label']) !!}
							<div class="col-md-10">
										<div class="form-check">
										<input class="form-check-input" type="radio" name="kategori_diagnosa" id="kategori_diagnosa" value="awal" >
										<label class="form-check-label" for="kategori_diagnosa">
										Diagnosa Sementara
										</label>
										<input class="form-check-input" type="radio" name="kategori_diagnosa" id="kategori_diagnosa" value="akhir">
										<label class="form-check-label" for="kategori_diagnosa">
										Diagnosa Akhir
										</label>
										</div>
							</div>
							</div>
							</div>
							<div class="col-md-12">
							<div class="form-group{{ $errors->has('nama_icd10') ? ' has-error' : '' }}">
								{!! Form::label('detail_diagnosa', 'Diagnosa Detail', ['class' => 'col-md-2 control-label']) !!}
							<div class="col-md-10">
								<div class="input-group">
								{!! Form::text('detail_diagnosa', null, ['class' => 'form-control col-12', 'id'=>'detail_diagnosa']) !!}
								<span class="input-group-btn">
									<input type="button" class="btn btn-flat pull-right simpan-assesment" id="simpan-assesment" value="Simpan">
								</span>
								<small class="text-danger">{{ $errors->first('nama_icd10') }}</small>
								</div>
							</div>
							</div>
							</div>
							
							</form>
					</div>
					<div class="col-md-12">
					<br><br>
						<table class="table table-striped table-bordered table-hover table-condensed" name="table_assesment" id="table_assesment" style="text-align: center;">
							<thead>
							<tr>
								<th style="text-align: center;">Dioagnosa Code</th>
								<th style="text-align: center;">Detail Diagnosa</th>
								<th style="text-align: center;">Aksi</th>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>                
				</div>
				<div class="tab-pane active" id="tab_kpo">
					<div class="row">
						<div style="padding:0 10px;">
							<div class="col-md-12">
								@if($status_upd_epo)
									<form id="formAddEpo" method="post" class="form-horizontal">
										{{ csrf_field() }} {{ method_field('POST') }}
										{!! Form::hidden('pasien_id', $pasien->id) !!}
										{!! Form::hidden('idreg', $idreg) !!}
										{!! Form::hidden('tipe_rawat', $reg->status_reg) !!}
										@include('tindakan::form_permintaan_obat')
									</form>
								@endif
								<hr>
								<div>
									<table id="detailEpo" class='table table-striped table-bordered table-hover table-condensed'>
										<thead>
											<tr>
												<th class="text-center">NO</th>
												<th>RACIKAN</th>
												<th>HARI, TANGGAL</th>
												<th>NAMA OBAT</th>
												<th>SATUAN</th>
												<th class="text-center">JML</th>
												<th class="text-center">HARGA @</th>
												<th>ATURAN PAKAI</th>
												<th>ETIKET</th>
												<th>STATUS</th>
												<th>HAPUS</th>
												<th>EDIT</th>
											</tr>
										</thead>
										<tbody>										  
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane active" id="tab_resepobat">
					<div class="row">
						<div style="padding:0 10px;">
							<div class="col-md-12">
								@if($status_upd_resep)
									<form id="formAddResep" method="post" class="form-horizontal">
										{{ csrf_field() }} {{ method_field('POST') }}
										{!! Form::hidden('pasien_id', $pasien->id) !!}
										{!! Form::hidden('idreg', $idreg) !!}
										{!! Form::hidden('tipe_rawat', $reg->status_reg) !!}
										@include('tindakan::form_resep_obat')
									</form>
								@endif
								<hr>
								<div>
									<table id="detailResep" class='table table-striped table-bordered table-hover table-condensed'>
										<thead>
											<tr>
												<th class="text-center">NO</th>
												<th>RACIKAN</th>
												<th>NAMA OBAT</th>
												<th>SATUAN</th>
												<th style="text-align:center">JML</th>
												<th style="width:10%" class="text-center">HARGA @</th>
												<th>ATURAN PAKAI</th>
												<th>ETIKET</th>
												<th>STATUS</th>
												<th>AKSI</th>
												<th>EDIT</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab_lain">
					<div class="row">
						<div style="padding:0 10px;">
							<div class="col-md-12">
							<h4 style="margin-top:0;font-size:14px;font-weight:600;">
									Order
								</h4>
								<div class="row">
									@php
										$link_pelayanan = "irj";
										$hidden = "";
										if(strtolower(Auth::user()->role()->first()->name)=='rawatjalan'){
											$link_pelayanan = "irj";
											$hidden = "hidden";
										}elseif(strtolower(Auth::user()->role()->first()->name)=='rawatdarurat'){
											$link_pelayanan = "darurat";
											$hidden = "hidden";
										}elseif(strtolower(Auth::user()->role()->first()->name)=='rawatinap'){
											$link_pelayanan = "irna";
										}
									@endphp
									<div class="col-md-4" style="margin-bottom:10px;">
										<td class="text-center">
											<a href="{{ url('/surat-keterangan-sakit/'.$reg->id) }}" onclick="return confirm('Yakin akan membuat surat keterangan sakit untuk Pasien?')" target="_blank" class="btn btn-primary btn-block">
												<i class="fa fa-file"></i>
												<br>
												Surat Ket Sakit
											</a>
										</td>
									</div>
									<div class="col-md-4" style="margin-bottom:10px;">
										<td class="text-center">
											<a href="#" class="btn btn-primary btn-block surat_ket_sehat">
												<i class="fa fa-file"></i>
												<br>
												Surat Ket Sehat
											</a>
										</td>
									</div>
									<div class="col-md-4" style="margin-bottom:10px;">
										<td class="text-center">
											<a href="#" class="btn btn-primary btn-block surat_rujukan_pasien">
												<i class="fa fa-file"></i>
												<br>
												Surat Rujukan
											</a>
										</td>
									</div>
									<div class="col-md-4" style="margin-bottom:10px;">
										<td class="text-center">
											<a href="#" class="btn btn-primary btn-block surat_persetujuan_tindakan_medis">
												<i class="fa fa-file"></i>
												<br>
												Surat Persetujuan / Penolakan <br>Tindakan Medis
											</a>
										</td>
									</div>
									<div class="col-md-12">
										<h4 style="margin-top:0;font-size:14px;font-weight:600;">
											Data Lainnya
										</h4>
										<h4 style="margin-top:0;font-size:12px;font-weight:500;">
											No. Surat Kontrol: <b>{{$reg->no_surat_kontrol}}</b>
										</h4>
										@if(substr($reg->status_reg,0,1)=='I')
											<h4 style="margin-top:0;font-size:12px;font-weight:500;">
												Kamar / Bed: <b>{{$irna->kamar->nama.' / '.$irna->bed->nama}}</b>
											</h4>
											@if($reg->bayar==1)
											<h4 style="margin-top:0;font-size:12px;font-weight:500;">
												Naik Kelas: <b>{{($reg->is_naik_kelas) ? 'Ya' : 'Tidak' }}</b>
											</h4>
											@endif
										@endif
										<form id="formAddSaranDokter" method="post" class="form-horizontal">
										{{ csrf_field() }} {{ method_field('POST') }}
										<input type="hidden" name="registrasi_id" value="{{ $reg->id }}">
										{!! Form::label('saran', 'Saran dari Dokter', ['class' => 'col-sm-12 no-padding no-margin']) !!}
										{!! Form::text('saran', $reg->saran, ['class' => 'form-control','id'=>'saran', 'style'=>'height:50px;resize:none;']) !!}
										
										<small class="text-danger">{{ $errors->first('saran') }}</small>
										
										<br>
										<fieldset>
											<div class="form-check">
											<input class="form-check-input" id="myCheck" type="checkbox" onclick="myFunction()" value="" checked >
											<label style="font-size:14px;"class="form-check-label" >
												Jadwal Kontrol Pasien
											</label>
											</div>
											@if($reg->tanggal_kontrol==null)
											<span id="text" class="myClass" style="display:none">
											{!! Form::text('tanggal_kontrol', date('d-m-Y'), ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
											</span>
											@else
											<span id="text" class="myClass" style="display:show">
											{!! Form::text('tanggal_kontrol', valid_date($reg->tanggal_kontrol), ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
											</span>
											@endif
											</span>
											<button style="margin:10px 0;" type="button" id="updateDataSaranDokter" class="btn btn-primary btn-block btn-flat pull-left">SIMPAN</button>
										</fieldset>
										</form>
									</div>
									
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
			
		<div class="modal fade" id="ICD10" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:1400;">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id=""></h4>
					</div>
					<div class="modal-body">
						<div>
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

		<div class="modal fade" id="histori_pemeriksaan_fisik" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:1400;">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id=""></h4>
					</div>
					<div class="modal-body">
						<div>
							<table id='data_histori_pemeriksaan' class='table table-striped table-bordered table-hover table-condensed'>
								<thead>
									<tr>
										<th>No</th>
										<th>Tanggal</th>
										<th>Tensi</th>
										<th>Suhu</th>
										<th>Berat Badan</th>
										<th>Tinggi</th>
										<th>anamnesis</th>
										<th>keluhan</th>
										<th>Diagnosa Awal</th>
										<th>Diagnosa Akhir</th>
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
		
		<div class="modal fade" id="surat_visum" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:1400;">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id=""></h4>
					</div>
					<div class="modal-body">
						<div>
						<form id="formVisum" method="post" class="form-horizontal">
							{{ csrf_field() }} {{ method_field('POST') }}
							<table class='table table-striped table-bordered table-hover table-condensed'>
								
									<tr>
										<td>Nama Pasien</td>
										<td><input type="hidden" class="form-control" id="registrasi_id" name="registrasi_id" value="{{$reg->id}}">
										<input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="{{$pasien->nama}}" readonly></td>
									</tr>
									<tr>
										<td>Jenis Kelamin</td>
										<td>
										@if($pasien->kelamin=="L")
										<input class="form-control" id="kelamin" name="kelamin" value="Laki-Laki" readonly>
										@else
										<input class="form-control" id="kelamin" name="kelamin" value="Perempuan" readonly>
										@endif
										</td>
									</tr>
									<tr>
										<td>Umur</td>
										<td><input type="text" class="form-control" id="umur" name="umur" value="{{hitung_umur($pasien->tgllahir)}}" readonly></td>
									</tr>
									<tr>
										<td>Pekerjaan</td>
										<td><input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{Modules\Pekerjaan\Entities\Pekerjaan::find($pasien->pekerjaan_id)->nama}} " readonly></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td><input type="text" class="form-control" id="alamat" name="alamat" value="{{$pasien->alamat}} " readonly></td>
									</tr>
									<tr>
										<td>instansi Pemohon</td>
										<td><input type="text" class="form-control" id="instansi_pemohon" name="instansi_pemohon" value="" placeholder="Kepolisian Resor Semarang Sektor Banyumanik"></td>
									</tr>
									<tr>
										<td>Pemohon</td>
										<td><input type="text" class="form-control" id="pemohon" name="pemohon" value="" placeholder="Kepala Kepolisian Sektor Banyumanik"></td>
									</tr>
									<tr>
										<td>Jabatan Permohonan</td>
										<td><input type="text" class="form-control" id="jabatan_pemohon" name="jabatan_pemohon" value="" placeholder="Penyidik"></td>
									</tr>
									<tr>
										<td>Nomor Pemohonan</td>
										<td><input type="text" class="form-control" id="nomor_permohonan" name="nomor_permohonan" value="" placeholder="Pol : B / 03 / III / 2020 / tbr"></td>
									</tr>
									<tr>
									<tr>
										<td>Kesimpulan</td>
										<td><input type="text" class="form-control" id="kesimpulan" name="kesimpulan" value="" ></td>
									</tr>
									
								
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary btn-flat pull-right" id="simpan_visum" name="simpan_visum" >Buat</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="surat_ket_sehat" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:1400;">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id=""></h4>
					</div>
					<div class="modal-body">
						<div>
						<form id="formKetSehat" method="post" class="form-horizontal">
							{{ csrf_field() }} {{ method_field('POST') }}
							<table class='table table-striped table-bordered table-hover table-condensed'>
								
									<tr>
										<td>Nama Pasien</td>
										<td><input type="hidden" class="form-control" id="registrasi_id" name="registrasi_id" value="{{$reg->id}}">
										<input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="{{$pasien->nama}}" readonly></td>
									</tr>
									<tr>
										<td>Jenis Kelamin</td>
										<td>
										@if($pasien->kelamin=="L")
										<input class="form-control" id="kelamin" name="kelamin" value="Laki-Laki" readonly>
										@else
										<input class="form-control" id="kelamin" name="kelamin" value="Perempuan" readonly>
										@endif
										</td>
									</tr>
									<tr>
										<td>Umur</td>
										<td><input type="text" class="form-control" id="umur" name="umur" value="{{hitung_umur($pasien->tgllahir)}}" readonly></td>
									</tr>
									<tr>
										<td>Pekerjaan</td>
										<td><input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{Modules\Pekerjaan\Entities\Pekerjaan::find($pasien->pekerjaan_id)->nama}} " readonly></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td><input type="text" class="form-control" id="alamat" name="alamat" value="{{$pasien->alamat}} " readonly></td>
									</tr>
									<tr>
										<td>Berat Badan</td>
										<td>
										@if($data_pemeriksaan==null)
										<input type="text" class="form-control" id="berat_badan" name="berat_badan" value="" placeholder="80 ( satuan Kg )">Kg
										@else
										<input type="text" class="form-control" id="berat_badan" name="berat_badan" value="" placeholder="80 ( satuan Kg )" value="{{$data_pemeriksaan->berat_badan}}">Kg
										@endif
										</td>
									</tr>
									<tr>
										<td>Tinggi Badan</td>
										<td>
										@if($data_pemeriksaan==null)
										<input type="text" class="form-control" id="tinggi_badan" name="tinggi_badan" value="" placeholder="150 ( satuan Cm )">Cm
										@else
										<input type="text" class="form-control" id="tinggi_badan" name="tinggi_badan" value="" placeholder="150 ( satuan Cm )" value="{{$data_pemeriksaan->tinggi_badan}}">Cm
										@endif
										</td>
									</tr>
									<tr>
										<td>Tekanan Darah</td>
										<td>
										@if($data_pemeriksaan==null)
										<input type="text" class="form-control" id="tekanan_darah" name="tekanan_darah" value="" placeholder="120/80">mmHg
										@else
										<input type="text" class="form-control" id="tekanan_darah" name="tekanan_darah" value="" placeholder="120/80" value="{{$data_pemeriksaan->tekanan_darah}}">mmHg
										@endif
										</td>
									</tr>
									<tr>
										<td>Golongan Darah</td>
										<td>
										@if($data_pemeriksaan==null)
										<input type="text" class="form-control" id="golongan_darah" name="golongan_darah" value="" placeholder="O">
										@else
										<input type="text" class="form-control" id="golongan_darah" name="golongan_darah" value="" placeholder="O" value="{{$data_pemeriksaan->golongan_darah}}">
										@endif
										</td>
									</tr>
									<tr>
										<td>Riwayat Penyakit</td>
										<td>
										@if($data_pemeriksaan==null)
										<input type="text" class="form-control" id="riwayat_penyakit" name="riwayat_penyakit" value="" >
										@else
										<input type="text" class="form-control" id="riwayat_penyakit" name="riwayat_penyakit" value="{{$data_pemeriksaan->riwayat_penyakit}}" >
										@endif
										</td>
									</tr>
									<tr>
										<td>Keperluan</td>
										<td>
										@if($data_pemeriksaan==null)
										<input type="text" class="form-control" id="keperluan" name="keperluan" placeholder="Untuk Melamar Kerja" >
										@else
										<input type="text" class="form-control" id="keperluan" name="keperluan" value="{{$data_pemeriksaan->keperluan}}" >
										@endif
										</td>
									</tr>
									
								
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary btn-flat pull-right" id="simpan_ket_sehat" name="simpan_ket_sehat" >Buat</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="surat_rujukan_pasien" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:1400;">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id=""></h4>
					</div>
					<div class="modal-body">
						<div>
						<form id="formRujukanPasien" method="post" class="form-horizontal">
							{{ csrf_field() }} {{ method_field('POST') }}
							<input type="hidden" class="form-control" id="registrasi_id" name="registrasi_id" value="{{$reg->id}}" >
							<table class='table table-striped table-bordered table-hover table-condensed'>
								
									<tr>
										<td>PPK Dirujuk</td>
										<td><b>
											@if($reg->pasien_no_dirujuk!=null)
												@php
													$dataxxx = json_decode($reg->pasien_text_dirujuk);
													if($reg->bayar==1){
														$ppkDirujukOld = $dataxxx->response->rujukan->tujuanRujukan->kode.' | '.$dataxxx->response->rujukan->tujuanRujukan->nama;
													}else{
														$ppkDirujukOld = $dataxxx->request->t_rujukan->ppkDirujuk;
													}
												@endphp
												<input type="text" name="ppkDirujukOld" value="{{$ppkDirujukOld}}" class="form-control" readonly=true style="width:50%;"/>
											@else
											<select name="ppkDirujuk1" class="form-control ppkDirujuk1" style="width:50%;"></select>
											@endif
										</td>
									</tr>
									<tr>
										<td>Penanggung Jawab PPK Dirujuk</td>
										<td><input type="text" class="form-control" id="penanggung_jawab_ppk" name="penanggung_jawab_ppk" value="" ></td>
									</tr>
									<tr>
										<td>Kasus</td>
										<td><input type="text" class="form-control" id="kasus_rujuk" name="kasus_rujuk" value="" ></td>
									</tr>
									<tr>
										<td>Terapi yang telah dilakukan</td>
										<td><input type="text" class="form-control" id="terapi" name="terapi" value="" ></td>
									</tr>
									
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary btn-flat pull-right" id="simpan_rujukan_pasien" name="simpan_rujukan_pasien" >Buat</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="surat_persetujuan_tindakan_medis" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:1400;">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id=""></h4>
					</div>
					<div class="modal-body">
						<div>
						<form id="form_persetujuan_tindakan_medis" method="post" class="form-horizontal">
							{{ csrf_field() }} {{ method_field('POST') }}
							<table class='table table-striped table-bordered table-hover table-condensed'>
								
									<tr>
										<td>Nama Penanggung Jawab</td>
										<td><input type="hidden" class="form-control" id="registrasi_id" name="registrasi_id" value="{{$reg->id}}">
										<input type="hidden" class="form-control" id="pasien_id" name="pasien_id" value="{{$reg->pasien->id}}">
										<input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" value="{{$reg->pasien->penanggung_jawab}}" ></td>
									</tr>
									<tr>
										<td>Hubungan</td>
										<td>
										<select class="form-control" id="hubungan_penanggung_jawab" name="hubungan_penanggung_jawab">
										@if($reg->pasien->hubungan_penanggung_jawab=='sendiri')<option value="sendiri" selected>Sendiri</option>@else <option value="sendiri">Sendiri</option> @endif
										@if($reg->pasien->hubungan_penanggung_jawab=='suami')<option value="suami" selected>Suami</option>@else <option value="suami">Suami</option> @endif
										@if($reg->pasien->hubungan_penanggung_jawab=='istri')<option value="istri" selected>Istri</option>@else <option value="istri">Istri</option> @endif
										@if($reg->pasien->hubungan_penanggung_jawab=='orang_tua')<option value="orang_tua" selected>Orang Tua</option>@else <option value="orang_tua">Orang Tua</option> @endif
										@if($reg->pasien->hubungan_penanggung_jawab=='anak')<option value="anak" selected>Anak</option>@else <option value="anak">Anak</option> @endif
										@if($reg->pasien->hubungan_penanggung_jawab=='saudara')<option value="saudara" selected>Saudara</option>@else <option value="saudara">Saudara</option> @endif
										@if($reg->pasien->hubungan_penanggung_jawab=='teman')<option value="teman" selected>Teman</option>@else <option value="teman">Teman</option> @endif
										</select>
										</td>
									</tr>
									<tr>
										<td>Jenis Kelamin</td>
										<td>
										<select class="form-control" id="kelamin_penanggung_jawab" name="kelamin_penanggung_jawab">
										@if($reg->pasien->kelamin_penanggung_jawab=='L')<option value="L" selected>Laki-Laki</option>@else<option value="L">Laki-Laki</option>@endif
										@if($reg->pasien->kelamin_penanggung_jawab=='P')<option value="P" selected>Perempuan</option>@else<option value="P">Perempuan</option>@endif
										</select>
										</td>
									</tr>
									<tr>
										<td>Umur</td>
										<td><input type="date" class="form-control" id="umur_penanggung_jawab" name="umur_penanggung_jawab" value="{{$reg->pasien->umur_penanggung_jawab}}" ></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td><input type="text" class="form-control" id="alamat_penanggung_jawab" name="alamat_penanggung_jawab" value="{{$reg->pasien->alamat_penanggung_jawab}}" ></td>
									</tr>
									<tr>
										<td>Jenis Tanda Pengenal</td>
										<td>
										<select class="form-control" id="jenis_tanda_pengenal" name="jenis_tanda_pengenal">
										@if($reg->pasien->jenis_tanda_pengenal=='ktp')<option value="ktp" selected>KTP</option>@else<option value="ktp">KTP</option>@endif
										@if($reg->pasien->jenis_tanda_pengenal=='sim')<option value="sim" selected>SIM</option>@else<option value="sim">SIM</option>@endif
										</select>
										</td>
									</tr>
									<tr>
										<td>No Bukti Diri / KTP / SIM</td>
										<td>
										<input type="text" class="form-control" id="no_bukti_diri" name="no_bukti_diri" value="{{$reg->pasien->no_bukti_diri}}" >
										</td>
									</tr>
									<tr>
										<td>No Telepon Penanggung Jawab</td>
										<td>
										<input type="text" class="form-control" id="telp_penanggung_jawab" name="telp_penanggung_jawab" value="{{$reg->pasien->telp_penanggung_jawab}}"" >
										</td>
									</tr>
									
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary btn-flat pull-right" id="simpan_persetujuan_tindakan_medis" name="simpan_persetujuan_tindakan_medis" >Buat</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="rujukanBpjs" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="">Buat Rujukan</h4>
					</div>
					<div class="modal-body">
						<table class="table no-border" style="width:100%;">
							@if($reg->bayar==1)
							<tr>
								<td style="width:30%;">No. SEP</td>
								<td><b><input type="text" class="form-control" name="noSep" value="{{ $reg->no_sep }}" style="width:50%;"></td>
							</tr>
							@else
							<tr>
								<td style="width:30%;">REG ID</td>
								<td><b><input type="text" class="form-control" readonly=true name="regId" value="{{ $reg->reg_id }}" style="width:50%;"></td>
							</tr>
							@endif
							<tr>
								<td>Tgl. Rujukan</td>
								<td><b><input type="text" class="form-control" name="tglRujukan" value="{{ date('Y-m-d') }}" style="width:50%;"></td>								
							</tr>
							<tr>
								<td>PPK Dirujuk</td>
								<td><b>
									@if($reg->pasien_no_dirujuk!=null)
										@php
											$dataxxx = json_decode($reg->pasien_text_dirujuk);
											if($reg->bayar==1){
												$ppkDirujukOld = $dataxxx->response->rujukan->tujuanRujukan->kode.' | '.$dataxxx->response->rujukan->tujuanRujukan->nama;
											}else{
												$ppkDirujukOld = $dataxxx->request->t_rujukan->ppkDirujuk;
											}
										@endphp
										<input type="text" name="ppkDirujukOld" value="{{$ppkDirujukOld}}" class="form-control" readonly=true style="width:50%;"/>
									@else
									<select name="ppkDirujuk" class="form-control ppkDirujuk" style="width:50%;"></select>
									@endif
								</td>
							</tr>
							<tr>
								<td>Jenis Pelayanan</td>
								<td><b>
									@php
										$pelayanan = 1;
										$pelayanan_text = "Rawat Inap";
										if(substr($reg->status_reg,0,1)=="J" || substr($reg->status_reg,0,1)=="G"){
											$pelayanan = 2;
											$pelayanan_text = "Rawat Jalan";
										}
									@endphp
									<input type="hidden" name="jnsPelayanan" value="{{$pelayanan}}" class="form-control">
									<input type="text" name="jnsPelayananText" value="{{$pelayanan_text}}" class="form-control" readonly=true style="width:50%;"/>
								</td>
							</tr>
							@if($reg->pasien_no_dirujuk==null)
							<tr>
								<td style="width:30%;">Catatan / Keluhan / Anamnesis</td>
								<td><b><input type="text" name="catatan" value="{{$reg->anamnesis}}" class="form-control" style="width:50%;"/></td>
							</tr>
							@endif
							<tr>
								<td style="width:30%;">Diagnosa Rujukan</td>
								<td><b>
									@if($reg->pasien_no_dirujuk!=null)
										@php
											$dataxxx = json_decode($reg->pasien_text_dirujuk);
											if($reg->bayar==1){
												$diagRujukanText = $dataxxx->response->rujukan->diagnosa->kode.' | '.$rujukan->response->rujukan->diagnosa->nama;
											}else{
												$diagRujukanText = $dataxxx->request->t_rujukan->diagRujukan.' | '.$dataxxx->request->t_rujukan->diagRujukanText;
											}
										@endphp
										<input type="text" name="diagRujukanText" id="diagRujukanText" value="{{$diagRujukanText}}" class="form-control" readonly=true style="width:50%;"/>
									@else
										<input type="hidden" name="diagRujukan" value="" class="form-control"/>
										<input type="text" name="diagRujukanText" id="diagRujukanText" value="" class="form-control" readonly=true style="width:50%;"/>
									@endif
								</td>
							</tr>
							@if($reg->pasien_no_dirujuk==null)
							<tr>
								<td>Tipe Rujukan</td>
								<td><b>
									<select name="tipeRujukan" class="form-control" style="width:50%;">
										<option value="0">Penuh</option>
										<option value="1">Partial</option>
										<option value="2">Rujuk Balik</option>
									</select>
								</td>
							</tr>
							@endif
							<tr>
								<td style="width:30%;">Poli Rujukan</td>
								<td><b>
									{!! Form::select('poliRujukan', Modules\Poli\Entities\Poli::whereNotIn('bpjs',['-'])->pluck('nama','bpjs'), Modules\Poli\Entities\Poli::find($reg->poli_id)->bpjs, ['placeholder'=>'--pilih poli--','class' => 'form-control poliRujukan', 'style'=>'width:50%;']) !!}
								</td>
							</tr>
						</table>
					</div>
					<div class="modal-footer">
						<div class="col-md-12">						
							<div class="progress progress-md active hidden">
								<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
									<span class="sr-only">87% Complete</span> Loading...
								</div>
							</div>
						</div>
						<div class="col-md-7 pull-left">
							<div class="form-group">
								<div class="col-md-12 no-padding">
									<div class="input-group">
										<span class="input-group-btn">
											<input type="button" disabled=true class="btn btn-flat btn-success pull-right" value="Nomor Rujukan">
										</span>
										{!! Form::text('no_rujukan', $reg->pasien_no_dirujuk , ['class' => 'form-control', 'readonly' => 'true']) !!}									
									</div>
								</div>
							</div>
						</div>
						<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">TUTUP</button>
						@if($reg->pasien_no_dirujuk==null)
							<button type="button" id="buatRujukan" class="btn btn-success btn-flat">BUAT RUJUKAN</button>
						@else
							<button type="button" id="hapusRujukan" class="btn btn-danger btn-flat">HAPUS RUJUKAN</button>
							<!--button type="button" id="updateRujukan" class="btn btn-success btn-flat">Update Rujukan</button-->
						@endif
						<button type="button" id="cetakRujukan" class="btn btn-success btn-flat"><i class="fa fa-print"></i> CETAK</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="icd10_list" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">Data ICD10</h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table id='get_dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>Nomor</th>
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

	<div class="modal fade" id="konfirmasi_pembayaran" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="">Konfirmasi Pembayaran</h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
		  	
			<table class='table table-striped table-bordered table-hover table-condensed'>
				<thead>
				<tr>
					<th>Nama Pasien</th>
					<th>No. RM</th>
					<th>Alamat</th>
					<th>Status Reg</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>{{ $reg->pasien->nama }}</td>
					<td>{{ $reg->pasien->no_rm }}</td>
					<td>{{ $reg->pasien->alamat }}</td>
					<td>
					@if (substr($reg->status_reg,0,1) == 'J')
						Rawat Jalan
					@elseif (substr($reg->status_reg,0,1) == 'G')
						Rawat Darurat
					@endif
					</td>
				</tr>
				
			</table>
			</div>
			<div class='table-responsiv'>
				{!! Form::label('biaya_tindakan', 'Biaya Tindakan', ['class' => 'col-12','style'=>'font-size:16px;']) !!}
				<table id="table_biaya"class='table table-striped table-bordered table-hover table-condensed'>
				<thead>
					<tr>
					<th>No</th>
					<th>Nama Tindakan</th>
					<th>Total</th>
					<th>Klinik</th>
					<th>Pelaksana</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				</table>
				{!! Form::label('biaya_Obat', 'Biaya Obat', ['class' => 'col-12','style'=>'font-size:16px;']) !!}
				<table id="table_biaya_obat"class='table table-striped table-bordered table-hover table-condensed'>
				<thead>
					<tr>
					<th>No</th>
					<th>Nama Obat</th>
					<th>Jumlah</th>
					<th>Aturan Makan</th>
					<th>Total</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				</table>
				{!! Form::label('biaya_Pemakaian_Obat', 'Biaya Pemakaian Obat', ['class' => 'col-12','style'=>'font-size:16px;']) !!}
				<table id="table_biaya_pemakaian_obat"class='table table-striped table-bordered table-hover table-condensed'>
				<thead>
					<tr>
					<th>No</th>
					<th>Nama Obat</th>
					<th>Jumlah</th>
					<th>Total</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				</table><br>
					<div class="form-group{{ $errors->has('dokter_anak') ? ' has-error' : '' }}">
						{!! Form::label('token_biaya', 'Total Biaya', ['class' => 'col-sm-3','style'=>'font-size:16px;']) !!}
						<div class="col-sm-9">
						<input type="text" name="total_biaya" value="0" class="col-12 form-control" style="font-size:24px;font-weight:bold; text-align: center;" readonly>
						</div>
					</div>
          </div>
		  <br><br><br>
		  <center>
		  {!! Form::open(['method' => 'POST', 'route' => 'tindakan.kondisiakhir', 'class' => 'form-horizontal']) !!}
		  {!! Form::hidden('registrasi_id', $reg_id) !!}
       	  {!! Form::hidden('status_reg', substr($reg->status_reg,0,1)) !!}
		  <input type="hidden" name="kondisi_akhir_pasien" >
		  {!! Form::submit("PULANGKAN PASIEN", ['class' => 'btn btn-success btn-block btn-flat', 'onclick'=>'javascript:return confirm("Yakin data ini sudah benar?")']) !!}
		  {!! Form::close() !!}
		  </center>
	    </div>
       
      </div>
    </div>
  	</div>
@stop

@section('script')
<script type="text/javascript">

$("input[name='nama_icd10']").on('click', function () {

	$("#get_dataICD10").DataTable().destroy();

	$("#icd10_list").modal('show');

	$('#get_dataICD10').DataTable({

		pageLength: 10,

		autoWidth: false,

		processing: true,

		serverSide: true,

		ordering: false,

		ajax: '{{url('icd10/getICD10/list')}}',

		columns: [

			// {data: 'rownum', orderable: false, searchable: false},

			{data: 'id'},

			{data: 'nomor'},

			{data: 'nama'},

			{data: 'add', searchable: false}

		]

	});

});

$(document).on('click', '.pilih_icd10',function () {
		$('input[name="nomor_icd10"]').val($(this).attr('data-nomor'));
		$('input[name="nama_icd10"]').val($(this).attr('data-nama'));
		$('#icd10_list').modal('hide');
	});

	
/*$(document).ready(function () {
	var url = "{{url('/tindakan/list-pemeriksaan-object/'.$reg->id)}}";
	$('#user_table').DataTable({
		processing:true,
		serverSide:true,
		ajax:{
			url: url,
		},
		columns:[
			{data: 'kategori_pemeriksaan'},
					{data: 'keterangan'},
					{data: 'aksi'},
		]
	});

});*/
$('#detailPemeriksaan_object').DataTable({
		lengthChange: false,
		paging      : false,
		searching   : false,
		ordering    : false,
		autoWidth   : false,
		processing  : false,
		info        : false,
		serverSide  : true,
		ajax: '{{url('/tindakan/list-pemeriksaan-object/'.$reg->id)}}',
		columns: [
					{data: 'kategori_pemeriksaan'},
					{data: 'keterangan'},
					{data: 'aksi'},
		]
	});
$('#table_assesment').DataTable({
		lengthChange: false,
		paging      : false,
		searching   : false,
		ordering    : false,
		autoWidth   : false,
		processing  : false,
		info        : false,
		serverSide  : true,
		ajax: '{{url('/icd10/list_assesment/'.$reg->id)}}',
		columns: [
					{data: 'icd10'},
					{data: 'detail_diagnosa'},
					{data: 'aksi'},
		]
	});
$('#table_histori_alergi').DataTable({
		lengthChange: false,
		paging      : false,
		searching   : false,
		ordering    : false,
		autoWidth   : false,
		processing  : false,
		info        : false,
		serverSide  : true,
		ajax: '{{url('/alergi/get-data-histori-alergi/'.$reg->id)}}',
		columns: [
					{data: 'tanggal'},
					{data: 'kategori_alergi'},
					{data: 'detail_alergi'},
					{data: 'aksi'},
		]
	});
$('#table_histori_icd10').DataTable({
		lengthChange: false,
		paging      : false,
		searching   : false,
		ordering    : false,
		autoWidth   : false,
		processing  : false,
		info        : false,
		serverSide  : true,
		ajax: '{{url('/icd10/list_riwayat_icd_10/'.$reg->id)}}',
		columns: [
					{data: 'tanggal'},		
					{data: 'nama_icd'},
					{data: 'aksi'},
		]
	});
$('#table_histori_penyakit_turunan').DataTable({
		lengthChange: false,
		paging      : false,
		searching   : false,
		ordering    : false,
		autoWidth   : false,
		processing  : false,
		info        : false,
		serverSide  : true,
		ajax: '{{url('/icd10/list_riwayat_penyakit_turunan/'.$reg->id)}}',
		columns: [
					{data: 'tanggal'},		
					{data: 'nama_icd'},
					{data: 'aksi'},
		]
	});
$('#simpan-alergi').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '{{url('/alergi/post-data-histori-alergi')}}',
			data: $('#formSimpan_Alergi').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					
				}else if(data.sukses == true){
					$('#table_histori_alergi').DataTable().ajax.reload();
					alert('Data sudah masuk');
				}
			}
		});
	});
	$('#simpan-riwayat').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '{{url('/icd10/post_riwayat_icd_10')}}',
			data: $('#formSimpan_riwayat_penyakit').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					//alert("Data sudah di masukan sebelumnya");
				}else if(data.sukses == true){
					$('#table_histori_icd10').DataTable().ajax.reload();
					alert('Data sudah masuk');
				}
			}
		});
	});
	$('#simpan-riwayat-turunan').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '{{url('/icd10/post_riwayat_penyakit_turunan')}}',
			data: $('#formSimpan_riwayat_penyakit_turunan').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					//alert("Data sudah di masukan sebelumnya");
				}else if(data.sukses == true){
					$('#table_histori_penyakit_turunan').DataTable().ajax.reload();
					alert('Data sudah masuk');
				}
			}
		});
	});

	$('#simpan-assesment').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '{{url('/icd10/post_assesment')}}',
			data: $('#formSimpan_assesment').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					$('#table_assesment').DataTable().ajax.reload();
					alert("Data sudah di masukan sebelumnya dan sudah di update");
				}else if(data.sukses == true){
					$('#table_assesment').DataTable().ajax.reload();
					alert('Data sudah masuk');
				}
			}
		});
	});
	
//HAPUS RIWAYAT PENYAKIT
$(document).on('click', '.hapushistoririwayatpenyakit', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	if (confirm('Apakah yakin Riwayat Penyakit ini akan dihapus?')) {
		$.ajax({
			url: '{{url('/icd10/hapus_riwayat_icd_10/')}}'+'/' + id,
			type: 'GET',
			success: function (data) {
				console.log(data);
				if(data.sukses == true) {
					$('#table_histori_icd10').DataTable().ajax.reload();
					alert('Data telah dihapus');
				}else{
					alert("Data gagal dihapus")
				}
			}
		});
	}
})
//HAPUS RIWAYAT ASSESMENT
$(document).on('click', '.hapusassesment', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	if (confirm('Apakah yakin Diagnosa Penyakit ini akan dihapus?')) {
		$.ajax({
			url: '{{url('/icd10/hapus_assesment/')}}'+'/' + id,
			type: 'GET',
			success: function (data) {
				console.log(data);
				if(data.sukses == true) {
					$('#table_assesment').DataTable().ajax.reload();
					alert('Data telah dihapus');
				}else{
					alert("Data gagal dihapus")
				}
			}
		});
	}
})
//HAPUS RIWAYAT PENYAKIT TURUNAN
$(document).on('click', '.hapushistoririwayatpenyakitturunan', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	if (confirm('Apakah yakin Riwayat Penyakit ini akan dihapus?')) {
		$.ajax({
			url: '{{url('/icd10/hapus_riwayat_penyakit_turunan/')}}'+'/' + id,
			type: 'GET',
			success: function (data) {
				console.log(data);
				if(data.sukses == true) {
					$('#table_histori_penyakit_turunan').DataTable().ajax.reload();
					alert('Data telah dihapus');
				}else{
					alert("Data gagal dihapus")
				}
			}
		});
	}
})
//HAPUS alergi
$(document).on('click', '.hapushistorialergi', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	if (confirm('Apakah yakin Riwayat Alergi ini akan dihapus?')) {
		$.ajax({
			url: '{{url('/alergi/hapus-data-histori-alergi')}}'+'/' + id,
			type: 'GET',
			success: function (data) {
				console.log(data);
				if(data.sukses == true) {
					$('#table_histori_alergi').DataTable().ajax.reload();
					alert('Data telah dihapus');
				}else{
					alert("Data gagal dihapus")
				}
			}
		});
	}
})

//HAPUS pemeriksaan object
$(document).on('click', '.hapus_pemeriksaan_object', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	if (confirm('Apakah yakin pemeriksaan ini akan dihapus?')) {
		$.ajax({
			url: '{{url('/tindakan/hapus-pemeriksaan-object')}}'+'/' + id,
			type: 'GET',
			success: function (data) {
				console.log(data);
				if(data.sukses == true) {
					$('#detailPemeriksaan_object').DataTable().ajax.reload();
					alert('Data telah dihapus');
				}else{
					alert("Data gagal dihapus")
				}
			}
		});
	}
})
//simpan pemeriksaan object
$('#simpan-pemeriksaan-object').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '{{url('/tindakan/simpan-pemeriksaan-object')}}',
			data: $('#formAddPemeriksaan_Object').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					$('#detailPemeriksaan_object').DataTable().ajax.reload();
				}else if(data.sukses == true){
					$('#detailPemeriksaan_object').DataTable().ajax.reload();
					alert('Data sudah masuk');
				}
			}
		});
	});


//konfirmasi pembayaran
$('#Kondisi_Akhir_Pasien').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '{{url('/tindakan/cek_pembayaran')}}',
			data: $('#formKondisi_Akhir_Pasien').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					alert(data.note)
				}else if(data.sukses == true){
					$('#konfirmasi_pembayaran').modal('show');
					$('input[name="kondisi_akhir_pasien"]').val(data.kondisi_pasien);
					$('input[name="total_biaya"]').val(data.total_biaya);
					$('#table_biaya').DataTable().destroy();
					$('#table_biaya_obat').DataTable().destroy();
					$('#table_biaya_pemakaian_obat').DataTable().destroy();
					$('#table_biaya').DataTable({
						lengthChange: false,
						paging      : false,
						searching   : false,
						ordering    : false,
						autoWidth   : false,
						processing  : false,
						info        : false,
						serverSide  : true,
						ajax: '{{url('/tindakan/get_data_biaya/'.$reg->id)}}',
						columns: [
									{data: 'rownum'},
									{data: 'namatarif'},
									{data: 'number_total'},
									{data: 'poli'},
									{data: 'pelaksana'},
						]
					});
					$('#table_biaya_obat').DataTable({
						lengthChange: false,
						paging      : false,
						searching   : false,
						ordering    : false,
						autoWidth   : false,
						processing  : false,
						info        : false,
						serverSide  : true,
						ajax: '{{url('/tindakan/get_data_biaya_obat/'.$reg->id)}}',
						columns: [
									{data: 'rownum'},
									{data: 'nama'},
									{data: 'jumlah'},
									{data: 'aturan_pakai'},
									{data: 'total'},
						]
					});
					$('#table_biaya_pemakaian_obat').DataTable({
						lengthChange: false,
						paging      : false,
						searching   : false,
						ordering    : false,
						autoWidth   : false,
						processing  : false,
						info        : false,
						serverSide  : true,
						ajax: '{{url('/tindakan/get_data_biaya_pemakaian_obat/'.$reg->id)}}',
						columns: [
									{data: 'rownum'},
									{data: 'nama'},
									{data: 'jumlah'},
									{data: 'total'},
						]
					});
				}
			}
		});
	});


function myFunction() {
	// Get the checkbox
	var checkBox = document.getElementById("myCheck");
	// Get the output text
	var text = document.getElementById("text");

	// If the checkbox is checked, display the output text
	if (checkBox.checked == true){
		text.style.display = "block";
	} else {
		text.style.display = "none";
	}
      
}
$('#show_histori').on('click', function() {
		$('#histori_pemeriksaan_fisik').modal('show');
		$('.modal-title').text('Histori Pemeriksaan ');
		$('#data_histori_pemeriksaan').DataTable().destroy();
		$('#data_histori_pemeriksaan').DataTable({
			autoWidth: false,
			processing: true,
			serverSide: true,
			ajax: '{{url('tindakan/get_histori_pemeriksaan_pasien/'.$reg->id)}}',
			columns: [
					{data: 'rownum'},
					{data: 'tanggal'},
					{data: 'tensi'},
					{data: 'suhu'},
					{data: 'berat'},
					{data: 'tinggi'},
					{data: 'anamnesis'},
					{data: 'keluhan_pasien'},
					{data: 'diagnosa_awal'},
					{data: 'diagnosa_akhir'},
			]
		});
	});
$('.select2').select2();
$('#div-right').css('height',(window.innerHeight-75));
$('.content').css('padding-right','0px');
$('#div-jenis-racikan-resep').hide();
$('#div-jenis-racikan-epo').hide();
setTimeout(function(){
	var element = document.getElementById("tab_rm");
	element.classList.remove("active");
	var element2 = document.getElementById("tab_pakaiobat");
	element2.classList.remove("active");
	var element3 = document.getElementById("tab_kpo");
	element3.classList.remove("active");
	var element4 = document.getElementById("tab_resepobat");
	element4.classList.remove("active");
}, 500);

// view Detail
function getPemakaian(){
	$("#detailPemakaian").DataTable().destroy()
	return $('#detailPemakaian').DataTable({
		'language': {
			'url': '/json/pasien.datatable-language.json',
		},
		lengthChange: false,
		paging      : false,
		searching   : false,
		ordering    : false,
		autoWidth   : false,
		processing  : false,
		info        : false,
		serverSide  : true,
		ajax: '/pemakaian-detail/'+id,
		columns: [
			{data: 'rownum'},
			{data: 'created_at'},
			{data: 'masterobat_id'},
			{data: 'satuan'},
			{data: 'jumlah'},
			{data: 'hargajual'},
			{data: 'delete'},
		]
	});
}
function getEpo(){
	$("#detailEpo").DataTable().destroy()
	return $('#detailEpo').DataTable({
		'language': {
			'url': '/json/pasien.datatable-language.json',
		},
		lengthChange: false,
		paging      : false,
		searching   : false,
		ordering    : false,
		autoWidth   : false,
		processing  : false,
		info        : false,
		serverSide  : true,
		ajax: '/epo-detail/'+id,
		columns: [
			{data: 'rownum'},
			{data: 'racikan'},
			{data: 'created_at'},
			{data: 'masterobat_id'},
			{data: 'satuan'},
			{data: 'jumlah'},
			{data: 'hargajual'},
			{data: 'aturan_pakai'},
			{data: 'etiket'},
			{data: 'status'},
			{data: 'delete'},
			{data: 'edit'}
		]
	});
}
function getResep(){
	$("#detailResep").DataTable().destroy()
	return $('#detailResep').DataTable({
		'language': {
			'url': '/json/pasien.datatable-language.json',
		},
		lengthChange: false,
		paging      : false,
		searching   : false,
		ordering    : false,
		autoWidth   : false,
		processing  : false,
		info        : false,
		serverSide  : true,
		ajax: '/resep-detail/'+id,
		columns: [
			{data: 'rownum'},
			{data: 'racikan'},
			{data: 'masterobat_id'},
			{data: 'satuan'},
			{data: 'jumlah'},
			{data: 'hargajual'},
			{data: 'aturan_pakai'},
			{data: 'etiket'},
			{data: 'status'},
			{data: 'hapus'},
			{data: 'edit'}
		]
	});
}

var id = $('input[name="registrasi_id"]').val();
var table = null;
var table2 = null;
var table3 = null;
// master Obat
$("#tabpakaiobat").click(function(){
	table = getPemakaian();
});
$("#tabkpo").click(function(){
	table2 = getEpo();
});
$("#tabresepobat").click(function(){
	table3 = getResep();
});

// save Detail
$('#saveItemPem').on('click', function () {
	$.ajax({
		type: 'POST',
		url: '/pemakaian-simpan',
		data: $('#formAddPakai').serialize(),
		success: function (data) {
			if(data.sukses == false) {
				alert(data.message);
			}else if(data.sukses == true) {
				$("#tabpakaiobat").click();
				$('input[name="masterobat_id"]').val("");
				$('input[name="jumlah"]').val(1);
				$('select[name="informasi1"]').val("");
				$('input[name="informasi2"]').val("");
			}
		}
	});
});
$('#saveItemEpo').on('click', function () {
	if($('input[name="berat_badan"]').val()==""){
		alert("Harap update berat badan pasien");
	}else if($('input[name="tekanan_darah"]').val()==""){
		alert("Harap update tekanan darah pasien");
	}else if($('#diagnosa_akhir').val()==""){
		alert("Harap update diagnosa akhir pasien");
	}else{
		$(this).hide();
		$.ajax({
			type: 'POST',
			url: '/epo-simpan',
			data: $('#formAddEpo').serialize(),
			success: function (data) {
				if(data.sukses == false) {
					alert(data.message);
				}else if(data.sukses == true) {
					table2.ajax.reload();
					$('#batalEditEpo').click();
				}
				$('#saveItemEpo').show();
			}
		});
	}
});
$('#saveItemResep').on('click', function () {
	if($('input[name="berat_badan"]').val()==""){
		alert("Harap update berat badan pasien");
	}else if($('input[name="tekanan_darah"]').val()==""){
		alert("Harap update tekanan darah pasien");
	}else if($('#diagnosa_akhir').val()==""){
		alert("Harap update diagnosa akhir pasien");
	}else{
		$(this).hide();
		$.ajax({
			type: 'POST',
			url: '/resep-simpan',
			data: $('#formAddResep').serialize(),
			success: function (data) {
				if(data.sukses == false) {
					alert(data.message);
				}else if(data.sukses == true) {
					table3.ajax.reload();
					$('#batalEditRes').click();
				}
				$('#saveItemResep').show();
			}
		});
	}
});
$('#saveRacikanEpo').on('click', function () {
	$.ajax({
		headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    },
		type: 'POST',
		url: '/epo-add-racikan',
		data: {registrasi_id: $('#registrasi_idx').val(), epo_jenis_racikan: $('select[name="epo_jenis_racikan"]').val(), epo_jumlah_racikan: $('input[name="epo_jumlah_racikan"]').val(), epo_satuan_racikan: $('select[name="epo_satuan_racikan"]').val()},
		success: function (data) {
			if(data.sukses == false) {
				alert(data.message);
			}else if(data.sukses == true) {
				$('input[name="epo_jumlah_racikan"]').prop("readonly",true);
				$('#epo_jenis_racikan').hide();
				$('#epo_satuan_racikan').hide();
				$('#epo_satuan_racikan').next(".select2-container").hide();
				$('#text_epo_jenis_racikan').val($('select[name="epo_jenis_racikan"]').val());
				$('#text_epo_satuan_racikan').val($('select[name="epo_satuan_racikan"]').val());
				$('#text_epo_id_racikan').val(data.id_racikan);
				$('#text_epo_jenis_racikan').show();
				$('#text_epo_satuan_racikan').show();
				$('#addRacikanEpo').show();
				$('#saveRacikanEpo').hide();
				$("#div-data-obat-epo").show();
			}
		}
	});
});
$('#saveRacikanResep').on('click', function () {
	$.ajax({
		headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    },
		type: 'POST',
		url: '/resep-add-racikan',
		data: {registrasi_id: $('#registrasi_idx').val(), resep_jenis_racikan: $('select[name="resep_jenis_racikan"]').val(), resep_jumlah_racikan: $('input[name="resep_jumlah_racikan"]').val(), resep_satuan_racikan: $('select[name="resep_satuan_racikan"]').val()},
		success: function (data) {
			if(data.sukses == false) {
				alert(data.message);
			}else if(data.sukses == true) {
				$('input[name="resep_jumlah_racikan"]').prop("readonly",true);
				$('#resep_jenis_racikan').hide();
				$('#resep_satuan_racikan').hide();
				$('#resep_satuan_racikan').next(".select2-container").hide();
				$('#text_resep_jenis_racikan').val($('select[name="resep_jenis_racikan"]').val());
				$('#text_resep_satuan_racikan').val($('select[name="resep_satuan_racikan"]').val());
				$('#text_resep_id_racikan').val(data.id_racikan);
				$('#text_resep_jenis_racikan').show();
				$('#text_resep_satuan_racikan').show();
				$('#addRacikanResep').show();
				$('#saveRacikanResep').hide();
				$("#div-data-obat-resep").show();
			}
		}
	});
});
$('#addRacikanEpo').on('click', function () {
	$('input[name="epo_jumlah_racikan"]').prop("readonly",false);
	$('select[name="status_racikan_epo"]').val(0);
	$('#status_racikan_epo').hide();
	$('#text_resep_id_racikan').val("");
	$('#epo_jenis_racikan').show();
	$('#epo_satuan_racikan').show();
	$('#epo_satuan_racikan').next(".select2-container").show();
	$('#text_epo_jenis_racikan').hide();
	$('#text_epo_satuan_racikan').hide();
	$("#div-data-obat-epo").hide();
	$("#addRacikanEpo").hide();
	$("#saveRacikanEpo").show();
});
$('#addRacikanResep').on('click', function () {
	$('input[name="resep_jumlah_racikan"]').prop("readonly",false);
	$('select[name="status_racikan_resep"]').val(0);
	$('#status_racikan_resep').hide();
	$('#text_resep_id_racikan').val("");
	$('#resep_jenis_racikan').show();
	$('#resep_satuan_racikan').show();
	$('#resep_satuan_racikan').next(".select2-container").show();
	$('#text_resep_jenis_racikan').hide();
	$('#text_resep_satuan_racikan').hide();
	$("#div-data-obat-resep").hide();
	$("#addRacikanResep").hide();
	$("#saveRacikanResep").show();
});
$('#updateDataPasien').on('click', function () {
	$.ajax({
		headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    },
		type: 'POST',
		url: '/registrasi/update-pasien',
		data: {registrasi_id: $('#registrasi_idx').val(),tanggal_kontrol: $('input[name="tanggal_kontrol"]').val(),kategori_diagnosa: $("input[name='kategori_diagnosa']:checked").val(),
		keluhan_pasien: $('input[name="keluhan_pasien"]').val(),tingkat_keluhan_pasien: $('input[name="tingkat_keluhan_pasien"]').val(), respirasi: $('input[name="respirasi"]').val(), suhu: $('input[name="suhu"]').val(), tinggi: $('input[name="tinggi"]').val(), berat_badan: $('input[name="berat_badan"]').val(), diastolik: $('input[name="diastolik"]').val(),sistolik: $('input[name="sistolik"]').val(), diagnosa_akhir: $('input[name="diagRujukanText"]').val(), anamnesis: $('textarea[name="anamnesis"]').val(),saran: $('textarea[name="saran"]').val()},
		success: function (data) {
			alert(data.message);
			$('input[name="gizi"]').val(data.input);
			$('input[name="tekanan_darah"]').val(data.input_tekanan_darah);
			$('#tampilan_diagnosa_awal').text( data.diagnosa_awal );
			$('#tampilan_diagnosa_akhir').text( data.diagnosa_akhir );
			
		}
	});
});

// hapus Detail

$(document).on('click', '.hapus', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	if (confirm('Apakah yakin item ini akan dihapus?')) {
		$.ajax({
			url: '/pemakaian-hapus/' + id,
			type: 'GET',
			success: function (data) {
				if(data.sukses == true) {
					//$("#tabpakaiobat").click();
					//$('#detailEpo').DataTable().ajax.reload(null, false);
					//$('#detailEpo').DataTable().destroy();
					//$('#detailEpo').DataTable().ajax.reload();
					//$("#tabpakaiobat").click();
				}else{
					alert("Item gagal dihapus");
				}
			}
		});
	}
});
$(document).on('click', '.copy-det-epo', function(e) {	
	if(confirm('Apakah Anda akan memasukkan resep yang sama?')){
		var id = $(this).attr('data-id');
		$.ajax({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			url: '/epo-copy/'+id,
			type: 'GET',
			dataType: 'json',
			data: null,
			success: function(data){
				if(data.sukses){
					table2.ajax.reload();
				}else{
					alert('Data gagal dihapus');
				}
			}
		}); 
	}
})
$(document).on('click', '.hapus-det-epo', function(e) {	
	e.preventDefault();
	var id = $(this).attr('data-id');
	var permintaan_id = $(this).attr('data-permintaan-id');
	var alasan = prompt("Jika Anda yakin menghapus data ini, silahkan masukan alasan:");
	if(alasan!=null){
		$.ajax({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			url: '/penjualan/deletedetailpermintaan/'+id+'/'+{{$reg->pasien_id}}+'/'+{{$idreg}}+'/'+permintaan_id+'/'+encodeURI(alasan),
			type: 'GET',
			dataType: 'json',
			data: null,
			success: function(data){
				if(data.sukses){
					table2.ajax.reload();
				}else{
					alert('Data gagal dihapus');
				}
			}
		}); 
	}else{
		alert("Alasan tidak diisi, data tidak dapat dihapus");
	}
})
$(document).on('click', '.hapus-det-res', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	var alasan = prompt("Jika Anda yakin menghapus data ini, silahkan masukan alasan:");
	if(alasan!=null){
		$.ajax({
			url: '/resep-hapus/'+id+'/0/'+encodeURI(alasan),
			type: 'GET',
			success: function (data) {
				if(data.sukses == true) {
					table3.ajax.reload();
				}else{
					alert("Item gagal dihapus");
				}
			}
		});
	}else{
		alert("Alasan tidak diisi, data tidak dapat dihapus");
	}
})

$(document).on('click', '.edit-det-res', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	$("#penjualan_id").val(id);
	$('#isUpdateResep').val(1);
	$('#isCreateResep').hide();
	$.ajax({
		url: '/penjualan/edit-penjualan/'+id,
		type: 'GET',
		dataType: 'json',
		success: function (data) {
			if(data.status){
				$('#batalEditRes').show();
				$('select[name="resep_masterobat_id"]').append('<option value="'+data.data.masterobat_id+'">'+data.data.nama+' | '+data.data.satuan+' | '+data.data.stok+'</option>');
				$('select[name="resep_masterobat_id"]').select2('data', {id:data.data.masterobat_id, text:data.data.nama});
				$('input[name="resep_expired"]').val(data.data.expired);
				$('input[name="resep_jumlah"]').val(data.data.jumlah);
				$('select[name="resep_aturan_pakai"]').val(data.data.aturan_pakai);
				$('select[name="resep_aturan_pakai"]').select2().trigger('change');
				$('input[name="resep_jumlah_aturanpakai"]').val(data.data.jumlah_aturanpakai);
				$('select[name="resep_satuan_aturanpakai"]').val(data.data.satuan_aturanpakai);
				$('select[name="resep_satuan_aturanpakai"]').select2().trigger('change');
				$('select[name="resep_informasi1"]').val(data.data.informasi1);
			}else{
				alert('Data tidak ditemukan')
			}
		}
	});
})

$(document).on('click', '.edit-det-epo', function(e) {
	e.preventDefault();
	var val = $(this).attr('data-id');
	$("#permintaan_id").val(val);
	$('#isCreateEpo').hide();
	$('#isUpdateEpo').val(1);
	$.ajax({
		url: '/penjualan/edit-permintaan/'+val,
		type: 'GET',
		dataType: 'json',
		success: function (data) {
			if(data.status){
				$('#batalEditEpo').show();
				$('select[name="epo_masterobat_id"]').append('<option value="'+data.data.masterobat_id+'">'+data.data.nama+' | '+data.data.satuan+' | '+data.data.stok+'</option>');
				$('select[name="epo_masterobat_id"]').select2('data', {id:data.data.masterobat_id, text:data.data.nama});
				$('input[name="epo_expired"]').val(data.data.expired);
				$('input[name="epo_jumlah"]').val(data.data.jumlah);
				$('select[name="epo_aturan_pakai"]').val(data.data.aturan_pakai);
				$('select[name="epo_aturan_pakai"]').select2().trigger('change');
				$('input[name="epo_jumlah_aturanpakai"]').val(data.data.jumlah_aturanpakai);
				$('select[name="epo_satuan_aturanpakai"]').val(data.data.satuan_aturanpakai);
				$('select[name="epo_satuan_aturanpakai"]').select2().trigger('change');
				$('select[name="epo_informasi1"]').val(data.data.informasi1);
			}else{
				alert('Data tidak ditemukan')
			}
		}
	});
})
$('#batalEditEpo').on('click', function(){
	$(this).hide();
	$("#permintaan_id").val(0);
	$('#isCreateEpo').show();
	$('#isUpdateEpo').val(0);
	$('input[name="epo_expired"]').val('');
	$('input[name="epo_jumlah"]').val(1);
	$('select[name="epo_masterobat_id"]').html('');
});
$('#batalEditRes').on('click', function(){
	$(this).hide();
	$("#penjualan_id").val(0);
	$('#isCreateRes').show();
	$('#isUpdateRes').val(0);
	$('input[name="resep_expired"]').val('');
	$('input[name="resep_jumlah"]').val(1);
	$('select[name="resep_masterobat_id"]').html('');
});

function ribuan(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function changeRacikan(val) {
	if(val==1){
		$("#div-jenis-racikan-epo").show();
		$("#div-jenis-racikan-resep").show();
		$("#div-data-obat-epo").hide();
		$("#div-data-obat-resep").hide();
		$('#addRacikanEpo').hide();
		$('#addRacikanResep').hide();
		$('#status_racikan_resep').show();
		$('#status_racikan_epo').show();
	}else{
		$("#div-jenis-racikan-epo").hide();
		$("#div-jenis-racikan-resep").hide();
		$("#div-data-obat-epo").show();
		$("#div-data-obat-resep").show();	
		$('#status_racikan_resep').hide();
		$('#status_racikan_epo').hide();
	}
}
function changeAlergi(val) {
	if(val==1){
		$("#div-ket-alergi-epo").show();
		$("#div-ket-alergi-resep").show();
	}else{
		$("#div-ket-alergi-epo").hide();
		$("#div-ket-alergi-resep").hide();
	}
}
function updateStatus(val, id){
	alert();
	/* $.ajax({
		headers:{
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		url: '/penjualan/update-status-permintaan',
		type: 'POST',
		dataType: 'json',
		data: {value: val, id: id},
		success: function(data){
			if(data.sukses){
				//window.location.reload();
			}else{
				alert(data.message);
			}
		},
		error: function(data){
			alert('Gagal update status');
		}
	});  */  
}
$(document).ready(function() {
	$("#diagRujukanText").on('focus', function () {
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
		/* document.getElementById("diagRujukan").value = $(this).attr('data-nomor');
		document.getElementById("diagRujukanText").value = $(this).attr('data-nama'); */		
		$('input[name="diagRujukan"]').val($(this).attr('data-nomor'));
		$('input[name="diagRujukanText"]').val($(this).attr('data-nama'));
		$('#ICD10').modal('hide');
	});
	
	$('select[name="kategoriTarifID"]').on('change', function() {
		var tarif_id = $(this).val();
		if(tarif_id) {
			$.ajax({
				url: '/tindakan/getTarif/'+tarif_id,
				type: "GET",
				dataType: "json",
				success:function(data) {
					$('select[name="tarif_id"]').empty();
					$.each(data, function(id, nama, total) {
						$('select[name="tarif_id"]').append('<option value="'+ nama.id +'">'+ nama.nama +' | '+ ribuan(nama.total)+'</option>');
					});
				}
			});
		}else{
			$('select[name="tarif_id"]').empty();
		}
	});
});

function kondisiAkhirPasien(val){
	if(val==2){
		$('#rujukanBpjs').modal('show');
	}
	if(val==6){
		window.open('/surat_pulang_paksa/'+id);
	}
	if(val==3){
		window.open('/surat_pulang_paksa/'+id);
	}
	if(val==7){
		$('#surat_visum').modal('show');
		$('.modal-title').text('Visum et Repertum');
		
	}
}
/* function getFaskes(){
	$.ajax({
		url: '/sep/get-faskes',
		type: 'GET',
		dataType: 'json',
		data: null,
		success: function (data) {
			console.log(data);
		}
	});
} */

$(document).ready(function() {
	$('.poliRujukan').select2({
		dropdownParent: $("#rujukanBpjs")
	});
	$('.ppkDirujuk').select2({
		dropdownParent: $("#rujukanBpjs"),
		placeholder: 'Cari...',
		minimumInputLength: 3,
		ajax: {
			url: '/sep/get-faskes',
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					q: $.trim(params.term)
				};
			},
			processResults: function (data) {
				if({{$reg->bayar}}==1){
					return {
						results: $.map(data, function (item) {
							return {
								text: item.nama,
								id: item.kode
							}
						})
					};
				}else{
					return {
						results: $.map(data, function (item) {
							return {
								text: item.nama,
								id: item.nama
							}
						})
					};
				}
			},
			cache: true
		}
	});
	$('#rujukanBpjs').on('hidden.bs.modal', function () {
		$('select[name="kondisi_akhir_pasien"]').val(1);
		location.reload();
	})
});

function kelolaRujukan(method){
	if(method=='insert'){
		var result = confirm('Apakah yakin data sudah benar?');
	}else if(method=='update'){
		var result = confirm('Apakah yakin akan mengubah data rujukan ini?');
	}else if(method=='delete'){
		var result = confirm('Apakah yakin akan menghapus data rujukan ini?');
	}
	if(result){
		$('.progress').removeClass('hidden')
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			type: 'POST',
			url: '/sep/buat-rujukan',
			data: {
				method: method,
				noRujukan: $('input[name="no_rujukan"]').val(),
				regId: $('input[name="regId"]').val(),
				noSep: $('input[name="noSep"]').val(),
				tglRujukan: $('input[name="tglRujukan"]').val(),
				ppkDirujuk: $('select[name="ppkDirujuk"]').val(),
				jnsPelayanan: $('input[name="jnsPelayanan"]').val(),
				catatan: $('input[name="catatan"]').val(),
				diagRujukan: $('input[name="diagRujukan"]').val(),
				diagRujukanText: $('input[name="diagRujukanText"]').val(),
				tipeRujukan: $('select[name="tipeRujukan"]').val(),
				poliRujukan: $('select[name="poliRujukan"]').val()
			},
			success: function (data) {
				if(method=='delete'){
					location.reload();
				}else if(data.status){
					$('input[name="no_rujukan"]').val(data.no_rujukan)
				}else{
					$('input[name="no_rujukan"]').val(data.message)
					alert(data.message)
				}
				$('.progress').addClass('hidden')
			}
		});
	}
}
$('#buatRujukan').on('click', function () {
	kelolaRujukan('insert');
});
$('#updateRujukan').on('click', function () {
	kelolaRujukan('update');
});
$('#hapusRujukan').on('click', function () {
	kelolaRujukan('delete');
});
$('#cetakRujukan').on('click', function () {
	window.open('/sep/cetak-rujukan/'+$('input[name="no_rujukan"]').val(), '_blank','location=yes,height=570,width=620,scrollbars=yes,status=yes');
});

$('#simpan_visum').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '{{url('/surat-visum/create')}}',
			data: $('#formVisum').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					
				}else if(data.sukses == true){
					$('input[name="instansi_pemohon"]').val(data.instansi_pemohon);
					$('input[name="pemohon"]').val(data.pemohon);
					$('input[name="jabatan_pemohon"]').val(data.jabatan_pemohon);
					$('input[name="nomor_permohonan"]').val(data.nomor_permohonan);
					$('input[name="kesimpulan"]').val(data.kesimpulan);
					$('#surat_visum').modal('hide');
					window.open('/surat-visum/'+id);
				}
			}
		});
	});
	
$('#simpan_rujukan_pasien').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '{{url('/create-surat-rujukan/')}}',
			data: $('#formRujukanPasien').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					alert(data.note);
				}else if(data.sukses == true){
					window.open('/surat-rujukan/'+id);
					$('#surat_ket_sehat').modal('hide');
				}
			}
		});
	});
$('#simpan_ket_sehat').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '{{url('/surat-keterangan-sehat/create')}}',
			data: $('#formKetSehat').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					
				}else if(data.sukses == true){
					$('input[name="keperluan"]').val(data.keperluan);
					$('input[name="berat_badan"]').val(data.berat_badan);
					$('input[name="tinggi_badan"]').val(data.tinggi_badan);
					$('input[name="tekanan_darah"]').val(data.tekanan_darah);
					$('input[name="golongan_darah"]').val(data.golongan_darah);
					$('input[name="riwayat_penyakit"]').val(data.riwayat_penyakit);
					//$('#surat_visum').modal('hide');
					window.open('/surat-keterangan-sehat/'+id);
					$('#surat_ket_sehat').modal('hide');
				}
			}
		});
	});

	$('#simpan_rujukan').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '{{url('/surat-rujukan/create')}}',
			data: $('#formKetSehat').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					
				}else if(data.sukses == true){
					$('input[name="keperluan"]').val(data.keperluan);
					$('input[name="berat_badan"]').val(data.berat_badan);
					$('input[name="tinggi_badan"]').val(data.tinggi_badan);
					$('input[name="tekanan_darah"]').val(data.tekanan_darah);
					$('input[name="golongan_darah"]').val(data.golongan_darah);
					$('input[name="riwayat_penyakit"]').val(data.riwayat_penyakit);
					//$('#surat_visum').modal('hide');
					window.open('/surat-rujukan/'+id);
					$('#surat_rujukan_pasien').modal('hide');
				}
			}
		});
	});

	$(document).on('click', '.surat_ket_sehat', function (e) {	
		$('#surat_ket_sehat').modal('show');
		$('.modal-title').text('Surat Keterangan Sehat');
	});

	$(document).on('click', '.surat_rujukan_pasien', function (e) {	
		$('#surat_rujukan_pasien').modal('show');
		$('.poliRujukan').select2({
		dropdownParent: $("#surat_rujukan_pasien")
		});
		$('.ppkDirujuk1').select2({
		dropdownParent: $("#surat_rujukan_pasien"),
		placeholder: 'Cari...',
		minimumInputLength: 3,
		ajax: {
			url: '/sep/get-faskes',
			dataType: 'json',
			delay: 250,
			data: function (params) {
				return {
					q: $.trim(params.term)
				};
			},
			processResults: function (data) {
				if({{$reg->bayar}}==1){
					return {
						results: $.map(data, function (item) {
							return {
								text: item.nama,
								id: item.kode
							}
						})
					};
				}else{
					return {
						results: $.map(data, function (item) {
							return {
								text: item.nama,
								id: item.nama
							}
						})
					};
				}
			},
			cache: true
		}
	});
		$('.modal-title').text('Surat Rujukan Pasien');
	});

	$('#simpan_persetujuan_tindakan_medis').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '{{url('/surat-persetujuan-tindakan-medis/create')}}',
			data: $('#form_persetujuan_tindakan_medis').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					
				}else if(data.sukses == true){
					
					window.open('/surat-persetujuan-tindakan-medis/'+id);
					$('#surat_persetujuan_tindakan_medis').modal('hide');
					//$('#surat_ket_sehat').modal('hide');
				}
			}
		});
	});

	$(document).on('click', '.surat_persetujuan_tindakan_medis', function (e) {	
		$('#surat_persetujuan_tindakan_medis').modal('show');
		$('.modal-title').text('Surat Persetujuan / Penolakan Tindakan Medis');
    });

	$('#updateDataSaranDokter').on('click', function () {
		$.ajax({
			type: 'POST',
			url: '{{url('tindakan/update-saran-dokter')}}',
			data: $('#formAddSaranDokter').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					
				}else if(data.sukses == true){
				alert('Data Sudah Tersimpan')
				}
			}
		});
	});



    var slider = document.getElementById("tingkat_keluhan_pasien");
    var output = document.getElementById("tingkat_keluhan");
    output.innerHTML = slider.value;

    slider.oninput = function() {
    output.innerHTML = this.value;
    }
    const _R = document.querySelector('[type=range]');
    _R.style.setProperty('--val', +_R.value);
    _R.style.setProperty('--max', +_R.max);
    _R.style.setProperty('--min', +_R.min);

    document.documentElement.classList.add('js');

    _R.addEventListener('input', e => {
        _R.style.setProperty('--val', +_R.value);
	}, false);

	
</script>
@endsection