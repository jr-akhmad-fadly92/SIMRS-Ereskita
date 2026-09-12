@extends('master')
@section('header')
  <h1>Gudang Obat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Gudang Obat&nbsp;
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="dataobat">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Harga Beli</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>

    </div>
  </div>
  @endsection
  @section('script')
  <script>
function deletelist() {
  confirm("Anda Yakin ingin menghapus ?");
}
  $('#dataobat').DataTable({
  autoWidth: false,
  processing: true,
  serverSide: true,
  ajax: '/get-data-gudang-obat',
  columns: [
      {data: 'rownum'},
      {data: 'kode_obat'},
      {data: 'nama_obj'},
      {data: 'satuan'},
      {data: 'stok'},
      {data: 'harga'}
  ]
  });
</script>
    
@endsection
