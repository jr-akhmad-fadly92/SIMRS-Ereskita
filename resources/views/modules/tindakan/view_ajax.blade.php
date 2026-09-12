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
        <th>Lab</th>
        <th>Rad</th>
        <th>Proses</th>
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
					<td class="text-center">
						<a href="{{ url('tindakan/order/laboratorium/irj/'.$d->id) }}" onclick="return confirm('Yakin akan di order ke LAB?')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-flask"> </i></a>
					</td>
					<td class="text-center">
						<a href="{{ url('tindakan/order/radiologi/irj/'.$d->id) }}" onclick="return confirm('Yakin akan di order ke RADIOLOGI?')"  class="btn btn-primary btn-sm btn-flat"><i class="fa fa-television"> </i></a>
					</td>
					<td>
						<a href="{{ url('tindakan/entry/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-edit"></i></a>
					</td>
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
</script>
@endsection