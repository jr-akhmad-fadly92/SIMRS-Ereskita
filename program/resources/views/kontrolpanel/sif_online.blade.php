@extends('master')
@section('header')
  <h1>Sif</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Data User Online&nbsp;
      
      </h3>
    </div>
    <div class="box-body">

        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed' id="datasifon">
            <thead>
              <tr>
                <th>Nama User</th>
                <th>Bagian</th>
                <th>Sif</th>
                <th>Status</th>
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
<script type="text/javascript">

var table = $('#datasifon').DataTable({
lengthChange: false,
paging      : false,
searching   : false,
ordering    : false,
autoWidth   : false,
processing  : false,
info        : false,
serverSide  : true,
ajax: '/kontrolpanel/sif_online/get',
columns: [
        {data: 'user'},
        {data: 'role'},
        {data: 'sif'},
        {data: 'status'},
]
});

setInterval( function () {
    table.ajax.reload();
}, 10000 );
</script>
@endsection
