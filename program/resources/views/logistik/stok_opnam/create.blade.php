<style>
.content{
	padding:0 15px 15px 15px !important; 
}
</style>
@extends('master')
@section('header')
  <h1>Stok Opnam</h1-->
@endsection

@section('content')
    <div class="box box-primary">
      @isset($pegawai)
      <div class="box-header with-border">
      {!! Form::open(['method' => 'POST','id'=>'laporanTagihan', 'url' => '/stok-opnam/create', 'class' => 'form-horizontal']) !!}

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
              {!! Form::label('tanggal_pelaksanaan', 'Tanggal Pelaksanaan', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-4">
                  {!! Form::text('tanggal_pelaksanaan', null, ['class' => 'form-control datepicker']) !!}
                  <small class="text-danger">{{ $errors->first('tanggal_pelaksanaan') }}</small>
              </div>
              
          </div>
          <div class="form-group">
              {!! Form::label('petugas', 'Petugas', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                  <select class="form-control" name="petugas">
                    <option value="">[Semua]</option>
                    @foreach ($pegawai as $key => $d)
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
              {!! Form::label('kategori', 'Kategori', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                  <select class="form-control" name="kategori">
                    <option value="obat">Obat</option>
                    <option value="nonmedis">Non-Medis</option>
                    
                  </select>
                  <small class="text-danger">{{ $errors->first('kategori') }}</small>
              </div>
            
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="form-group">
              {!! Form::label('periode', 'Periode', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-4">
              {!! Form::text('periode', null, ['class' => 'form-control periode']) !!}
                  <small class="text-danger">{{ $errors->first('periode') }}</small>
              </div>
          </div>
          <div class="form-group">
              {!! Form::label('catatan', 'Catatan', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
              {!! Form::text('catatan', null, ['class' => 'form-control ']) !!}
                  <small class="text-danger">{{ $errors->first('catatan') }}</small>
              </div>
          </div>
          
          <div class="form-group">
              {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="btn-group ">
                    <input type="submit" class="btn btn-primary btn-flat" >
                    
                </div>
              </div>
          </div>

        </div>
      </div>

      {!! Form::close() !!}
      
      </div>
      @endisset
      
      @isset($detail_stok_opnam)
      <div class="box-header with-border">
        <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed '>
              <thead>
                <tr>
                  <th>No Stok Opnam</th>
                  <th>{{$detail_stok_opnam->no_stok_opnam}}</th>
                  <th>Tanggal</th>
                  <th>{{tgl_indo($detail_stok_opnam->tanggal_pelaksanaan)}}</th>
                </tr>
                <tr>
                  <th>Petugas</th>
                  <th>{{baca_pegawai($detail_stok_opnam->petugas)}}</th>
                  <th>kategori</th>
                  <th>{{$detail_stok_opnam->kategori}}</th>
                </tr>
                <tr>
                  <th>Catatan</th>
                  <th>{{$detail_stok_opnam->catatan}}</th>
                  <th>status</th>
                  <th>{{$detail_stok_opnam->status}}</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
        @if($detail_stok_opnam->kategori=='obat')
            <table class='table table-striped table-bordered table-hover table-condensed tableData'  id="tableData">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>stok</th>
                  <th>stok sekarang</th>
                  <th>selisih</th>
                  <th>keterangan</th>
                </tr>
              </thead>
        @elseif($detail_stok_opnam->kategori=='nonmedis')
            <table class='table table-striped table-bordered table-hover table-condensed tableDatanonmedis'  id="tableDatanonmedis">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>stok</th>
                  <th>stok sekarang</th>
                  <th>selisih</th>
                  <th>keterangan</th>
                </tr>
              </thead>
        @endif
              <tbody>

              </tbody>
            </table>
          </div>
          <center><a href="{{url('/stok-opnam/selesai/'.$detail_stok_opnam->no_stok_opnam)}}" type="button" class="btn btn-success btn-flat" onclick="javascript: return confirm('Apakah anda akan menyelesaikan ini?')" >Simpan & Setuju</a><center>
      </div>
      
      @endisset
    </div>



@stop

@section('script')
@isset($detail_stok_opnam)
    <script type="text/javascript">
    $(document).ready(function(){
    $(document).ready( function () {
      $('#tableData').DataTable({
          pageLength: 10,
          autoWidth: false,
          processing: true,
          serverSide: true,
    
            ajax: "{{ url('/stok-opnam/list_detail_stok').'/'.$detail_stok_opnam->no_stok_opnam }}",
            columns: [
                      { data: 'rownum', name: 'rownum' },
                      { data: 'kode', name: 'kode' },
                      { data: 'nama_obj', name: 'nama_obj' },
                      { data: 'stok_sebelum', name: 'stok_sebelum' },
                      { data: 'input'},
                      { data: 'selisih', name: 'selisih' },
                      { data: 'inputket',name:'inputket' }
                   ]
          });
      });
      });
      $(document).ready(function(){
      $(document).ready( function () {
        $('#tableDatanonmedis').DataTable({
            pageLength: 10,
            autoWidth: false,
            processing: true,
            serverSide: true,
      
              ajax: "{{ url('/stok-opnam/list_detail_stok').'/'.$detail_stok_opnam->no_stok_opnam }}",
              columns: [
                        { data: 'rownum', name: 'rownum' },
                        { data: 'kode', name: 'kode' },
                        { data: 'nama_barang', name: 'nama_barang' },
                        { data: 'stok_sebelum', name: 'stok_sebelum' },
                        { data: 'input'},
                        { data: 'selisih',name:'selisih'},
                        { data: 'inputket',name:'inputket'},                        
                    ]
            });
        });
        });
    $(document).ready(function(){
      $('.periode').datepicker({
          format: "yyyy-mm",
          viewMode: "months", 
          minViewMode: "months"
      });
    });
    
    function updatePemberian(value,no_po,kode_item){
      var table2 = $('#tableDatanonmedis').DataTable();
      var table3 = $('#tableData').DataTable();
      
      setTimeout(function () {
        
     
        $.ajax({
                url: '{{url('stok-opnam-update-pemberian')}}/'+value+'/'+no_po+'/'+kode_item,
                type: 'GET',
                success: function (data) {
                  console.log(data);
                    if(data.sukses == false) {
                      if(data.message!="") {
                        alert(data.message)
                      }else{
                        
                      }
                    }else if(data.sukses == true){
                      table2.ajax.reload( false);
                      table3.ajax.reload( false);
                      
                    }
                }
            });
          }, 3000);
    };
    function updateketerangan(value,no_po,kode_item){
      var table2 = $('#tableDatanonmedis').DataTable();
      var table3 = $('#tableData').DataTable();
      setTimeout(function () {
        
     
		$.ajax({
            url: '{{url('stok-opnam-update-keterangan')}}/'+value+'/'+no_po+'/'+kode_item,
            type: 'GET',
            success: function (data) {
              console.log(data);
                if(data.sukses == false) {
                  if(data.message!="") {
                    alert(data.message)
                  }else{
                    
                  }
                }else if(data.sukses == true){
                  table2.ajax.reload( false);
                  table3.ajax.reload( false);
                  
                }
            }
        });
      }, 3000);
    };
   
    </script>
@endisset
<script type="text/javascript">
$(document).ready(function(){
      $('.periode').datepicker({
          format: "yyyy-mm",
          viewMode: "months", 
          minViewMode: "months"
      });
    });
</script>
@endsection
