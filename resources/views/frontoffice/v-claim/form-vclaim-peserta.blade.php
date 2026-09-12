@extends('master')
@section('header')
  <h1>V-Claim Peserta<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/v-claim/peserta', 'class'=>'form-hosizontal']) !!}
				<div class="row">
					<div class="col-md-6">
						<div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
								<span class="input-group-btn">
									<button class="btn btn-default }}" type="button">NO. BPJS / NIK KTP</button>
								</span>
								{!! Form::text('nomor', null, ['class' => 'form-control']) !!}
								<span class="input-group-btn">
									<button class="btn btn-success }}" type="submit">CARI</button>
								</span>
						</div>
					</div>
        </div>
      {!! Form::close() !!}
      <hr>
			
			@isset($data)
				@if($data!=null)
					<priv>
					{{ var_dump($data) }}
					</priv>
				
    </div>
  </div>
  <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr class="info">
                <th style="vertical-align: middle;">#</th>
                <th style="vertical-align: middle;"></th>
                <th style="vertical-align: middle;">Tgl / Waktu</th>
                <th style="vertical-align: middle;">No. RM</th>
                <th style="vertical-align: middle;">Nama</th>
                <th style="vertical-align: middle;">Cara Bayar</th>
                <th style="vertical-align: middle;">Tunai</th>
                <th style="vertical-align: middle;">Piutang</th>
                <th style="vertical-align: middle;">Subsidi</th>
                <th style="vertical-align: middle;">Kasir</th>
                <th style="vertical-align: middle;">Poli</th>
                <th style="vertical-align: middle;">Nama Dokter</th>
                {{-- <th style="vertical-align: middle;">Shift</th>
                <th style="vertical-align: middle;">Tipe Layanan</th> --}}
              </tr>
            </thead>
            <tbody>
              
                <tr>
                 
                </tr>
             
            </tbody>
           
          </table>
        </div>
        @endif
			@endisset
@endsection
