@extends('master')
@section('header')
  <h1>Master Diet Gizi <small><button class="btn btn-default" id="tambahGizi"> <i class="fa fa-plus"></i> </button></small></h1>
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
            <table id='datadiet1' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <!--th>No</th-->
                  <th>Kategori</th>
                  <th>Nama Menu</th>
                  <th>Energi/kkal</th>
                  <th>Protein/gr</th>
                  <th>Edit</th>
                </tr>
              </thead>
              
            </table>
          </div>
        </div>
      </div>

    </div>
    <div class="box-footer">
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
        <form method="post" action="masterdietpasien">
            {{ csrf_field() }}
           <div class="form-group">
                <label>Katagori Diet Pasien</label>
                <select class="form-control" name="kategori_menu">
                  <option value="Nasi">Nasi</option>
                  <option value="lauk_hewani">Lauk Hewani</option>
                  <option value="lauk_nabati">Lauk Nabati</option>
                  <option value="sayur">Sayur</option>
                  <option value="buah">Buah</option>
                  <option value="snack">Snack</option>
                </select>
                @if($errors->has('kategori_menu'))
                    <div class="text-danger">
                        {{ $errors->first('kategori_menu')}}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" placeholder="contoh : nasi putih">
                  @if($errors->has('nama_menu'))
                    <div class="text-danger">
                        {{ $errors->first('nama_menu')}}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label>Energi</label>
                <input type="text" name="energi_kkal" class="form-control" placeholder="contoh : 36">
                  @if($errors->has('energi_kkal'))
                    <div class="text-danger">
                        {{ $errors->first('energi_kkal')}}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label>Protein</label>
                <input type="text" name="protein_gr" class="form-control" placeholder="contoh : 36">
                  @if($errors->has('protein_gr'))
                    <div class="text-danger">
                        {{ $errors->first('protein_gr')}}
                    </div>
                @endif
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
<script type="text/javascript" >

    $('#datadiet1').DataTable({
        
        processing: true,
        serverSide: true,
       
        ajax: 'getdata-diet',
        columns: [
           
            {data: 'kategori_menu'},
            {data: 'nama_menu'},
            {data: 'energi_kkal' },
            {data: 'protein_gr'},
            {data: 'edit'},
        ]
    });

</script>
@endsection
