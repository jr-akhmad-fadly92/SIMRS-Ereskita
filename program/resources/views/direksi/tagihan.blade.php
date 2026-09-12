@extends('master')
@section('header')
  <h1>Laporan Pendapatan</h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

    </div>
    <div class="box-body">
    {!! Form::open(['method' => 'POST','id'=>'laporanTagihan', 'url' => '/direksi/laporan-tagihan', 'class' => 'form-horizontal']) !!}

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
              {!! Form::label('poli_id', 'Klinik', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                 <select class="form-control chosen-select" name="poli_id">
                                  <option value="">[semua]</option>
                              @foreach (Modules\Poli\Entities\Poli::select('id', 'nama')->get() as $key => $d)
                                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                              @endforeach
                          </select>
                  <small class="text-danger">{{ $errors->first('poli_id') }}</small>
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('Jenis Bayar', 'Jenis Bayar', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                 <select class="form-control chosen-select" name="bayar">
                 <option value="">[Semua]</option>
                              <option value="1">JKN</option>
                              <option value="2">UMUM</option>
                              <option value="3">Asuransi Swasta</option>
                          </select>
                  <small class="text-danger">{{ $errors->first('bayar') }}</small>
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('dokter_id', 'Nama Dokter', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
              <select class="form-control chosen-select" name="dokter_id">
                                  <option value="">[Semua]</option>
                              @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->where('kategori_pegawai', 1)->get() as $key => $d)
                                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
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
                                  <option value="{{ $d->id }}">{{ $d->tipelayanan }}</option>
                              @endforeach
                  </select>
                  <small class="text-danger">{{ $errors->first('tipelayanan') }}</small>
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('tipe_penerimaan', 'Tipe Penerimaan', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                  <select class="form-control" name="tipe_penerimaan">
                              <option value="">[semua]</option>
                              <option value="tunai">Tunai</option>
                              <option value="piutang">Piutang</option>
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
      @isset($pembayaran)
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr class="info">
                <th style="vertical-align: middle;">#</th>
                <th style="vertical-align: middle;">Tgl / Waktu</th>
                <th style="vertical-align: middle;">No. RM</th>
                <th style="vertical-align: middle;">Nama</th>
                <th style="vertical-align: middle;">Nama Tarif</th>
                <th style="vertical-align: middle;">Cara Bayar</th>
                <th style="vertical-align: middle;">Total</th>
                <th style="vertical-align: middle;">Poli</th>
                <th style="vertical-align: middle;">Nama Dokter</th>
                {{-- <th style="vertical-align: middle;">Shift</th>
                <th style="vertical-align: middle;">Tipe Layanan</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($pembayaran as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  
                  <td>{{ tanggal($d->created_at) }}</td>
                  <td>{{ $d->no_rm }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->namatarif }}</td>
                  <td>{{ !empty($d->bayar) ? baca_carabayar($d->bayar) : '' }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                  <td>{{ number_format($d->total) }}</td>
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
                
                <th colspan="6"></th>
              </tr>
              <tr>
                <th colspan="2">Total</th>
                <th colspan="10">{{ number_format($tunai) }}</th>
              </tr>

              <tr>
                <th colspan="2"><i>Terbilang</i></th>
                <th colspan="10"><i>{{ terbilang($tunai) }} Rupiah</i></th>
              </tr>
            </tfoot>
          </table>
        </div>
      @endisset



    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
