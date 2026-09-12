@extends('master')
@section('header')
  <h1>Laporan Pendapatan</h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

    </div>
    <div class="box-body">
    {!! Form::open(['method' => 'POST','id'=>'historikamar', 'url' => '/kamar/histori_kamar_ranap', 'class' => 'form-horizontal']) !!}

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
              {!! Form::label('nama_kamar', 'Nama Kamar', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
              
                  <select class="form-control" name="nama_kamar">
                    <option value="">[Semua]</option>
                    @foreach (Modules\Kamar\Entities\Kamar::all() as $key => $d)
                    <option value="{{ $d->id }}" >{{ $d->nama }}</option>
                    
                    @endforeach       
                  </select>
                  <small class="text-danger">{{ $errors->first('nama_kamar') }}</small>
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('kelas', 'Kelas', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                  <select class="form-control" name="kelas">
                    <option value="">[Semua]</option>
                    @foreach (Modules\Kelas\Entities\Kelas::all() as $key => $d)
                    <option value="{{ $d->id }}" >{{ $d->nama }}</option>
                    
                    @endforeach
                  </select>
                  <small class="text-danger">{{ $errors->first('kelas') }}</small>
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('bed', 'Bed', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                  <select class="form-control" name="bed">
                    <option value="">[Semua]</option>
                    @foreach (Modules\Bed\Entities\Bed::all() as $key => $d)
                    <option value="{{ $d->id }}" >{{ $d->nama }}</option>
                    
                    @endforeach
                  </select>
                  <small class="text-danger">{{ $errors->first('bed') }}</small>
              </div>
          </div>
          

        </div>
        <div class="col-md-6">
          <div class="form-group">
              {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="btn-group ">
                    <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
                    
                </div>
              </div>
          </div>

        </div>
      </div>
      
      {!! Form::close() !!}

      <hr>
      @isset($tampil_data)
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr class="info">
                <th style="vertical-align: middle;">#</th>
                <th style="vertical-align: middle;">Nama Pasien</th>
                <th style="vertical-align: middle;">Kamar / Kelas / Bed </th>
                <th style="vertical-align: middle;">Pasien Masuk</th>
                <th style="vertical-align: middle;">Pasien Keluar</th>
              </tr>
            </thead>
            <tbody>
              @foreach($tampil_data as $t)
              <tr>
               <td>{{ $no++ }}</td>
               <td>{{$t->nama_pasien}}</td>
               <td>{{$t->nama_kamar}} / {{$t->nama_kelas}} / {{$t->nama_bed}}</td>
               <td>{{$t->created_at}}</td>
               @if($t->updated_at==NULL)
               <td>masih di rawat</td> 
               @else
               <td>{{$t->updated_at}}</td> 
               @endif              
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
