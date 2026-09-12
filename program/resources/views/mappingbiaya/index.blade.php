@extends('master')
@section('header')
  <h1>Master Mapping Rincian Biaya</h1>
@endsection

@section('content')

  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
				Master Mapping/Group Rincian Biaya
				<a href="{{ url('mapping-biaya-tarif') }}" class="btn btn-default btn-flat">BUAT MAPPING BARU</a>
      </h3>
    </div>
    <div class="box-body">
			<div class="col-md-10 no-padding">
				<div class="bg-aqua-active" style="padding:10px;min-height:55px;height:auto;">
					<form class="form-horizontal" action="{{ url('simpan-mapping-group') }}"  method="post">
						{{ csrf_field() }} {{ method_field('POST') }}
						<div class="col-md-3 col-sm-3 col-xs-3 no-padding">
							<select name="kategoritarif" id="kategoritarif" class="form-control chosen-select" onchange="changeJenis(this.value)">
									<option value="">-- Pilih Kategori Tarif --</option>
									@foreach ($kategori_tarif as $d)
											<option {{(session('kategoritarif')==$d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->namatarif }}</option>
									@endforeach
							</select>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 no-padding">
							@if(session('jenislab')!="")
							@elseif(session('jenisradiologi')!="")
							@else
							@endif
								<select name="jenislab" id="jenislab" class="form-control" style="display:{{ (session('jenislab')!="") ? '' : 'none' }};">
										<option value="">-- Pilih Jenis Lab --</option>
										@foreach (App\Labsection::get() as $d)
												<option {{(session('jenislab')==$d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->nama }}</option>
										@endforeach
								</select>
								<select name="jenisradiologi" id="jenisradiologi" class="form-control" style="display:{{ (session('jenisradiologi')!="") ? '' : 'none' }};">
										<option value="">-- Pilih Jenis Radiologi --</option>
										@foreach (App\TindakanRadiologi::get() as $d)
												<option {{(session('jenisradiologi')==$d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->tindakan_radiologi }}</option>
										@endforeach
								</select>
								<input type="text" id="id-null" value="NULL" disabled class="form-control" style="display:{{ (session('jenislab')=="" && session('jenisradiologi')=="") ? '' : 'none' }};">
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4 no-padding" style="padding-right:5px!important;">
							{!! Form::text('mapping_group', null, ['class' => 'form-control', 'placeholder'=>'Tuliskan nama group...']) !!}
							<small class="text-danger">{{ $errors->first('mapping_group') }}</small>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 no-padding">
							<input type="submit" name="submit" value="TAMBAH GROUP" class="btn btn-default btn-block btn-flat">								
						</div>
					</form>
				</div>
			</div>
      <div class="row">
        <div class="col-md-12">
					<hr>
          <div>
            <table class="table table-bordered table-condensed table-hover" id="dataMappingBiaya">
              <thead>
                <tr>
                  <!--th>No</th-->
                  <th>Kategori</th>
                  <th>Kelompok / Group</th>
                  <th>Jumlah Tindakan</th>
                  <th>Aksi</th>
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

@endsection

@section('script')
<script type="text/javascript">
	function changeJenis(val){
		//alert(val);
		if(val==2 || val==3){
			if(val==2){
				$("#jenislab").show();
				$("#jenisradiologi").hide();
				$("#id-null").hide();
			}else if(val==3){
				$("#jenislab").hide();
				$("#jenisradiologi").show();
				$("#id-null").hide();
			}
		}else{
			$("#jenislab").hide();
			$("#jenisradiologi").hide();
			$("#id-null").show();
		}
	}
	
  $('#dataMappingBiaya').DataTable({
		'language': {
				"url": "/json/pasien.datatable-language.json",
		},
		paging      : true,
		lengthChange: true,
		searching   : false,
		ordering    : false,
		info        : false,
		autoWidth   : false,
		destroy     : true,
		processing  : true,
		serverSide  : true,
		ajax: '/data-mapping-biaya',
		columns: [
				{data: 'kategoritarif_id'},
				{data: 'kelompok'},
				{data: 'jumlah'},
				{data: 'mapping'}
		]
	});

</script>
@endsection
