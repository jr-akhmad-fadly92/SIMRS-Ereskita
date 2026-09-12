@extends('master')

@section('header')
  <h1>Pasien </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-body">
        <div class='table-responsive'>
          <table id='rekammedispasien' class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                {{-- <th>No</th> --}}
                <th>No. RM</th>
                <th>Nama</th>
                <th>Kelamin</th>
                <th>Tgl Lahir</th>
                <th>Alamat</th>
                <th>Histori Rekam Medis</th>
              </tr>
            </thead>

          </table>
        </div>

      </div>
    </div>

    <div class="modal fade" id="pasienModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">Data Lengkap Pasien</h4>
          </div>
          <div class="modal-body">
            <div id="dataPasien"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
@stop
