@extends('master')

@section('header')
  <h1>Jadwal Dokter</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Jadwal Dokter &nbsp;
        </h3>
      </div>
      @role(['administrator','admission'])
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'route' => 'jadwal-dokter.store', 'class' => 'form-horizontal']) !!}

            @include('jadwaldokter._form')

        {!! Form::close() !!}
      @endrole
        <hr>
        @if (!empty($jadwal))
          <div class='table-responsive'>
          
          <table id='jadwaldokter' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  
                  <th>Poli</th>
                  <th>Dokter</th>
                  <th>Hari</th>
                  <th>Jam Praktek</th>
                  @role(['administrator','admission'])<th>Hapus</th>@endrole
                </tr>
              </thead>
              
            </table>
          </div>

        @endif


      </div>
    </div>

    <div class="modal fade" id="poliJadwal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">Daftar Poli</h4>
          </div>
          <div class="modal-body">
            <div class='table-responsive'>
              <table class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Poli</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $no=1;
                  @endphp
                  @foreach (\Modules\Poli\Entities\Poli::select('nama')->get() as $key => $d)
                    <tr class='addPoli' data-poli="{{ $d->nama }}">
                      <td>{{ $no++ }}</td>
                      <td>{{ $d->nama }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          {{-- <div class="modal-footer">
            <button type="button" class="btn btn-default bt" data-dismiss="modal">Close</button>
          </div> --}}
        </div>
      </div>
    </div>


    <div class="modal fade" id="dokterJadwal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="">Data Dokter</h5>
          </div>
          <div class="modal-body">
            <div class='table-responsive'>
              <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Dokter</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $no=1;
                  @endphp
                  @foreach (\Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->select('nama')->get() as $key => $d)
                    <tr class="addDokter" data-dokter="{{ $d->nama }}">
                      <td>{{ $no++ }}</td>
                      <td>{{ $d->nama }}</td>
                    </tr>
                  @endforeach

                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
@stop
@script

@endscript