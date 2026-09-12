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
      <div class="box-header with-border">
      <a href="{{url('/stok-opnam/open_create')}}"type="button" class="btn btn-primary" >Tambah</a>
     </div>
      <div class="box-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed tableData' id="tableData">
              <thead>
                <tr>
                  
                  <th>No. Stok opnam</th>
                  <th>Tanggal</th>
                  <th>Petugas</th>
                  <th>Kategori</th>
                  <th>Keterangan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
      </div>
    </div>

  

@stop

@section('script')
    <script type="text/javascript">
    $(document).ready(function(){
    $(document).ready( function () {
      $('#tableData').DataTable({
          pageLength: 10,
          autoWidth: false,
          processing: true,
          serverSide: true,
    
            ajax: "{{ url('/stok-opnam/listall')}}",
            columns: [
                     
                      { data: 'no_stok_opnam', name: 'no_stok_opnam' },
                      { data: 'date' },
                      { data: 'petugas_stok_opnam' },
                      { data: 'kategori'},
                      { data: 'catatan'},
                      { data: 'aksi' }
                   ]
          });
      });
      });
    </script>
@endsection
