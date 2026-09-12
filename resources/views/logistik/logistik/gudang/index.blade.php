@extends('master')
@section('header')
  <h1>Stok Gudang Obat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Stok Gudang Obat&nbsp;
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
             @foreach($stokobat as $data)
              <tr>
                <td>{{$no++}}</td>
                <td>{{$data->kode_obat}}</td>
                <td>{{$data->nama_obj}}</td>
                <td></td>
                <td>{{$data->stok}}</td>
                <td>{{$data->harga_jual}}</td>
                <td>{{$data->harga}}</td>
                <td></td>
                
              </tr>
             @endforeach 
            </tbody>
          </table>
        </div>

    </div>
  </div>
  <script>
function deletelist() {
  confirm("Anda Yakin ingin menghapus ?");
}
</script>
  
@endsection
