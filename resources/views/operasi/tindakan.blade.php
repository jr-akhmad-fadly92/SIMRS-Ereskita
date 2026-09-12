@extends('master')

@section('content')
	<div class="col-md-2 no-padding" style="padding-right:10px!important;">	
		<!--h4 style="margin-top:0;font-size:14px;font-weight:600;">
			@if(strtolower(Auth::user()->role()->first()->name)=='rawatinap')
				Pendaftaran IBS
			@else
				Operasi
			@endif
		</h4-->
		<div class="box-group" id="accordion">
			<div class="panel box box-success no-margin" style="background:transparent!important;box-shadow:none;">
				<div class="box-header with-border" style="background:white!important;">
					<h4 class="box-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
							Data Pasien
						</a>
					</h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse in" style="background:transparent!important;">
					<div class="box box-widget widget-user" style="margin-bottom:10px;">
						<div class="widget-user-header bg-aqua-active" style="height:auto;">
							<div class="row">
								<table class="table-condensed" style="width:100%;color:white;">
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
										<td>Alamat</td><td class="text-right"><b>{{ $pasien->alamat }}</td>
									</tr>
									<tr>
										<td>Cara Bayar</td><td class="text-right"><b>{{ baca_carabayar($reg->bayar) }}</td>
									</tr>
									<tr>
										<td>DPJP</td><td class="text-right"><b>{{ baca_dokter($reg->dokter_id) }}</td>
									</tr>
									<tr>
										<td>Kelas</td><td class="text-right"><b>{{ !empty($irna) ? $irna->kelas->nama : NULL }}</td>
									</tr>
									<tr>
										<td>Kamar</td><td class="text-right"><b>{{ !empty($irna) ? $irna->kamar->nama : NULL }}</td>
									</tr>
									<tr>
										<td>Bed</td><td class="text-right"><b>{{ !empty($irna) ? $irna->bed->nama : NULL }}</td>
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
							<button class="btn btn-warning btn-block btn-flat"><span id="total_tagihan_text"></span></button>
						</div>
					</div>
					<!--h4 style="margin-top:0;font-size:14px;font-weight:600;">
						#Ket Order
					</h4-->
					<div class="box box-widget widget-user" style="margin-bottom:10px;">
						<div class="widget-user-header bg-aqua-active" style="height:auto;">
							<div class="row">
								@foreach ($ibs as $key => $d)
									<table class="" style="width:100%;color:white;">
										<tr>
											<td>{{ $no++ }}. <b>{{ tgl_indo($d->rencana_operasi) }} | {{$d->jam_operasi}}</b></td>
										</tr>
										<tr>
											<td>{!! $d->suspect !!}</td>
										</tr>
									</table>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel box box-success no-margin">
				<div class="box-header with-border">
					<h4 class="box-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
							Kondisi Pasien
						</a>
					</h4>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse">
					<div class="col-md-12 no-padding" style="margin-top:5px;">
						<div class="col-md-12 no-padding">
							<div class="form-group{{ $errors->has('berat_badan') ? ' has-error' : '' }}">
								{!! Form::label('berat_badan', 'Berat Badan', ['class' => 'col-sm-12 no-padding no-margin']) !!}
								<div class="col-md-12 no-padding">
									<div class="input-group">
										{!! Form::text('berat_badan', $reg->berat_badan, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
										<small class="text-danger">{{ $errors->first('berat_badan') }}</small>
										<span class="input-group-btn">
											<input type="button" class="btn btn-flat pull-right" value="Kg">
										</span>
									</div>
								</div>
							</div>
						</div>				
						<div class="col-md-12 no-padding">
							<div class="form-group{{ $errors->has('tekanan_darah') ? ' has-error' : '' }}">
								{!! Form::label('tekanan_darah', 'Tekanan Darah', ['class' => 'col-sm-12 no-padding no-margin']) !!}
								<div class="col-md-12 no-padding">
									<div class="input-group">
										{!! Form::text('tekanan_darah', $reg->tekanan_darah, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
										<small class="text-danger">{{ $errors->first('tekanan_darah') }}</small>
										<span class="input-group-btn">
											<input type="button" class="btn btn-flat pull-right" value="mmHg">
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 no-padding">
							<div class="form-group{{ $errors->has('suhu_tubuh') ? ' has-error' : '' }}">
								{!! Form::label('suhu_tubuh', 'Suhu Tubuh', ['class' => 'col-sm-12 no-padding no-margin']) !!}
								<div class="col-md-12 no-padding">
								@if($op==null)
									<div class="input-group">
										{!! Form::text('suhu_tubuh', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
										<small class="text-danger">{{ $errors->first('suhu_tubuh') }}</small>
										<span class="input-group-btn">
											<input type="button" class="btn btn-flat pull-right" value="C">
										</span>
									</div>
								@else
									<div class="input-group">
										{!! Form::text('suhu_tubuh', $op->suhu_tubuh, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
										<small class="text-danger">{{ $errors->first('suhu_tubuh') }}</small>
										<span class="input-group-btn">
											<input type="button" class="btn btn-flat pull-right" value="C">
										</span>
									</div>
								@endif
									
								</div>
							</div>
						</div>
						<div class="col-md-12 no-padding">
							<div class="form-group{{ $errors->has('nadi') ? ' has-error' : '' }}">
								{!! Form::label('nadi', 'Nadi', ['class' => 'col-sm-12 no-padding no-margin']) !!}
								<div class="col-md-12 no-padding">
									@if($op==null)
										<div class="input-group">
											{!! Form::text('nadi', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											<small class="text-danger">{{ $errors->first('nadi') }}</small>
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right" value="/ Mnt">
											</span>
										</div>
									@else
										<div class="input-group">
											{!! Form::text('nadi', $op->nadi, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											<small class="text-danger">{{ $errors->first('nadi') }}</small>
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right" value="/ Mnt">
											</span>
										</div>
									@endif
									
								</div>
							</div>
						</div>
						<div class="col-md-12 no-padding">
							<div class="form-group{{ $errors->has('respirasi') ? ' has-error' : '' }}">
								{!! Form::label('respirasi', 'Respirasi', ['class' => 'col-sm-12 no-padding no-margin']) !!}
								<div class="col-md-12 no-padding">
									@if($op==null)
										<div class="input-group">
											{!! Form::text('respirasi', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											<small class="text-danger">{{ $errors->first('respirasi') }}</small>
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right" value="/ Mnt">
											</span>
										</div>
									@else
										<div class="input-group">
											{!! Form::text('respirasi', $op->respirasi, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											<small class="text-danger">{{ $errors->first('respirasi') }}</small>
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right" value="/ Mnt">
											</span>
										</div>
									@endif
									
								</div>
							</div>
						</div>
						<div class="col-md-12 no-padding">
							<div class="form-group{{ $errors->has('gcs') ? ' has-error' : '' }}">
								{!! Form::label('gcs', 'GCS(E,V,M)', ['class' => 'col-sm-12 no-padding no-margin']) !!}
								<div class="col-md-12 no-padding">
									@if($op==null)
										<div class="input-group">
											{!! Form::text('gcs', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											<small class="text-danger">{{ $errors->first('gcs') }}</small>
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right" value="/ Mnt">
											</span>
										</div>
									@else
										<div class="input-group">
											{!! Form::text('gcs', $op->GCS, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
											<small class="text-danger">{{ $errors->first('gcs') }}</small>
											<span class="input-group-btn">
												<input type="button" class="btn btn-flat pull-right" value="/ Mnt">
											</span>
										</div>
									@endif
									
								</div>
							</div>
						</div>				
						<div class="col-md-12 no-padding">
							<div class="form-group{{ $errors->has('diagnosa_akhir') ? ' has-error' : '' }}">
								{!! Form::label('diagnosa_akhir', 'Diagnosa Pasien', ['class' => 'col-sm-12 no-padding no-margin']) !!}
								<div class="col-md-12 no-padding">
									{!! Form::textarea('diagnosa_akhir', $reg->diagnosa_akhir, ['class' => 'form-control', 'readonly'=>true, 'id'=>'diagnosa_akhir', 'style'=>'height:70px;resize:none;']) !!}
									<small class="text-danger">{{ $errors->first('diagnosa_akhir') }}</small>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>		
	</div>
	
	<div class="col-md-10 no-padding" id="div-right" style="overflow-y:auto;overflow-x:hidden;">
		<div class="nav-tabs-custom" style="margin-bottom:0;">
			<ul class="nav nav-tabs">
				<li id="tabtindakan" class="active"><a href="#tab_tindakan" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">TINDAKAN</a></li>
				@if(strtolower(Auth::user()->role()->first()->name)=='operasi')
					<li id="tabpakaiobat"><a href="#tab_pakaiobat" data-toggle="tab" style="color:#5a5a5a;font-weight:bold;">PEMAKAIAN OBAT</a></li>
				@endif
				<div class="pull-right" style="width: 40%;">
					<div class="col-md-12 col-sm-12 col-xs-12" style="padding-left:0;margin-top:3px;">
						<input type="hidden" value="{{ $reg->id }}" id="reg_id">
						@if(strtolower(Auth::user()->role()->first()->name)=='operasi')							
						<div class="input-group">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button">PPI</button>
							</span>
							<div class="col-xs-9 no-padding">
								{!! Form::select('ppi', ['Bersih'=>'Bersih','Bersih Terkontaminasi'=>'Bersih Terkontaminasi','Terkontaminasi'=>'Terkontaminasi','Kotor'=>'Kotor'], $ibs[0]->ppi, ['class' => 'form-control', 'onchange'=>'changePpi(this.value)']) !!}
							</div>
							<div class="col-xs-3 no-padding" style="padding-left:0;margin-top:2px;">
								<a href="{{ url('operasi/selesai/'.$reg->id) }}" class="btn btn-primary btn-flat pull-right">SELESAI</a>
							</div>
						</div>
						@endif
					</div>
				</div>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_tindakan">
					<div class="row">
						<div style="padding:0 10px;">
							<div class="col-md-12 no-padding">
								<div class="box-info" style="margin-bottom:10px;">										
									@if(strtolower(Auth::user()->role()->first()->name)=='rawatinap')
										{!! Form::open(['method' => 'POST', 'url' => 'operasi/simpan-order', 'class' => 'form-horizontal']) !!}
										{!! Form::hidden('registrasi_id', $reg->id) !!}
										{!! Form::hidden('ranap_ibs', true) !!}
										<div class="row">
											<div class="col-md-12">	
												<div class="col-md-4 no-padding">									
													<div class="form-group{{ $errors->has('tindakan_operasi') ? ' has-error' : '' }}">
														{!! Form::label('tindakan_operasi', 'Tindakan', ['class' => 'col-md-12']) !!}
														<div class="col-md-12">
																<select class="form-control select2" name="tindakan_operasi" id="tindakan_operasi">
																<option value=""></option>
																@foreach (App\TindakanOperasi::get() as $d)
																	<option value="{{ $d->id }}">{{ $d->tindakan_operasi }}</option>
																@endforeach
																</select>
															<small class="text-danger">{{ $errors->first('tindakan_operasi') }}</small>
														</div>
													</div>
												</div>															
												<div class="col-md-2 no-padding">									
													<div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
														{!! Form::label('tanggal', 'Tanggal', ['class' => 'col-md-12']) !!}
														<div class="col-md-12">
															{!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
															<small class="text-danger">{{ $errors->first('tanggal') }}</small>
														</div>
													</div>
												</div>
												<div class="col-md-2">									
													{!! Form::label('', 'Aksi', ['class' => 'col-md-12']) !!}
													{!! Form::submit("Tambah Jenis Tindakan", ['class' => 'btn btn-success btn-flat pull-left', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
												</div>
											</div>
										</div>
										{!! Form::close() !!}
									@endif
											
									<h5 style="margin-top:0;"><b>#Jenis Tindakan</b></h5>
									<div>
										<table class='table table-striped table-bordered table-hover table-condensed'>
											<thead>
												<tr>
													<th>No</th>
													<th>Nama</th>
													@role(['supervisor','administrator','rawatjalan','rawatdarurat','rawatinap'])
													<th>Hapus</th>
													@endrole
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												@php
													$no=1;
												@endphp
												@if($detil_order!=null)
												@foreach($detil_order as $key => $d)
												<tr>
													<td>{{ $no++ }}</td>
													<td>{{ $d->tindakanOperasi->tindakan_operasi }}</td>
													@role(['supervisor','administrator','rawatjalan','rawatdarurat','rawatinap'])
														<td>
															@if($d->status_proses!=1)
																<a href="{{ url('operasi/hapus-jenisorder/'.$d->id.'/'.$d->registrasi_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
															@endif
														</td>
													@endrole
													<td>
														@if($d->status_proses==1)
															<i class="fa fa-check"></i> Sudah diproses
														@else
															<i class="fa fa-remove"></i> Belum diproses
														@endif
													</td>
												</tr>
												@endforeach
												@endif
											</tbody>
										</table>
									</div>
									
									@if(strtolower(Auth::user()->role()->first()->name)=='operasi')
										{!! Form::open(['method' => 'POST', 'url' => 'operasi/simpan-tindakan', 'class' => 'form-horizontal']) !!}
										<div class="col-md-4 no-padding">
											{!! Form::hidden('registrasi_id', $reg->id) !!}
											{!! Form::hidden('jenis', $reg->bayar) !!}
											{!! Form::hidden('pasien_id', $reg->pasien_id) !!}
											{!! Form::hidden('ranap_ibs', true) !!}
											{!! Form::hidden('dokter_dpjp', $reg->dokter_id) !!}
											{!! Form::hidden('jumlah', 1) !!}
											{!! Form::hidden('tanggal', date('d-m-Y')) !!}
											<div>
												<div class="col-md-12">
													<div class="form-group{{ $errors->has('dokter_anestesi') ? ' has-error' : '' }}">
														{!! Form::label('dokter_anestesi', 'Dr. Anestesi', ['class' => 'col-sm-4']) !!}
														<div class="col-sm-8">
															<select id="dokter_anestesi" name="dokter_anestesi" class="select2 form-control">
																<option value="">-- Pilih --</option>
																<option value="">-- Kosong --</option>
																@foreach($dokter as $key => $data)
																	<option {{ (session('dokter_anestesi')==$data->id) ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->nama }}</option>
																@endforeach
															</select>
															<small class="text-danger">{{ $errors->first('dokter_anestesi') }}</small>
														</div>
													</div>
													<div class="form-group{{ $errors->has('dokter_anak') ? ' has-error' : '' }}">
														{!! Form::label('dokter_anak', 'Dr. Anak', ['class' => 'col-sm-4']) !!}
														<div class="col-sm-8">
															<select id="dokter_anak" name="dokter_anak" class="select2 form-control">
																<option value="">-- Pilih --</option>
																<option value="">-- Kosong --</option>
																@foreach($dokter as $key => $data)
																	<option {{ (session('dokter_anak')==$data->id) ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->nama }}</option>
																@endforeach
															</select>
															<small class="text-danger">{{ $errors->first('dokter_anak') }}</small>
														</div>
													</div>
													<div class="form-group{{ $errors->has('operator1') ? ' has-error' : '' }}">
														{!! Form::label('operator1', 'Operator / Dokter Bedah', ['class' => 'col-sm-4', 'placeholder'=>'']) !!}
														<div class="col-sm-8">
															<select id="operator1" name="operator1" class="select2 form-control">
																<option value="">-- Pilih --</option>
																<option value="">-- Kosong --</option>
																@foreach($dokter as $key => $data)
																	<option {{ (session('operator1')==$data->id) ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->nama }}</option>
																@endforeach
															</select>
															<small class="text-danger">{{ $errors->first('operator1') }}</small>
														</div>
													</div>
																										
													@for($i=1; $i<=3; $i++)
													<div class="form-group{{ $errors->has('perawat_ibs'.$i) ? ' has-error' : '' }}">
														{!! Form::label('perawat_ibs'.$i, 'Perawat / Bidan '.$i, ['class' => 'col-sm-4', 'placeholder'=>'']) !!}
														<div class="col-sm-8">
															<select id="perawat_ibs{{ $i }}" name="perawat_ibs{{ $i }}" class="select2 form-control">
																<option value="">-- Pilih --</option>
																<option value="">-- Kosong --</option>
																@foreach($perawatbidan as $key => $data)
																	<option {{ (session('perawat_ibs'.$i)==$data->id) ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->nama }}</option>
																@endforeach
															</select>
															<small class="text-danger">{{ $errors->first('perawat_ibs'.$i) }}</small>
														</div>
													</div>
													@endfor	
													

													<h5 style="margin:20px 0;"><b><i>Tambahan Single</i></b></h5>
													<div class="form-group{{ $errors->has('operator2') ? ' has-error' : '' }}">
														{!! Form::label('operator2', 'Operator / Dokter Bedah', ['class' => 'col-sm-4', 'placeholder'=>'']) !!}
														<div class="col-sm-8">
															<select id="operator2" name="operator2" class="select2 form-control">
																<option value="">-- Pilih --</option>
																<option value="">-- Kosong --</option>
																@foreach($dokter as $key => $data)
																	<option {{ (session('operator2')==$data->id) ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->nama }}</option>
																@endforeach
															</select>
															<small class="text-danger">{{ $errors->first('operator2') }}</small>
														</div>
													</div>
													<div class="form-group{{ $errors->has('perawat_ibs4') ? ' has-error' : '' }}">
														{!! Form::label('perawat_ibs4', 'Perawat', ['class' => 'col-sm-4', 'placeholder'=>'']) !!}
														<div class="col-sm-8">
															<select id="perawat_ibs{{ $i }}" name="perawat_ibs{{ $i }}" class="select2 form-control">
																<option value="">-- Pilih --</option>
																<option value="">-- Kosong --</option>
																@foreach($perawatbidan as $key => $data)
																	<option {{ (session('perawat_ibs4')==$data->id) ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->nama }}</option>
																@endforeach
															</select>
															<small class="text-danger">{{ $errors->first('perawat_ibs4') }}</small>
														</div>
													</div>
												</div>
											</div>
										</div>
								
										<div class="col-md-8 no-padding">																						
											<!--atas -->
											<div class="form-group{{ $errors->has('jenis_anestesis') ? ' has-error' : '' }}">
												<div class="col-md-5 col-sm-5">
													<select class="form-control select2" name="jenis_anestesis" id="jenis_anestesis">
														<option value="">-- Jenis Anastesi --</option>
														<option value="">-- Kosong --</option>
														<option value="Lokal">Lokal</option>
														<option value="Regional">Regional</option>
														<option value="Umum">Umum</option>
													</select>
													<small class="text-danger">{{ $errors->first('jenis_anestesis') }}</small>
												</div>
												<div class="col-md-5 col-sm-5 no-padding">
													<select class="form-control select2" name="jenis_operasi" id="jenis_operasi">
														<option value="">-- Jenis Operasi --</option>
														<option value="">-- Kosong --</option>
														<option value="Besar">Besar</option>
														<option value="Kecil">Kecil</option>
													</select>
													<small class="text-danger">{{ $errors->first('jenis_operasi') }}</small>
												</div>
												
											</div>
											<hr>
											<!--/ kanan atas -->
											<div class="form-group{{ $errors->has('nama_tindakan') ? ' has-error' : '' }}">
												<div class="col-md-5 col-sm-5">
													<select class="form-control select2" name="nama_tindakan" id="nama_tindakan">
														<option value="">-- Nama Tindakan --</option>
														<option value="">-- Kosong --</option>
														@foreach ($nama_tindakan as $d)
															<option value="{{ $d->tindakan_operasi }}">{{ $d->tindakan_operasi }}</option>
														@endforeach
													</select>
													<small class="text-danger">{{ $errors->first('nama_tindakan') }}</small>
												</div>
												<div class="col-md-5 col-sm-5 no-padding">
													<select class="form-control select2" name="jenis_tindakan" id="jenis_tindakan">
														<option value="">-- Jenis Tindakan --</option>
														<option value="">-- Kosong --</option>
														@foreach ($group as $d)
															<option value="group-{{ $d->id }}">{{ $d->kelompok }}</option>
														@endforeach
														@foreach ($tindakan as $d)
															<option value="{{ $d->id }}">{{ $d->nama }} | {{ number_format(getTotalTarif($reg,$d)) }}</option>
														@endforeach
													</select>
													<small class="text-danger">{{ $errors->first('jenis_tindakan') }}</small>
												</div>
												<div class="col-md-2 col-sm-2">
													{!! Form::submit("TAMBAH", ['class' => 'btn btn-success btn-flat btn-block', 'onclick'=>'javascript:return confirm("Yakin Data Ini Sudah Benar")']) !!}
												</div>
											</div>
											<div>
												<table class='table table-striped table-bordered table-hover table-condensed' style="margin-top:0!important;" id="rincian">
													<thead>
														<tr>
														<th class="text-center" style="vertical-align: middle;">No</th>
														<th class="text-center" style="vertical-align: middle;">Tindakan</th>
														<th class="text-center" style="vertical-align: middle;">Pelaksana</th>
														<th class="text-center" style="vertical-align: middle;">Biaya</th>
														<th class="text-center" style="vertical-align: middle;">Waktu</th>
														<th class="text-center" style="vertical-align: middle;">Status</th>
														@role(['supervisor', 'administrator', 'rawatinap', 'operasi'])
															<th>Hapus</th>
														@endrole
														</tr>
													</thead>
													<tbody>
														@php
															$no = 1;
															$total = 0;
														@endphp
														@foreach ($folio as $key => $d)
															@php
																$total = $total + $d->total;
															@endphp
															<tr>
																<td>{{ $no++ }}</td>
																<td>{{ $d->namatarif }}</td>
																<td>
																	@php
																	if($d->dokter_anestesi!=''){
																		echo Modules\Pegawai\Entities\Pegawai::where('id', $d->dokter_anestesi)->first()->nama;
																	}elseif($d->dokter_anak!=''){
																		echo Modules\Pegawai\Entities\Pegawai::where('id', $d->dokter_anak)->first()->nama;
																	}elseif($d->dokter_operator1!=''){
																		echo Modules\Pegawai\Entities\Pegawai::where('id', $d->dokter_operator1)->first()->nama;
																	}elseif($d->dokter_operator2!=''){
																		echo Modules\Pegawai\Entities\Pegawai::where('id', $d->dokter_operator2)->first()->nama;
																	}elseif($d->perawat_ibs1!=''){
																		echo Modules\Pegawai\Entities\Pegawai::where('id', $d->perawat_ibs1)->first()->nama;
																	}elseif($d->perawat_ibs2!=''){
																		echo Modules\Pegawai\Entities\Pegawai::where('id', $d->perawat_ibs2)->first()->nama;
																	}elseif($d->perawat_ibs3!=''){
																		echo Modules\Pegawai\Entities\Pegawai::where('id', $d->perawat_ibs3)->first()->nama;
																	}elseif($d->perawat_ibs4!=''){
																		echo Modules\Pegawai\Entities\Pegawai::where('id', $d->perawat_ibs4)->first()->nama;
																	}
																	@endphp
																</td>
																<td class="text-right">{{ number_format($d->total,0,',','.') }}</td>
																<td>{{ $d->created_at->format('d-m-Y') }}</td>
																<td>{{ ($d->status_proses==1) ? 'Selesai' : '' }}</td>
																@role(['supervisor', 'administrator', 'rawatinap', 'operasi'])
																	<td>
																	@if ($d->lunas == 'Y')
																		<i class="fa fa-check"></i>
																	@else
																		<a href="{{ url('tindakan/hapus-tindakan/'.$d->id_folio.'/'.$d->registrasi_id.'/'.$d->pasien_id.'/order') }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
																	@endif
																	</td>
																@endrole
															</tr>
														@endforeach
													</tbody>
												</table>
												<input type="hidden" value="{{$total}}" id="total_tagihan">
											</div>
										</div>
										<!--- bawah-->
										<div>
										<div class="col-md-12">
										@if($op->diagnosa_awal==null)
											<div class="form-group{{ $errors->has('diagnosa_awal') ? ' has-error' : '' }}">
													{!! Form::label('diagnosa_awal', 'Diagnosa Awal', ['class' => 'col-sm-12']) !!}
													<div class="col-sm-12">
															{!! Form::textarea('diagnosa_awal', $reg->diagnosa_awal   , ['class' => 'form-control', 'style'=>'height:40px;']) !!}
															<small class="text-danger">{{ $errors->first('diagnosa_awal') }}</small>
													</div>
											</div>
										@else
											<div class="form-group{{ $errors->has('diagnosa_awal') ? ' has-error' : '' }}">
													{!! Form::label('diagnosa_awal', 'Diagnosa Awal', ['class' => 'col-sm-12']) !!}
													<div class="col-sm-12">
															{!! Form::textarea('diagnosa_awal', $op->diagnosa_awal   , ['class' => 'form-control', 'style'=>'height:40px;']) !!}
															<small class="text-danger">{{ $errors->first('diagnosa_awal') }}</small>
													</div>
											</div>
										@endif
											<div class="form-group{{ $errors->has('jaringan_eksisi-insisi') ? ' has-error' : '' }}">
													{!! Form::label('jaringan_eksisi-insisi', 'Jaringan yang di Eksisi / Insisi', ['class' => 'col-sm-12']) !!}
													<div class="col-sm-12">
															{!! Form::textarea('jaringan_eksisi-insisi', $op->jaringan_tubuh, ['class' => 'form-control', 'style'=>'height:40px;']) !!}
															<small class="text-danger">{{ $errors->first('jaringan_eksisi-insisi') }}</small>
													</div>
											</div>
											<div class="form-group{{ $errors->has('diagnosa_pasca_op') ? ' has-error' : '' }}">
													{!! Form::label('diagnosa_pasca_op', 'Diagnosa Pasca Operasi', ['class' => 'col-sm-12']) !!}
													<div class="col-sm-12">
															{!! Form::textarea('diagnosa_pasca_op', $op->diagnosa_pasca_op, ['class' => 'form-control', 'style'=>'height:40px;']) !!}
															<small class="text-danger">{{ $errors->first('diagnosa_pasca_op') }}</small>
													</div>
											</div>
											<div class="form-group{{ $errors->has('laporan_operasi') ? ' has-error' : '' }}">
													{!! Form::label('laporan_operasi', 'Laporan (Prosedur, Temuan Spesifik, Komplikasi)', ['class' => 'col-sm-12']) !!}
													<div class="col-sm-12">
															{!! Form::textarea('laporan_operasi', $op->laporan_operasi, ['class' => 'form-control', 'style'=>'height:60px;']) !!}
															<small class="text-danger">{{ $errors->first('laporan_operasi') }}</small>
													</div>
											</div>

											
										</div>
										</div>
										<!---/ bawah------------------------------------->
										
										{!! Form::close() !!}
									@endif
								</div>
							</div>
							@if(count($detil_order)>0)
								@if(strtolower(Auth::user()->role()->first()->name)=='rawatinap')
									<!-- baris kiri -->
									<div class="col-md-6">
										{!! Form::open(['method' => 'POST', 'url' => 'operasi/simpan-order-operasi', 'class' => 'form-horizontal']) !!}
											{!! Form::hidden('registrasi_id', $reg->id) !!}
											{!! Form::hidden('rawatinap_id', $irna->id) !!}
											{!! Form::hidden('no_rm', $reg->pasien->no_rm) !!}
											<div class="form-group{{ $errors->has('rencana_operasi') ? ' has-error' : '' }}">
													{!! Form::label('rencana_operasi', 'Rencana Tanggal Operasi', ['class' => 'col-sm-6']) !!}
													<div class="col-sm-3">
															{!! Form::text('rencana_operasi', null, ['class' => 'form-control datepicker', 'readonly' => 'true']) !!}
															<small class="text-danger">{{ $errors->first('rencana_operasi') }}</small>
													</div>
											</div>
											<div class="form-group{{ $errors->has('jam_operasi') ? ' has-error' : '' }}">
													{!! Form::label('jam_operasi', 'Rencana Jam Operasi', ['class' => 'col-sm-6']) !!}
													<div class="col-sm-3">
															{!! Form::text('jam_operasi', null, ['class' => 'form-control timepicker', 'readonly' => 'true']) !!}
															<small class="text-danger">{{ $errors->first('jam_operasi') }}</small>
													</div>
											</div>
											<div class="form-group{{ $errors->has('nadi') ? ' has-error' : '' }}">
													{!! Form::label('nadi', 'Nadi(/mnt)', ['class' => 'col-sm-6']) !!}
													<div class="col-sm-3">
															{!! Form::text('nadi', null, ['class' => 'form-control' ]) !!}
															<small class="text-danger">{{ $errors->first('nadi') }}</small>
													</div>
											</div>
											<div class="form-group{{ $errors->has('respirasi') ? ' has-error' : '' }}">
													{!! Form::label('respirasi', 'Respirasi(/mnt)', ['class' => 'col-sm-6']) !!}
													<div class="col-sm-3">
															{!! Form::text('respirasi', null, ['class' => 'form-control' ]) !!}
															<small class="text-danger">{{ $errors->first('respirasi') }}</small>
													</div>
											</div>
									</div>
									<!-- baris kanan --> 
									<div class="col-md-6">
											<div class="form-group{{ $errors->has('suhu_tubuh') ? ' has-error' : '' }}">
													{!! Form::label('suhu_tubuh', 'Suhu Tubuh (C)', ['class' => 'col-sm-6']) !!}
													<div class="col-sm-3">
															{!! Form::text('suhu_tubuh', null, ['class' => 'form-control' ]) !!}
															<small class="text-danger">{{ $errors->first('suhu_tubuh') }}</small>
													</div>
											</div>
											<div class="form-group{{ $errors->has('tensi') ? ' has-error' : '' }}">
													{!! Form::label('tensi', 'Tensi Pasien', ['class' => 'col-sm-6']) !!}
													<div class="col-sm-3">
															{!! Form::text('tensi', $reg->tekanan_darah, ['class' => 'form-control']) !!}
															<small class="text-danger">{{ $errors->first('tensi') }}</small>
													</div>
											</div>
											<div class="form-group{{ $errors->has('tinggi') ? ' has-error' : '' }}">
													{!! Form::label('tinggi', 'Tinggi(Cm)', ['class' => 'col-sm-6']) !!}
													<div class="col-sm-3">
															{!! Form::text('tinggi', null, ['class' => 'form-control']) !!}
															<small class="text-danger">{{ $errors->first('tinggi') }}</small>
													</div>
											</div>
											<div class="form-group{{ $errors->has('berat') ? ' has-error' : '' }}">
													{!! Form::label('berat', 'Berat(Kg)', ['class' => 'col-sm-6']) !!}
													<div class="col-sm-3">
															{!! Form::text('berat', $reg->berat_badan, ['class' => 'form-control']) !!}
															<small class="text-danger">{{ $errors->first('berat') }}</small>
													</div>
											</div>
											<div class="form-group{{ $errors->has('gcs') ? ' has-error' : '' }}">
													{!! Form::label('gcs', 'GCS(E,V,M)', ['class' => 'col-sm-6']) !!}
													<div class="col-sm-3">
															{!! Form::text('gcs', null, ['class' => 'form-control']) !!}
															<small class="text-danger">{{ $errors->first('gcs') }}</small>
													</div>
											</div>
									</div>
									<div class="col-md-12">
											<div class="form-group{{ $errors->has('suspect') ? ' has-error' : '' }}">
													{!! Form::label('suspect', 'Catatan', ['class' => 'col-sm-12']) !!}
													<div class="col-sm-12">
															{!! Form::textarea('suspect', null, ['class' => 'form-control', 'style'=>'height:60px;']) !!}
															<small class="text-danger">{{ $errors->first('suspect') }}</small>
													</div>
											</div>
											<div class="form-group{{ $errors->has('keluhan') ? ' has-error' : '' }}">
													{!! Form::label('keluhan', 'Keluhan', ['class' => 'col-sm-12']) !!}
													<div class="col-sm-12">
															{!! Form::textarea('keluhan', $reg->anamnesis, ['class' => 'form-control', 'style'=>'height:60px;']) !!}
															<small class="text-danger">{{ $errors->first('keluhan') }}</small>
													</div>
											</div>
											<div class="form-group{{ $errors->has('penilaian') ? ' has-error' : '' }}">
													{!! Form::label('penilaian', 'Penilaian', ['class' => 'col-sm-12']) !!}
													<div class="col-sm-12">
															{!! Form::textarea('penilaian', null, ['class' => 'form-control', 'style'=>'height:60px;']) !!}
															<small class="text-danger">{{ $errors->first('penilaian') }}</small>
													</div>
											</div>
											<div class="form-group{{ $errors->has('tindak_lanjut') ? ' has-error' : '' }}">
													{!! Form::label('tindak_lanjut', 'Tindak Lanjut', ['class' => 'col-sm-12']) !!}
													<div class="col-sm-12">
															{!! Form::textarea('tindak_lanjut', null, ['class' => 'form-control', 'style'=>'height:60px;']) !!}
															<small class="text-danger">{{ $errors->first('tindak_lanjut') }}</small>
													</div>
											</div>

											<div class="btn-group pull-right">
													<a href="{{ url('rawat-inap/billing') }}" class="btn btn-warning btn-flat">BATAL</a>
													{!! Form::submit("ORDER IBS", ['class' => 'btn btn-success btn-flat']) !!}
											</div>
										{!! Form::close() !!}	
									</div>
								@endif
							@endif
						</div>
					</div>
				</div>
				<div class="tab-pane active" id="tab_pakaiobat">
					<div class="row">
						<div style="padding:;">
							<div class="col-md-12 no-padding">
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
															<select name="masterobat_id" id="" class="form-control select2ajaxdepo">
															</select>
															<small class="text-danger">{{ $errors->first('masterobat_id') }}</small>
														</div>
													</div>
													<div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
														{!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-12']) !!}
														<div class="col-sm-6">
															<input type="number" name="jumlah" value="1" class="form-control">
														</div>
													</div>
													<div class="form-group{{ $errors->has('informasi1') ? ' has-error' : '' }}">
														{!! Form::label('informasi1', 'Informasi 1', ['class' => 'col-sm-12']) !!}
														<div class="col-sm-12">
															{!! Form::text('informasi1', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
														</div>
													</div>
													<div class="form-group{{ $errors->has('informasi2') ? ' has-error' : '' }}">
														{!! Form::label('informasi2', 'Informasi 2', ['class' => 'col-sm-12', 'autocomplete' => 'off']) !!}
														<div class="col-sm-12">
															{!! Form::text('informasi2', null, ['class' => 'form-control']) !!}
														</div>
													</div>
													<div class="form-group{{ $errors->has('cetak') ? ' has-error' : '' }}">
														<div class="col-sm-12">
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
			</div>
		</div>
  </div>
@endsection
@section('script')
<script>
$('#div-right').css('height',(window.innerHeight-100));
$('.content').css('padding-right','0px');
$('#total_tagihan_text').html('Menghitung...');
function ribuan(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

setTimeout(function(){ 
	var element = document.getElementById("tab_pakaiobat");
	element.classList.remove("active");
}, 500);

setTimeout(function(){
	$('#total_tagihan_text').html('Rp. '+ribuan(parseInt($("#total_tagihan").val()) + parseInt(<?php echo session('total_obat'); ?>)));
}, 2000);

function changePpi(val){
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		type: 'POST',
		url: '/operasi/ppi',
		data: {
			ppi: val,
			registrasi_id: "{{$reg->id}}"
		},
		success: function (data) {
			
		}
	});
}

// master Obat
$('.select2').select2();
var table = null;
$('#tabpakaiobat').on('click', function () {
	table = getPemakaian();
});

function getPemakaian(){
	// view Detail
	var id = $('input[name="registrasi_id"]').val();
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
				$('input[name="informasi1"]').val("");
				$('input[name="informasi2"]').val("");
			}
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
					$("#tabpakaiobat").click();
				}else{
					alert("Item gagal dihapus");
				}
			}
		});
	}
})

$(function () {
	$('#rincian').DataTable({
	  'language'    : {
		"url": "/json/pasien.datatable-language.json",
	  },
	  'paging'      : false,
	  'lengthChange': false,
	  'searching'   : false,
	  'ordering'    : false,
	  'info'        : false,
	  'autoWidth'   : false
	});
});
</script>
@stop