@extends('master')
@section('header')
  <h1>Laporan Pendapatan</h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

    </div>
    <div class="box-body">
    {!! Form::open(['method' => 'POST','id'=>'laporanTagihan', 'url' => '/direksi/laporan-pendapatan', 'class' => 'form-horizontal']) !!}

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
              {!! Form::label('tga', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-4">
                  {!! Form::text('tga', null, ['class' => 'form-control datepicker']) !!}
                  <small class="text-danger">{{ $errors->first('tga') }}</small>
              </div>
              <div class="col-sm-4">
                  {!! Form::text('tgb', null, ['class' => 'form-control datepicker']) !!}
                  <small class="text-danger">{{ $errors->first('tgb') }}</small>
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('petugas', 'Petugas', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                  <select class="form-control select2" name="petugas">
                    <option value="">[Semua]</option>
                    @foreach ($user as $key => $d)
                          @if (!empty($_POST['petugas']) && $_POST['petugas'] == $d->user_id)
                              <option value="{{ $d->user_id }}" selected>{{ $d->nama }}</option>
                          @else
                              <option value="{{ $d->user_id }}">{{ $d->nama }}</option>
                          @endif
                        @endforeach
                  </select>
                  <small class="text-danger">{{ $errors->first('petugas') }}</small>
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('poli_id', 'Klinik', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                 <select class="form-control chosen-select select2" name="poli_id">
                                <option value="">[semua]</option>
                              @foreach (Modules\Poli\Entities\Poli::select('id', 'nama')->get() as $key => $d)
                              @if (!empty($_POST['poli_id']) && $_POST['poli_id'] == $d->id)
                                <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                              @else
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                              @endif
                                  
                              @endforeach
                          </select>
                  <small class="text-danger">{{ $errors->first('poli_id') }}</small>
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('Jenis Bayar', 'Jenis Bayar', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                 <select class="form-control chosen-select" name="bayar">
                      
                      @if (!empty($_POST['bayar']) && $_POST['bayar'] == 1)
                      <option value="">[Semua]</option>
                      <option value="1" selected>JKN</option>
                      <option value="2">UMUM</option>
                      <option value="3">Asuransi Swasta</option>
                      @elseif (!empty($_POST['bayar']) && $_POST['bayar'] == 2)
                      <option value="">[Semua]</option>
                      <option value="1">JKN</option>
                      <option value="2" selected>UMUM</option>
                      <option value="3">Asuransi Swasta</option>
                      @elseif (!empty($_POST['bayar']) && $_POST['bayar'] == 3)
                      <option value="">[Semua]</option>
                      <option value="1">JKN</option>
                      <option value="2">UMUM</option>
                      <option value="3" selected>Asuransi Swasta</option>
                      @else
                      <option value="">[Semua]</option>
                      <option value="1">JKN</option>
                      <option value="2">UMUM</option>
                      <option value="3">Asuransi Swasta</option>
                      @endif
                      
                 </select>
                  <small class="text-danger">{{ $errors->first('bayar') }}</small>
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('dokter_id', 'Nama Dokter', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
              <select class="form-control chosen-select select2" name="dokter_id">
                                  <option value="">[Semua]</option>
                              @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->where('kategori_pegawai', 1)->get() as $key => $d)
                              @if (!empty($_POST['dokter_id']) && $_POST['dokter_id'] == $d->id)
                                <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                              @else
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                              @endif
                                  
                              @endforeach
                          </select>
                  <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
              </div>
          </div>
          
          

        </div>
        <div class="col-md-6">
        <div class="form-group">
              {!! Form::label('tipe_layanan', 'Tipe Layanan', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                  <select class="form-control" name="tipelayanan">
                  <option value="">[Semua]</option>
                              @foreach (Modules\Registrasi\Entities\Tipelayanan::select('id', 'tipelayanan')->get() as $key => $d)
                              @if (!empty($_POST['tipelayanan']) && $_POST['tipelayanan'] == $d->id)
                              <option value="{{ $d->id }}" selected>{{ $d->tipelayanan }}</option>
                              @else
                              <option value="{{ $d->id }}">{{ $d->tipelayanan }}</option>
                              @endif
                                  
                              @endforeach
                  </select>
                  <small class="text-danger">{{ $errors->first('tipelayanan') }}</small>
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('tipe_penerimaan', 'Tipe Penerimaan', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                  <select class="form-control" name="tipe_penerimaan">
                      @if (!empty($_POST['tipe_penerimaan']) && $_POST['tipe_penerimaan'] == 'tunai')
                      <option value="">[semua]</option>
                      <option value="tunai" selected>Tunai</option>
                      <option value="piutang">Piutang</option>
                      @elseif (!empty($_POST['tipe_penerimaan']) && $_POST['tipe_penerimaan'] == 'piutang')
                      <option value="">[semua]</option>
                      <option value="tunai">Tunai</option>
                      <option value="piutang" selected>Piutang</option>
                      @else
                      <option value="">[semua]</option>
                      <option value="tunai">Tunai</option>
                      <option value="piutang">Piutang</option>
                      @endif
                  </select>
                  <small class="text-danger">{{ $errors->first('tipe_penerimaan') }}</small>
              </div>
          </div>
          
          
          <div class="form-group">
              {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="btn-group ">
                    <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
                    <input type="submit" name="excel" class="btn btn-success btn-flat fa-file-excel-o" value=" &#xf1c3; EXCEL">
                    <input type="submit" name="pdf" class="btn btn-danger btn-flat fa-file-pdf-o" value="&#xf1c1; CETAK">
                </div>
              </div>
          </div>

        </div>
      </div>
      
      {!! Form::close() !!}

      <hr>
      @isset($pembayaran_pendapatan)
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr class="info">
                <th style="vertical-align: middle;">#</th>
                <th style="vertical-align: middle;">No. Kuitansi</th>
                <th style="vertical-align: middle;">Tgl / Waktu</th>
                <th style="vertical-align: middle;">No. RM</th>
                <th style="vertical-align: middle;">Nama</th>
                <th style="vertical-align: middle;">Cara Bayar</th>
                <th style="vertical-align: middle;">Tunai</th>
                <th style="vertical-align: middle;">Piutang</th>
                <th style="vertical-align: middle;">Subsidi</th>
                <th style="vertical-align: middle;">Kasir</th>
                <th style="vertical-align: middle;">Poli</th>
                <th style="vertical-align: middle;">Nama Dokter</th>
                {{-- <th style="vertical-align: middle;">Shift</th>
                <th style="vertical-align: middle;">Tipe Layanan</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($pembayaran_pendapatan as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->no_kwitansi }}</td>
                  <td>{{ tanggal($d->created_at) }}</td>
                  <td>{{ $d->no_rm }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ !empty($d->bayar) ? baca_carabayar($d->bayar) : '' }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                  <td>{{ ($d->jenis == 'tunai') ? number_format($d->total) : '' }}</td>
                  <td>{{ ($d->jenis == 'piutang') ? number_format($d->total) : '' }}</td>
                  <td>{{ $d->subsidi }}</td>
                  <td>{{ App\User::find($d->user_id)->name }}</td>
                  <td>{{ baca_poli($d->poli_id) }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  {{-- <td></td>
                  <td></td> --}}
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th colspan="6" class="text-right">Total</th>
                <th>{{ number_format($tunai) }}</th>
                <th>{{ number_format($piutang) }}</th>
                <th colspan="6"></th>
              </tr>
              <tr>
                <th colspan="2">Total</th>
                <th colspan="10">{{ number_format($tunai + $piutang) }}</th>
              </tr>

              <tr>
                <th colspan="2"><i>Terbilang</i></th>
                <th colspan="10"><i>{{ terbilang($tunai + $piutang) }} Rupiah</i></th>
              </tr>
            </tfoot>
          </table>
        </div>
  {{--<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h5 class="no-margin">
						<i class="fa fa-bar-chart-o"></i>
						<b>Grafik Pendapatan
					</h5>
				</div>
				<div class="box-body">
					<div id="bar-chart1" style="height: 350px;"></div>
				</div>
			</div>
    </div>
    
  </div>--}}
  
      @endisset



    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
