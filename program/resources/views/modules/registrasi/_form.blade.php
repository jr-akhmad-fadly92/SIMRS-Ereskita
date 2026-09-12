{!! Form::hidden('antrian_id', session('antrian_id')) !!}

{!! Form::hidden('status_reg', 'J1') !!}

{!! Form::hidden('bayar', '1') !!}



<div class="row">

  <div class="col-md-6">

		@if(session('urlx')=='bayi')

			{!! Form::hidden('poli_id', 0) !!}

		@else

    <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">

      {!! Form::label('poli_id', 'Poli tujuan', ['class' => 'col-sm-3']) !!}

      <div class="col-sm-9">

        <select class="form-control select2" name="poli_id">

          <option value=""></option>

          @foreach ($poli as $key => $d)

            <option {{ (session('poli_tujuan')==$d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->nama }}</option>

          @endforeach

        </select>

        <small class="text-danger">{{ $errors->first('poli_id') }}</small>

      </div>

    </div>

		@endif

    <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">

        {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

					

					 <select class="form-control select2" name="dokter_id">

              <option value=""></option>

              @foreach ($dokter as $key => $d)

                <option {{ (session('dokter')==$d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->nama }}</option>

              @endforeach

            </select>


						

            <small class="text-danger">{{ $errors->first('dokter_id') }}</small>

        </div>

    </div>



    @if (request()->segment(1) == 'regperjanjian')

      <div class="form-group{{ $errors->has('bayar') ? ' has-error' : '' }}">

          {!! Form::label('bayar', 'Cara Bayars', ['class' => 'col-sm-3']) !!}

          <div class="col-sm-5">

              {!! Form::select('bayar', $carabayar, null, ['class' => 'form-control select2']) !!}

              <small class="text-danger">{{ $errors->first('bayar') }}</small>

          </div>

          <div class="col-sm-4" id="tipeJKN">

              {!! Form::select('jkn', ['PBI'=>'PBI', 'NON PBI'=>'NON PBI'], null, ['class' => 'form-control select2']) !!}

              <small class="text-danger">{{ $errors->first('bayar') }}</small>

          </div>

      </div>

    @endif

  </div>

	

  {{-- =========================Kolom Kanan=========================== --}}

	

  <div class="col-md-6">

    <div class="form-group{{ $errors->has('tipe_layanan') ? ' has-error' : '' }}">

        {!! Form::label('tipe_layanan', 'Tipe Layanan', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            {!! Form::select('tipe_layanan', $tipelayanan, '2', ['class' => 'form-control select2']) !!}

            <small class="text-danger">{{ $errors->first('tipe_layanan') }}</small>

        </div>

    </div>



    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">

        {!! Form::label('status', 'Status', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

          @if ($pasien && !empty($pasien->id) && session('urlx')!='bayi')

            {!! Form::select('status', $status, 2, ['class' => 'form-control', 'readonly'=>true]) !!}

          @else

            {!! Form::select('status', $status, 1, ['class' => 'form-control', 'readonly'=>true]) !!}

          @endif

            <small class="text-danger">{{ $errors->first('status') }}</small>

        </div>

    </div>



    @if (request()->segment(1) == 'regperjanjian')

      <div class="form-group{{ $errors->has('created_at') ? ' has-error' : '' }}">

          {!! Form::label('created_at', 'Tanggal Periksa', ['class' => 'col-sm-3']) !!}

          <div class="col-sm-9">

              {!! Form::text('created_at', '', ['class' => 'form-control', 'id'=>'regperjanjian', 'required' => 'required']) !!}

              <small class="text-danger">{{ $errors->first('created_at') }}</small>

          </div>

      </div>

    @endif

  </div>

		

	<div class="col-md-12">

		<hr>

		<div class="pull-right">

				<a href="{{ url('antrian/daftarantrian/'.session('no_loket')) }}" class="btn btn-warning btn-flat">BATAL</a>

				{!! Form::submit("LANJUT ", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Anda yakin data yang di input sudah benar?")']) !!}

		</div>

	</div>

</div>

