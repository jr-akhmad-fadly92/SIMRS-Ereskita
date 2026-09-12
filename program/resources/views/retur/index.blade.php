<style>
.content{
	padding:0 15px 15px 15px !important; 
}
</style>
@extends('master')
@section('header')
  <!--h1>Order Obat</h1-->
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
            Data Retur Obat &nbsp; &nbsp;    <a href="{{ url('retur-order') }}" class="btn btn-success btn-sm btn-flat">Retur</a>
        </h3>
      </div>
      <div class="box-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed tableData'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>No. Retur</th>
                  <th>Tanggal Retur</th>
                  <th>Petugas</th>
                  <th>Status</th>
                  <th>Detail</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
      </div>
    </div>

{{-- DETAIL Retur --}}
<div class="modal fade" id="detailPO" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog" style="width:750px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""></h4>
      </div>
      <div class="modal-body">
          <table class='table table-striped table-bordered table-hover table-condensed'>
              <tbody>
                <tr>
                    <th>Tanggal</th> <td id="tanggal">  </td>
                </tr>
                <tr>
					          <th>No. Retur</th> <td id="no_retur">  </td>
                </tr>
                <tr>
                    <th>Petugas</th> <td id='user_create'>  </td>
                </tr>
                <tr>
                    <th>Catatan</th> <td id='catatan'>  </td>
                </tr>
                <tr>
                    <th>Status</th> <td id='status'>  </td>
                </tr>
              </tbody>
          </table>

          <div class='table-responsive'>
            <table id="dataDetailPO" class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                  

                  </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-flat" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@stop

@section('script')
    <script type="text/javascript">
    $('.tableData').DataTable({
          autoWidth: false,
          processing: true,
          serverSide: true,
          ajax: '/retur-data',
          columns: [
              {data: 'rownum'},
              {data: 'no_retur'},
              {data: 'tanggal'},
              {data: 'user_create'},
              {data: 'status'},
              {data: 'aksi'}
          ]
    });

    //DETAIL PO
    $(document).on('click', '.view',function () {
        $('#detailPO').modal('show');
        $('.modal-title').text('Detail Retur');
        var id = $(this).attr('data-id');
        var retur = $(this).attr('data-retur');
        $.ajax({
            url: 'retur-data-detail/'+id,
            type: 'GET',
            success: function (data) {
                $('#tanggal').html(data.tanggal);
                $('#no_retur').html(data.po.no_retur);
                $('#distributor').html(data.distributor);
                $('#user_create').html(data.po.user_create);
                $('#catatan').html(data.po.catatan);
                $('#status').html(data.po.status);
                
            }
        })

        //DATA DETAIL ON MODAL
		$('#dataDetailPO').DataTable().destroy();
		var table = $('#dataDetailPO').DataTable({
        
			  lengthChange: false,
			  paging      : true,
			  searching   : true,
			  ordering    : true,
			  autoWidth   : false,
			  processing  : true,
			  info        : true,
			  serverSide  : true,
			  ajax: '/retur-detail/'+retur,
			  columns: [
				  {data: 'rownum'},
				  {data: 'kode'},
				  {data: 'nama'},
				  {data: 'jumlah'},
				  
			  ]
		});
    });
    </script>
@endsection
