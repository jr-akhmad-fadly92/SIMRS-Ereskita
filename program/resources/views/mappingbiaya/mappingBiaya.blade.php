@extends('master')
@section('header')
  <h1>Master Mapping Rincian Biaya</h1>    
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Mapping Rincian Biaya</h3>
            <a href="{{ url('mapping-biaya') }}" class="btn btn-default btn-flat"><i class="fa fa-backward"></i> Kembali</a>
        </div>
        <div class="box-body">
            <form class="form-horizontal" action="{{ url('simpan-mapping-biaya') }}"  method="post">
								<div class="col-md-6 no-padding">
									<div class="bg-grey" style="padding:10px 0;">
											<div class="form-group no-margin">
													<div class="col-md-4 no-padding">
														<select name="kategoritarif" id="kategoritarif" class="form-control select2" onchange="changeFilter()">
																<option value="NULL">-- Pilih Kategori --</option>
																@foreach (Modules\Kategoritarif\Entities\Kategoritarif::get() as $d)
																		<option {{ ($kategori==$d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->namatarif }}</option>
																@endforeach
														</select>
													</div>
											</div>
									</div>
								</div>
								<div class="col-md-6 no-padding">
									{{ csrf_field() }} {{ method_field('POST') }}
									<div class="bg-aqua-active" style="padding:10px 0;">
											<div class="form-group no-margin {{ $errors->has('mapping_biaya_id') ? ' has-error' : '' }}">
													<div class="col-md-10">
															<select name="mapping_biaya_id" class="form-control select2">
																	<option value="">-- Pilih Group Tarif --</option>
																	@foreach ($master_biaya_id as $d)
																			<option {{ (session('group')==$d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->kelompok }}</option>
																	@endforeach
															</select>
															<small class="text-danger">{{ $errors->first('mapping_biaya_id') }}</small>
													</div>
													<div class="col-md-2 no-padding">
														<input type="submit" name="submit" value="SIMPAN" class="btn btn-default btn-flat">
													</div>
											</div>
									</div>                
								</div>                
                <div class="col-md-12">
									<br>
									<a style="position:fixed;right:40%;bottom:20px;z-index:100;" href="#" class="btn btn-flat btn-warning btn-sm" onclick="checkAll()">Pilih Semua</a>
								</div>                
                <div class="row">
                    <div class="col-md-6">
                        <div class='table-responsive'>
                          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Nama Tarif</th>
                                <th>Tarif Kelas VIP</th>
                                <th>Tarif Kelas 1</th>
                                <th>Tarif Kelas 2</th>
                                <th>Tarif Kelas 3</th>
                                <th>Tarif Kelas RJ</th>
                                <th>#</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataKiri as $key => $d)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $d->nama }}</td>
                                        <td class="text-right">{{ number_format($d->tarif_kelas_vip) }}</td>
                                        <td class="text-right">{{ number_format($d->tarif_kelas_1) }}</td>
                                        <td class="text-right">{{ number_format($d->tarif_kelas_2) }}</td>
                                        <td class="text-right">{{ number_format($d->tarif_kelas_3) }}</td>
                                        <td class="text-right">{{ number_format($d->tarif_kelas_rj) }}</td>
                                        <td>
                                            <input type="checkbox" class="flat-col" id="ck1" style="cursor:pointer" name="tarif{{ $no }}" value="{{ $d->id }}">
                                        </td>
                                    </tr>
                                    @php
                                        $no++;
                                    @endphp
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class='table-responsive'>
                          <table class='table table-striped table-bordered table-hover table-condensed' id="data2">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Nama Tarif</th>
                                <th>Tarif Kelas VIP</th>
                                <th>Tarif Kelas 1</th>
                                <th>Tarif Kelas 2</th>
                                <th>Tarif Kelas 3</th>
                                <th>Tarif Kelas RJ</th>
                                <th>#</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataKanan as $key => $d)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $d->nama }}</td>
                                        <td class="text-right">{{ number_format($d->tarif_kelas_vip) }}</td>
                                        <td class="text-right">{{ number_format($d->tarif_kelas_1) }}</td>
                                        <td class="text-right">{{ number_format($d->tarif_kelas_2) }}</td>
                                        <td class="text-right">{{ number_format($d->tarif_kelas_3) }}</td>
                                        <td class="text-right">{{ number_format($d->tarif_kelas_rj) }}</td>
                                        <td>
                                            <input type="checkbox" class="flat-col" id="ck2" style="cursor:pointer" name="tarif{{ $no }}" value="{{ $d->id }}">
                                        </td>
                                    </tr>
                                    @php
                                        $no++;
                                    @endphp
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                        <input type="hidden" name="total" value="{{ count($tarif) }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script>
function changeFilter(){
  window.location = "/mapping-biaya-tarif/"+$('#kategoritarif').val();
}
$(function () {
	$('#data2').DataTable({
		'searching'   : true
	});
});
function checkAll(){
	var inputs = document.getElementsByTagName("input");
	for (var i = 0; i < inputs.length; i++) { 
		if (inputs[i].type == "checkbox") { 
			if(inputs[i].checked){
				inputs[i].checked = false;
			}else{
				inputs[i].checked = true;
			}
		}  
	}
	return false;
}
</script>
@stop