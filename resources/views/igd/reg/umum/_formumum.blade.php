{!! Form::hidden('status_reg', 'G1') !!}
<div class="row">
  <div class="col-md-6">
      <div class="form-group{{ $errors->has('poli_id') ? ' has-error' : '' }}">
        {!! Form::label('poli_id', 'Poli Tujuan', ['class' => 'col-sm-3']) !!}
        <div class="col-sm-9">
          <select class="form-control select2" name="poli_id">
            @foreach ($poli as $key => $d)
              <option value="{{ $d->id }}">{{ $d->nama }}</option>
            @endforeach
          </select>
          <small class="text-danger">{{ $errors->first('poli_id') }}</small>
        </div>
      </div>
      <div class="form-group{{ $errors->has('rujukan') ? ' has-error' : '' }}">
          {!! Form::label('rujukan', 'Cr Kunjungan', ['class' => 'col-sm-3']) !!}
          <div class="col-sm-9">
              {!! Form::select('rujukan', $rujukan, null, ['class' => 'form-control select2']) !!}
              <small class="text-danger">{{ $errors->first('rujukan') }}</small>
          </div>
      </div>
    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        {!! Form::label('status', 'Status ', ['class' => 'col-sm-3']) !!}
        <div class="col-sm-9">
          @if ($pasien && !empty($pasien->id))
            {!! Form::select('status', [2=>'Lama'], 2, ['class' => 'form-control select2', 'readonly'=>true]) !!}
          @else
            {!! Form::select('status', [1=>'Baru'], 1, ['class' => 'form-control select2', 'readonly'=>true]) !!}
          @endif
            <small class="text-danger">{{ $errors->first('status') }}</small>
        </div>
    </div>
    <div class="form-group{{ $errors->has('keterangan') ? ' has-error' : '' }}">
        {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('keterangan') }}</small>
        </div>
    </div>


    {!! Form::hidden('antrian_id', session('antrian_id')) !!}



  </div>
  {{-- =========================================================== --}}
  <div class="col-md-6">
    <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
        {!! Form::label('dokter_id', 'Dokter', ['class' => 'col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::select('dokter_id', $dokter, null, ['class' => 'form-control select2', 'placeholder'=>'-- Pilih Dokter --']) !!}
            <small class="text-danger">{{ $errors->first('dokter_id') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('sebabsakit_id') ? ' has-error' : '' }}">
        {!! Form::label('sebabsakit_id', 'Sebab Sakit', ['class' => 'col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::select('sebabsakit_id', $sebabsakit, null, ['class' => 'form-control select2', 'placeholder'=>'-- pilih --']) !!}
            <small class="text-danger">{{ $errors->first('sebabsakit_id') }}</small>
        </div>
    </div>

    <div class="form-group{{ $errors->has('bayar') ? ' has-error' : '' }}">
        {!! Form::label('bayar', 'Cara Bayar', ['class' => 'col-sm-3']) !!}
        <div class="col-sm-9">
          <select class="form-control select2" name="bayar" onchange="caraBayar(this.value)">
            @foreach ($carabayar as $key => $d)
							@if($d->id!=1)
								@if ($d->id == '2')
									<option value="{{ $d->id }}" selected>{{ $d->carabayar }}</option>
								@else
									<option value="{{ $d->id }}">{{ $d->carabayar }}</option>
								@endif
              @endif
            @endforeach
          </select>
            <small class="text-danger">{{ $errors->first('bayar') }}</small>
        </div>
    </div>
    <div id="asuransi" style="display:none;">
      <div class="form-group{{ $errors->has('asuransi_id') ? ' has-error' : '' }}">
          {!! Form::label('asuransi_id', 'Asuransi', ['class' => 'col-sm-3']) !!}
          <div class="col-sm-9">
              {!! Form::select('asuransi_id', $asuransi, null, ['class' => 'form-control select2', 'style' => 'width:100%;']) !!}
              <small class="text-danger">{{ $errors->first('asuransi_id') }}</small>
          </div>
      </div>
    </div>
    <div class="form-group{{ $errors->has('bayar') ? ' has-error' : '' }}">
        {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3']) !!}
        <div class="col-sm-9">
          <input type="text" name="tanggal" value="{{date('d-m-Y')}}" class="form-control datepicker">
        </div>
    </div>
  </div>
	
	<div class="col-md-12">
		<hr>
		<div class="btn-group pull-right">
         <a href="{{ url('frontoffice/rawat-darurat') }}" class="btn btn-warning btn-flat">Batal</a>
        {!! Form::submit("SIMPAN", ['class' => 'btn btn-success btn-flat', 'onclick'=>'return confirm("Anda yakin data yang di input sudah benar?")']) !!}
    </div>
  </div>
</div>

<script type="text/javascript">
function caraBayar(val){
	if(val==3){
		$("#asuransi").show();
	}else{
		$("#asuransi").hide();
	}
}
</script>