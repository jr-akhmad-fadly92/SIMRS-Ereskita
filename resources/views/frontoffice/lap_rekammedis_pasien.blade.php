@extends('master')
@section('header')
  <h1>Laporan Rekam Medis Pasien</h1>
@endsection
@section('content')
  <div class="box box-primary">
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/laporan/rekammedis-pasien', 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('pasien_id', null) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('tga', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-4">
                    {!! Form::text('tga', null, ['class' => 'form-control datepicker']) !!}
                    <small class="text-danger">{{ $errors->first('tga') }}</small>
                </div>
                <div class="col-md-4">
                  {!! Form::text('tgb', null, ['class' => 'form-control datepicker']) !!}
                  <small class="text-danger">{{ $errors->first('tgb') }}</small>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('nama', 'Nama Pasien', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-8">
                  <div class="input-group">
                      {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                      <span class="input-group-btn">
                        <button type="button" id="openModal" class="btn btn-default btn-flat"><i class="fa fa-search"></i> </button>
                      </span>
                  </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('nama', 'No. RM', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('no_rm', null, ['class' => 'form-control', 'readonly'=>true]) !!}
                    <small class="text-danger">{{ $errors->first('no_rm') }}</small>
                </div>
            </div>
            <p class="small text-warning">* Jika pencarian berdasarkan nama pasien, variable yang lain di abaikan</p>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="tanggal" class="col-md-3 control-label">Nama Dokter</label>
              <div class="col-md-8">
                <select class="form-control" name="dokter_id">
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
              <label for="tanggal" class="col-md-3 control-label">Cara Bayar</label>
              <div class="col-md-8">
                <select class="form-control" name="jenis_pasien">
									@php $jenis_pasien=""; @endphp
                  @if (isset($_POST['jenis_pasien']))
										@php $jenis_pasien=$_POST['jenis_pasien']; @endphp
                  @endif
									<option {{ ($jenis_pasien=='') ? 'selected' : '' }} value="">[Semua]</option>
									<option {{ ($jenis_pasien==1) ? 'selected' : '' }} value="1">JKN</option>
									<option {{ ($jenis_pasien==2) ? 'selected' : '' }} value="2">Umum</option>
									<option {{ ($jenis_pasien==3) ? 'selected' : '' }} value="3">Asuransi Swasta</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="tanggal" class="col-md-3 control-label">Kategori JKN</label>
              <div class="col-md-8">
                <select class="form-control" name="tipe_jkn">
									@php $tipe_jkn=""; @endphp
                  @if (isset($_POST['tipe_jkn']))
										@php $tipe_jkn=$_POST['tipe_jkn']; @endphp
                  @endif
									<option selected value="">[Semua]</option>
									<option {{ ($tipe_jkn=='PBI') ? 'selected' : '' }} value="PBI" selected>PBI</option>
									<option {{ ($tipe_jkn=='NON PBI') ? 'selected' : '' }} value="NON PBI">NON PBI</option>
                </select>
              </div>
            </div>
            {!! Form::submit('Tampilkan', ['class' => 'btn btn-warning btn-flat']) !!}
          </div>
        </div>
      {!! Form::close() !!}
      <hr>

      @if (isset($rekammedis))
        <div class='table-responsive'>
          <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No.RM</th>
                <th>Nama </th>
                <th>Alamat</th>
                <th>Umur</th>
                <th>L/P</th>
                <th>Jenis Pasien</th>
                <th>Subjective</th>
                <th>Objective</th>
                <th>Assesment</th>
                <th>Planning</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
                <th>Resep Obat</th>
                <th>Poli</th>
                <th>Dokter</th>
                <th>Nama Petugas</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($rekammedis as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->created_at->format('d-m-Y') }}</td>
                  <td>{{ $d->pasien->no_rm }}</td>
                  <td>{{ $d->pasien->nama }}</td>
                  <td>{{ $d->pasien->alamat }}</td>
                  <td>{{ hitung_umur($d->pasien->tgllahir, 'Y') }}</td>
                  <td>{{ $d->pasien->kelamin }}</td>
                  <td>{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>{{ baca_diagnosa($d->diagnosa_awal) }}</td>
                  <td>{{$d->verifikasi_tindakan}}</td>
                  <td>{{$d->obat}}</td>
                  <td>{{ baca_poli($d->poli_id) }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ baca_pegawai($d->user_create) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>

  {{-- MODAL SEARCH pasien --}}
  <div class="modal fade" id="searchPasien" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table id="dataPasien" class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No. RM</th>
                  <th>Nama Lengkap</th>
                  <th>Alamat</th>
                  <th>Input</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    if($('select[name="jenis_pasien"]').val() == 1) {
      $('select[name="tipe_jkn"]').removeAttr('disabled');
    } else {
      $('select[name="tipe_jkn"]').val('');
      $('select[name="tipe_jkn"]').attr('disabled', true);
    }

    $('select[name="jenis_pasien"]').on('change', function () {
      if ($(this).val() == 1) {
        $('select[name="tipe_jkn"]').removeAttr('disabled');
      } else {
				$('select[name="tipe_jkn"]').val('');
        $('select[name="tipe_jkn"]').attr('disabled', true);
      }
    });

    //SEARCH PASIEN
    $('#openModal').on('click', function () {
      $("#dataPasien").DataTable().destroy();
      $('#searchPasien').modal('show');
      $('.modal-title').text('Cari Pasien');
      $('#dataPasien').DataTable({
          "language": {
              "url": "/json/pasien.datatable-language.json",
          },

          pageLength: 10,
          autoWidth: false,
          processing: true,
          serverSide: true,
          ordering: false,
          ajax: '/frontoffice/lap-rekammedis/datapasien',
          columns: [
              {data: 'no_rm'},
              {data: 'nama'},
              {data: 'alamat'},
              {data: 'input', searchable: false},
          ]
      });
    });

    $(document).on('click', '.inputPasien', function (e) {
      $('input[name="nama"]').val($(this).attr('data-nama'));
      $('input[name="no_rm"]').val($(this).attr('data-no_rm'));
      $('input[name="pasien_id"]').val($(this).attr('data-pasien_id'));
      $('#searchPasien').modal('hide');
    });

    $('input[name="nama"]').on('keyup', function () {
      if ( $('input[name="nama"]').val() == '' ) {
        $('input[name="no_rm"]').val('');
        $('input[name="pasien_id"]').val('');
      }
    });
  });
</script>
@endsection
