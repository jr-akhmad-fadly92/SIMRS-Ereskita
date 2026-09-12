@extends('master')
@section('header')
  <h1>Master Obat </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Daftar Master Obat | {{ ucfirst(strtolower(Auth::user()->role()->first()->display_name)) }}
        </h3>
          
      </div>
      <div class="box-body">
      <div class="row">
        <div class="col-md-6">
        @role(['apotik'])
        Rincian RI: Harga dasar + harga_dasar x 15% , Rincian RJ : Harga dasar + harga_dasar x 10% <br><br>
      
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#rincian">Edit Rincian </button>
        @endrole
        
        </div>
        <div class="col-md-5">
        <div class='table-responsive'>
        <table  class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <td>Jumlah obat Experied</td>
                <td>{{$stok_kadaluarsa}}</td>
                <td><a href="#" class="btn btn-primary btn-sm " data-toggle="modal" data-target="#stok_explied">detail</a></td>
              </tr>
              <tr>
                <td>Jumlah obat Experied Null</td>
                <td>{{$stok_kadaluarsa_null}}</td>
                <td><a href="#" class="btn btn-primary btn-sm " data-toggle="modal" data-target="#stok_null">detail</a></td>
              </tr>
              <tr>
                <td>Jumlah obat Stok tipis/habis</td>
                <td>{{$stok_limit}}</td>
                <td><a href="#" class="btn btn-primary btn-sm " data-toggle="modal" data-target="#stok_limit">detail</a></td>
              </tr>
            </thead>
        </table>
        </div>
        </div>
        </div>
      </div>
      <div class="box-footer">
        <div class="col-md-12">
        <div class='table-responsive'>
          <table id='tableObat' class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <!--th>Satuan Beli</th>
                <th>Satuan Jual</th-->
                <th>Satuan</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Harga RJ</th>
                <th>Harga RI</th>
                <th>Info</th>
                
                <!--th>Harga JKN</th>
                <th>Harga Beli</th>
                <th>Edit</th-->
              </tr>
            </thead>
            
          </table>
        </div>
      </div>
      </div>
          
      </div>
    </div>
    <!-- Modal edit -->
    <div class="modal fade" id="rincian" tabindex="-1" role="dialog" style=" padding-right: 17px;"aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title">Edit fee obat
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              </h4>
          </div>
          <div class="modal-body">
          <b>Satuan %</b>
          <form method="post" action="{{url('update_margin')}}">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Rawat Inap</label>
                <input type="text" name="rawatinap" class="form-control" value="{{$margin->rawatinap}}">
            </div>
            <div class="form-group">
                <label>Rawat Jalan</label>
                <input type="text" name="rawatjalan" class="form-control" value="{{$margin->rawatjalan}}">
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal update-->
    <div class="modal fade" id="update_harga_dasar" tabindex="-1" role="dialog" style=" padding-right: 17px;"aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title">Update Harga
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              </h4>
          </div>
          <div class="modal-body">
          
          <form method="post" id="formupdate">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="form-group">
                <label>Nama Obat</label>
                <input type="text" name="kode" class="form-control" readonly value="">
                <input type="text" name="nama" class="form-control" readonly value="">
            </div>
            <div class="form-group">
                <label>harga jual</label>
                <input type="text" name="hargajual" class="form-control" value="">
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="saveItem" class="btn btn-primary">Simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal stok habis-->
    <div class="modal fade" id="stok_limit" tabindex="-1" role="dialog" style=" padding-right: 17px;"aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title">data stok habis
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              </h4>
          </div>
          <div class="modal-body">
          <div class='table-responsive'>
            <table  class='table table-striped table-bordered table-hover table-condensed' id="tableStokLimit">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Stok</th>
                    
                  </tr>
                 
                </thead>
            </table>
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <a type="button" id="saveItem" class="btn btn-primary" href="{{url('po-order')}}">Order Logistik</a>
          </div>
          
        </div>
      </div>
    </div>
    <!-- Modal stok habis-->
    <div class="modal fade" id="stok_explied" tabindex="-1" role="dialog" style=" padding-right: 17px;"aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title">data stok Explied
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              </h4>
          </div>
          <div class="modal-body">
          <div class='table-responsive'>
            <table  class='table table-striped table-bordered table-hover table-condensed' id="tableStokExpired">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Stok</th>
                    
                  </tr>
                 
                </thead>
            </table>
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <a type="button" id="saveItem" class="btn btn-primary" href="{{url('retur-order')}}">Retur Logistik</a>
          </div>
          
        </div>
      </div>
    </div>
    <!-- Modal stok habis-->
    <div class="modal fade" id="stok_null" tabindex="-1" role="dialog" style=" padding-right: 17px;"aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title">data stok null expired
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              </h4>
          </div>
          <div class="modal-body">
          <div class='table-responsive'>
            <table  class='table table-striped table-bordered table-hover table-condensed tableStokNull' id="data" name="tableStokNull">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Expired-date</th>
                    <th>Update</th>
                  </tr>
                 
                </thead>
                <tbody>
                @foreach($detail_stok_kadaluarsa_null as $data)
                
                  <tr>
                    <td>{{$no++}}</td>
                    <td>{{$data->nama}}</td>
                    <td><form method="post" action="{{url('update_expired_null')}}">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" name="kode" id="kode" value="{{$data->kode}}">
                        <input type="date" name="expired_date" id="expired_date" ></td>
                    <td><input type="submit"class="btn btn-sm btn-primary btn-flet" value="update" ></form></td>
                  
                  </tr>
                  
                @endforeach
                </tbody>
            </table>
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            
          </div>
          
        </div>
      </div>
    </div>

@stop
@section('script')
<script type="text/javascript">
$(document).on('click', '.insert',function () {
$('input[name="kode"]').val($(this).attr('data-id'));
$('input[name="nama"]').val($(this).attr('data-nama'));
$('input[name="hargajual"]').val($(this).attr('data-harga'));
$('#update_harga_dasar').modal('show');

});
$('#saveItem').on('click', function () {

  $.ajax({
    type: 'POST',
    url: '{{url('/update_harga_apotik')}}',
    data: $('#formupdate').serialize(),
    success: function (data) {
      console.log(data);
      if(data.sukses == false) {
        if(data.message!="") {
          alert(data.message)
        }else{
          
        }
      }else if(data.sukses == true){
        $('#tableObat').DataTable().ajax.reload(null, false);
        $('#grouphargajual').removeClass('has-error');
        $('#hargajual-error').html( "" )

        $('input[name="koda"]').val("");
        $('input[name="nama"]').val("");
        $('input[name="hargajual"]').val("");
        $('#update_harga_dasar').modal('hide');
        
        
      }
    }
  });
});
$('#tableStokLimit').DataTable({
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: 'obat/getstoklimit',
        columns: [
					{data: 'rownum', orderable: false, searchable: false},
					{data: 'nama', orderable: false},
				  {data: 'stok', sClass: 'text-center', orderable: false},
				
        ]
    });
$('#tableStokExpired').DataTable({
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: 'obat/getstokexplied',
        columns: [
					{data: 'rownum', orderable: false, searchable: false},
					{data: 'nama', orderable: false},
				  {data: 'stok', sClass: 'text-center', orderable: false},
				
        ]
    });

</script>
@endsection
