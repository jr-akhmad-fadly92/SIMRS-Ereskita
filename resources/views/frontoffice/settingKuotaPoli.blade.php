@extends('master')
@section('header')
  <h1>Konfigurasi Kuota Antrian<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Poli</th>
              <th>Kuota</th>
              <th>Loket</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($poli as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->kuota }}</td>
                <td>{{ $d->loket }}</td>
                <td>
                  <button type="button" onclick="editKuota({{ $d->id }})" class="btn btn-primary btn-sm btn-flat">
                    <i class="fa fa-edit"></i>
                  </button>
              </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>

  <div class="modal fade" id="modalKuota" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""</h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formKuota" class="form-horizontal" role="form">
            {{ csrf_field() }} {{ method_field('POST') }}
					  <input type="hidden" name="id" value="">
            <div class="form-group">
              <label for="namapoli" class="col-md-3 control-label" readonly >Nama Poli</label>
              <div class="col-md-9">
                <input type="text" name="nama" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="kuota" class="col-md-3 control-label">Jumlah Kuota</label>
              <div class="col-md-9">
                <input type="text" name="kuota" class="form-control" >
              </div>
            </div>
            <div class="form-group">
              <label for="kuota" class="col-md-3 control-label">Loket Antrian</label>
              <div class="col-md-9">
                <select name="loket" class="form-control" >
                  @for ($i = 0; $i <=6 ; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="saveKuota()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
  <script type="text/javascript">
    function editKuota(id) {
      $('#modalKuota').modal('show');
      $('.modal-title').text('Ubah Kuota Poli');
      $.ajax({
        url: '/frontoffice/get-poli/'+id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $('input[name="id"]').val(data.id);
          $('input[name="nama"]').val(data.nama);
          $('input[name="kuota"]').val(data.kuota);
          $('select[name="loket"]').val(data.loket);
        }
      });
    }

    //SAve Kuota
    function saveKuota() {
      $.ajax({
        url: '/frontoffice/save-kuota-poli',
        type: 'POST',
        dataType: 'json',
        data: $('#formKuota').serialize(),
        success: function (data) {
          if(data.sukses == true) {
            $('#modalKuota').modal('hide');
            location.reload();
          }
        }
      });

    }
  </script>
@endsection
