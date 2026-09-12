@extends('master')
@section('header')
  <h1>Tahun Tarif</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Master Lokasi Barang&nbsp;
        <a href="{{ url('/backoffice/master_lokasi_barang/createlokasi') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-6'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Ruangan</th>
                <th>Lokasi Barang</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach($lokasi_barang as $lokasi)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$lokasi->ruangan}}</td>
                    <td>{{$lokasi->lokasi}}</td>
                    <td><a href="{{ url('/backoffice/master_lokasi_barang/kode/'.$lokasi->id_lokasi.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    <a href="{{ url('/backoffice/master_lokasi_barang/kode/'.$lokasi->id_lokasi.'/delete') }}" onclick="return confirm('apakah anda yakin menghapus data ini?');"class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
