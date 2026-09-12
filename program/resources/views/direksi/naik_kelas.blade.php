@extends('master')
@section('header')
  <h1>Laporan Naik Kelas</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => 'direksi/laporan-naik-kelas', 'class' => 'form-horizontal']) !!}

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
                <th style="vertical-align: middle;">No RM</th>
                <th style="vertical-align: middle;">No. Registrasi</th>
                <th style="vertical-align: middle;">Nama Pasien</th>
                <th style="vertical-align: middle;">Kelas Awal</th>
                <th style="vertical-align: middle;">Naik Kelas</th>
                
                </tr>
            </thead>
            <tbody>
            @foreach ($pembayaran as $key => $d)
              
                  
              <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->created_at }}</td>
              <td>{{ $d->no_rm }}</td>
              <td>{{ $d->reg_id }}</td>
              <td>{{ $d->nama }}</td>
              <td>{{ baca_kelas($d->hak_kelas_inap) }}</td>
              <td>{{ baca_kelas($d->is_naik_kelas) }}</td>
              
            </tr>
                
               
          @endforeach
            </tbody>
            <tfoot>
             
            </tfoot>
          </table>
        </div>
      @endisset
      
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection