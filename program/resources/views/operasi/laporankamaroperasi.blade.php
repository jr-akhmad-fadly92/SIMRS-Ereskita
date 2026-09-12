@extends('master')
@section('header')
  <h1>Laporan Pendapatan</h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

    </div>
    <div class="box-body">
    {!! Form::open(['method' => 'POST','id'=>'laporan_penggunaan_kamar_op', 'url' => 'operasi/laporan/penggunaan_kamar_operasi', 'class' => 'form-horizontal']) !!}

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
                    <input type="submit" name="lanjut" class="btn btn-primary btn-flat fa " value="LANJUT">
                    <input type="submit" name="pdf" class="btn btn-danger btn-flat fa fa-file-pdf-o" value="&#xf1c1; CETAK">
                </div>
              </div>
          </div>

        </div>
      </div>
      
      {!! Form::close() !!}

      <hr>
      @isset($list_pasien)
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr class="info">
                <th style="vertical-align: middle;">#</th>
                <th style="vertical-align: middle;">Nama Pasien</th>
                <th style="vertical-align: middle;">Nama Operasi</th>
                <th style="vertical-align: middle;">Dokter Bedah</th>
                <th style="vertical-align: middle;">Detail Operasi</th>
              </tr>
            </thead>
            <tbody>
            @foreach($list_pasien as $key =>$list)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $list->nama_pasien }}</td>
                <td>{{$list->nama_operasi}}</td>
                <td>{{baca_dokter($list->operator)}}</td>
                <td> 
              
                <a href="{{ url('/operasi/laporan/detail_operasi_pasien/'.$list->registrasi_id) }}" class="btn btn-info btn-sm"><i class="fa fa-file-pdf-o"></i></a>
                </td>
              </tr>
              @endforeach
            </tbody>
            
          </table>
        </div>
    @endisset
  
     



    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
