@extends('master')

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
          Data Tindakan
        <button type="button" onclick="addForm()"  class="btn btn-default btn-flat">
            <i class="fa fa-plus"></i> TAMBAH
        </button>
      </h3>
    </div>
    <div class="box-body">
      <table id="tindakanTable" class="table table-striped table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>NO</th>
						<th>NAMA TINDAKAN</th>
						<th>AKSI</th>
					</tr>
				</thead>
				<tbody>
					@if($nama_tindakan!=null)
						@foreach($nama_tindakan as $key => $data)
							<tr>
								<td>{{$no++}}</td>
								@role('operasi')
									<td>{{ $data->tindakan_operasi }}</td>
								@endrole
								@role('radiologi')
									<td>{{ $data->tindakan_radiologi }}</td>
								@endrole
								<td>
									<button type="button" onclick="editForm('{{ $data->id }}')" class="btn btn-info btn-flat btn-sm">
											<i class="fa fa-edit"></i>
									</button>
									<a onclick="return confirm('Apakah yakin data ini akan dihapus ?');" href="{{ url('/tindakan/data/hapus/'.$data->id) }}" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-trash"></i> </a>
								</td>
							</tr>
						@endforeach
					@endif
				</tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="modalTindakan" tabindex="-1"  role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="masterTindakanForm"  method="post">
                {{ csrf_field() }} {{ method_field('POST') }}
                <input type="hidden" name="id" value="">
                <div class="form-group" id="tindakanGroup">
                  <label for="tindakan" class="col-md-3 control-label">Nama Tindakan</label>
                  <div class="col-md-9">
                      <input type="text" name="tindakan" class="form-control" >
                      <span class="text-danger" id="tindakanError"></span>
                  </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">TUTUP</button>
              <button type="button" onclick="saveForm()" class="btn btn-success btn-flat">SIMPAN</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		$('#tindakanTable').DataTable({
			pageLength: 20
		});
	});
	function addForm() {
		$('#modalTindakan').modal('show');
		$('.modal-title').text('Tambah Mapping')
		$('#tindakanGroup').removeClass('has-error');
		$('#tindakanError').html('');
		$('#masterTindakanForm')[0].reset()
		$('input[name="id"]').val('')
	}

	function editForm(id) {
		$('#modalTindakan').modal('show');
		$('.modal-title').text('Edit Nama Tindakan')
		$('#tindakanGroup').removeClass('has-error');
		$('#tindakanError').html('');
		$('#masterTindakanForm')[0].reset()
		$.ajax({
			url: '/tindakan/data/edit/'+id,
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				console.log(data);
				$('input[name="id"]').val(id)
				$('input[name="tindakan"]').val(data.tindakan)
			}
		});
	}

	function saveForm() {
		$.ajax({
			url: '/tindakan/data/simpan-tindakan',
			type: 'POST',
			data: $('#masterTindakanForm').serialize(),
			success: function (data) {
				console.log(data);
				if(data.status) {
					location.reload();
				}else{
					$('#tindakanGroup').addClass('has-error');
					$('#tindakanError').html(data.errors.mapping[0]);
				}
			}
		});
	}
</script>
@endsection
