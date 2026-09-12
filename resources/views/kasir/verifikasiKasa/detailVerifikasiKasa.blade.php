<div class='table-responsiv'>

  <table class='table table-striped table-bordered table-hover table-condensed'>

    <thead>

      <tr>

        <th>Nama Pasien</th>

        <th>No. RM</th>

        <th>Alamat</th>

        <th>Status Reg</th>

      </tr>

    </thead>

    <tbody>

      <tr>

        <td>{{ $pasien->nama }}</td>

        <td>{{ $pasien->no_rm }}</td>

        <td>{{ $pasien->alamat }}</td>

        <td>

          @if (substr($registrasi->status_reg,0,1) == 'J')

            Rawat Jalan

          @elseif (substr($registrasi->status_reg,0,1) == 'G')

            Rawat Darurat

          @endif

        </td>

      </tr>

      <thead>

      <tr>

        <th>Nama Penanggung jawab</th>

        <th>No Telp</th>

        <th>Alamat</th>

        <th>Hubungan</th>

      </tr>

    </thead>

    <tbody>

      <tr>

        <td>{{ $pasien->penanggung_jawab }}</td>

        <td>{{ $pasien->telp_penanggung_jawab }}</td>

        <td>{{ $pasien->alamat_penanggung_jawab }}</td>

        <td>{{ $pasien->hubungan_penanggung_jawab }}</td>

      </tr>

    </tbody>

  </table>

</div>



@if ($folio->count() > 0)

  <div class='table-responsiv'>

    <table class='table table-striped table-bordered table-hover table-condensed'>

      <thead>

        <tr>

          <th>No</th>

          <th>Nama Tindakan</th>

          <th>Total</th>

          <th>Klinik</th>

          <th>Pelaksana</th>

          <th>Verif</th>

          <th>Hapus</th>

        </tr>

      </thead>

      <tbody>

        @foreach ($folio as $key => $d)

          @php

            $pelaksana = DB::table('foliopelaksanas')->where('folio_id', $d->id)->first();

          @endphp

          <tr>

            <td>{{ $no++ }}</td>

            <td>{{ $d->namatarif }}</td>

            <td>{{ number_format($d->total) }}</td>

            <td>{{ baca_poli($d->poli_id) }}</td>

            <td>{{ !empty($pelaksana) ? baca_dokter($pelaksana->dokter_pelaksana) : NULL }}</td>

            <td> 

              @if ($d->verif_kasa == 'N')

                <input type="checkbox" class="flat-col" name="verif_kasa{{ $baris++ }}" id="verif_kasa{{ $baris++ }}" value="{{ $d->id }}">

              @else

                <i class="fa fa-check text-success"></i>

              @endif               

            </td>

            <td> 

               <input type="checkbox" class="flat-col" name="hapus{{ $baris++ }}" id="hapus{{ $baris++ }}" value="{{ $d->id }}">

            </td>

          </tr>

        @endforeach

        <input type="hidden" name="jmlbaris" value="{{ $baris }}">

        <input type="hidden" name="registrasi_id" value="{{ $registrasi->id }}">

      </tbody>

    </table>

  </div>

@else

  @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $registrasi->id)->where('verif_rj', 'Y')->count() > 0)

    <h4 class="text-success text-center">Sudah di verifikasi</h4>

  @else

    <h4 class="text-danger text-center">Belum diinput tindakan!!!</h4>

  @endif

@endif



@if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $registrasi->id)->where('verif_kasa', 'Y')->sum('total') > 0)

	<div class="col-md-12 no-padding">

		<a href="{{ url('kasir/cetak-verifikasi/'.$registrasi->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat pull-right"><i class="fa fa-print"></i> CETAK</a>

	</div>

	<br>

	<br>

@endif





