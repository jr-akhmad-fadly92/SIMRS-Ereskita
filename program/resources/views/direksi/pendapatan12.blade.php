@extends('master')
@section('header')
  <h1>Laporan Pendapatan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        <form class="form-horizontal" id="laporanTagihan" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="tanggal" class="col-md-4">Tanggal</label>
                      <div class="col-md-4">
                          <input type="text" name="tga" class="form-control datepicker" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                      <div class="col-md-4">
                          <input type="text" name="tgb" class="form-control datepicker" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="shift" class="col-md-4">Shift Kasa</label>
                      <div class="col-md-8">
                          <input type="text" class="form-control" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="klinik" class="col-md-4">Klinik</label>
                      <div class="col-md-8">
                          <select class="form-control chosen-select" name="poli_id">
                              @foreach (Modules\Poli\Entities\Poli::select('id', 'nama')->get() as $key => $d)
                                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                              @endforeach
                          </select>
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="petugas" class="col-md-4">Nama Petugas</label>
                      <div class="col-md-8">
                          <select class="form-control chosen-select" name="petugas_id">
                              @foreach (App\Pembayaran::select('user_id')->distinct()->get(['user_id']) as $key => $d)
                                  <option value="{{ $d->user_id }}">{{ App\User::where('id', $d->user_id)->name }}</option>
                              @endforeach
                          </select>
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="bayar" class="col-md-4">Jenis Bayar</label>
                      <div class="col-md-8">
                          <select class="form-control chosen-select" name="bayar">
                              <option value="1">JKN</option>
                              <option value="2">UMUM</option>
                          </select>
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="tipe_perawatan" class="col-md-4">Tipe Perawatan</label>
                      <div class="col-md-8">
                          <input type="text" class="form-control" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="jenispasien" class="col-md-4">Jenis Pasien</label>
                      <div class="col-md-8">
                          <input type="text" class="form-control" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="dokter" class="col-md-4">Nama Dokter</label>
                      <div class="col-md-8">
                          <select class="form-control chosen-select" name="dokter_id">
                              @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->where('kategori_pegawai', 1)->get() as $key => $d)
                                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                              @endforeach
                          </select>
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="tipelayanan" class="col-md-4">Tipe Layanan</label>
                      <div class="col-md-8">
                          <input type="text" class="form-control" id="" placeholder="">
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="tipe_perawatan" class="col-md-4">Tipe Penerimaan</label>
                      <div class="col-md-8">
                          <select class="form-control chosen-select" name="tipe_penerimaan">
                              <option value="tunai">Tunai</option>
                              <option value="piutang">Piutang</option>
                          </select>
                          <span class="text-danger" id=""></span>
                      </div>
                    </div>
                  
                    
                </div>
            </div>
        </form>
        

    </div>
    <div class="box-footer">
    </div>

    
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr class="info">
                <th style="vertical-align: middle;">#</th>
                <th style="vertical-align: middle;">No. Kuitansi</th>
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
              
            </tbody>
            <tfoot>
              <tr>
              
              </tr>
              <tr>
              
              </tr>

              <tr>
              
              </tr>
            </tfoot>
          </table>
        </div>
      

  </div>
@endsection
