@extends('master')
@section('header')
  <h1>Master Obat All</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Master Obat All&nbsp;
        <a href="{{ url('/master-obat-all/createobat-all') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        <a href="{{url('/backoffice')}}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i></a>
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
                <th>Kategori</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($Obat_all as $data)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$data->id_obat}}</td>
                    <td>{{$data->nama_obat}}</td>
                    <td>{{$data->satuan}}</td>
                    <td>
                    @if($data->katagori_obat>0)
                    {{App\Kategoriobat::find($data->katagori_obat)->nama}}
                    @else
                    Belum diisi
                    @endif</td>
                    <td><a href="{{ url('/master-obat-all/kode/'.$data->id_obat.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    <a href="{{ url('/master-obat-all/kode/'.$data->id_obat.'/delete') }}" onclick="return confirm('apakah anda yakin menghapus data ini?');"class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
