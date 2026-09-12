@extends('master')
@section('header')
  @if (request()->segment(2) == 'igd')
    <h1>Kasir Rawat Darurat</h1>
  @else
    <h1>Kasir Rawat Jalan</h1>
  @endif

@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      {{-- <h3 class="box-title">
        Kasir &nbsp;
      </h3> --}}
    </div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'kasir/igd', 'class'=>'form-horizontal']) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                    {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-4">
                        {!! Form::text('tga', null, ['class' => 'form-control datepicker']) !!}
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                    <div class="col-sm-1">
                        s/d
                    </div>
                    <div class="col-sm-4">
                        {!! Form::text('tgb', null, ['class' => 'form-control datepicker']) !!}
                        <small class="text-danger">{{ $errors->first('tgb') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('lunas') ? ' has-error' : '' }}">
                    {!! Form::label('lunas', 'Lunas / Blm', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('ket_lunas', ['' => '[Semua]', 'N'=> 'Belum Lunas', 'Y'=>'Lunas', 'P'=>'Piutang'], null, ['class' => 'chosen-select']) !!}
                        <small class="text-danger">{{ $errors->first('Lunas/Blm') }}</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                        <button type="submit" class="btn btn-primary btn-flat pull-right">
                            Lanjut
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!--div class="form-group{{ $errors->has('carabayar') ? ' has-error' : '' }}">
                    {!! Form::label('carabayar', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="form-control" name="carabayar">
                          @if (!empty($_POST['carabayar']) && $_POST['carabayar'] == 1)
                            <option value="">[Semua]</option>
                            <option value="1" selected>JKN</option>
                            <option value="2">Umum</option>
                          @elseif (!empty($_POST['carabayar']) && $_POST['carabayar'] == 2)
                            <option value="">[Semua]</option>
                            <option value="1">JKN</option>
                            <option value="2" selected>Umum</option>
                          @else
                            <option value="">[Semua]</option>
                            <option value="1">JKN</option>
                            <option value="2">Umum</option>
                          @endif

                        </select>
                        <small class="text-danger">{{ $errors->first('carabayar') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tipe_jkn') ? ' has-error' : '' }}">
                    {!! Form::label('tipe_jkn', 'Tipe JKN', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        <select class="form-control" name="tipe_jkn">
                          @if (!empty($_POST['tipe_jkn']) && $_POST['tipe_jkn'] == 'PBI')
                            <option value="">[Semua]</option>
                            <option value="PBI" selected>PBI</option>
                            <option value="NON PBI">NON PBI</option>
                          @elseif (!empty($_POST['tipe_jkn']) && $_POST['tipe_jkn'] == 'NON PBI')
                            <option value="">[Semua]</option>
                            <option value="PBI">PBI</option>
                            <option value="NON PBI" selected>NON PBI</option>
                          @else
                            <option value="">[Semua]</option>
                            <option value="PBI">PBI</option>
                            <option value="NON PBI">NON PBI</option>
                          @endif

                        </select>
                        <small class="text-danger">{{ $errors->first('tipe_jkn') }}</small>
                    </div>
                </div-->
            </div>
        </div>
        {!! Form::close() !!}
        <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th class="text-center" style="vertical-align: middle;">No</th>
              <th class="text-center" style="vertical-align: middle;">Nama Pasien</th>
              <th class="text-center" style="vertical-align: middle;">No. RM</th>
              <th class="text-center" style="vertical-align: middle;">Dokter</th>
              <th class="text-center" style="vertical-align: middle;">Pelayanan</th>
              <th class="text-center" style="vertical-align: middle;">Cara Bayar</th>
              <th class="text-center" style="vertical-align: middle;">Total Tagihan</th>
              <th class="text-center" style="vertical-align: middle;">Bayar</th>
              <th class="text-center" style="vertical-align: middle;">Piutang</th>
            </tr>
          </thead>
          <tbody>
            @isset($today)
              @foreach ($today as $key => $d)
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $d->pasien->nama }}</td>
									<td>{{ $d->pasien->no_rm }}</td>
									<td>{{ baca_dokter($d->dokter_id) }}</td>
									<td>{{ $d->poli->nama }}</td>
									<td>{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
									<td class="text-right">{{ number_format(total_tagihan($d->id)) }}</td>
									<td>
										@if ($d->lunas == 'Y')
											 <i class="fa fa-check"> </i>
										@else
											@if ($d->lunas == 'N' AND $d->status_obat=='selesai')
												<a href="{{ url('kasir/rawatjalan/bayar/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
											@elseif($d->status_obat=='proses')
												<span class="text-aqua"> PROSES FARMASI </span>									
											@endif
										@endif
									</td>
									<td>
										@if ($d->lunas == 'P')
												Piutang
										@elseif($d->status_obat=='proses')
											<span class="text-aqua"> PROSES FARMASI </span>
										@else
												<a href="{{ url('kasir/piutang-igd/'.$d->id) }}" onclick="return confirm('Yakin akan di masukkan piutang?')" class="btn btn-sm btn-warning btn-flat"><i class="fa fa-dollar"></i></a>
										@endif
									</td>
								</tr>
              @endforeach
            @endisset
						
						{{--
            @isset($byRM)
              @foreach ($byRM as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->no_rm }}</td>
                  <td>{{ $d->reg_id }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ baca_poli($d->poli_id) }}</td>
                  <td>{{ baca_carabayar($d->bayar) }}</td>
                  <td>{{ number_format(total_tagihan($d->id)) }}</td>
                  <td>
                    <a href="{{ url('kasir/rawatjalan/bayar/'. $d->regid.'/'.$d->pasienid) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                  </td>
                </tr>
              @endforeach
            @endisset
						--}}
          </tbody>
        </table>
      </div>



      {{-- =================================================== --}}
      {{-- <div id="kasirIGD"> </div>

    </div> --}}
  </div>

  <!-- jQuery 3 -->
  {{-- <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      setInterval(function () {
        $('#kasirIGD').load("{{ route('kasir.ajax-igd') }}");
      },6000);
    });

  </script> --}}
@endsection


@section('script')
  <script type="text/javascript">
    $(document).ready(function() {
      if($('select[name="carabayar"]').val() == 1) {
        $('select[name="tipe_jkn"]').removeAttr('disabled');
      } else {
        $('select[name="tipe_jkn"]').attr('disabled', true);
      }

      $('select[name="carabayar"]').on('change', function () {
        if ($(this).val() == 1) {
          $('select[name="tipe_jkn"]').removeAttr('disabled');
        } else {
          $('select[name="tipe_jkn"]').attr('disabled', true);
        }
      });
    });

  </script>
@endsection
