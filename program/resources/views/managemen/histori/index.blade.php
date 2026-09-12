@extends('master')
@section('header')
  <h1>Pegawai Rumah Sakit</h1>
@endsection
@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Histori Pendidikan dan Kesehatan Pegawai<br> &nbsp;
         
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed table-pegawai' id='dataPegawai'>
          <thead>
              <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Kategori Pegawai</th>
                <th style="width:50px;">detail</th>
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
var table = $('#dataPegawai').DataTable({
        lengthChange: true,
        paging      : true,
        searching   : true,
        ordering    : true,
        autoWidth   : false,
        processing  : true,
        info        : true,
        serverSide  : true,
        ajax: '/managemen/histori/get-data-pegawai',
        columns: [
                {data: 'rownum'},
                {data: 'kode'},
                {data: 'nama'},
                {data: 'kategori_pegawai'},
                {data: 'add'},
                        ]
    });
</script>
@endsection
