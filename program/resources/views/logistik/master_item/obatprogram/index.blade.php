@extends('master')
@section('header')
  <h1>Master Obat Program</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Master Obat Program&nbsp;
        <a href="{{ url('/master/obat_program/createobat_program') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-9'>
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
                @foreach($Obatprogram as $data)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$data->nama_program}}</td>
                    <td>{{$data->keterangan}}</td>
                    
                    <td><a href="{{ url('/master/obat_program/kode/'.$data->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    <a href="{{ url('/master/obat_program/kode/'.$data->id.'/delete') }}" onclick="return confirm('apakah anda yakin menghapus data ini?');"class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
