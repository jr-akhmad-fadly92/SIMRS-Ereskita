@extends('master')

@section('header')
  <h1>Kasir - Cetak Ulang <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <div class='table-responsive'>
				<div class="col-md-6 pull-left">
					{!! Form::open(['method' => 'POST', 'url' => 'kasir/cetak', 'class'=>'form-hosizontal']) !!}
						<div class="row">
							<div class="col-md-6">
								<div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
										<span class="input-group-btn">
											<button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
										</span>
										{!! Form::text('tga', (session('tga')) ? session('tga') : '', ['style'=>'z-index:1020!important;', 'class' => 'form-control datepicker', 'required' => 'required']) !!}
										<small class="text-danger">{{ $errors->first('tga') }}</small>
								</div>
							</div>

							<div class="col-md-6">
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button">Sampai Tanggal</button>
									</span>
										{!! Form::text('tgb', (session('tgb')) ? session('tgb') : '', ['style'=>'z-index:1020!important;', 'class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
								</div>
							</div>
							</div>
						{!! Form::close() !!}
				</div>
        <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr class="text-center">
              <th>NO</th>
              <th>NO. REG</th>
              <th>NO. RM</th>
              <th>NAMA</th>
              <th>TGL. LAHIR</th>
              <th>CARA BAYAR</th>
              <th>INSTALASI</th>
              <th>TOTAL</th>
              <th>IUR</th>
              <th class="text-center">KWITANSI</th>
              <th class="text-center">RINCIAN BIAYA</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pemb as $key => $d)
              @php
                $bayar = Modules\Registrasi\Entities\Registrasi::where('id',$d->registrasi_id)->first();
              @endphp
							<tr>
								<td>{{ $no++ }}</td>
								<td>{{ $bayar->reg_id }}</td>
								<td>{{ $d->pasien->no_rm }}</td>
								<td>{{ '('.$d->pasien->kelamin.') '.$d->pasien->nama }}</td>
								<td>{{ tgl_indo($d->pasien->tgllahir) }}</td>
								<td>{{ $bayar->bayars->carabayar }}</td>
								<td>
									@if(substr($bayar->status_reg,0,1)=='I')
										Rawat Inap
									@elseif(substr($bayar->status_reg,0,1)=='J')
										Rawat Jalan
									@elseif(substr($bayar->status_reg,0,1)=='G')
										Rawat Darurat
									@endif
								</td>
								<td class="text-right">{{ number_format(total_tagihan($bayar->id,'Y')) }}</td>
								<td class="text-right">{{ number_format($d->iur) }}</td>
								<td class="text-center">
									<a target="" href="{{ url('kasir/cetak/cetakkuitansi/'.$d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
								</td>
								<td class="text-center">
									<a href="{{ url('kasir/rincian-biaya/'.$d->id) }}" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a>
								</td>
							</tr>              
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="box-footer">
			* <b>total</b> tersebut diatas adalah sebelum dipotong diskon (pasien umum)
    </div>
  </div>
@endsection
