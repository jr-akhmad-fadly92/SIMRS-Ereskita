<div id="list-pasien">
	@if($registrasi!=null)
  <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
    <thead>
      <tr>
        <th>No</th>
        <th>Antrian</th>
        <th>Nama Pasien</th>
        <th>No. RM</th>
        <th>Dokter</th>
        <!--th>Poli Tujuan</th-->
        <th>Cara Bayar</th>
        <th>Tgl Registrasi</th>
        {{--<th class="text-center">Lab</th>
        <th class="text-center">Rad</th>--}}
        <th class="text-center">Proses</th>
		<th class="text-center">Biaya</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
			@foreach($registrasi as $key => $d)
				<tr>
					<td>{{ $no++ }}</td>
					<td>
						<a href="#" onclick="clickPanggil('{{$d->id}}','{{$d->antrian_poli}}','{{$d->poli_id}}')" regid="{{$d->id}}" antrian="{{$d->antrian_poli}}" poli="{{$d->poli_id}}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-microphone"></i> - {{ $d->antrian_poli }}</a>
					</td>
					<td>{{ $d->pasien->nama }}</td>
					<td>{{ $d->pasien->no_rm }}</td>
					<td>{{ baca_dokter($d->dokter_id) }}</td>
					<!--td>{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td-->
					<td>{{ baca_carabayar($d->bayar) }}
						@if (!empty($d->tipe_jkn))
							- {{ $d->tipe_jkn }}
						@endif
					</td>
					<td>
						{{ $d->created_at->format('d-m-Y H:i:s') }}
					</td>
					{{--<td class="text-center">
						<a href="{{ url('tindakan/order/laboratorium/irj/'.$d->id) }}" onclick="return confirm('Yakin akan di order ke LAB?')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-flask"> </i></a>
					</td>
					<td class="text-center">
						<a href="{{ url('tindakan/order/radiologi/irj/'.$d->id) }}" onclick="return confirm('Yakin akan di order ke RADIOLOGI?')"  class="btn btn-primary btn-sm btn-flat"><i class="fa fa-television"> </i></a>
					</td>--}}
					<td class="text-center">
						<a href="{{ url('tindakan/entry/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-edit"></i></a>
					</td>
					<td class="text-center">
					<button type="button" id="Kondisi_Akhir_Pasien" data-id="{{ $d->id }}" data-namapasien="{{ $d->pasien->nama }}" data-rm="{{ $d->pasien->no_rm }}" data-alamat="{{ $d->pasien->alamat }}" data-status="{{substr($d->status_reg,0,1)}}"class="btn btn-primary btn-sm btn-flat">
                    <i class="fa fa-money"></i>
                  	</button>
					<td>
						{{ $d->posisi_pasien }}
					</td>
				</tr>
			@endforeach
    </tbody>
  </table>
	@else
		@if(session('poli_id')==0)
			<center><b>---</center>
			<center><b>Silahkan filter poli terlebih dahulu</center>
			<center><b>---</center>
		@endif
	@endif
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
					<th align="center">Nama Pasien</th>
					<th align="center">No. RM</th>
					<th align="center">Alamat</th>
					<th align="center">Status Reg</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td align="center"><label name="namapasien"></label></td>
					<td align="center"><label name="rm"></label></td>
					<td align="center"><label name="alamat"></label></td>
					<td align="center"><label name="status"></label></td>
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
						<center><h4 style="font-weight:bold;">Total Biaya</h4></center>
						<input type="text" name="total_biaya" value="" class="col-12 form-control" style="font-size:24px;font-weight:bold; text-align: center;" readonly>
						</div>
					</div>
          </div>
		  <br><br><br>
		  
	    </div>
       
      </div>
    </div>
  	</div>
@section('script')
<script>
function clickPanggil(regid,antrian,poli){
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		type: 'POST',
		url: '/antrian/poli',
		data: {regid: regid, antrian: antrian, poli: poli},
		success: function (data) {
			if(data.status){
				
			}else{
				alert(data.message);
			}
		}
	});
}
$('#Kondisi_Akhir_Pasien').on('click', function () {
		
		$('#konfirmasi_pembayaran').modal('show');
		var id = $(this).attr('data-id');
	
		$('label[name="namapasien"]').text($(this).attr('data-namapasien'));
		$('label[name="rm"]').text($(this).attr('data-rm'));
		$('label[name="alamat"]').text($(this).attr('data-alamat'));
		
		if($(this).attr('data-status')=='J')
		{
			$('label[name="status"]').text('Rawat Jalan');
		}else if($(this).attr('data-status')=='I')
		{
			$('label[name="status"]').text('Rawat Inap');
		}else{
			$('label[name="status"]').text('Rawat Darurat');
		}
	
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
			ajax: '{{url('/tindakan/get_data_biaya/')}}'+'/'+id,
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
			ajax: '{{url('/tindakan/get_data_biaya_obat/')}}'+'/'+id,
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
						ajax: '{{url('/tindakan/get_data_biaya_pemakaian_obat/')}}'+'/'+id,
						columns: [
									{data: 'rownum'},
									{data: 'nama'},
									{data: 'jumlah'},
									{data: 'total'},
						]
					});
		$.ajax({
			type: 'get',
			url: '{{url('/tindakan/get_total_biaya/')}}'+'/'+id,
			data: id,
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					
				}else if(data.sukses == true){
					$('input[name="total_biaya"]').val(data.folio);
				}
			}
		});
});
</script>



@endsection