@extends('master')
@section('header')
  <h1>Pengajuan Inventaris</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Pengajuan Inventaris&nbsp;
      </h3>
    </div>
    <div class="box-body">
        <button type="button"  class="btn btn-info btn-sm btn-flat" data-toggle="modal" data-target="#modal-input"> <i class="fa fa-edit"></i>Buat Pengajuan</button>
        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>Kode Pengajuan</th>
                <th>Jumlah Barang</th>
                <th>Nama Yang mengajukan</th>
                <th>Sum Harga Pengajuan</th>
                <th>Action</th>
                
                
              </tr>
            </thead>
            <tbody>
              
             
            </tbody>
          </table>
        </div>

    </div>
  </div>
  <!---- modal --->
  <div class="modal fade" id="modal-input" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
        <button type="button"  class="btn btn-info btn-sm btn-flat" data-toggle="modal" data-target="#modal-new"> <i class="fa fa-edit"></i>buat baru</button>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                
                <th>Pilih</th>
              </tr>
            </thead>
            <tbody>
            
            </tbody>
          </table>
                
        <div class="modal-footer">
          <div class="btn-group">
          
          </div>
          
        </div>
      </div>
    </div>
  </div>
  <!---end modal--->
  <!--modal 2--->
  
  <!---end modal--->
@endsection
