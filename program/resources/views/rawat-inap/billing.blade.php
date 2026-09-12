@extends('master')
@section('header')
  <h1>Rawat Inap - Penata Jasa <small></small></h1>
@endsection


@section('content')
<style>
.datepicker {
    z-index: 1111!important;
}
</style>
  <div class="box box-primary">
    <div class="box-body">
      @if ($inap->count() > 0)
      <div class='table-responsiv'>
				<div class="col-md-6 pull-left no-padding text-green">
					<h4 style="margin-top:5px;"><b>Pasien Dalam Perawatan</b></h4>
				</div>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th class="text-center" style="vertical-align: middle">No</th>
              <th class="text-center" style="vertical-align: middle">NO. RM</th>
              <th class="text-center" style="vertical-align: middle">NAMA</th>
              <th class="text-center" style="vertical-align: middle">KELAS/KAMAR</th>
              <th class="text-center" style="vertical-align: middle">CARA BAYAR</th>
              <th class="text-center" style="vertical-align: middle">TGL MASUK</th>
              <th class="text-center" style="vertical-align: middle">ENTRY</th>
              <th class="text-center" style="vertical-align: middle">LAB</th>
              <th class="text-center" style="vertical-align: middle">RAD</th>
              <th class="text-center" style="vertical-align: middle">IBS</th>
              <th class="text-center" style="vertical-align: middle">GIZI</th>
              <th class="text-center" style="vertical-align: middle">FIS</th>
              <th class="text-center" style="vertical-align: middle">MUT</th>
              <th class="text-center" style="vertical-align: middle">RB</th>
              <th class="text-center" style="vertical-align: middle">STATUS</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($inap as $key => $d)
							@if(in_array($d->posisi_pasien,['rawat inap','sedang diperiksa']))
								@php
									$reg = Modules\Registrasi\Entities\Registrasi::where('id', $d->registrasi_id)->first();
								@endphp
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $reg->pasien->no_rm }}</td>
									<td>{{ $reg->pasien->nama }}</td>
									<td>{{ baca_kelas($d->kelas_id) }} / {{ baca_kamar($d->kamar_id) }} / {{ baca_bed($d->bed_id) }}</td>
									<td>{{ baca_carabayar($reg->bayar) }} {{ !empty($reg->tipe_jkn) ? ' - '.$reg->tipe_jkn : '' }}</td>
									<td>{{ tanggal_eklaim($d->tgl_masuk) }}</td>
									<td  class="text-center">
										<a href="{{ url('tindakan/entry/'.$d->registrasi_id.'/'.$reg->pasien->id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i> </a>
									</td>
									<td class="text-center">
										<a href="{{ url('tindakan/order/laboratorium/irna/'.$reg->id) }}" onclick="return confirm('Yakin akan di order ke LAB?')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-flask"> </i></a>
									</td>
									<td class="text-center">
										<a href="{{ url('tindakan/order/radiologi/irna/'.$reg->id) }}" onclick="return confirm('Yakin akan di order ke RADIOLOGI?')"  class="btn btn-primary btn-sm btn-flat"><i class="fa fa-television"> </i></a>
									</td>
									<td class="text-center">
										<a href="{{ url('operasi/tindakan/'.$reg->id) }}" onclick="return confirm('Yakin akan di order ke IBS?')"  class="btn btn-success btn-sm btn-flat"><i class="fa fa-cut"></i></a>
									</td>
									<td class="text-center">
										<a href="{{ url('rawat-inap/gizi/'.$reg->id) }}" onclick="return confirm('Yakin akan di order ke GIZI?')"  class="btn btn-success btn-sm btn-flat"><i class="fa fa-cutlery"></i></a>
									</td>
									<td>
										<a href="{{ url('tindakan/order/penunjang/fis/irna/'.$reg->id) }}" onclick="return confirm('Yakin akan di order ke FISIOTERAPI?')"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-wheelchair"></i></a>
									</td>
									<td class="text-center">
										<a href="{{ url('rawat-inap/mutasi/'.$reg->id) }}" onclick="return confirm('Yakin akan di Mutasi?')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-recycle"></i></a>
									</td>
									<td>
										<button type="button" onclick="rincianBiaya({{ $reg->id }}, '{{ $reg->pasien->nama }}', {{ $reg->pasien->no_rm }} , '{{ substr($reg->status_reg,0,1) }}' )" class="btn btn-info btn-sm btn-flat"><i class="fa fa-search"></i> </button>
									</td>
									<td>
										@php
											$warna = 'red';
										@endphp
										<span style="font-weight:bold;color:{{$warna}};">{{ ucwords($reg->posisi_pasien) }}</span>
									</td>
								</tr>
							@endif
            @endforeach
          </tbody>
        </table>
      </div>
      @endif			
			<hr>
			@php $no=1; @endphp
			@if ($inap->count() > 0)
      <div class='table-responsiv'>
				<div class="col-md-6 pull-left no-padding text-green">
					<h4><b>Pasien Sudah Dipulangkan</b></h4>
				</div>
        <table class='table table-striped table-bordered table-hover table-condensed' id='datax'>
          <thead>
            <tr>
              <th class="text-center" style="vertical-align: middle">No</th>
              <th class="text-center" style="vertical-align: middle">NO. RM</th>
              <th class="text-center" style="vertical-align: middle">NAMA</th>
              <th class="text-center" style="vertical-align: middle">KELAS/KAMAR</th>
              <th class="text-center" style="vertical-align: middle">CARA BAYAR</th>
              <th class="text-center" style="vertical-align: middle">TGL MASUK</th>
              <th class="text-center" style="vertical-align: middle">ENTRY</th>
              <th class="text-center" style="vertical-align: middle">LAB</th>
              <th class="text-center" style="vertical-align: middle">RAD</th>
              <th class="text-center" style="vertical-align: middle">IBS</th>
              <th class="text-center" style="vertical-align: middle">GIZI</th>
              <th class="text-center" style="vertical-align: middle">FIS</th>
              <!--th class="text-center" style="vertical-align: middle">VK</th-->
              <th class="text-center" style="vertical-align: middle">MUT</th>
              <!--th class="text-center" style="vertical-align: middle">PULANG</th-->
              <th class="text-center" style="vertical-align: middle">RB</th>
              <th class="text-center" style="vertical-align: middle">STATUS</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($inap as $key => $d)
							@if(!in_array($d->posisi_pasien,['rawat inap','sedang diperiksa']))
								@php
									$reg = Modules\Registrasi\Entities\Registrasi::where('id', $d->registrasi_id)->first();
								@endphp
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $reg->pasien->no_rm }}</td>
									<td>{{ $reg->pasien->nama }}</td>
									<td>{{ baca_kelas($d->kelas_id) }} / {{ baca_kamar($d->kamar_id) }} / {{ baca_bed($d->bed_id) }}</td>
									<td>{{ baca_carabayar($reg->bayar) }} {{ !empty($reg->tipe_jkn) ? ' - '.$reg->tipe_jkn : '' }}</td>
									<td>{{ tanggal_eklaim($d->tgl_masuk) }}</td>
									<td  class="text-center">
										<a href="{{ url('tindakan/entry/'.$d->registrasi_id.'/'.$reg->pasien->id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i> </a>
									</td>
									<td class="text-center">
										<a href="{{ url('tindakan/order/laboratorium/irna/'.$reg->id) }}" onclick="return confirm('Yakin akan di order ke LAB?')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-flask"> </i></a>
									</td>
									<td class="text-center">
										<a href="{{ url('tindakan/order/radiologi/irna/'.$reg->id) }}" onclick="return confirm('Yakin akan di order ke RADIOLOGI?')"  class="btn btn-primary btn-sm btn-flat"><i class="fa fa-television"> </i></a>
									</td>
									<td class="text-center">
										<a href="{{ url('operasi/tindakan/'.$reg->id) }}" onclick="return confirm('Yakin akan di order ke IBS?')"  class="btn btn-success btn-sm btn-flat"><i class="fa fa-cut"></i></a>
									</td>
									<td class="text-center">
										<a href="{{ url('rawat-inap/gizi/'.$reg->id) }}" onclick="return confirm('Yakin akan di order ke GIZI?')"  class="btn btn-success btn-sm btn-flat"><i class="fa fa-cutlery"></i></a>
									</td>
									<td>
										<a href="{{ url('tindakan/order/penunjang/fis/irna/'.$reg->id) }}" onclick="return confirm('Yakin akan di order ke FISIOTERAPI?')"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-wheelchair"></i></a>
									</td>
									<!--td>
										<a href="{{ url('tindakan/order/penunjang/vk/irna/'.$reg->id) }}" onclick="return confirm('Yakin akan di order ke Kamar Bersalin?')"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-child"></i></a>
									</td-->
									<td class="text-center">
										<a href="{{ url('rawat-inap/mutasi/'.$reg->id) }}" onclick="return confirm('Yakin akan di Mutasi?')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-recycle"></i></a>
									</td>
									<!--td class="text-center">
										<a class="btn btn-success btn-sm btn-flat" onclick="pulangkan({{ $reg->id }}, {{ $d->bed_id }})"><i class="fa fa-home"></i></a>
									</td-->
									<td>
										<button type="button" onclick="rincianBiaya({{ $reg->id }}, '{{ $reg->pasien->nama }}', {{ $reg->pasien->no_rm }}, '{{ substr($reg->status_reg,0,1) }}' )" class="btn btn-info btn-sm btn-flat"><i class="fa fa-search"></i> </button>
									</td>
									<td>
										@php
											$warna = 'black';
											if($reg->posisi_pasien=='menunggu antrian' OR $reg->posisi_pasien=='menunggu persalinan'){
												$warna = 'orange';
											}elseif($reg->posisi_pasien=='sedang diperiksa'){
												$warna = 'red';
											}elseif($reg->posisi_pasien=='selesai diperiksa'){
												$warna = 'green';
											}
										@endphp
										<span style="font-weight:bold;color:{{$warna}};">{{ ucwords($reg->posisi_pasien) }}</span>
									</td>
								</tr>
							@endif
            @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </div>
  </div>

  <div class="modal fade" id="modalRincianBiaya" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tindakan</th>
                  <th>Tagihan</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody class="tagihan">
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3" class="text-right">Total Tagihan</th>
                  <th class="text-right totalTagihan"></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
(function blink() {
	$('.blink_me').fadeOut(500).fadeIn(500, blink);
})();

function ribuan(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function jenisLayanan(jenis) {
	switch (jenis) {
		case 'TA' : return 'Layanan rawat jalan'; break;
		case 'TG' : return 'Layanan rawat darurat'; break;
		case 'TI' : return 'Layanan rawat inap'; break;
		default : return 'Apotek'; break;
	}
}

function rincianBiaya(registrasi_id, nama, no_rm, status_reg) {
	$('#modalRincianBiaya').modal('show');
	$('.modal-title').text(nama +' | '+no_rm)
	$('.tagihan').empty();
	$.ajax({
		url: '/informasi-rincian-biaya/'+registrasi_id,
		type: 'GET',
		dataType: 'json',
		success: function(data) {
			console.log(data);
			if(status_reg=='I'){
				$('.tagihan').append('<tr><td>0</td> <td>Biaya Kamar</td> <td class="text-right" id="total_kamar"></td> <td>-</td></tr>')
			}
			$.each(data, function(key, value) {
				$('.tagihan').append('<tr><td>'+ (key+1) +'</td> <td>'+ value.namatarif+'</td> <td class="text-right">'+ ribuan(value.total)+'</td> <td>'+ value.created_at +'</td> </tr>')
			});
		}
	});

	$.ajax({
		url: '/informasi-total-biaya/'+registrasi_id,
		type: 'GET',
		dataType: 'json',
		success: function (data) {
			$('.totalTagihan').html(ribuan(data.tagihan))
			
			if(status_reg=='I'){
				$('#total_kamar').html(ribuan(data.kamar));
			}
		}
	});
}

$('select[name="kelas_id"]').on('change', function(e) {
		e.preventDefault();
		var kelas_id = $(this).val();
		$.ajax({
			url: '/getkamar/'+kelas_id,
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				$('select[name="kamar_id"]').empty()
				$.each(data, function(key, value) {
						$('select[name="kamar_id"]').append('<option value="'+ value.id +'">'+ value.nama +'</option>');
				});
			}
		})
	})
</script>
@endsection
