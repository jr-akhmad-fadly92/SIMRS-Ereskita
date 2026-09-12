@extends('master')
@section('header')
  <h1>Master Jenis Racikan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Master Jenis Racikan&nbsp;
        <a href="{{ url('/master/jenis_racikan/createjenisracikan') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-6'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr>
                <th>No</th>
                <th>Jenis Racikan</th>
                
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
                @foreach($jenis_racikan as $j)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$j->jenis_racikan}}</td>
                    <td><a href="{{ url('/master/jenis_racikan/kode/'.$j->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    <a href="{{ url('/master/jenis_racikan/kode/'.$j->id.'/delete') }}" onclick="return confirm('apakah anda yakin menghapus data ini?');"class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
