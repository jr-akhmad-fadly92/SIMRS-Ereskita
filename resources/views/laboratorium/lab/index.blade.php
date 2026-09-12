@extends('master')
@section('header')
  <h1>Laboratorium </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Laboratorium &nbsp;
          <a href="{{ route('lab.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="data_rindakan_lab">
            <thead>
              <tr>
                <th>No</th>
                <th>Kategori Lab</th>
                <th>Nama</th>
                <th>Nilai Rujukan Bawah</th>
                <th>Nilai Rujukan Atas</th>
                <th>Satuan</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $e)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ ($e->mastermapping_biaya_id!=null) ? $e->group->kelompok : '' }}</td>
                <td>{{ (isset($e->tarif->nama)) ? $e->tarif->nama : '' }}</td>
                <td>{{ $e->nilairujukanbawah }}</td>
                <td>{{ $e->nilairujukanatas }}</td>
                <td>{{ $e->satuan }}</td>
                <td><a href="{{ url('lab/'.$e->id.'/edit') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> </a></td>
              </tr>
            @endforeach

            </tbody>
          </table>
        </div>

      </div>
    </div>

@section('script')
<script type="text/javascript">
$('#data_rindakan_lab').DataTable( {
            lengthMenu : [[10, 25, 50,100,1000, -1], [10, 25, 50,100,1000, "All"]],
            
        } );
</script>
@endsection
@stop