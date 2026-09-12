@extends('master')
@section('header')
  <h1>Antrian Farmasi<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <a href="" class="btn btn-flat btn-success pull-right">Refresh</a>
			<a href="#" class="btn btn-success btn-sm btn-flat">A</a> RJ Non Racikan
			<a href="#" class="btn btn-success btn-sm btn-flat">B</a> RJ Racikan
			<a href="#" class="btn btn-success btn-sm btn-flat">C</a> RI Non Racikan
			<a href="#" class="btn btn-success btn-sm btn-flat">D</a> RI Racikan
			<a href="#" class="btn btn-success btn-sm btn-flat">E</a> Tanpa Resep / Obat Pulang
			<a href="#" class="btn btn-success btn-sm btn-flat">F</a> Pasien Langsung
    </div>
    <div class="box-body">
      @if ($antrian->count() > 0)
      <div>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th class="text-center" style="vertical-align: middle">NO</th>
              <th class="text-center" style="vertical-align: middle"></th>
              <th class="text-center" style="vertical-align: middle">NO. REG</th>
              <th class="text-center" style="vertical-align: middle">NO. RM</th>
              <th class="text-center" style="vertical-align: middle">NAMA</th>
              <th class="text-center" style="vertical-align: middle">CARA BAYAR</th>
              <th class="text-center" style="vertical-align: middle">PROSES</th>
              <th class="text-center" style="vertical-align: middle">TELAAH</th>
              <th class="text-center" style="vertical-align: middle">RINCIAN</th>
              <th class="text-center" style="vertical-align: middle">RESEP</th>
              <th class="text-center" style="vertical-align: middle">ETIKET</th>
              <th class="text-center" style="vertical-align: middle">STATUS</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($antrian as $key => $d)
							@if($d->kelompok!='E')
								@php
									$penjualan = App\Penjualan::where('registrasi_id', $d->registrasi_id)->first();
								@endphp
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $d->kelompok.$d->nomor }}</td>
									<td>{{ $d->reg_id }}</td>
									<td>
										@php
											if($d->penjualan_bebas_apotek==1){
												echo '';
											}else{
												echo $d->pasien->no_rm;
											}
										@endphp
									</td>
									<td>
										@php
											if($d->penjualan_bebas_apotek==1 AND $d->pasien_id==0){
												$pasien_id = 0;
												echo '';
											}else{
												$pasien_id = $d->pasien->id;
												echo $d->pasien->nama;
											}
										@endphp
									</td>
									<td>
										{{ 'R-'.substr($d->status_reg,0,1) }} |
										{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}
									</td>
									<td  class="text-center">
										@if($d->pasien_id==0)
											<a href="{{ url('penjualan-bebas/'.$d->registrasi_id) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-check"></i></a>
										@else
											@if($d->penjualan_bebas_apotek==1)
												<a href="{{ url('penjualan/formpenjualan/'.$pasien_id.'/'.$d->registrasi_id.'/'.$penjualan->id.'/bebas') }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-check"></i></a>
											@else
												<a href="{{ url('penjualan/formpenjualan/'.$pasien_id.'/'.$d->registrasi_id) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-check"></i></a>
											@endif
										@endif
									</td>
									<td class="text-center">
										@if($d->pasien!=null)
											@if($d->pasien->pasien_luar==null)
												<a href="{{ url('farmasi/telaah-resep/resep/'.$d->registrasi_id) }}" class="btn btn-warning btn-flat btn-sm"> <i class="fa fa-check-square"></i> </a>
											@endif
										@endif
									</td>
									<td class="text-center">
										@if($d->pasien!=null)
											@if($penjualan!=null)
												<a target="_blank" href="{{ url('farmasi/cetak-detail/'.$penjualan->id) }}" class="btn btn-danger btn-flat btn-sm"> <i class="fa fa-file-pdf-o"></i> </a>
											@endif
										@endif
									</td>
									<td class="text-center">
										@if($d->pasien!=null)
											@if($penjualan!=null)
												<a target="_blank" href="{{ url('farmasi/cetak-resep/'.$penjualan->id) }}" class="btn bg-pink btn-flat 	btn-sm"> <i class="fa fa-print"></i> </a>
											@endif
										@endif
									</td>
									<td class="text-center">
										@if($d->pasien!=null)
											@if($penjualan!=null)
												<a target="_blank" href="{{ url('farmasi/laporan/etiket/rj/'.$penjualan->id) }}" class="btn btn-primary btn-flat btn-sm"> <i class="fa fa-print"></i> </a>
											@endif
										@endif
									</td>
									<td>
										@if($d->posisi_pasien=='selesai')
											<b>{{ ucwords($d->posisi_pasien) }}</b>
										@elseif($d->posisi_pasien=='antrian apotek')
											<b class="text-orange">{{ ucwords($d->posisi_pasien) }}</b>
										@elseif($d->posisi_pasien=='konfirmasi farmasi')
											<b class="text-blue">{{ ucwords($d->posisi_pasien) }}</b>
										@elseif($d->posisi_pasien=='selesai pembayaran')
											<b class="text-red">{{ ucwords($d->posisi_pasien) }}</b>
										@else
											{{ ucwords($d->posisi_pasien) }}
										@endif
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
@endsection

@section('script')
  <script type="text/javascript">
    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
  </script>

@endsection
