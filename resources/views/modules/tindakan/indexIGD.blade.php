@extends('master')

@section('header')
  <h1>Penata Jasa Rawat Darurat  </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title pull-left">
          Periode Tanggal: &nbsp;
        </h3>
				<div class="col-md-8 pull-right">
				{!! Form::open(['method' => 'POST', 'url' => 'tindakan/igd', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()']) !!}
            </div>
          </div>
        </div>
        {!! Form::close() !!}
        </div>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
					<div class="col-md-8 no-padding pull-left">
						Keterangan <br>
						<button type="button" class="btn btn-sm btn-info btn-flat">
							<i class="fa fa-flask"></i>
						</button> Order Lab
						&nbsp; &nbsp; &nbsp; &nbsp;
						<button type="button" class="btn btn-success btn-flat btn-sm">
							<i class="fa fa-television"></i>
						</button> Order Radiologi
						&nbsp; &nbsp; &nbsp; &nbsp;
						{{--<button type="button" class="btn btn-success btn-flat btn-sm">
							<i class="fa fa-hand-lizard-o"></i>
						</button> Order Fisioterapi
						&nbsp; &nbsp; &nbsp; &nbsp;--}}
						<button type="button" class="btn btn-sm btn-info btn-flat">
							<i class="fa fa-edit"></i>
						</button> Entry Tindakan
						&nbsp; &nbsp; &nbsp; &nbsp;
						<button type="button" class="btn btn-success btn-flat btn-sm">
							<i class="fa fa-user"></i>
						</button> False Emergency
					</div>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>No. RM</th>
                <th>Nama Pasien</th>
                <th>Tgl. Lahir</th>
                <th>Dokter</th>
                <th>Triage</th>
                <th>Cara Bayar</th>
                <th>False EM</th>
                <th style="width: 10%">Order</th>
                <th style="width: 10%">Proses</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($registrasi as $key => $d)
                @if (Auth::user()->role()->first()->name == 'rawatdarurat')
									@if ( cek_tindakan($d->id, 6) >= 2 )
									<tr class="info">
									@else
									<tr>
									@endif
                @endif
									<td>{{ $no++ }}</td>
                  <td>{{ $d->pasien->no_rm }}</td>
									<td>
										@if (Carbon\Carbon::now() > $d->created_at->addHours(6) && $d->status_reg == 'G1')
											<span class="blink_me" style="color: red; font-weight: bold;">{{ $d->pasien->nama }}</span>
										@else
											{{ $d->pasien->nama }}
										@endif
									</td>
                  <td>{{ tgl_indo($d->pasien->tgllahir) }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ !empty($d->poli_id) ? $d->poli->nama : '' }}</td>
                  <td>{{ baca_carabayar($d->bayar) }}
                    @if (!empty($d->tipe_jkn))
                      - {{ $d->tipe_jkn }}
                    @endif
                  </td>
                  <td>{{ $d->status_ugd }}</td>
                  <td>
										<a style="margin-bottom:3px;" href="{{ url('tindakan/order/laboratorium/darurat/'.$d->id) }}" onclick="return confirm('Yakin akan di order ke LAB?')" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-flask"> </i></a>
										<br>
                    <a style="margin-bottom:3px;" href="{{ url('tindakan/order/radiologi/darurat/'.$d->id) }}" onclick="return confirm('Yakin akan di order ke RADIOLOGI?')"  class="btn btn-primary btn-sm btn-flat"><i class="fa fa-television"> </i></a>
										<br>
                  </td>
                  <td>
                    <a href="{{ url('tindakan/entry/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                    <button type="button" onclick="triage({{ $d->id }}, '{{ $d->pasien->nama }}', '{{ $d->pasien->no_rm }}')" class="btn btn-success btn-flat btn-sm">
                      <i class="fa fa-user"></i>
                    </button>
                  </td>
                  <td>{{ ucwords($d->posisi_pasien) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalTriage" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id=""></h4>
          </div>
          <div class="modal-body">
            <form method="POST" class="form-horizontal" role="form">
              <input type="hidden" name="registrasi_id" value="">
                <div class="form-group">
                  <label for="nama" class="col-md-3">Nama Pasien</label>
                  <div class="col-md-6">
                    <input type="text" readonly class="form-control" id="namaPasien" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="norm" class="col-md-3">No. RM</label>
                  <div class="col-md-6">
                    <input type="text" readonly class="form-control" id="nomorRM" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="kondisi" class="col-md-3">False Emergency</label>
                  <div class="col-md-6">
                    <select class="form-control" name="status_ugd">
                      <option value="HTS1">HTS1</option>
                      <option value="HTS2">HTS2</option>
                      <option value="HTS3">HTS3</option>
                      <option value="HTS4">HTS4</option>
                    </select>
                  </div>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
              <button type="button" onclick="simpanTriage()" class="btn btn-primary btn-flat">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </div>

@stop

@section('script')
  <script type="text/javascript">
    (function blink() {
      $('.blink_me').fadeOut(500).fadeIn(500, blink);
    })();

    function triage(registrasi_id, nama, norm) {
      $('#modalTriage').modal('show');
      $('.modal-title').text('Kondisi Pasien');
      $('#namaPasien').val(nama);
      $('#nomorRM').val(norm);
      $('input[name="registrasi_id"]').val(registrasi_id);
    }

    function simpanTriage() {
      var status_ugd = $('select[name="status_ugd"]').val();
      var registrasi_id = $('input[name="registrasi_id"]').val();
      $.ajax({
        url: '/tindakan/igd/ubah-status-ugd/'+registrasi_id+'/'+status_ugd,
        type: 'GET',
        success: function (data) {
          console.log(data);
          if(data.sukses == true){
            $('#modalTriage').modal('hide');
            location.reload();
          }
        }
      })
    }
  </script>
@endsection
