@extends('master')

@section('header')
  <h1>Kinerja Rawat Inap</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => '/direksi/kinerja-rawat-inap', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('cara_bayar') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('cara_bayar') ? ' has-error' : '' }}" type="button">Cara Bayar</button>
              </span>
              <select name="carabayar" class="chosen-select">
                <option value="100">[Semua]</option>
                  @foreach ($carabayar as $d)
                    @if (isset($_POST['carabayar']) && $_POST['carabayar'] == $d->id)
                      <option value="{{ $d->id }}" selected>{{ $d->carabayar }}</option>
                    @else
                      <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
                    @endif
                    
                  @endforeach
              </select>
              <small class="text-danger">{{ $errors->first('cara_bayar') }}</small>
          </div>
        </div>
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
          </div>
        </div>
        <div class="col-md-3">
          <div class="btn-group">
            <button type="submit" name="submit" value="view" class="btn btn-primary"><i class="fa fa-firefox"></i> VIEW</button>
            <button type="submit" name="submit" value="excel" class="btn btn-success"><i class="fa fa-file-excel-o"></i> EXCEL</button>
          </div>
        </div>
        </div>
      {!! Form::close() !!}
      <hr>
        <div class="table-responsive">
          <table class="table table-hover table-condensed table-bordered">
            <thead>
              <tr class="bg-primary">
                <th rowspan="2" class="text-center" style="vertical-align: middle;">No</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">Nama Dokter</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">Pemeriksaan</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">Konsultasi</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">Tindakan</th>
                {{-- @foreach ($bangsal as $k)
                  <th colspan="2" class="text-center" style="vertical-align: middle;">{{ str_replace('Ruang', '', $k->kelompok)  }}</th>
                @endforeach --}}
              </tr>
              {{-- <tr class="bg-primary">
                @foreach ($bangsal as $k)
                  <th class="text-center">Perawat</th>
                  <th class="text-center">Dokter</th>
                @endforeach
              </tr> --}}
            </thead>
            <tbody>
              @if (isset($dokter))
                @foreach ($dokter as $d)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->nama }}</td>
                    <td class="text-center"><a href="{{ url('/direksi/detail-kinerja-rawat-inap/'.$d->id.'/'.$cara_bayar_id.'/PM') }}" target="_blank">{{ number_format( pemeriksaan($d->id, 'TI', $tga, $tgb, $cara_bayar_id) ) }}</a></td>
                    <td class="text-center"><a href="{{ url('/direksi/detail-kinerja-rawat-inap/'.$d->id.'/'.$cara_bayar_id.'/KS') }}" target="_blank">{{ number_format( konsultasi($d->id, 'TI', $tga, $tgb, $cara_bayar_id) ) }}</a></td>
                    <td class="text-center"><a href="{{ url('/direksi/detail-kinerja-rawat-inap/'.$d->id.'/'.$cara_bayar_id.'/TN') }}" target="_blank">{{ number_format( tindakan($d->id, 'TI', $tga, $tgb, $cara_bayar_id) ) }}</a></td>
                    {{-- @foreach ($bangsal as $r)
                      <td></td>
                      <td class="text-right"></td>
                    @endforeach --}}
                  </tr>
                @endforeach
              @endif
              
              
            </tbody>
          </table>
        </div>


    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection


@section('script')
    <script type="text/javascript">
      // $('select[name="carabayar"]').change(function(e) {
      //   $('input[name="tga"]').val('');
      //   $('input[name="tgb"]').val('');
      // });
    </script>
@endsection
