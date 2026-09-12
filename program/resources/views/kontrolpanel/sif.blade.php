@extends('master')
@section('header')
  <h1>Sif</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Data Sif&nbsp;
       
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="datasif">
            <thead>
              <tr>
                <th>Sif</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach(App\Sifuser::all() as $data)
              <tr>
                <td>{{$data->sif}}</td>
                <td>{{$data->jam_masuk}}</td>
                <td>{{$data->jam_pulang}}</td>
                <td><a href="#" data-kode="{{$data->id}}"  data-nama="{{$data->sif}}" data-masuk="{{$data->jam_masuk}}" data-pulang="{{$data->jam_pulang}}"  data-toggle="modal" data-target="#edit" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-check"></i></a> </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

    </div>
  </div>

  

<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="font-weight: bold;"></h4>
      </div>
      <div class="modal-body">
      <form id="formEditSif" class="form-horizontal">
        {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="id" class="form-control" readonly="true">
            <label for="kode_barang" class="control-label">Sif </label>
            <input type="text" name="nama" class="form-control" readonly="true">
            <label for="masuk" class="control-label">Masuk </label>
            <input type="time" name="masuk" class="form-control" >
            <label for="pulang" class="control-label">Pulang </label>
            <input type="time" name="pulang" class="form-control" >
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="simpan" class="btn btn-primary">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
  
@endsection
@section('script')
<script type="text/javascript">
$('#datasif').DataTable({
    autoWidth: false,
});

$(document).on('click', '.insert',function () {
$('.modal-title').text('Edit Sif');
$('input[name="id"]').val($(this).attr('data-kode'));

$('input[name="nama"]').val($(this).attr('data-nama'));

$('input[name="masuk"]').val($(this).attr('data-masuk'));

$('input[name="pulang"]').val($(this).attr('data-pulang'));

$('#edit').modal('show');

});

$('#simpan').on('click', function () {
$.ajax({
    type: 'POST',
    url: '{{url('/kontrolpanel/sif/update')}}',
    data: $('#formEditSif').serialize(),
    success: function (data) {
        console.log(data);
        if(data.sukses == false) {
            if(data.message!="") {
                alert(data.message)
            }else{
            }
        }else if(data.sukses == true){
            
        }

    }

});

});

</script>
@endsection
