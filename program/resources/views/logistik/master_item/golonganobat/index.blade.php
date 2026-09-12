@extends('master')
@section('header')
  <h1>Master Golongan Obat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Master Golongan Obat&nbsp;
        <a href="{{ url('/master/golongan_obat/creategolongan_obat') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-6'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Golongan</th>
                <th>Keterangan Golongan</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
                @foreach($golonganobat as $data)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$data->nama_golongan}}</td>
                    <td>{{$data->keterangan}}</td>
                    
                    <td><a href="{{ url('/master/golongan_obat/kode/'.$data->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    <a href="{{ url('/master/golongan_obat/kode/'.$data->id.'/delete') }}" onclick="return confirm('apakah anda yakin menghapus data ini?');"class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
