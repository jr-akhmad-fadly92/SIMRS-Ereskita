{!! Form::open(['method' => 'POST', 'url' => 'kasir/rawatjalan', 'class'=>'form-horizontal']) !!}
<!--div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
            {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3']) !!}
            <div class="col-sm-6">
                {!! Form::text('tanggal', null, ['class' => 'form-control datepicker']) !!}
                <small class="text-danger">{{ $errors->first('tanggal') }}</small>
            </div>            
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-flat btn-block">
                    Lanjut
                </button>
            </div>
        </div>
    </div>
</div-->
{!! Form::close() !!}

<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Pasien</th>
        <th>No. RM</th>
        <th>Dokter</th>
        <th>Poli</th>
        <th>Cara Bayar</th>
        <th>Tanggal</th>
        <th>Total Tagihan</th>
        <th>Bayar</th>
        <th>Piutang</th>
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
						<td>{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
						<td>{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
						<td>{{ $d->created_at->format('d-m-Y') }}</td>
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
							@if ($d->bayar <> 1)
								@if ($d->lunas == 'P')
									Piutang
								@elseif($d->status_obat=='proses')
									<span class="text-aqua"> PROSES FARMASI </span>
								@else
									<a href="{{ url('kasir/piutang/'.$d->id) }}" onclick="return confirm('Yakin akan di masukkan piutang?')" class="btn btn-sm btn-warning btn-flat"><i class="fa fa-dollar"></i></a>
								@endif
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
            <td>
            </td>
          </tr>
        @endforeach
      @endisset
			--}}
    </tbody>
  </table>
</div>

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
