@extends('master')

@section('header')
  <h1>Ubah DPJP </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <div class='table-responsive'>
				<div class="col-md-6">
					<form class="form-horizontal" method="post">
						<div class="row">
								<div class="col-md-6 col-sm-6">
										<div class="form-group no-margin">
											<label for="tanggal" class="col-sm-3 control-label no-margin no-padding">Tanggal Awal</label>
											<div class="col-sm-9">
													<input type="text" name="tga" class="form-control datepicker" id="" placeholder="">
													<span class="text-danger"></p>
											</div>
										</div>
								</div>
								<div class="col-md-6 col-sm-6">
										<div class="form-group no-margin">
											<label for="tanggal" class="col-sm-3 control-label no-margin no-padding">Tanggal Awal</label>
											<div class="col-sm-9">
													<input type="text" name="tgb" class="form-control datepicker" id="" placeholder="">
													<span class="text-danger"></p>
											</div>
										</div>
								</div>
						</div>
				</form>
				</div>
        <table class='table table-striped table-bordered table-hover table-condensed' id='dataUbahDpjp'>
          <thead>
            <tr>
              <th>NO. RM</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Klinik Tujuan</th>
              <th>Cara Bayar</th> {{--ubah cara bayar --}}
              <th>Dokter</th> {{--ubah cara bayar --}}
              <th>Ubah</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <br>
    </div>
  </div>

  <div class="modal fade" id="ubahDpjpModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
					<div class='table-responsive'>
						<table class='table table-striped table-bordered table-hover table-condensed'>
							<tbody>
									<tr>
										<th>No. RM</th> <td id="norm"></td>
									</tr>
								<tr>
									<th>Nama</th> <td id="nama"></td>
								</tr>
								<tr>
									<th>Alamat</th> <td id="alamat"></td>
								</tr>
								<tr>
									<th>Poli Tujuan</th> <td id="poli"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<form class="form-horizontal" id="formDpjp" method="post">
						{{ csrf_field() }} {{ method_field('POST') }}
						<input type="hidden" name="id" value="">
						<div class="form-group" id="poliGroup">
							<label for="poli_id" class="col-sm-3 control-label">Poli Tujuan</label>
							<div class="col-sm-9">
								<select class="form-control select2" name="poli_id" style="width:100%">
										<option value="">-- pilih poli --</option>
										@foreach (Modules\Poli\Entities\Poli::select('id', 'nama')->get() as $key => $d)
												<option value="{{ $d->id }}">{{ $d->nama }}</option>
										@endforeach
								</select>
								<span class="text-danger" id="poliError"></p>
							</div>
						</div>

						<div class="form-group" id="bayarGroup">
							<label for="carabayar" class="col-sm-3 control-label">Cara Bayar</label>
							<div class="col-sm-9">
									<select class="form-control" name="carabayar" onchange="caraBayar(this.value)">
											@foreach (Modules\Registrasi\Entities\Carabayar::select('id', 'carabayar')->get() as $key => $d)
													<option value="{{ $d->id }}">{{ $d->carabayar }}</option>
											@endforeach
									</select>
									<span class="text-danger" id="carabayarError"></p>
							</div>
						</div>
						<div id="asuransi" style="display:none;">
							<div class="form-group{{ $errors->has('asuransi_id') ? ' has-error' : '' }}">
									{!! Form::label('asuransi_id', 'Asuransi', ['class' => 'col-sm-3 control-label']) !!}
									<div class="col-sm-9">
											{!! Form::select('asuransi_id', Modules\Asuransi\Entities\Asuransi::pluck('nama','id'), null, ['class' => 'form-control select2', 'style' => 'width:100%;']) !!}
											<small class="text-danger">{{ $errors->first('asuransi_id') }}</small>
									</div>
							</div>
						</div>

						<div class="form-group" id="tipeJKNGroup">
							<label for="tipe_jkn" class="col-sm-3 control-label">Tipe JKN</label>
							<div class="col-sm-9">
									<select class="form-control" name="tipe_jkn">
											<option value=""></option>
											<option value="PBI">PBI</option>
											<option value="NON PBI">NON PBI</option>
									</select>
									<span class="text-danger" id="tipe_jknError"></p>
							</div>
						</div>

						<div class="form-group" id="bayarGroup">
							<label for="carabayar" class="col-sm-3 control-label">Dokter DPJP</label>
							<div class="col-sm-9">
								<select class="form-control select2" name="dokter_id" style="width:100%">
									@foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->select('id', 'nama')->get() as $key => $d)
										<option value="{{ $d->id }}">{{ $d->nama }}</option>
									@endforeach
								</select>
								<span class="text-danger" id="carabayarError"></p>
							</div>
						</div>
					</form>
        </div>
        <div class="modal-footer">
					<div class="btn-groups">
						<button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">SELESAI</button>
						<button type="button" id="saveDpjp" class="btn btn-success btn-flat">SIMPAN</button>
					</div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
function caraBayar(val){
	if(val==3){
		$("#asuransi").show();
	}else{
		$("#asuransi").hide();
	}
}
$(document).ready(function() {
		var tga = $('input[name="tga"]').val();
		var tgb = $('input[name="tga"]').val();

		if(tga !='' && tga !='')            {
				url = '/frontoffice-data-ubah-dpjp/'+tga+'/'+tgb;
		} else {
				url = '/frontoffice-data-ubah-dpjp';
		}

		var table;
		table = $('#dataUbahDpjp').DataTable({
				'language'    : {
					"url": "/json/pasien.datatable-language.json",
				},

				paging      : true,
				lengthChange: false,
				searching   : true,
				ordering    : false,
				info        : false,
				autoWidth   : false,
				destroy     : true,
				processing  : true,
				serverSide  : true,
				ajax: url,
				columns: [
					{data: 'no_rm'},
					{data: 'nama'},
					{data: 'alamat'},
					{data: 'poli'},
					{data: 'bayar'},
					{data: 'dokter'},
					{data: 'ubah'},
			]
		});
});

//FILTER TANGGAL
$('input[name="tgb"]').on('change', function() {
		var tga = $('input[name="tga"]').val()
		var tgb = $(this).val();

		$('#dataUbahDpjp').empty();
		$('#dataUbahDpjp').DataTable({
				'language'    : {
					"url": "/json/pasien.datatable-language.json",
				},

				destroy     : true,
				paging      : true,
				lengthChange: false,
				searching   : true,
				ordering    : false,
				info        : false,
				autoWidth   : false,
				processing  : true,
				serverSide  : true,
				ajax: '/frontoffice-data-ubah-dpjp/'+tga+'/'+tgb,
				columns: [
					{data: 'no_rm'},
					{data: 'nama'},
					{data: 'alamat'},
					{data: 'poli'},
					{data: 'bayar'},
					{data: 'dokter'},
					{data: 'ubah'},
			]
		});
});
//SET JKN PBI NON PBI
$('select[name="carabayar"]').on('change', function() {
		if($(this).val() == 1) {
				$('select[name="tipe_jkn"]').removeAttr('disabled');
		} else {
				$('select[name="tipe_jkn"]').attr('disabled', 'disabled');
		}
})
//FORM UBAH DPJP
function ubahDpjp(id) {
		$('#ubahDpjpModal').modal('show');
		$('.modal-title').text('Ubah DPJP');

		$.ajax({
				url: '/frontoffice-data-detail-reg/'+id,
				type: 'GET',
				dataType: 'json',
				success: function (data) {
						console.log(data);
						$('select[name="carabayar"]').val(data.bayar);
						$('select[name="poli_id"]').val(data.poli_id);
						$('select[name="poli_id"]').select2().trigger('change');
						$('select[name="tipe_jkn"]').val(data.tipe_jkn);
						$('select[name="dokter_id"]').val(data.dokter_id);
						$('select[name="dokter_id"]').select2().trigger('change');
						$('input[name="id"]').val(data.id);

						$('#tipeJKNGroup').removeClass('has-error');
						$('#tipe_jknError').html('');

						$('#norm').html(data.no_rm);
						$('#nama').html(data.nama);
						$('#alamat').html(data.alamat);
						$('#poli').html(data.poli);

						if($('select[name="carabayar"]').val() == 1) {
								$('select[name="tipe_jkn"]').removeAttr('disabled');
								$('select[name="tipe_jkn"]').attr('required', true);
						} else if($('select[name="carabayar"]').val() == 3) {
								$("#asuransi").show();
								$('select[name="asuransi_id"]').val(data.asuransi_id);
								$('select[name="asuransi_id"]').select2().trigger('change');
								$('select[name="tipe_jkn"]').attr('disabled', 'disabled');
						} else {
								$('select[name="tipe_jkn"]').attr('disabled', 'disabled');
						}
				}
		});
};

//SAVE UBAH DPJP
$(document).on('click', '#saveDpjp', function(e) {
	e.preventDefault();
	$.ajax({
		url: '/frontoffice/supervisor/saveubahdpjp',
		type: 'POST',
		dataType: 'json',
		data: $('#formDpjp').serialize(),
		success: function (data) {
			console.log(data);
			if(!data.sukses) {
				if(data.full){
					alert(data.message);
				}else{
					$('#tipeJKNGroup').addClass('has-error');
					$('#tipe_jknError').html(data.errors.tipe_jkn[0]);
				}
			}else{
				if(data.admission){
					window.open("/frontoffice/cetak_antrian/0/"+data.data.id,'popUpWindow','height=400,width=600,left=10,top=10,,scrollbars=yes,menubar=no');
				}else{
					$('#ubahDpjpModal').modal('hide');
				}
				location.reload();
			}
		}
	});
})
</script>

@endsection
