@extends('master')
@section('header')
  <h1>Master Gizi <small><button class="btn btn-default" id="tambahGizi"> <i class="fa fa-plus"></i> </button></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-8">
        <button type="button"  class="btn btn-info btn-sm btn-flat" data-toggle="modal" data-target="#modal-input"> <i class="fa fa-edit"></i>Tambah menu</button>
          <div class='table-responsive'>
            <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Gizi</th>
                  <th>Jumlah kkal</th>
                  <th>Jumlah Protein</th>
                  
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($gizi as $key => $d)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->gizi }}</td>
                    <td>{{ $d->energi_kkal }}</td>
                    <td>{{ $d->protein_gr }}</td>
                    
                    <td>
                      <a href="{{ url('/gizi/edit/'.$d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>


  <div class="modal fade" id="modalGizi" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <form method="POST" class="form-horizontal" id="formGizi">
              {{ csrf_field() }} {{ method_field('POST') }}
              <input type="hidden" name="id" value="">
            <div class="form-group" id="inputGizi">
              <label for="gizi" class="col-md-3">Nama Gizi</label>
              <div class="col-md-9">
                <input type="text" name="gizi" class="form-control" >
                <span class="text-danger"><p id="gizi-error"></p> </span>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success btn-flat" id="saveGizi">Simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-input" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
        <form method="post" action="tambah_gizi_pasien">
            {{ csrf_field() }}
            
           <div class="form-group">
                <label>Nasi</label>
                <select id="nasi" name="nasi" class="form-control  @error('nasi') is-invalid @enderror">
                 
                  @foreach($nasi as $data)
                  <option value="{{ $data->id }}" >{{ $data->nama_menu }}</option>
                  @endforeach
                </select>
                
            </div>
            <div class="form-group">
                <label>Lauk Hewani</label>
                <select id="lauk_hewani" name="lauk_hewani" class="form-control  @error('lauk_hewani') is-invalid @enderror">
                 
                  @foreach($laukhewani as $data)
                  <option value="{{ $data->id }}">{{ $data->nama_menu }}</option>
                  @endforeach
                </select>
                
            </div>
            <div class="form-group">
                <label>Lauk Nabati</label>
                <select id="lauk_nabati" name="lauk_nabati" class="form-control  @error('lauk_nabati') is-invalid @enderror">
                 
                  @foreach($lauknabati as $data)
                  <option value="{{ $data->id }}">{{ $data->nama_menu }}</option>
                  @endforeach
                </select>
                
            </div>
            <div class="form-group">
                <label>Sayur</label>
                <select id="sayur" name="sayur" class="form-control  @error('sayur') is-invalid @enderror">
                 
                  @foreach($sayur as $data)
                  <option value="{{ $data->id }}">{{ $data->nama_menu }}</option>
                  @endforeach
                </select>
                
            </div>
            <div class="form-group">
                <label>Buah</label>
                <select id="buah" name="buah" class="form-control  @error('buah') is-invalid @enderror">
                 
                  @foreach($buah as $data)
                  <option value="{{ $data->id }}">{{ $data->nama_menu }}</option>
                  @endforeach
                </select>
                
            </div>
            <div class="form-group">
                <label>Snack</label>
                <select id="snack" name="snack" class="form-control  @error('snack') is-invalid @enderror">
                 
                  @foreach($snack as $data)
                  <option value="{{ $data->id }}">{{ $data->nama_menu }}</option>
                  @endforeach
                </select>
                
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Simpan">
            </div>
            </form>
                
        <div class="modal-footer">
          <div class="btn-group">
          
          </div>
          
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
<script type="text/javascript">
//disabled enter
$('#formGizi').keypress(function (event) {
    if (event.keyCode == 13) {
        event.preventDefault();
    }
});
//Add Form
  $('#tambahGizi').on('click', function () {
    $('#modalGizi').modal('show');
    $('.modal-title').text('Tambah Gizi');
    $('#formGizi')[0].reset();
    $('#inputGizi').removeClass('has-error');
    $('#gizi-error').html("");
  });
//Save Gizi
  $('#saveGizi').on('click', function() {
    var id = $('input[name="id"]').val();

    if(id != ''){
      url = '/mastergizi/'+id+'';
    } else {
      url = '{{ route('mastergizi.store') }}';
    }

    $.ajax({
      url: url,
      type:'POST',
      data: $('#formGizi').serialize(),
      success: function (data) {
        console.log(data);
        if(data.errors) {
          if(data.errors.gizi) {
            $('#inputGizi').addClass('has-error');
            $('#gizi-error').html( data.errors.gizi[0] );
          }
        };
        if (data.success == 1) {
          $('#formGizi')[0].reset();
          $('#modalGizi').modal('hide');
          location.reload();
          //document.location.href = '/mastergizi';
        }
      }
    });
  });

  //EDIT
  $('.editGizi').on('click', function () {
    $('#modalGizi').modal('show');
    $('.modal-title').text('Ubah Gizi');
    $('#inputGizi').removeClass('has-error');
    $('#gizi-error').html("");

    $.ajax({
      url: '/mastergizi/'+$(this).attr('data-id')+'/edit',
      type: 'GET',
      success: function(data) {
        $('input[name="id"]').val(data.id);
        $('input[name="gizi"]').val(data.gizi);
        $('input[name="_method"]').val('PATCH');
      }
    });
  });
</script>
@endsection
