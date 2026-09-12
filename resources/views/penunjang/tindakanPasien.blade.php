@extends('master')

@section('header')
  <h1>Penata Jasa {{ Auth::user()->role()->first()->display_name }} </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-body">
        <div class='table-responsive'>
					<div class="col-md-6 pull-left">
						Keterangan:
						<br>
						<b>APS (Atas Permintaan Sendiri)</b>
					</div>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th class="text-center" style="vertical-align: middle;">No</th>
                <th class="text-center" style="vertical-align: middle;">Antrian</th>
                <th class="text-center" style="vertical-align: middle;">Nama Pasien</th>
                <th class="text-center" style="vertical-align: middle;">No. RM</th>
                <th class="text-center" style="vertical-align: middle;">Tgl Reg</th>
                <th class="text-center" style="vertical-align: middle;">Dokter</th>
                <th class="text-center" style="vertical-align: middle;">Klinik Asal</th>
                <th class="text-center" style="vertical-align: middle;">Instalasi</th>
                <th class="text-center" style="vertical-align: middle;">Cara Bayar</th>
                <th class="text-center" style="vertical-align: middle;">Proses</th>
                <th class="text-center" style="vertical-align: middle;">Status</th>
              </tr>
            </thead>
            <tbody>
							@if($registrasi!=null)
								@foreach ($registrasi as $key => $d)
									<tr>
										<td>{{ $no++ }}</td>
										<td>{{ $d->antrian_poli }}</td>
										<td>{{ $d->pasien->nama }}</td>
										<td>{{ $d->pasien->no_rm }}</td>
										<td>{{ $d->created_at->format('d-m-Y') }}</td>
										<td>{{ !(empty($d->dokter_id)) ? baca_dokter($d->dokter_id) : '' }}</td>
										<td>{{ ($d->poli_id!=null) ? $d->poli->nama : '' }}</td>
										<td>{{ instalasi(substr($d->status_reg,0,1)) }}</td>
										<td>{{ baca_carabayar($d->bayar) }}
											@if (!empty($d->tipe_jkn))
												- {{ $d->tipe_jkn }}
											@endif
										</td>
										<td>
											<a href="{{ url('tindakan/entry/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-edit"></i></a>
										</td>
										<td>
											{{$d->posisi_pasien}}
										</td>
									</tr>
								@endforeach
              @endif
							
							@if($registrasi!=null)
              @foreach ($registrasi2 as $key => $d)
								<tr>
                  <td>{{ $no++ }}</td>
                  <td>Order {{ ($d->dokter_id==null || $d->dokter_id==0) ? '- APS - Antrian '.$d->antrian_poli : '' }}</td>
                  <td>{{ $d->pasien->nama }}</td>
                  <td>{{ $d->pasien->no_rm }}</td>
                  <td>{{ $d->created_at->format('d-m-Y') }}</td>
                  <td>{{ !(empty($d->dokter_id)) ? baca_dokter($d->dokter_id) : '' }}</td>
                  <td>{{ ($d->poli_id!=null) ? $d->poli->nama : '' }}</td>
                  <td>{{ instalasi(substr($d->status_reg,0,1)) }}</td>
                  <td>{{ baca_carabayar($d->bayar) }}
                    @if (!empty($d->tipe_jkn))
                      - {{ $d->tipe_jkn }}
                    @endif
                  </td>
                  <td>
                    <a href="{{ url('/penunjang/insert-kunjungan/'. $d->id.'/'.$d->pasien_id) }}" onclick="return confirm('Apakah yakin akan dilakukan tindakan? Karena akan menambah kunjungan.')" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                  </td>
                  <td>
										@if($d->status_proses==1)
											<i class="fa fa-check"></i> Selesai
										@endif
                  </td>
                </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
