@extends('master')
@section('header')
  <h1>Laporan Pendapatan</h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

    </div>
    <div class="box-body">
    {!! Form::open(['method' => 'POST','id'=>'laporanTagihan', 'url' => 'rehabmedik/RL2', 'class' => 'form-horizontal']) !!}

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
                 <select class="form-control chosen-select select2" name="poli_id">
                    @if(isset($poli_id) && $poli_id=='I')<option value="I" selected>Rawat Inap</option>@else<option value="I">Rawat Inap</option>@endif
                    @if(isset($poli_id) && $poli_id=='J|G')<option value="J|G" selected>Rawat Jalan</option>@else<option value="J|G" >Rawat Jalan</option>@endif
                 </select>
                  <small class="text-danger">{{ $errors->first('poli_id') }}</small>
              </div>
          </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
              {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="btn-group ">
                    <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
                    <input type="submit" name="pdf" class="btn btn-danger btn-flat fa-file-pdf-o" value="&#xf1c1; CETAK">
                </div>
              </div>
          </div>

        </div>
      </div>
      
      {!! Form::close() !!}

      <hr>
      @isset($poli_id)
        <div class='table-responsive'>
          <table id="RL2" class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr class="info">
                <th style="vertical-align: middle;" width="20%">Kode ICD</th>
                <th style="vertical-align: middle;" width="20%">Nama ICD</th>
                <th style="vertical-align: middle;">0 - 28 H</th>
                <th style="vertical-align: middle;">28H - < 1 Th </th>
                <th style="vertical-align: middle;">1 Th - 4 Th</th>
                <th style="vertical-align: middle;">5 Th - 14 Th</th>
                <th style="vertical-align: middle;">15 Th - 24 Th</th>
                <th style="vertical-align: middle;">25 Th - 44 Th</th>
                <th style="vertical-align: middle;">45 Th - 64 Th</th>
                <th style="vertical-align: middle;">64 Th < </th>
                <th style="vertical-align: middle;">Laki</th>
                <th style="vertical-align: middle;">Wanita</th>
                <th style="vertical-align: middle;">Hidup</th>
                <th style="vertical-align: middle;">Mati</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              
            </tfoot>
          </table>
        </div>
        @endisset
  </div>
  
 



    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
@section('script')
@isset($poli_id)
    <script type="text/javascript">
    $(document).ready(function(){
    $(document).ready( function () {
      $('#RL2').DataTable({
          pageLength: 10,
          autoWidth: false,
          processing: true,
          serverSide: true,
    
            ajax: "{{ url('RL2/data='.$poli_id.'/'.$tga.'/'.$tgb.'')}}",
            columns: [
                      { data: 'nomor'},
                      { data: 'nama' },
                      { data: '28h'},
                      { data: '<1th'},
                      { data: '<4th'},
                      { data: '<14th'},
                      { data: '<24th'},
                      { data: '<44th'},
                      { data: '<64th'},
                      { data: '>64th'},
                      { data: 'perempuan'},
                      { data: 'laki'},
                      { data: 'hidup'},
                      { data: 'mati'},
                   ]
          });
      });
      });
    </script>
@endisset
@endsection
