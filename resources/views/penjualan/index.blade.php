@extends('master')
@section('header')
  <h1>
		@if(isset($epo))
			@if($epo)
				Permintaan Rawat Inap
			@endif
		@else
			Penjualan Rawat Inap
		@endif
	</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Periode Tanggal &nbsp;
      </h3>
    </div>
    <div class="box-body">
			@if(isset($epo))
				{!! Form::open(['method' => 'POST', 'url' => 'penjualan/epo', 'class'=>'form-hosizontal']) !!}
			@else
				{!! Form::open(['method' => 'POST', 'url' => 'penjualan', 'class'=>'form-hosizontal']) !!}
			@endif
      <div class="row">
        <div class="col-md-6">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>

			@if (isset($data))
			 <div class='table-responsive'>
				 <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
					 <thead>
						 <tr>
							 <th>No</th>
							 <th>No Reg</th>
							 <th>No RM</th>
							 <th>Nama</th>
							 <th>Tgl Lahir</th>
							 <th>Alamat</th>
							 <th>Tgl Reg</th>
							 @if(isset($epo))
								 <th>Proses</th>
								 <th>Telaah</th>
								 <th>Status</th>
							 @else
								 <th>Proses</th>
								 <th>Resep</th>
								 <th>Rincian</th>
								 <th>Etiket</th>
								 <th>Telaah</th>
								 @if(strtolower(Auth::user()->role()->first()->name)=='supervisor-apotik')
									<th>Retur</th>
								 @endif
							 @endif
						 </tr>
					 </thead>
					 <tbody>
						@php
							$form = "formpenjualan";
							if(isset($epo)){
								if($epo){
									$form = "formpermintaan";
								}
							}
						@endphp
						@foreach ($data as $key => $d)
								@php
									if(isset($epo)){
										if($epo){
											$pending = App\Permintaanobat::where('registrasi_id', $d->id)->orderBy('created_at', 'asc')->get();
											$penjualan = App\Permintaanobat::where('registrasi_id', $d->id)->whereIn('status', ['selesai'])->orderBy('created_at', 'asc')->get();
										}
									}else{
										$pending = App\Penjualan::where('registrasi_id', $d->id)->whereIn('status', ['pending','proses'])->orderBy('created_at', 'asc')->get();
										$penjualan = App\Penjualan::where('registrasi_id', $d->id)->whereIn('status', ['selesai'])->orderBy('created_at', 'asc')->get();
									}
								@endphp
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $d->reg_id }}</td>
									<td>{{ $d->pasien->no_rm }}</td>
									<td>{{ $d->pasien->nama }}</td>
									<td>{{ tgl_indo($d->pasien->tgllahir) }}</td>
									<td>{{ $d->pasien->alamat }}</td>
									<td>{{ date_format(date_create($d->tgl_regis), 'd-m-Y') }}</td>
									@if(isset($epo))
										<td>
											@foreach ($pending as $xd)
												<a href="{{ url('penjualan/'.$form.'/'.$d->pasien->id).'/'.$d->id }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-check"></i></a>
											@endforeach
										</td>
										<td>
											<a href="{{ url('farmasi/telaah-resep/epo/'.$d->id) }}" class="btn btn-warning btn-flat btn-sm"> <i class="fa fa-check-square"></i> </a>
										</td>
										<td>
											{{ $d->status }}
										</td>
									@else
										<td>
											@foreach ($penjualan as $dtl)
												@if($d->penjualan_bebas_apotek==1)
													<a href="{{ url('penjualan/formpenjualan/'.$d->pasien->id.'/'.$d->registrasi_id.'/'.$dtl->id.'/bebas') }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-check"></i></a>
												@else
													<a href="{{ url('penjualan/formpenjualan/'.$d->pasien->id.'/'.$d->registrasi_id) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-check"></i></a>
												@endif
											@endforeach
										</td>
										<td>
											@foreach ($penjualan as $dtl)
												<a target="_blank" href="{{ url('farmasi/cetak-resep/'.$dtl->id) }}" class="btn bg-pink btn-flat 	btn-sm"> <i class="fa fa-print"></i> </a>
											@endforeach
										</td>
										<td>
											@foreach ($penjualan as $dtl)
												<a href="{{ url('farmasi/cetak-detail/'.$dtl->id) }}" class="btn btn-danger btn-flat btn-sm"> <i class="fa fa-file-pdf-o"></i> </a>
											@endforeach
										</td>
										<td>
											@foreach ($penjualan as $det)
												<a href="{{ url('farmasi/laporan/etiket/rj/'.$det->id) }}" class="btn btn-primary btn-flat btn-sm"> <i class="fa fa-print"></i> </a>
											@endforeach
										</td>
										<td>
											@if($d->penjualan_bebas_apotek==null)
												@foreach ($penjualan as $det)
													<a href="{{ url('farmasi/telaah-resep/resep/'.$d->id) }}" class="btn btn-warning btn-flat btn-sm"> <i class="fa fa-check-square"></i> </a>
												@endforeach
											@endif
										</td>
										<td>
											@if($d->penjualan_bebas_apotek==null AND (strtolower(Auth::user()->role()->first()->name)=='supervisor-apotik'))
												<a href="{{ url('resep-retur/'.$d->pasien->id.'/'.$d->registrasi_id) }}" class="btn btn-danger btn-flat btn-sm"> <i class="fa fa-undo"></i> </a>
											@endif
										</td>
									@endif
								</tr>
							@endforeach
						 </tbody>
				 </table>
			 </div>
			@endif
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
function updatePenjualan(penjualan_id) {
	$('#penjualanDetail').modal('show');
	$('#tambahObat').modal('hide')
	$('.modal-title').text('Update Penjualan Obat');
	$('#loadPenjualanDetail').load('/detail-penjualan/'+penjualan_id);
	$('.addPenjualan').attr('onclick', 'tambahObat('+penjualan_id+')');
}

function hapusObat(id){
	$.ajax({
		url: '/hapus-detail-penjualan/'+id,
		type: 'GET',
		dataType: 'json',
		success: function (data) {
			if (data.sukses == true) {
				$('#penjualanDetail').modal('show');
				$('.modal-title').text('Update Penjualan Obat');
				$('#loadPenjualanDetail').load('/detail-penjualan/'+data.penjualan_id);
			}
		}
	});
}

function tambahObat(penjualan_id) {
	$('#penjualanDetail').modal('hide');
	$('#tambahObat').modal('show')
	$('.modal-title').text('Tambah Obat')
	$('#loadTambahPenjualan').load('/tambah-detail-penjualan/'+penjualan_id);
	$('.closeAddObat').attr('onclick', 'updatePenjualan('+penjualan_id+')');
}

function saveObat() {
	var data = $('#formTambahPenjualan').serialize();
	$.ajax({
		url: '/simpan-detail-penjualan',
		type: 'POST',
		dataType: 'json',
		data: data,
		success: function (data) {
			if (data.sukses == true) {
				updatePenjualan(data.penjualan_id)
			} else {
				updatePenjualan(data.penjualan_id)
			}
		}
	});      
}
	
$(document).on('click', '.retur-det-res', function(e) {
	e.preventDefault();
	var id = $(this).attr('data-id');
	var alasan = prompt("Apakah yakin item ini akan diretur? Silahkan masukan alasan:");
	if(alasan!=null){
		$.ajax({
			url: '/resep-retur/'+id+'/'+encodeURI(alasan),
			type: 'GET',
			success: function (data) {
				if(data.sukses == true) {
					alert("Item berhasil diretur");
					location.reload();
				}else{
					alert("Item gagal diretur");
				}
			}
		});
	}
})
</script>
@endsection

