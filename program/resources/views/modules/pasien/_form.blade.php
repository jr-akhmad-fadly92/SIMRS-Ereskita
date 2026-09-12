<div class="row">

  {{-- kolom kiri  --}}

  <div class="col-md-6">

    @if (session('blm_terdata') == true)

      <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">

        {!! Form::label('no_rm', 'Nomor RM', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

          {!! Form::text('no_rm', null, ['class' => 'form-control']) !!}

          <small class="text-danger">{{ $errors->first('no_rm') }}</small>

        </div>

      </div>

    @endif

	

	@if(isset($bayi))

		<input type="hidden" value="{{$id_pasien}}" name="id_orangtua">

		<input type="hidden" value="{{$bayi}}" name="bayi">

	@endif

	

    <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">

        {!! Form::label('nama', 'Nama', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            {!! Form::text('nama', session('nama'), ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}

            <small class="text-danger text-bold">*nama harus diisi</small>

        </div>

    </div>

    <div class="form-group{{ $errors->has('nik') ? ' has-error' : '' }}">

        {!! Form::label('nik', 'NIK', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            {!! Form::text('nik', session('nik'), ['class' => 'form-control', 'maxlength'=>16]) !!}

			<small class="text-danger">{{ $errors->first('nik') }}</small>

        </div>

    </div>

    <div class="form-group{{ $errors->has('tmplahir') ? ' has-error' : '' }}">

        {!! Form::label('tmplahir', 'Tmp, Tgl Lahir', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            <div class="row">

              <div class="col-md-5">

                {!! Form::text('tmplahir', session('tmplahir'), ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}

                <small class="text-danger text-bold">*tempat lahir harus diisi</small>

              </div>

              <div class="col-md-7">

                {!! Form::text('tgllahir', (!empty($pasien->tgllahir)) ? tgl_indo($pasien->tgllahir) : null, ['class' => 'datepicker form-control', 'id'=>'tgllahir']) !!}

                <small class="text-danger text-bold">*tanggal lahir harus diisi</small>

              </div>

            </div>

        </div>

    </div>



    <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">

        {!! Form::label('alamat', 'Dsn, RT, RW', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-5">

            {!! Form::text('alamat', null, ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}

            <small class="text-danger">{{ $errors->first('alamat') }}</small>

        </div>

        <div class="col-sm-2">

            {!! Form::text('rt', null, ['class' => 'form-control', 'placeholder'=>'RT']) !!}

            <small class="text-danger">{{ $errors->first('rt') }}</small>

        </div>

        <div class="col-sm-2">

            {!! Form::text('rw', null, ['class' => 'form-control', 'placeholder'=>'RW']) !!}

            <small class="text-danger">{{ $errors->first('rw') }}</small>

        </div>

    </div>



		<div class="form-group{{ $errors->has('province_id') ? ' has-error' : '' }}">

		    {!! Form::label('province_id', 'Propinsi', ['class' => 'col-sm-3']) !!}

		    <div class="col-sm-9">

		        {!! Form::select('province_id', $provinsi, null, ['class' => 'form-control select2', 'placeholder'=>' ']) !!}

		        <small class="text-danger">{{ $errors->first('province_id') }}</small>

		    </div>

		</div>

    <div class="form-group{{ $errors->has('regency_id') ? ' has-error' : '' }}">

			{!! Form::label('regency_id', 'Kabupaten', ['class' => 'col-sm-3']) !!}

			<div class="col-sm-9">

					<select class="form-control select2" name="regency_id" id="regency_id">

						@if (!empty ($pasien->regency_id))

							<option value="{{ $pasien->regency_id }}">{{ baca_kabupaten($pasien->regency_id) }}</option>

						@elseif (session('regency_id'))

							<option value="{{ session('regency_id') }}">{{ (session('regency_id')!='') ? baca_kabupaten(session('regency_id')) : 0 }}</option>

						@endif

					</select>

					<small class="text-danger">{{ $errors->first('regency_id') }}</small>

			</div>

    </div>

    <div class="form-group{{ $errors->has('district_id') ? ' has-error' : '' }}">

			{!! Form::label('district_id', 'Kecamatan', ['class' => 'col-sm-3']) !!}

			<div class="col-sm-9">

				<select class="form-control select2" name="district_id" id="district_id">

					@if (!empty ($pasien->district_id))

						<option value="{{ $pasien->district_id }}">{{ baca_kecamatan($pasien->district_id) }}</option>

					@elseif (session('district_id')!=null)

						<option value="{{ session('district_id') }}">{{ (session('district_id')!='') ? baca_kecamatan(session('district_id')) : 0 }}</option>

					@endif

				</select>

					<small class="text-danger">{{ $errors->first('district_id') }}</small>

			</div>

    </div>

    <div class="form-group{{ $errors->has('village_id') ? ' has-error' : '' }}">

        {!! Form::label('village_id', 'Kelurahan', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

          <select class="form-control select2" name="village_id" id="village_id">

            @if (!empty ($pasien->village_id))

              <option value="{{ $pasien->village_id }}">{{ baca_kelurahan($pasien->village_id) }}</option>

						@elseif (session('village_id'))

							<option value="{{ session('village_id') }}">{{ (session('village_id')!='') ? baca_kelurahan(session('village_id')) : 0 }}</option>

            @endif

          </select>

            <small class="text-danger">{{ $errors->first('village_id') }}</small>

        </div>

    </div>

    <div class="form-group{{ $errors->has('alamat_penanggung_jawab') ? ' has-error' : '' }}">

        {!! Form::label('alamat_penanggung_jawab', 'Alamat PJ', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            {!! Form::text('alamat_penanggung_jawab', null, ['class' => 'form-control']) !!}

			<small class="text-danger">{{ $errors->first('alamat_penanggung_jawab') }}</small>

        </div>

    </div>

    <div class="form-group{{ $errors->has('hubungan_penanggung_jawab') ? ' has-error' : '' }}">

        {!! Form::label('hubungan_penanggung_jawab', 'Hubungan PJ', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            {!! Form::text('hubungan_penanggung_jawab', null, ['class' => 'form-control']) !!}

			<small class="text-danger">{{ $errors->first('hubungan_penanggung_jawab') }}</small>

        </div>

    </div>


  </div>

  {{-- kolom kanan =================================================================== --}}

  <div class="col-md-6">

    <div class="form-group{{ $errors->has('kelamin') ? ' has-error' : '' }}">

        {!! Form::label('kelamin', 'Jenis Kelamin', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            {!! Form::select('kelamin', ['L'=>'Laki-laki', 'P'=>'Perempuan'], null, ['class' => 'form-control select2 form-control']) !!}

            <small class="text-danger">{{ $errors->first('kelamin') }}</small>

        </div>

    </div>



    <div class="form-group{{ $errors->has('nohp') ? ' has-error' : '' }}">

      {!! Form::label('nohp', 'No. HP / Tlp', ['class' => 'col-sm-3']) !!}

      <div class="col-sm-9">

        {!! Form::text('nohp', null, ['class' => 'form-control']) !!}

		<small class="text-danger">{{ $errors->first('nohp') }}</small>

      </div>

    </div>

    <div class="form-group{{ $errors->has('pekerjaan_id') ? ' has-error' : '' }}">

        {!! Form::label('pekerjaan_id', 'Pekerjaan', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            {!! Form::select('pekerjaan_id', $pekerjaan, null, ['class' => 'form-control select2']) !!}

            <small class="text-danger">{{ $errors->first('pekerjaan_id') }}</small>

        </div>

    </div>

    <div class="form-group{{ $errors->has('agama_id') ? ' has-error' : '' }}">

        {!! Form::label('agama_id', 'Agama', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            {!! Form::select('agama_id', $agama, null, ['class' => 'form-control select2']) !!}

            <small class="text-danger">{{ $errors->first('agama_id') }}</small>

        </div>

    </div>

    <div class="form-group{{ $errors->has('pendidikan_id') ? ' has-error' : '' }}">

        {!! Form::label('pendidikan_id', 'Pendidikan', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            {!! Form::select('pendidikan_id', $pendidikan, null, ['class' => 'form-control select2']) !!}

            <small class="text-danger">{{ $errors->first('pendidikan_id') }}</small>

        </div>

    </div>



    <div class="form-group{{ $errors->has('ibu_kandung') ? ' has-error' : '' }}">

        {!! Form::label('ibu_kandung', 'Ibu Kandung', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            {!! Form::text('ibu_kandung', null, ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}

            <small class="text-danger text-bold">*ibu kandung harus diisi</small>

        </div>

    </div>



    <div class="form-group{{ $errors->has('status_marital') ? ' has-error' : '' }}">

        {!! Form::label('status_marital', 'Status Marital', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            @if (!empty($pasien->status_marital))

                <select class="form-control form-control select2" name="status_marital">

              @if ($pasien->status_marital == 'Blm Menikah')

                  <option value="Blm Menikah" selected="true">Blm Menikah</option>

                  <option value="Menikah">Menikah</option>

                  <option value="Janda">Janda</option>

                  <option value="Duda">Duda</option>

              @elseif ($pasien->status_marital == 'Menikah')

                 <option value="Blm Menikah">Blm Menikah</option>

                 <option value="Menikah" selected="true">Menikah</option>

                 <option value="Janda">Janda</option>

                 <option value="Duda">Duda</option>

              @elseif ($pasien->status_marital == 'Janda')

                 <option value="Blm Menikah">Blm Menikah</option>

                 <option value="Menikah">Menikah</option>

                 <option value="Janda" selected="true">Janda</option>

                 <option value="Duda">Duda</option>

              @elseif ($pasien->status_marital == 'Duda')

                 <option value="Blm Menikah">Blm Menikah</option>

                 <option value="Menikah">Menikah</option>

                 <option value="Janda">Janda</option>

                 <option value="Duda" selected="true">Duda</option>

              @else

                 <option value="Blm Menikah">Blm Menikah</option>

                 <option value="Menikah">Menikah</option>

                 <option value="Janda">Janda</option>

                 <option value="Duda">Duda</option>

              @endif

            </select>

            @else

                <select class="form-control form-control select2" name="status_marital">

                    <option value="Blm Meninkah">Blm Menikah</option>

                    <option value="Menikah">Menikah</option>

                    <option value="Janda">Janda</option>

                    <option value="Duda">Duda</option>

                </select>

            @endif

            

            <small class="text-danger">{{ $errors->first('status_marital') }}</small>

        </div>

    </div>

    

    <div class="form-group{{ $errors->has('penanggung_jawab') ? ' has-error' : '' }}">

        {!! Form::label('penanggung_jawab', 'Nama PJ', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            {!! Form::text('penanggung_jawab', null, ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}

            <small class="text-danger text-bold">*Penanggung Jawab harus diisi</small>

        </div>

    </div>
    
    <div class="form-group{{ $errors->has('telp_penanggung_jawab') ? ' has-error' : '' }}">

        {!! Form::label('telp_penanggung_jawab', 'Telp PJ', ['class' => 'col-sm-3']) !!}

        <div class="col-sm-9">

            {!! Form::text('telp_penanggung_jawab', null, ['class' => 'form-control', 'onkeyup'=>'this.value = this.value.toUpperCase()']) !!}

            <small class="text-danger text-bold">*Telp Penanggung Jawab harus diisi</small>

        </div>

    </div>
    
    

    </div>

</div>




@section('script')

  <script type="text/javascript">

    $('.select2').select2();

  </script>

@endsection

