@extends('master')
@section('header')
  <h1>Master Obat All</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Master Non Medis&nbsp;
        <a href="{{ url('/master-nonmedis/createnonmedis') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
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
                <th>Jenis</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
             @foreach($non_medis as $data)
              <tr>
                <td>{{$no++}}</td>
                <td>{{$data->kode_barang}}</td>
                <td>{{$data->nama_barang}}</td>
                <td>{{$data->satuan}}</td>
                <td>{{$data->jenis_barang}}</td>
                <td>{{$data->stok}}</td>
                <td>Rp. {{number_format($data->harga)}}</td>
                <td>
                <a href="{{ url('/master-nonmedis/kode/'.$data->kode_barang.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                <a href="{{ url('/master-nonmedis/kode/'.$data->kode_barang.'/delete') }}" onclick="return confirm('apakah anda yakin menghapus data ini?');"class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                    
                </td>
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
