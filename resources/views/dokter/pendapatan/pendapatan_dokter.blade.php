@extends('master')
@section('header')
  <h1>Laporan Pendapatan</h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

    </div>
    <div class="box-body">
    {!! Form::open(['method' => 'POST','id'=>'laporanTagihan', 'url' => '/pendapatan_dokter', 'class' => 'form-horizontal']) !!}

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
              {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                  <select class="form-control select2" name="dokter_id">
                   
                    @if(Auth::user()->role()->first()->name)=='dokter')
                    @foreach ($user as $key => $d)
                          @if (!empty($_POST['dokter_id']) && $_POST['dokter_id'] == $d->id)
                              <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                          @else
                              <option value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endif
                    @endforeach
                    @else
                    <option value="null">[Semua]</option>
                    @foreach ($user as $key => $d)
                          @if (!empty($_POST['dokter_id']) && $_POST['dokter_id'] == $d->id)
                              <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                          @else
                              <option value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endif
                    @endforeach
                    @endif
                  </select>
                  <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
              </div>
          </div>
          
        </div>
        <div class="col-md-6">
        <div class="form-group">
              {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="btn-group ">
                    <input type="submit" name="lanjut" class="btn btn-primary btn-flat fa btn-sm" value="LANJUT">
                    @if(Auth::user()->role()->first()->name=='dokter')
                    @else
                    <input type="submit" name="pdf" class="btn btn-danger btn-sm btn-flat fa fa-file-pdf-o" value="&#xf1c1; CETAK">
                    @endif
                </div>
              </div>
          </div>

        </div>
      </div>
      
      {!! Form::close() !!}

      <hr>
      @isset($dokter_id)
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="pendapatan_dokter">
            <thead>
              <tr class="info">
                <th style="vertical-align: middle;">No</th>
                @if(Auth::user()->role()->first()->name=='dokter')
                @else
                <th style="vertical-align: middle;">Nama Dokter</th>
                @endif
                <th style="vertical-align: middle;">Tindakan</th>
                <th style="vertical-align: middle;">Konsultasi</th>
                <th style="vertical-align: middle;">Pemeriksaan</th>
                <th style="vertical-align: middle;">Pendapatan RS Kotor</th>
                <th style="vertical-align: middle;">Pendapatan RS</th>
                <th style="vertical-align: middle;">Pendapatan Dokter</th>
                <th style="vertical-align: middle;">Detail</th>
                <th style="vertical-align: middle;">PDF</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
           
          </table>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="detailpendapatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id=""></h4>
              </div>
              <div class="modal-body">
              <table class='table table-striped table-bordered table-hover table-condensed' id="detail_pendapatan_dokter">
                <thead>
                  <tr class="info">
                    <th style="vertical-align: middle;">No</th>
                    <th style="vertical-align: middle;">Tanggal</th>
                    <th style="vertical-align: middle;">Nama Pasien</th>
                    <th style="vertical-align: middle;">Tindakan</th>
                    <th style="vertical-align: middle;">Biaya</th>
                    <th style="vertical-align: middle;">Pendapatan RS</th>
                    <th style="vertical-align: middle;">Pendapatan Dokter</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              
              </table>
              </div>
              <div class="modal-footer">
                
              </div>
            </div>
          </div>
        </div>
      @endisset
  </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
@section('script')
@isset($dokter_id)
<script type="text/javascript">
$(document).ready(function(){
    $(document).ready( function () {
      var cek = '{{Auth::user()->role()->first()->name}}';
      if(cek=='dokter'){
        $('#pendapatan_dokter').DataTable({
          pageLength: 10,
          autoWidth: false,
          processing: true,
          serverSide: true,
    
            ajax: "{{ url('pendapatan_dokter/data='.$dokter_id.'/'.$tga.'/'.$tgb.'')}}",
            columns: [
              { data: 'nomor' },
              { data: 'tindakan' },
              { data: 'konsultasi' },
              { data: 'pemeriksaan' },
              { data: 'pendapatan_sementara' },
              { data: 'pendapatan_rs' },
              { data: 'pendapatan' },
              { data: 'detail' },
              { data: 'pdf' },
            ]
          });
      }else{
        $('#pendapatan_dokter').DataTable({
          pageLength: 10,
          autoWidth: false,
          processing: true,
          serverSide: true,
    
            ajax: "{{ url('pendapatan_dokter/data='.$dokter_id.'/'.$tga.'/'.$tgb.'')}}",
            columns: [
              { data: 'nomor' },
              { data: 'nama' },
              { data: 'tindakan' },
              { data: 'konsultasi' },
              { data: 'pemeriksaan' },
              { data: 'pendapatan' },
              { data: 'detail' },
              { data: 'pdf' },
            ]
          });
      }
      
      });
      });
      $(document).on('click', '.detail',function () {
      $('.modal-title').text('Detail Pendapatan');
      var id = $.parseJSON($(this).attr('data-id'));
      
      $('#detail_pendapatan_dokter').DataTable({
        destroy: true,
          autoWidth: false,
          processing: true,
          serverSide: true,
            ajax: "{{ url('pendapatan_dokter/'.$tga.'sampai'.$tgb)}}"+'/'+id,
            columns: [
              { data: 'rownum' },
              { data: 'nama_pasien' },
              { data: 'tanggal' },
              { data: 'namatarif' },
              { data: 'biaya' },
              { data: 'pendapatan_rs' },
              { data: 'pendapatan_dokter' },
              
            ]
          });
     
      $('#edit').modal('show');

});

</script>
@endisset
@endsection