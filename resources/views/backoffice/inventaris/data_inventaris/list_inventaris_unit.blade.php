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
					Data Inventaris &nbsp; &nbsp;
					
        </h3>
      </div>
      <div class="box-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed ' id="datapengajuan">
              <thead>
                <tr>
                  <th>No</th>
				          <th>Nama Inventaris</th>
                  <th>Ruangan</th>
                  <th>Kondisi Barang</th>
                  <th>Tanggal Masuk</th>
                  <th>Pengajuan</th>
                </tr>
              </thead>
              <tbody>
                @foreach($list as $data)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$data->nama_barang}}</td>
                        <td>{{$data->ruangan}}</td>
                        <td>{{$data->kondisi_barang}}</td>
                        <td>{{date('d F Y',strtotime($data->updated_at))}}</td>
                        <td><button type="button" class="btn btn-primary pengajuan" data-toggle="modal" data-kode="{{$data->no_inv}}" data-nama="{{$data->nama_barang}}">Pengajuan</button></td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
      </div>
    </div>

        <!-- M`odal -->
        <div class="modal fade" id="pengajuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <h5 class="modal-title" id=""></h5>
                </button>
            </div>
            <div class="modal-body">
            <form method="post" id="form_pengajuan_inventaris_rusak" >
							{{ csrf_field() }}
								<label for="no_inv" class="control-label">No Inv</label>
								<input type="text" name="no_inv" class="form-control" readonly="true">
						  	<label for="nama_barang" class="control-label">Nama Barang</label>
								<input type="text" name="nama_barang" class="form-control" readonly="true">
								<label for="alasan" class="control-label">Alasan</label>
								<select name="alasan" class="form-control " id="alasan">
                  <option value="rusak">Rusak</option>
                  <option value="hilang">Hilang</option>
                </select>
								<label for="tanggal" class="control-label">Tanggal Pengajuan</label>
								<input type="date" name="tanggal" class="form-control" id="tanggal" placeholder="">
								<label for="dokte_perawat" class="control-label">Nama Dokter / Perawat yang meminta</label><br>
                <select name="dokte_perawat" class="form-control select2" style="width:100%;"id="">
                <option disabled selected>--Pilih--</option>
                  @foreach(Modules\Pegawai\Entities\Pegawai::whereIn('kategori_pegawai',['1','2','3'])->get() as $data)
                    <option value="{{$data->nama}}">{{$data->nama}}</option>
                  @endforeach
                </select><br>
								<label for="petugas" class="control-label">Nama Petugas yang mengajukan</label><br>
							  <select name="petugas" class="form-control select2" style="width:100%;" id="">
                  <option disabled selected>--Pilih--</option>
                  @foreach(Modules\Pegawai\Entities\Pegawai::all() as $data)
                    <option value="{{$data->nama}}">{{$data->nama}}</option>
                  @endforeach
                </select>
								
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary " id="savepengajuan">Save changes</button>
            </form>
            </div>
            </div>
        </div>
        </div>`



@stop

@section('script')
<script type="text/javascript">
$('#datapengajuan').DataTable({
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: '{{url('get-list-inventaris/'.$id)}}',
        columns: [
					{data: 'rownum', orderable: false, searchable: false},
					{data: 'nama_barang', orderable: false},
				  {data: 'ruangan', orderable: false},
          {data: 'kondisi_barang', orderable: false},
          {data: 'tanggal', orderable: false},
          {data: 'pengajuan', orderable: false},
        ]
    });
$(document).on('click', '.pengajuan',function () {
    $('#pengajuan').modal('show');
    $('.modal-title').text('Pengajuan Inventaris Rusak / Hilang');
    $('input[name="no_inv"]').val($(this).attr('data-kode'));
		$('input[name="nama_barang"]').val($(this).attr('data-nama'));
	});
  $('#savepengajuan').on('click', function () {
    $.ajax({
			type: 'POST',
			url: '/pengajuan-inventaris-rusak',
			data: $('#form_pengajuan_inventaris_rusak').serialize(),
			success: function (data) {
				console.log(data);
				if(data.sukses == false) {
					
				}else if(data.sukses == true){
          //$('#datapengajuan').dataTable().fnDestroy();
          $('#datapengajuan').DataTable().ajax.reload(null, false);
          $('#pengajuan').modal('hide');
          if(data.alasan == 'rusak'){
            window.open('{{url('/pengajuan-invetaris-rusak')}}');
          }else  if(data.alasan == 'hilang'){
            window.open('{{url('/pengajuan-invetaris-hilang')}}');
          }
          
				}
			}
		});
	});

  //$('#data_pengajuan_inv_rusak').DataTable();
</script>
@endsection
