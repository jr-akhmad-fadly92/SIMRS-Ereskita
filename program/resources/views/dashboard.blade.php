@extends('master')

@section('header')
  <h1> {{ Auth::user()->name }}, <small> Anda Masuk Sebagai : </small> {{ ucfirst(Auth::user()->role()->first()->display_name)}}</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h5 class="no-margin">
        <b>Dashboard Pelayanan {{ $config->nama }} Tanggal: {{ tanggalkuitansi(date('d-m-Y')) }}
      </h5>
    </div>
    <div class="box-body">

  <div class="row">
    <div class="col-lg-2 col-xs-4">
      <!-- small box -->
      <div class="small-box bg-gradient">
        <div class="inner text-center">
          <h3>{{ $total }}</h3>
          <p>Total </p>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-gradient">
            <div class="inner text-center">
              <h3>{{ $rajal }}</h3>
              <p>Rawat Jalan</p>
            </div>
          </div>
        </div>

        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-gradient">
            <div class="inner text-center">
              <h3>{{ $igd }}</h3>
              <p>Rawat Darurat</p>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-gradient color-palette">
            <div class="inner text-center">
              <h3>{{ $irna }}</h3>
              <p>Rawat Inap</p>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-gradient">
            <div class="inner text-center">
              <h3>{{ $l }}</h3>
              <p>Laki - laki</p>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-gradient">
            <div class="inner text-center">
              <h3>{{ $p }}</h3>
              <p>Perempuan</p>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
    </div>
  </div>

  <div class="row">
		<div class="col-md-7">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h5 class="no-margin">
						<i class="fa fa-bar-chart-o"></i>
						<b>Grafik Kunjungan Klinik Hari Ini
					</h5>
				</div>
				<div class="box-body">
					<div id="bar-chart" style="height: 350px;"></div>
				</div>
			</div>
    </div>
    <div class="col-md-5">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h5 class="no-margin">
            <b>Kunjungan Pasien Per Klinik &nbsp;
          </h5>
        </div>
        <div class="box-body">
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Klinik</th>
                  <th class="text-center">Jumlah</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($poli as $d)
                  @if (!empty($d->poli_id))
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ !empty($d->poli_id) ? baca_poli($d->poli_id)  : '' }}</td>
                      <td class="text-center">{{ pasien_perpoli(date('Y-m-d'), $d->poli_id) }}</td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection