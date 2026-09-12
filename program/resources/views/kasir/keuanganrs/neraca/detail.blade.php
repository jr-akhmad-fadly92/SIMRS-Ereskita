
@extends('master')

@section('head')

@endsection
@section('header')

  <h1>Detail Neraca</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      Detail Neraca &nbsp<a href="{{url('keuangan/neraca')}}" class="btn btn-success">Back</a>
      </h3>
      
    </div>
    <div class="box-body">
    
        <div class='table-responsive col-md-12'>
        <h4>Data Neraca Bulan {{ $bulan }}</h4>
        <h5>Aktiva Lancar</h5>
          <table class='table table-striped table-bordered table-hover table-condensed' id="datajurnal_lancar">
          
            <thead>
              <tr>
                <th>Nama Akun</th>
                <th>Debet</th>
                <th>Kredit</th>
                
              </tr>
            </thead>
            <tbody>
            
            </tbody>
              
          </table>
          <h5>Aktiva Lancar</h5>
          <table class='table table-striped table-bordered table-hover table-condensed' id="datajurnal_tetap">
          
            <thead>
              <tr>
                <th>Nama Akun</th>
                <th>Debet</th>
                <th>Kredit</th>
                
              </tr>
            </thead>
            <tbody>
            
            </tbody>
              
          </table>
          <h4 style="font-weight: bold;">
          Total
          </h4>
          <table class='table table-striped table-bordered table-hover table-condensed text-center' style="font-weight: bold;font-size:12;" id="datatotal">
          
            <thead>
              <tr>
                <th>Aktiva Lancar</th>
                <th>Aktiva Tetap</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr style="font-weight: bold;font-size:12;">
                <td>Rp. {{number_format($debet_lancar)}}</td>
                <td>Rp. {{number_format($debet_tetap)}}</td>
                <td>Rp. {{number_format($debet)}}</td>
                
              </tr>
              <tr style="font-weight: bold;font-size:12;">
                <td>{{terbilang($debet_lancar)}} Rupiah</td>
                <td>{{terbilang($debet_tetap)}} Rupiah</td>
                <td>{{terbilang($debet)}} Rupiah</td>
              </tr>
            </tbody>
              
          </table>
        </div>

    </div>

  </div>
  

  
@endsection
@section('script')
<script type="text/javascript">
  
	$('#datajurnal_lancar').DataTable({
  lengthChange: true,
  pageLength  :   100,
  paging      : false,
  searching   : false,
  ordering    : true,
  autoWidth   : false,
  processing  : true,
  info        : true,
  serverSide  : true,
  ajax: '{{url('/keuangan/list-detail-neraca-aktiva-lancar/'.$id)}}',
  columns: [
      {data: 'nama_akun', name: 'nama_akun'},
      {data: 'debet', name: 'debet'},
      {data: 'kredit', name: 'kredit'},
     
    ]
  })
  $('#datajurnal_tetap').DataTable({
  lengthChange: true,
  pageLength  :   100,
  paging      : false,
  searching   : false,
  ordering    : true,
  autoWidth   : false,
  processing  : true,
  info        : true,
  serverSide  : true,
  ajax: '{{url('/keuangan/list-detail-neraca-aktiva-tetap/'.$id)}}',
  columns: [
      {data: 'nama_akun', name: 'nama_akun'},
      {data: 'debet', name: 'debet'},
      {data: 'kredit', name: 'kredit'},
     
    ]
  })
  
  
  $(document).ready(function(){
      $('.periode').datepicker({
          format: "MM-yyyy",
          viewMode: "months", 
          minViewMode: "months"
      });
    });
 
</script>
@endsection
