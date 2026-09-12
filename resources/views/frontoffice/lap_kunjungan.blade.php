@extends('master')
@section('header')
  <h1>Laporan Kunjungan </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/kunjungan', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="tanggal" class="col-md-3">Tanggal</label>
            <div class="col-md-4">
              <input type="text" name="tga" value="{{ !empty($_POST['tga']) ? $_POST['tga'] : '' }}" class="form-control datepicker" >
              <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
            <div class="col-md-4">
              <input type="text" name="tgb" value="{{ !empty($_POST['tgb']) ? $_POST['tgb'] : '' }}" class="form-control datepicker"  >
              <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
          </div>
          <div class="form-group">
            <label for="tanggal" class="col-md-3">Cara Bayar</label>
            <div class="col-md-8">
              <select class="form-control select2" name="jenis_pasien">
                @if (!empty($_POST['jenis_pasien']) && $_POST['jenis_pasien'] == 1)
                  <option value="">[Semua]</option>
                  <option value="1" selected>JKN</option>
                  <option value="2">Umum</option>
                @elseif (!empty($_POST['jenis_pasien']) && $_POST['jenis_pasien'] == 2)
                  <option value="">[Semua]</option>
                  <option value="1">JKN</option>
                  <option value="2" selected>Umum</option>
                @else
                  <option value="">[Semua]</option>
                  <option value="1">JKN</option>
                  <option value="2">Umum</option>
                @endif

              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="tanggal" class="col-md-3">Kategori JKN</label>
            <div class="col-md-8">
              <select class="form-control select2" name="tipe_jkn">
                @if (!empty($_POST['tipe_jkn']) && $_POST['tipe_jkn'] == 'PBI')
                  <option value="">[Semua]</option>
                  <option value="PBI" selected>PBI</option>
                  <option value="NON PBI">NON PBI</option>
                @elseif (!empty($_POST['tipe_jkn']) && $_POST['tipe_jkn'] == 'NON PBI')
                  <option value="">[Semua]</option>
                  <option value="PBI">PBI</option>
                  <option value="NON PBI" selected>NON PBI</option>
                @else
                  <option value="">[Semua]</option>
                  <option value="PBI">PBI</option>
                  <option value="NON PBI">NON PBI</option>
                @endif
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="tanggal" class="col-md-3">Nama Poli</label>
            <div class="col-md-8">
              <select class="form-control select2" name="poli_id">
                <option value="">[Semua]</option>
                @foreach ($poli as $key => $d)
                  @if (!empty($_POST['poli_id']) && $_POST['poli_id'] == $d->id)
                    <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                  @else
                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="tanggal" class="col-md-3">Nama Dokter</label>
            <div class="col-md-8">
              <select class="form-control select2" name="dokter_id">
                <option value="">[Semua]</option>
                @foreach ($dokter as $key => $d)
                  @if (!empty($_POST['dokter_id']) && $_POST['dokter_id'] == $d->id)
                    <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                  @else
                    <option value="{{ $d->id }}" >{{ $d->nama }}</option>
                  @endif

                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="tanggal" class="col-md-3"> &nbsp; </label>
            <div class="col-md-8">
              <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
              <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
            </div>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
      <br>
      {{-- ================================================================================================== --}}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No. RM</th>
              <th>Umur</th>
              <th>L/P</th>
              <th>Klinik Tujuan</th>
              <th>Dokter</th>
              <th>Cara Bayar</th>
              <th>Tanggal</th>
              <th>Status Pasien</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
              @php
                $registrasi = Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id);
                $pasien = Modules\Pasien\Entities\Pasien::find($d->pasien_id);
              @endphp
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $registrasi->pasien->nama  }}</td>
                <td>{{ $registrasi->pasien->no_rm }}</td>
                <td>{{ hitung_umur($registrasi->pasien->tgllahir, 'Y') }}</td>
                <td>{{ $registrasi->pasien->kelamin }}</td>
                <td>{{ baca_poli($d->poli_id) }}</td>
                <td>{{ baca_dokter($registrasi->dokter_id) }}</td>
                <td>{{ !empty($registrasi->bayar) ? strtoupper(baca_carabayar($registrasi->bayar)) : '' }} {{ !empty($registrasi->tipe_jkn) ? ' - '.$registrasi->tipe_jkn : '' }}</td>
                <td>{{ tanggal($d->created_at) }}</td>
                <td>{{ ucwords($registrasi->posisi_pasien) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();

    if($('select[name="jenis_pasien"]').val() == 1) {
      $('select[name="tipe_jkn"]').removeAttr('disabled');
    } else {
      $('select[name="tipe_jkn"]').attr('disabled', true);
    }

    $('select[name="jenis_pasien"]').on('change', function () {
      if ($(this).val() == 1) {
        $('select[name="tipe_jkn"]').removeAttr('disabled');
      } else {
        $('select[name="tipe_jkn"]').attr('disabled', true);
      }

    });
  });

</script>
@endsection
